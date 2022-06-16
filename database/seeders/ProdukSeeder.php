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
              'nama_produk' => 'Moffe(mojito Coffe)',
              'deskripsi_produk' => 'modjito coffe',
              'harga_beli' => '15000',
              'diskon' => '0',
              'harga_jual' => '20000',
              'stok' => '50',
              'gambar_produk' =>'/kenal_kopi/produk_img/dummy.jpg'
          ],
          [
                'id_produk' => 2,
                'id_kategori' => 1,
                'kode_produk' => 'P0002',
                'nama_produk' => 'Fragaria Mocktail',
                'deskripsi_produk' => 'test',
                'harga_beli' => '15000',
                'diskon' => '0',
                'harga_jual' => '20000',
                'stok' => '50',
                 'gambar_produk' =>'/kenal_kopi/produk_img/dummy.jpg'
          ],
          [
                'id_produk' => 3,
                'id_kategori' => 1,
                'kode_produk' => 'P0003',
                'nama_produk' => 'Kopsus Kenal Matcha',
                'deskripsi_produk' => 'test',
                'harga_beli' => '15000',
                'diskon' => '0',
                'harga_jual' => '20000',
                'stok' => '50',
                 'gambar_produk' =>'/kenal_kopi/produk_img/dummy.jpg'
          ],
          [
                'id_produk' => 4,
                'id_kategori' => 1,
                'kode_produk' => 'P0004',
                'nama_produk' => 'Kopsus Kenal Redvelvet',
                'deskripsi_produk' => 'test',
                'harga_beli' => '13000',
                'diskon' => '0',
                'harga_jual' => '18000',
                'stok' => '50',
                 'gambar_produk' =>'/kenal_kopi/produk_img/dummy.jpg'
          ],
          [
                'id_produk' => 5,
                'id_kategori' => 1,
                'kode_produk' => 'P0005',
                'nama_produk' => 'Kopsus Kenal Taro',
                'deskripsi_produk' => 'test',
                'harga_beli' => '13000',
                'diskon' => '0',
                'harga_jual' => '18000',
                'stok' => '50',
                 'gambar_produk' =>'/kenal_kopi/produk_img/dummy.jpg'
          ],
          [
                'id_produk' => 6,
                'id_kategori' => 1,
                'kode_produk' => 'P0006',
                'nama_produk' => 'Kopsus Kenal Caramel',
                'deskripsi_produk' => 'test',
                'harga_beli' => '13000',
                'diskon' => '0',
                'harga_jual' => '18000',
                'stok' => '50',
                 'gambar_produk' =>'/kenal_kopi/produk_img/dummy.jpg'
          ],

          [
                'id_produk' => 7,
                'id_kategori' => 1,
                'kode_produk' => 'P0007',
                'nama_produk' => 'Kopsus Kenal Hazelnut',
                'deskripsi_produk' => 'test',
                'harga_beli' => '13000',
                'diskon' => '0',
                'harga_jual' => '18000',
                'stok' => '50',
                 'gambar_produk' =>'/kenal_kopi/produk_img/dummy.jpg'
          ],

          [
                'id_produk' => 8,
                'id_kategori' => 1,
                'kode_produk' => 'P0008',
                'nama_produk' => 'Kopsus Kenal Banana',
                'deskripsi_produk' => 'test',
                'harga_beli' => '13000',
                'diskon' => '0',
                'harga_jual' => '18000',
                'stok' => '50',
                 'gambar_produk' =>'/kenal_kopi/produk_img/dummy.jpg'
          ],

          [
                'id_produk' => 9,
                'id_kategori' => 1,
                'kode_produk' => 'P0009',
                'nama_produk' => 'Kopsus Kenal Regal',
                'deskripsi_produk' => 'test',
                'harga_beli' => '13000',
                'diskon' => '0',
                'harga_jual' => '18000',
                'stok' => '50',
                 'gambar_produk' =>'/kenal_kopi/produk_img/dummy.jpg'
          ],
          [
                'id_produk' => 10,
                'id_kategori' => 1,
                'kode_produk' => 'P00010',
                'nama_produk' => 'Kopsus Kenal Aren',
                'deskripsi_produk' => 'test',
                'harga_beli' => '10000',
                'diskon' => '0',
                'harga_jual' => '15000',
                'stok' => '50',
                 'gambar_produk' =>'/kenal_kopi/produk_img/dummy.jpg'
          ],

          [
                'id_produk' => 11,
                'id_kategori' => 1,
                'kode_produk' => 'P00011',
                'nama_produk' => 'Cappucino',
                'deskripsi_produk' => 'test',
                'harga_beli' => '13000',
                'diskon' => '0',
                'harga_jual' => '18000',
                'stok' => '50',
                 'gambar_produk' =>'/kenal_kopi/produk_img/dummy.jpg'
          ],

          [
                'id_produk' => 12,
                'id_kategori' => 1,
                'kode_produk' => 'P00012',
                'nama_produk' => 'Latte',
                'deskripsi_produk' => 'test',
                'harga_beli' => '10000',
                'diskon' => '0',
                'harga_jual' => '15000',
                'stok' => '50',
                 'gambar_produk' =>'/kenal_kopi/produk_img/dummy.jpg'
          ],

          [
                'id_produk' => 13,
                'id_kategori' => 1,
                'kode_produk' => 'P00013',
                'nama_produk' => 'Americano',
                'deskripsi_produk' => 'test',
                'harga_beli' => '8000',
                'diskon' => '0',
                'harga_jual' => '13000',
                'stok' => '50',
                 'gambar_produk' =>'/kenal_kopi/produk_img/dummy.jpg'
          ],

          [
                'id_produk' => 14,
                'id_kategori' => 1,
                'kode_produk' => 'P00014',
                'nama_produk' => 'Espresso',
                'deskripsi_produk' => 'test',
                'harga_beli' => '5000',
                'diskon' => '0',
                'harga_jual' => '10000',
                'stok' => '50',
                 'gambar_produk' =>'/kenal_kopi/produk_img/dummy.jpg'
          ],

          // Non Cofee
          [
                'id_produk' => 15,
                'id_kategori' => 2,
                'kode_produk' => 'P00015',
                'nama_produk' => 'Kenal Matcha',
                'deskripsi_produk' => 'test',
                'harga_beli' => '12000',
                'diskon' => '0',
                'harga_jual' => '17000',
                'stok' => '50',
                 'gambar_produk' =>'/kenal_kopi/produk_img/dummy.jpg'
          ],

          [
                'id_produk' => 16,
                'id_kategori' => 2,
                'kode_produk' => 'P00016',
                'nama_produk' => 'Tropical Series',
                'deskripsi_produk' => 'Mango,Strawebery,Grape',
                'harga_beli' => '10000',
                'diskon' => '0',
                'harga_jual' => '15000',
                'stok' => '50',
                 'gambar_produk' =>'/kenal_kopi/produk_img/dummy.jpg'
          ],

          [
                'id_produk' => 17,
                'id_kategori' => 2,
                'kode_produk' => 'P00017',
                'nama_produk' => 'Kenal Taro',
                'deskripsi_produk' => 'test',
                'harga_beli' => '10000',
                'diskon' => '0',
                'harga_jual' => '15000',
                'stok' => '50',
                 'gambar_produk' =>'/kenal_kopi/produk_img/dummy.jpg'
          ],

          [
                'id_produk' => 18,
                'id_kategori' => 2,
                'kode_produk' => 'P00018',
                'nama_produk' => 'Kenal Redvelvet',
                'deskripsi_produk' => 'test',
                'harga_beli' => '10000',
                'diskon' => '0',
                'harga_jual' => '15000',
                'stok' => '50',
                 'gambar_produk' =>'/kenal_kopi/produk_img/dummy.jpg'
          ],
          [
                'id_produk' => 19,
                'id_kategori' => 2,
                'kode_produk' => 'P00019',
                'nama_produk' => 'Kenal Cokelat',
                'deskripsi_produk' => 'test',
                'harga_beli' => '10000',
                'diskon' => '0',
                'harga_jual' => '15000',
                'stok' => '50',
                 'gambar_produk' =>'/kenal_kopi/produk_img/dummy.jpg'
          ],
          [
                'id_produk' => 20,
                'id_kategori' => 2,
                'kode_produk' => 'P00020',
                'nama_produk' => 'Kenal Milk Regal',
                'deskripsi_produk' => 'test',
                'harga_beli' => '8000',
                'diskon' => '0',
                'harga_jual' => '13000',
                'stok' => '50',
                 'gambar_produk' =>'/kenal_kopi/produk_img/dummy.jpg'
          ],
          [
                'id_produk' => 21,
                'id_kategori' => 2,
                'kode_produk' => 'P00021',
                'nama_produk' => 'Lemaon Tea',
                'deskripsi_produk' => 'test',
                'harga_beli' => '8000',
                'diskon' => '0',
                'harga_jual' => '13000',
                'stok' => '50',
                 'gambar_produk' =>'/kenal_kopi/produk_img/dummy.jpg'
          ],
          [
                'id_produk' => 22,
                'id_kategori' => 2,
                'kode_produk' => 'P00022',
                'nama_produk' => 'Caramel Sweet Milk',
                'deskripsi_produk' => 'test',
                'harga_beli' => '5000',
                'diskon' => '0',
                'harga_jual' => '10000',
                'stok' => '50',
                 'gambar_produk' =>'/kenal_kopi/produk_img/dummy.jpg'
          ],
          [
                'id_produk' => 23,
                'id_kategori' => 2,
                'kode_produk' => 'P00023',
                'nama_produk' => 'Banana Sweet Milk',
                'deskripsi_produk' => 'test',
                'harga_beli' => '5000',
                'diskon' => '0',
                'harga_jual' => '10000',
                'stok' => '50',
                 'gambar_produk' =>'/kenal_kopi/produk_img/dummy.jpg'
          ],
          [
                'id_produk' => 24,
                'id_kategori' => 2,
                'kode_produk' => 'P00024',
                'nama_produk' => 'Hazelnut Sweet Milk',
                'deskripsi_produk' => 'test',
                'harga_beli' => '5000',
                'diskon' => '0',
                'harga_jual' => '10000',
                'stok' => '50',
                 'gambar_produk' =>'/kenal_kopi/produk_img/dummy.jpg'
          ],
          [
                'id_produk' => 25,
                'id_kategori' => 2,
                'kode_produk' => 'P00025',
                'nama_produk' => 'Sweet Milk',
                'deskripsi_produk' => 'test',
                'harga_beli' => '2000',
                'diskon' => '0',
                'harga_jual' => '7000',
                'stok' => '50',
                 'gambar_produk' =>'/kenal_kopi/produk_img/dummy.jpg'
          ],
          [
                'id_produk' => 26,
                'id_kategori' => 2,
                'kode_produk' => 'P00026',
                'nama_produk' => 'Milo',
                'deskripsi_produk' => 'test',
                'harga_beli' => '2000',
                'diskon' => '0',
                'harga_jual' => '7000',
                'stok' => '50',
                 'gambar_produk' =>'/kenal_kopi/produk_img/dummy.jpg'
          ],
          [
                'id_produk' => 27,
                'id_kategori' => 3,
                'kode_produk' => 'P00027',
                'nama_produk' => 'Japanese Iced Coffe',
                'deskripsi_produk' => 'test',
                'harga_beli' => '10000',
                'diskon' => '0',
                'harga_jual' => '15000',
                'stok' => '50',
                 'gambar_produk' =>'/kenal_kopi/produk_img/dummy.jpg'
          ],
          [
                'id_produk' => 28,
                'id_kategori' => 3,
                'kode_produk' => 'P00028',
                'nama_produk' => 'Vietnam Drip',
                'deskripsi_produk' => 'test',
                'harga_beli' => '10000',
                'diskon' => '0',
                'harga_jual' => '15000',
                'stok' => '50',
                 'gambar_produk' =>'/kenal_kopi/produk_img/dummy.jpg'
          ],
          [
                'id_produk' => 29,
                'id_kategori' => 3,
                'kode_produk' => 'P00029',
                'nama_produk' => 'V60',
                'deskripsi_produk' => 'test',
                'harga_beli' => '8000',
                'diskon' => '0',
                'harga_jual' => '13000',
                'stok' => '50',
                 'gambar_produk' =>'/kenal_kopi/produk_img/dummy.jpg'
          ],
          [
                'id_produk' => 30,
                'id_kategori' => 3,
                'kode_produk' => 'P00030',
                'nama_produk' => 'French Press',
                'deskripsi_produk' => 'test',
                'harga_beli' => '8000',
                'diskon' => '0',
                'harga_jual' => '13000',
                'stok' => '50',
                 'gambar_produk' =>'/kenal_kopi/produk_img/dummy.jpg'
          ],
          [
                'id_produk' => 31,
                'id_kategori' => 3,
                'kode_produk' => 'P00031',
                'nama_produk' => 'Kopi Tubruk',
                'deskripsi_produk' => 'test',
                'harga_beli' => '8000',
                'diskon' => '0',
                'harga_jual' => '13000',
                'stok' => '50',
                 'gambar_produk' =>'/kenal_kopi/produk_img/dummy.jpg'
          ],
          [
                'id_produk' => 32,
                'id_kategori' => 4,
                'kode_produk' => 'P00032',
                'nama_produk' => 'Mix Platter',
                'deskripsi_produk' => 'kentang goreng + soses',
                'harga_beli' => '10000',
                'diskon' => '0',
                'harga_jual' => '15000',
                'stok' => '50',
                 'gambar_produk' =>'/kenal_kopi/produk_img/dummy.jpg'
          ],
          [
                'id_produk' => 33,
                'id_kategori' => 4,
                'kode_produk' => 'P00033',
                'nama_produk' => 'Kentang Goreng',
                'deskripsi_produk' => 'kentang goreng + soses',
                'harga_beli' => '5000',
                'diskon' => '0',
                'harga_jual' => '10000',
                'stok' => '50',
                 'gambar_produk' =>'/kenal_kopi/produk_img/dummy.jpg'
          ],
          [
                'id_produk' => 35,
                'id_kategori' => 4,
                'kode_produk' => 'P00035',
                'nama_produk' => 'Indomie Goreng + Telur',
                'deskripsi_produk' => 'Indomie + Telur',
                'harga_beli' => '5000',
                'diskon' => '0',
                'harga_jual' => '10000',
                'stok' => '50',
                 'gambar_produk' =>'/kenal_kopi/produk_img/dummy.jpg'
          ],
          [
                'id_produk' => 36,
                'id_kategori' => 4,
                'kode_produk' => 'P00036',
                'nama_produk' => 'Indomie Rebus + Telur',
                'deskripsi_produk' => 'Indomie + Telur',
                'harga_beli' => '5000',
                'diskon' => '0',
                'harga_jual' => '10000',
                'stok' => '50',
                 'gambar_produk' =>'/kenal_kopi/produk_img/dummy.jpg'
          ],
          [
                'id_produk' => 37,
                'id_kategori' => 4,
                'kode_produk' => 'P00037',
                'nama_produk' => 'Indomie Goreng',
                'deskripsi_produk' => 'Indomie',
                'harga_beli' => '2000',
                'diskon' => '0',
                'harga_jual' => '7000',
                'stok' => '50',
                 'gambar_produk' =>'/kenal_kopi/produk_img/dummy.jpg'
          ],
          [
                'id_produk' => 38,
                'id_kategori' => 4,
                'kode_produk' => 'P00038',
                'nama_produk' => 'Indomie Rebus',
                'deskripsi_produk' => 'Indomie',
                'harga_beli' => '2000',
                'diskon' => '0',
                'harga_jual' => '7000',
                'stok' => '50',
                 'gambar_produk' =>'/kenal_kopi/produk_img/dummy.jpg'
          ],

      );
      array_map(function (array $produk) {
          Produk::query()->updateOrCreate(
              ['id_produk' => $produk['id_produk']],
              $produk
          );
      }, $produks);
    }
}
