<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Order extends Model
{
  protected $guarded = [];
    protected $table = 'order';
    protected $primaryKey = 'id_order';

public const CREATED = 'created';
public const CONFIRMED = 'confirmed';
public const DELIVERED = 'delivered';
public const COMPLETED = 'completed';
public const CANCELLED = 'cancelled';

public const ORDERCODE = 'KNL_KOPI';
// public const ORDERCODE = 'INV';

public const PAID = 'paid';
public const UNPAID = 'unpaid';

  public function Order_Produk()
    {
        return $this->belongsTo(Order_Produk::class, 'id_order_produk');
    }
    public function Produk()
      {
          return $this->belongsTo(Produk::class,'id_produk');
      }
      public function Ratings()
        {
            return $this->belongsTo(Ratings::class,'id');
        }
        public function Payments()
          {
              return $this->belongsTo(Payments::class,'code');
          }

  public function user()
  {
      return $this->belongsTo(User::class);
  }

  public function confirm()
  {
      return $this->hasOne(Confirm::class);
  }


  public static function generateCode()
{
  $dateCode = self::ORDERCODE . '/' . date('Ymd') . '/' .\General::integerToRoman(date('m')). '/' .\General::integerToRoman(date('d')). '/';

  $lastOrder = self::select([\DB::raw('MAX(order.code) AS last_code')])
    ->where('code', 'like', $dateCode . '%')
    ->first();

  $lastOrderCode = !empty($lastOrder) ? $lastOrder['last_code'] : null;

  $orderCode = $dateCode . '1';
  if ($lastOrderCode) {
    $lastOrderNumber = str_replace($dateCode, '', $lastOrderCode);
    $nextOrderNumber = sprintf('%05d', (int)$lastOrderNumber + 1);

    $orderCode = $dateCode . $nextOrderNumber;
  }

  if (self::_isOrderCodeExists($orderCode)) {
    return generateOrderCode();
  }

  return $orderCode;
}

/**
 * Check if the generated order code is exists
 *
 * @param string $orderCode order code
 *
 * @return void
 */
private static function _isOrderCodeExists($orderCode)
{
  return Order::where('code', '=', $orderCode)->exists();
}
public function isPaid(){
  return $this->payment_status == self::PAID;
}

}
