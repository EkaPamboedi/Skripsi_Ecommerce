<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Confirm;
use App\Models\Order;
use App\Models\Order_Produk;
use App\Models\Produk;
use App\Models\Ratings;
use Cart;
use Auth;
use DB;
use Session;

// use DB;

class InvoiceController extends Controller
{
      public function __construct()
    {
      if ($id_penjualan = session('id_penjualan')) {
          $penjualan = Penjualan::find($id_penjualan);
    }else {
      return redirect('/kenalkopi/login');
    }
    }

    public function index() {

      if($token = session('token')) {
        $CartProduk = Cart::content();
        $total = Cart::subtotal();
        Cart::destroy();
        // $user_id = Auth::user()->user_id;
        return view('kenal_kopi.order.invoice', compact('CartProduk','total'));
      }else {
        return redirect('/kenalkopi/login')->with('message', 'You need to scan Qr First!');
      }
    }

    public function daftar_order() {
      if($token = session('token')) {
         $Orders = Order::orderBy('id_order','desc')->where('login_token',$token)->get();
        // $SnapToken = Order::where('user_id',$user_id)
        //         ->get('payment_token');
        return view('kenal_kopi.order.daftar_order',compact('Orders'));
      }else{
        return redirect('/kenalkopi/login')->with('message', 'You need to scan Qr First!');
      }
    }

    public function detail_order($id) {
      if($token = session('token')) {
      $Details = Order_Produk::leftJoin('produk', 'produk.id_produk', 'order_produk.id_produk')
      ->select('order_produk.*', 'produk.*')
      ->where('order_produk.id_order',$id)->get();
      // $Details = Order_Produk::
      // join('produk', 'produk.id_produk', 'order_produk.id_produk')
      // ->join('order', 'order.id_order', 'order_produk.id_order')
      // ->where('order_produk.id_order',$id)
      // ->select('order_produk.*',
      //          'produk.nama_produk',
      //          'produk.gambar_produk',
      //          'produk.gambar_produk',
      //          'order.*')
      // ->get();
      // $Orders = Order::where('id_order',$id)->get();
      $Orders = Order::where('id_order', '=' ,$id)->get();
      // dd($Orders);
      $SnapToken = DB::table('order')->where('id_order',$id)->pluck('payment_token');
      $PaymentUrl = DB::table('order')->where('id_order',$id)->pluck('payment_url');
      // $SnapToken = $Snap;
      // $Snap = Order::where('id_order',$id)->get('payment_token')->toArray();
      // $SnapToken = json_encode($Snap);
      // $Snap = json_encode($SnapToken);
      // dd($SnapToken);

      return view('kenal_kopi.order.detail_order',compact('Details','Orders','SnapToken','PaymentUrl'));
    }else{
      return redirect('/kenalkopi/login')->with('message', 'You need to scan Qr First!');
     }
   }


}
