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
      // $this->middleware('auth');
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
      if($token = session('token')) {
        $CartProduk = Cart::content();
        $CartProduks=[];
        $CartProduks = array_push($CartProduks, $CartProduk);

          return view('kenal_kopi.cart.index', compact('CartProduk'));
      }else{
          return redirect('/kenalkopi/login')->with('message', 'You need to scan Qr First!');
        }
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
      if($token = session('token')) {
        $no_meja = session('no_meja');

        $CartProduk = Cart::content();
      return view('kenal_kopi.cart.checkout',compact('CartProduk','no_meja'));
  }else{
      return redirect('/kenalkopi/login')->with('message', 'You need to scan Qr First!');
    }
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

          // ini didapat dari pengiriman session setelah login qr
          $code_order = mt_rand(1000000000, 9999999999);
          $no_meja = session('no_meja');
          $login_token = session('token');
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

          // if ($id_order = session('id_order')) {
          //   $data_orders = Order::where('id_order',$id_order)
          //   ->select('id_order','code_order','no_meja')->get();

          // $order = Order::findOrFail($data_orders[0]->id_order);
          $order = $request->except('_token');
          $order = new Order;
          $order->login_token = $login_token;
          $order->code_order = $code_order;
          $order->first_name = $request->first_name;
          $order->last_name = $request->last_name;
          $order->no_meja = $no_meja;
          $order->status = "belum bayar";
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
        // }
          // $user = User::findOrFail($user_id);

          return redirect('/kenalkopi/invoice')->with('status','Anda berhasil melakukan checkout');
      }

  public function confirm()
    {
        return view('kenal_kopi.cart.konfirmasi');
    }
}
