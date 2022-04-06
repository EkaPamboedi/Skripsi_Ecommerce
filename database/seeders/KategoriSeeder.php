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
                'nama_kategori' => 'makanan ringan'
            ],
            [
                'id_kategori' => 2,
                'nama_kategori' => 'minuman'
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
