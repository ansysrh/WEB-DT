<?php

namespace Tests\Feature;

use Tests\TestCase;
use Mockery;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class AdminAuthControllerTest extends TestCase
{
    protected function tearDown(): void
    {
        // Pastikan Mockery ditutup setiap test
        Mockery::close();
        parent::tearDown();
    }

    protected function setUp(): void
    {
        parent::setUp();

        // Buat route minimal yang dipakai controller (agar helper route() tidak error)
        Route::get('/admin/barang', fn() => 'ok')->name('adminn.barang.index');
        Route::get('/admin/login', fn() => 'login')->name('adminn.login');
    }

    public function test_show_login_returns_a_view_instance()
    {
        // Panggil controller method langsung
        $controller = app()->make(\App\Http\Controllers\Auth\AdminAuthController::class);

        $response = $controller->showLogin();

        // Pastikan mengembalikan instance View
        $this->assertInstanceOf(View::class, $response);
    }

    public function test_login_success_attempts_login_and_redirects()
    {
        // Mock Request agar validate() mengembalikan kredensial yang kita mau
        $request = Mockery::mock(Request::class);
        $credentials = ['email' => 'admin@example.test', 'password' => 'secret'];

        $request->shouldReceive('validate')
            ->once()
            ->andReturn($credentials);

        // Session mock (karena controller memanggil session()->regenerate() dan mungkin invalidate/regenerateToken)
        $session = Mockery::mock();
        $session->shouldReceive('regenerate')->once();
        // pada jalur sukses, controller hanya memanggil session()->regenerate() bukan invalidate()
        $request->shouldReceive('session')->andReturn($session);
        $request->shouldReceive('ip')->andReturn('127.0.0.1');
        $request->shouldReceive('input')->with('email')->andReturn($credentials['email']);

        // Mock guard admin
        $guard = Mockery::mock();
        $guard->shouldReceive('check')->once()->andReturn(false); // tidak ada admin yang login sebelumnya
        $guard->shouldReceive('attempt')->once()->with($credentials)->andReturn(true);
        $guard->shouldReceive('id')->andReturn(42);

        // Bind facade Auth guard mock
        Auth::shouldReceive('guard')->with('admin')->andReturn($guard);

        // Panggil controller
        $controller = app()->make(\App\Http\Controllers\Auth\AdminAuthController::class);
        $response = $controller->login($request);

        // Harus berupa RedirectResponse (redirect()->intended(...))
        $this->assertInstanceOf(RedirectResponse::class, $response);

        // Expected redirect location is the route we registered
        $this->assertStringContainsString('/adminn/barang', $response->getTargetUrl());
    }

    public function test_login_failure_returns_back_with_errors()
    {
        $request = Mockery::mock(Request::class);
        $credentials = ['email' => 'admin@example.test', 'password' => 'wrong'];

        $request->shouldReceive('validate')
            ->once()
            ->andReturn($credentials);

        // On failed attempt, code calls RateLimiter::hit(...), session not necessarily used here for success path,
        // but controller calls only session()->invalidate() when check() returns true and we log out previous admin.
        $request->shouldReceive('session')->andReturn(Mockery::mock());
        $request->shouldReceive('ip')->andReturn('127.0.0.1');
        $request->shouldReceive('input')->with('email')->andReturn($credentials['email']);

        $guard = Mockery::mock();
        $guard->shouldReceive('check')->once()->andReturn(false);
        $guard->shouldReceive('attempt')->once()->with($credentials)->andReturn(false); // login gagal

        Auth::shouldReceive('guard')->with('admin')->andReturn($guard);

        $controller = app()->make(\App\Http\Controllers\Auth\AdminAuthController::class);
        $response = $controller->login($request);

        // back()->withErrors(...) mengembalikan RedirectResponse
        $this->assertInstanceOf(RedirectResponse::class, $response);

        // Dan response harus berisi pesan error pada session flash (cek bahwa target url bukan /admin/barang)
        $this->assertStringNotContainsString('/admin/barang', $response->getTargetUrl());
    }

    public function test_relogin_when_another_admin_is_logged_out_first()
    {
        $request = Mockery::mock(Request::class);
        $credentials = ['email' => 'admin2@example.test', 'password' => 'newpass'];

        $request->shouldReceive('validate')->once()->andReturn($credentials);

        // Session is used for invalidate/regenerateToken when existing admin is logged out
        $session = Mockery::mock();
        $session->shouldReceive('invalidate')->once();
        $session->shouldReceive('regenerateToken')->once();
        $session->shouldReceive('regenerate')->once();
        $request->shouldReceive('session')->andReturn($session);
        $request->shouldReceive('ip')->andReturn('127.0.0.1');
        $request->shouldReceive('input')->with('email')->andReturn($credentials['email']);

        // Guard mock: first check() true (someone is logged in), then logout is expected, then attempt returns true
        $guard = Mockery::mock();
        $guard->shouldReceive('check')->once()->andReturn(true);
        $guard->shouldReceive('id')->andReturn(99);
        $guard->shouldReceive('logout')->once();
        $guard->shouldReceive('attempt')->once()->with($credentials)->andReturn(true);
        // after login, id may be called by the controller when logging success
        $guard->shouldReceive('id')->andReturn(100);

        Auth::shouldReceive('guard')->with('admin')->andReturn($guard);

        $controller = app()->make(\App\Http\Controllers\Auth\AdminAuthController::class);
        $response = $controller->login($request);

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(route('adminn.barang.index'), $response->getTargetUrl());
    }


    public function test_logout_calls_guard_logout_and_redirects_to_login_route()
    {
        $request = Mockery::mock(Request::class);
        $session = Mockery::mock();
        $session->shouldReceive('invalidate')->once();
        $session->shouldReceive('regenerateToken')->once();
        $request->shouldReceive('session')->andReturn($session);

        $guard = Mockery::mock();
        $guard->shouldReceive('logout')->once();

        Auth::shouldReceive('guard')->with('admin')->andReturn($guard);

        $controller = app()->make(\App\Http\Controllers\Auth\AdminAuthController::class);
        $response = $controller->logout($request);

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertStringContainsString('/admin/login', $response->getTargetUrl());
    }
}
