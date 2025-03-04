<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 30; $i++) {
            DB::table('t_penjualan_detail')->insert([
                'detail_id' => $i,
                'penjualan_id' => ceil($i / 3), // Setiap transaksi memiliki 3 barang
                'barang_id' => rand(1, 10),
                'harga' => rand(5000, 500000),
                'jumlah' => rand(1, 5),
            ]);
        }
    }
}
