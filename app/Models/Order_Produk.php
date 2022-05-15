<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_Produk extends Model
{
    protected $guarded = [];
    protected $table = 'order_produk';
    protected $primaryKey = 'id_order_produk';

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
        return $this->hasOne(Produk::class, 'id_produk', 'id_produk');
    }
      // public function Ratings()
      // {
      //     return $this->belongsTo(Ratings::class, 'id');
      // }
}
