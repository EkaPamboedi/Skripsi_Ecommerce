<?php

namespace App\Http\Controllers;

// use App\Mail\Checkout;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
use Auth;
use App\Models\User;
use App\Models\Kategori;
use Carbon\Carbon;
use App\Models\Produk;
use Cart;
use App\Models\Order;
use App\Models\Order_Produk;
use App\Models\Payments;
use Session;

class CartController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }


  private function _generatePaymentToken($order)
{

  $snap = \Midtrans\Snap::createTransaction($params);

  if ($snap->token) {
    $order->payment_token = $snap->token;
    $order->payment_url = $snap->redirect_url;
    $order->save();
  }
}

  public function index()
      {

      $this->middleware('auth');
      $user_id = Auth::user()->id;
      $user_table = Auth::user()->no_meja;
      $CartProduk = Cart::content();
      // ->toArray();

      $CartProduks=[];
      $CartProduks = array_push($CartProduks, $CartProduk, $user_table, $user_id);

        return view('kenalkopi.cart.index', compact('CartProduk'));
      }

  public function remove($rowId){
      Cart::remove($rowId);
      return back();
    }
  public function update(Request $request){
    Cart::update($request->rowId, $request->qty);
    return back();
  }

  public function checkout()
    {
      $this->middleware('level:2');
      $user_id = Auth::user()->id;
      $CartProduk = Cart::content();
      $user_table = Auth::user()->no_meja;
      // $code_order = mt_rand(1000000000, 9999999999);
        // dd($CartProduk);
        // lfp ulti finale
      // dd($no_meja);

      return view('kenalkopi.cart.checkout',compact('CartProduk','user_table','user_id'));
    }

  public function payment(Request $request)
  {
    // Set your Merchant Server Key
    \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
    // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
    \Midtrans\Config::$isProduction = false;
    // Set sanitization on (default)
    \Midtrans\Config::$isSanitized = true;
    // Set 3DS transaction for credit card to true
    \Midtrans\Config::$is3ds = true;

    // // Add new notification url(s) alongside the settings on Midtrans Dashboard Portal (MAP)
    // \Midtrans\Config::$appendNotifUrl = "http://800c-140-213-35-166.ngrok.io/payments/notification";
    // // Use new notification url(s) disregarding the settings on Midtrans Dashboard Portal (MAP)
    // \Midtrans\Config::$overrideNotifUrl = "http://800c-140-213-35-166.ngrok.io/payments/notification";


          // $this->_generatePaymentToken($order);
          $order = $request->except('_token');
          $user_id = Auth::user()->id;
          // $id_order = Order::get()->id_order;
          // dd($id_order);

          // $atas_nama = $request->atas_nama;
          $user_table = Auth::user()->no_meja;
          $code_order = mt_rand(1000000000, 9999999999);
          // $span_token = Auth::user()->no_meja
          // $paymentDue = (new DateTime($orderDate))->modify('+1 our')->format('H:i:s');
          $total_bayar = 0;
          $total = 0;
          $prod_discount = 0;

          $CartProduk = Cart::content();
          $Produks = Cart::content();

          foreach ($CartProduk as $produk){
                  if($produk->options->diskon === null) {
                    $subTotal = $produk->price*$produk->qty;
                    // $total_bayar += $produk->subTotal;
                    $total_bayar = $total_bayar + $subTotal;
                    }else {
                      $subTotal = (($produk->price - ($produk->price * $produk->options->diskon/100))*$produk->qty);
                      $total_bayar = $total_bayar + $subTotal;
                    }
                  };




            // dd($Produks);

          $order = new Order;
          $order->user_id = $user_id;
          $order->code_order = $code_order;
          // $order->id_order = $id_order;
          $order->no_meja = $user_table;
          $order->first_name = $request->first_name;
          $order->last_name = $request->last_name;
          $order->notes = $request->notes;
          // $order->customer_phone = $request->customer_phone;
          // $order->customer_email = $request->customer_email;
          $order->total_price = $total_bayar;
          $order->order_date = Carbon::now();
          // kudu di ubah jadi satu jam

          foreach($Produks as $produk){
            $harga =  intval($produk->price);
            $quantity = intval($produk->qty);
            // dd($harga);
            if($produk->options->diskon === null) {
              $subTotal = $harga * $quantity;
              // $total_bayar += $produk->subTotal;
              $total = $total_bayar + $subTotal;

              $item_details []= [
                'id' => $produk->id,
                'price' => $subTotal,
                'quantity' =>  $quantity,
                'name' => $produk->name
              ];
            }else{
              $subTotal = (($harga - ($harga * $produk->options->diskon/100))* $quantity);
              // $total = $total_bayar + $subTotal;

              $harga_discount = ($harga - (($harga * $produk->options->diskon)/100));
              // $prod_discount = $prod_discount + $harga_discount;
              $item_details []=[
                'id' => $produk->id,
                'price' => $harga_discount,
                'quantity' => $quantity,
                'name' => $produk->name,
              ];
            }
          };

          $customerDetails = [
            'first_name' =>   $order->first_name = $request->first_name,
            'last_name' =>  $order->last_name = $request->last_name,
          ];

          $params = [
            'enable_payments' => 'credit_card', 'mandiri_clickpay', 'cimb_clicks', 'bca_klikbca', 'bca_klikpay', 'bri_epay', 'echannel', 'permata_va',
                                     'bca_va', 'bni_va', 'other_va', 'gopay', 'indomaret','danamon_online', 'akulaku',
            'transaction_details' => [
              // 'id_order' => $id_order,
              'order_id' => $code_order,
              'gross_amount' => $subTotal,
            ],
            'item_details' => $item_details,
            'customer_details' => $customerDetails,
            'expiry' => [
              'start_time' => date('Y-m-d H:i:s T'),
              'unit' => 'HOUR',
              'duration' => 1,
            ],
          ];
          // dd($params);

          // dd($produk);

          $snap = \Midtrans\Snap::createTransaction($params);
          if ($snap->token) {
      			$order->payment_token = $snap->token;
      			$order->payment_url = $snap->redirect_url;
      			$order->save();
      		}

          foreach ($CartProduk as $produk){
            if($produk->options->diskon === null) {
              $order_produk = new Order_Produk;
              $order_produk->id_order = $order->id_order;
              $order_produk->id_kategori = $produk->options->id_kategori;
              $order_produk->id_produk = $produk->id_produk;
              $order_produk->qty = $produk->qty;
              $order_produk->subtotal = $produk->subtotal;
              $order_produk->save();

            }else {
              $order_produk = new Order_Produk;
              $order_produk->id_order = $order->id_order;
              $order_produk->id_kategori = $produk->options->id_kategori;
              $order_produk->id_produk = $produk->id;
              $order_produk->qty = $produk->qty;
              $order_produk->subtotal =(($produk->price - ($produk->price * $produk->options->diskon/100))*$produk->qty);
              $order_produk->save();

            }
          }
          $user = User::findOrFail($user_id);

          return redirect('invoice')->with('status','Anda berhasil melakukan checkout');
      }

  public function confirm()
    {
        return view('kenalkopi.cart.konfirmasi');
    }
}
