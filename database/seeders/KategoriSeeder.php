<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kategoris = array(
            [
                'id_kategori' => 1,
                'nama_kategori' => 'Espresso Based'
            ],
            [
              'id_kategori' => 2,
                'nama_kategori' => 'Non Coffe'
            ],
            [
              'id_kategori' => 3,
                'nama_kategori' => 'Manual Brew'
            ],
            [
              'id_kategori' => 4,
                'nama_kategori' => 'Food'
            ],
        );
          array_map(function (array $kategori) {
              Kategori::query()->updateOrCreate(
                  ['id_kategori' => $kategori['id_kategori']],
                  $kategori
              );
          }, $kategoris);
    }
}
