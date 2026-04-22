<?php

namespace Database\Factories;

use App\Models\TipeAlat;
use App\Models\KategoriAlat;
use Illuminate\Database\Eloquent\Factories\Factory;

class TipeAlatFactory extends Factory
{
    protected $model = TipeAlat::class;

    public function definition()
    {
        return [
            'kategori_id' => KategoriAlat::factory(), // otomatis buat kategori
            'nama_alat' => $this->faker->words(2, true),
            'gambar' => null, // biarkan null, test file upload mengisi ini
            'stok' => $this->faker->numberBetween(0, 50),
            'harga_sewa' => $this->faker->numberBetween(10000, 50000),
            'deskripsi' => $this->faker->sentence(),
        ];
    }
}
