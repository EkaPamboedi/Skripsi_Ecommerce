<?php

namespace Database\Seeders;

use App\Models\Produk;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $produks = array(
          [
              'id_produk' => 1,
              'id_kategori' => 1,
              'kode_produk' => 'P0001',
              'nama_produk' => 'Ciki zeki',
              'gambar_produk' =>$faker->image('/kenalkopi/produk_img/produk-1.jpg')
          ],
          [
                'id_produk' => 2,
                'id_kategori' => 2,
                'kode_produk' => 'P0002',
                'nama_produk' => 'Arinda',
                'gambar_produk' =>$faker->image('/kenalkopi/produk_img/produk-2.jpg')
          ],
      );
    }
}
