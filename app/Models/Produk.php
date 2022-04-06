<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';
    protected $primaryKey = 'id_produk';
    protected $guarded = [];

    public function Kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    public function Order_Produk()
    {
        return $this->belongsTo(Order_Produk::class);
    }
    public function Ratings()
    {
        return $this->belongsTo(Ratings::class, $id_produk);
    }
}
