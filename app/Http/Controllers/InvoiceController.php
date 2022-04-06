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
        $this->middleware('auth');
    }

    public function index()
    {
        $CartProduk = Cart::content();
        $total = Cart::subtotal();
        Cart::destroy();
        $user_id = Auth::user()->user_id;
      return view('kenalkopi.order.invoice', compact('CartProduk','total','user_id'));
    }

    public function daftar_order(){

    $user_id = Auth::user()->id;
    $Orders = Order::where('user_id',$user_id)
            ->orderBy('user_id','desc')
            ->get();
    $SnapToken = Order::where('user_id',$user_id)
            ->get('payment_token');
        return view('kenalkopi.order.daftar_order', compact('Orders'));
    }

    public function detail_order($id){

      // Dibutuhin nanti buat bedain pesenan setiap user
      // $user_id = Auth::user()->id;
      $Details = Order_Produk::where('id_order',$id)->get();
      // $Orders = Order::where('id_order',$id)->get();
      $Orders = Order::where('id_order',$id)->get('status','total_price');
      // dd($Orders);
      $SnapToken = DB::table('order')->where('id_order',$id)->pluck('payment_token');
      $PaymentUrl = DB::table('order')->where('id_order',$id)->pluck('payment_url');
      // $SnapToken = $Snap;
      // $Snap = Order::where('id_order',$id)->get('payment_token')->toArray();
      // $SnapToken = json_encode($Snap);
      // $Snap = json_encode($SnapToken);
      // dd($SnapToken);

      return view('kenalkopi.order.detail_order',compact('Details','Orders','SnapToken','PaymentUrl'));
    }

    public function Rating(Request $request){


      $Ratings = new Ratings();
      $Ratings->user_id = $request->user_id;
      $Ratings->id_order_produk = $request->id_order_produk;
      $Ratings->id_produk = $request->id_produk;
      $Ratings->ratings = $request->ratings;
      $Ratings->save();

      // $Stat_rating = Order_Produk::findOrFail($id);
      // $Stat_rating->id_order_produk = $request->id_order_produk;
      // $Stat_rating->status_rating = 'sudah';
      // $Stat_rating->update();

        $Status_rating = DB::table('order_produk')
                   ->where('id_order_produk', $request->id_order_produk)
                   ->update(['status_rating'=>'sudah']);
      //
      return redirect()->back();
      //

    }



}
