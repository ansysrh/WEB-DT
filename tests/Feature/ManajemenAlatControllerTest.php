<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\Admin;
use App\Models\TipeAlat;
use App\Models\KategoriAlat;

class ManajemenAlatControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_displays_items_and_categories_for_authenticated_admin()
    {
        $admin = Admin::factory()->create();
        $kategori = KategoriAlat::factory()->create(['nama_kategori' => 'Kategori A']);
        $item = TipeAlat::factory()->create([
            'kategori_id' => $kategori->id,
            'nama_alat' => 'Mesin X'
        ]);

        $response = $this->actingAs($admin, 'admin')->get(route('adminn.barang.index'));

        $response->assertStatus(200);
        $response->assertViewIs('adminn.barang');
        $response->assertSee('Kategori A');
        $response->assertSee('Mesin X');
    }

    public function test_store_validates_and_creates_new_tipe_alat_with_optional_image()
    {
        $admin = Admin::factory()->create();
        $kategori = KategoriAlat::factory()->create();

        Storage::fake('public');
        $file = UploadedFile::fake()->create('alat.jpg', 100, 'image/jpeg');

        $postData = [
            'kategori_id' => $kategori->id,
            'nama_alat' => 'Bor 2000',
            'stok' => 3,
            'harga_sewa' => 15000,
            'deskripsi' => 'Deskripsi alat',
            'gambar' => $file,
        ];

        $response = $this->actingAs($admin, 'admin')->post(route('adminn.barang.store'), $postData);

        $response->assertStatus(302);

        // gunakan nama tabel yang sesuai dengan model ($table = 'tipe_alat')
        $this->assertDatabaseHas('tipe_alat', [
            'nama_alat' => 'Bor 2000',
            'kategori_id' => $kategori->id,
            'stok' => 3,
            'harga_sewa' => 15000,
        ]);

        Storage::disk('public')->assertExists('gambar_alat/' . $file->hashName());
    }

    public function test_update_replaces_image_and_updates_fields()
    {
        $admin = Admin::factory()->create();
        $kategori = KategoriAlat::factory()->create();
        Storage::fake('public');

        $oldFile = UploadedFile::fake()->create('old.jpg', 80, 'image/jpeg');
        $oldPath = $oldFile->store('gambar', 'public');

        $item = TipeAlat::factory()->create([
            'kategori_id' => $kategori->id,
            'nama_alat' => 'Nama Lama',
            'stok' => 1,
            'harga_sewa' => 10000,
            'gambar' => $oldPath,
        ]);

        Storage::disk('public')->assertExists($oldPath);

        $newFile = UploadedFile::fake()->create('new.jpg', 90, 'image/jpeg');

        $response = $this->actingAs($admin, 'admin')->put(route('adminn.barang.update', $item->id), [
            'kategori_id' => $kategori->id,
            'nama_alat' => 'Nama Baru',
            'stok' => 5,
            'harga_sewa' => 20000,
            'deskripsi' => 'Updated',
            'gambar' => $newFile,
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('tipe_alat', [
            'id' => $item->id,
            'nama_alat' => 'Nama Baru',
            'stok' => 5,
            'harga_sewa' => 20000,
        ]);

        Storage::disk('public')->assertMissing($oldPath);
        Storage::disk('public')->assertExists('gambar/' . $newFile->hashName());
    }

    public function test_destroy_deletes_record_and_image()
    {
        $admin = Admin::factory()->create();
        Storage::fake('public');

        $file = UploadedFile::fake()->create('to-delete.jpg', 80, 'image/jpeg');
        $path = $file->store('gambar', 'public');

        $item = TipeAlat::factory()->create(['gambar' => $path]);

        $response = $this->actingAs($admin, 'admin')->delete(route('adminn.barang.destroy', $item->id));

        $response->assertStatus(302);
        $this->assertDatabaseMissing('tipe_alat', ['id' => $item->id]);
        Storage::disk('public')->assertMissing($path);
    }
}
