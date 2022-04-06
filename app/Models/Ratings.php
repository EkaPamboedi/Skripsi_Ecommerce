<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ratings extends Model
{
    use HasFactory;
    protected $table = 'ratings';
    protected $primarykey = 'id';
    protected $fillable = [
      'user_id',
      'id_order_produk',
      'id_produk',
      'ratings'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function Order()
    {
        return $this->belongsTo(Order::class, 'id_order');
    }

    public function Produk()
    {
        return $this->hasMany(Produk::class, 'id_produk');
    }
    public function Order_Produk()
    {
        return $this->belongsTo(Order_Produk::class, 'id_order_produk');
    }
}
