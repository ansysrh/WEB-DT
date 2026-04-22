<?php

namespace Database\Factories;

use App\Models\Keranjang;
use App\Models\TipeAlat;
use Illuminate\Database\Eloquent\Factories\Factory;

class KeranjangFactory extends Factory
{
    protected $model = Keranjang::class;

    public function definition()
    {
        return [
            'session_id' => $this->faker->uuid(),
            'tipe_alat_id' => TipeAlat::factory(),
            'nama_alat' => $this->faker->words(2, true),
            'gambar' => 'dummy.jpg',
            'harga' => $this->faker->numberBetween(5000, 30000),
            'jumlah' => 1,
        ];
    }
}
