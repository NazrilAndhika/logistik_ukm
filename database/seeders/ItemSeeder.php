<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        // Membuat beberapa data barang awal
        Item::create([
            'nama_barang' => 'Raket Yonex Astrox',
            'stok' => 5,
            'kondisi' => 'Baik'
        ]);

        Item::create([
            'nama_barang' => 'Shuttlecock Garuda',
            'stok' => 3,
            'kondisi' => 'Baru'
        ]);

        Item::create([
            'nama_barang' => 'Net Badminton Lining',
            'stok' => 2,
            'kondisi' => 'Baik'
        ]);
    }
}