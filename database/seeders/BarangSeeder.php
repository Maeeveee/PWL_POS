<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_barang')->insert([
            ['barang_id' => 1, 'kategori_id' => 1, 'barang_kode' => 'BR001', 'barang_nama' => 'Laptop', 'harga_beli' => 5000000, 'harga_jual' => 5500000],
            ['barang_id' => 2, 'kategori_id' => 1, 'barang_kode' => 'BR002', 'barang_nama' => 'HP Android', 'harga_beli' => 3000000, 'harga_jual' => 3500000],
            ['barang_id' => 3, 'kategori_id' => 2, 'barang_kode' => 'BR003', 'barang_nama' => 'Mie Instan', 'harga_beli' => 2500, 'harga_jual' => 3000],
            ['barang_id' => 4, 'kategori_id' => 2, 'barang_kode' => 'BR004', 'barang_nama' => 'Biskuit', 'harga_beli' => 5000, 'harga_jual' => 6000],
            ['barang_id' => 5, 'kategori_id' => 3, 'barang_kode' => 'BR005', 'barang_nama' => 'Teh Botol', 'harga_beli' => 3500, 'harga_jual' => 4000],
            ['barang_id' => 6, 'kategori_id' => 3, 'barang_kode' => 'BR006', 'barang_nama' => 'Kopi Susu', 'harga_beli' => 4000, 'harga_jual' => 4500],
            ['barang_id' => 7, 'kategori_id' => 4, 'barang_kode' => 'BR007', 'barang_nama' => 'Kaos', 'harga_beli' => 50000, 'harga_jual' => 60000],
            ['barang_id' => 8, 'kategori_id' => 4, 'barang_kode' => 'BR008', 'barang_nama' => 'Celana Jeans', 'harga_beli' => 150000, 'harga_jual' => 170000],
            ['barang_id' => 9, 'kategori_id' => 5, 'barang_kode' => 'BR009', 'barang_nama' => 'Pensil', 'harga_beli' => 2000, 'harga_jual' => 2500],
            ['barang_id' => 10, 'kategori_id' => 5, 'barang_kode' => 'BR010', 'barang_nama' => 'Pulpen', 'harga_beli' => 3000, 'harga_jual' => 4000],
        ]);
    }
}
