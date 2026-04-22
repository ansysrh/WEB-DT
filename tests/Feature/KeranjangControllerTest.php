<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Keranjang;
use App\Models\TipeAlat;
use Illuminate\Support\Facades\Storage;

class KeranjangControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Inisialisasi session test (memastikan cookie/session aktif untuk request berikutnya).
     * Mengembalikan array [sessionName, sessionId] untuk dipakai pada withCookie().
     */
    protected function startSession(): array
    {
        $this->get('/'); // memaksa Laravel membuat session untuk client test ini
        $sessionName = session()->getName();
        $sessionId = session()->getId();
        return [$sessionName, $sessionId];
    }

    public function test_index_shows_cart_and_total()
    {
        Storage::fake('public');

        [$sessionName, $sessionId] = $this->startSession();

        $alat = TipeAlat::factory()->create([
            'nama_alat' => 'AlatTest',
            'harga_sewa' => 10000,
            'gambar' => 'alat.jpg',
        ]);

        // Buat record langsung di DB (forceFill) dengan session yang sama
        $item = (new Keranjang())->forceFill([
            'session_id' => $sessionId,
            'tipe_alat_id' => $alat->id,
            'nama_alat' => $alat->nama_alat,
            'gambar' => $alat->gambar,
            'harga_sewa' => $alat->harga_sewa,
            'jumlah' => 1,
        ]);
        $item->save();

        // Panggil route sambil mengirim cookie session agar controller membaca session yang sama
        $response = $this->withCookie($sessionName, $sessionId)
            ->get(route('admin.keranjang'));

        $response->assertStatus(200);
        $response->assertSee('AlatTest');
        $response->assertSee('Jumlah: 1');
    }

    public function test_increment_works_through_controller()
    {
        Storage::fake('public');

        [$sessionName, $sessionId] = $this->startSession();

        $alat = TipeAlat::factory()->create([
            'harga_sewa' => 5000,
            'gambar' => 'alatx.jpg',
        ]);

        // buat item awal langsung di DB (forceFill) sehingga controller akan masuk branch "existing"
        $item = (new Keranjang())->forceFill([
            'session_id' => $sessionId,
            'tipe_alat_id' => $alat->id,
            'nama_alat' => $alat->nama_alat,
            'gambar' => $alat->gambar,
            'harga_sewa' => $alat->harga_sewa,
            'jumlah' => 1,
        ]);
        $item->save();

        // panggil controller tambah dengan cookie session yang sama
        $this->withCookie($sessionName, $sessionId)
            ->post(route('tambah.keranjang', $alat->id));

        $this->assertDatabaseHas('keranjang', [
            'session_id' => $sessionId,
            'tipe_alat_id' => $alat->id,
            'jumlah' => 2,
        ]);
    }

    public function test_hapus_respects_session_and_deletes_only_own_item()
    {
        Storage::fake('public');

        [$sessionName, $sessionId] = $this->startSession();

        $alat = TipeAlat::factory()->create([
            'gambar' => 'afile.jpg',
            'harga_sewa' => 7000,
        ]);

        // item milik session lain → buat langsung di DB dengan 'other-session'
        $foreign = (new Keranjang())->forceFill([
            'session_id' => 'other-session',
            'tipe_alat_id' => $alat->id,
            'nama_alat' => 'XBarang',
            'gambar' => $alat->gambar,
            'harga_sewa' => $alat->harga_sewa,
            'jumlah' => 1,
        ]);
        $foreign->save();

        $this->withCookie($sessionName, $sessionId)
            ->delete(route('keranjang.hapus', $foreign->id))
            ->assertStatus(403);

        $own = (new Keranjang())->forceFill([
            'session_id' => $sessionId,
            'tipe_alat_id' => $alat->id,
            'nama_alat' => 'BarangOK',
            'gambar' => $alat->gambar,
            'harga_sewa' => $alat->harga_sewa,
            'jumlah' => 1,
        ]);
        $own->save();

        $this->withCookie($sessionName, $sessionId)
            ->delete(route('keranjang.hapus', $own->id))
            ->assertStatus(302);

        $this->assertDatabaseMissing('keranjang', ['id' => $own->id]);
    }
}
