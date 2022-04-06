<?php

namespace App\Http\Controllers;

use App\Models\Confirm;
use App\Models\Order;
use App\Models\Produk;
use App\Models\Order_Produk;
use Auth;
use Illuminate\Http\Request;
use Session;


class ConfirmAdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $title = 'List Konfirmasi Pembayaran Customer';
        $Confirms = Confirm::leftJoin('order','first_name','last_name', 'order.id_order', 'confirms.id_order')
            ->select('confirms.*','total_price')
            ->where('status_order','menunggu verifikasi')->orderBy('id_order','desc')->get();


            // gk tau kenapa pake eloquent gk bisa, jadi pake cara lama xoxoxo
        // $Confirms = Confirm::where('status_order','menunggu verifikasi')->orderBy('id_order','desc')->get();
        return view('admin.konfirmasi_order.index', compact('Confirms', 'title'));
      }

      public function terima($order_id){
      $order = Order::where('id_order', $order_id)->first();
      $order->status = 'dibayar';
      $order->save();

      $confirm = Confirm::where('id_order',$order_id)->first();
      $confirm->status_order = 'dibayar';
      $confirm->save();

       $order_produk = Order_Produk::findOrFail($order_id);
       $order_produk->status_rating = 'belum';
       $order_produk->save();

      $order_produk = Order_Produk::findOrFail($order_id);
      $produk = Produk::findOrFail($order_produk->id_produk);
      $produk->stok -= $order_produk->qty;
      $produk->update();

      // Session::flash('status','Berhasil di konfirmasi dengan status di terima');
      return redirect()->back();
      // return redirect('/confirms_order');
      // return redirect('confirms_order/index');
      // return view('admin.konfirmasi_order.index', compact('Confirms', 'title'));
      // return view('admin.konfirmasi_order.index');

  }

  public function tolak($order_id)
  {
      $order = Order::where('id_order', $order_id)->first();
      $order->status = 'ditolak';
      $order->save();

      $confirm = Confirm::where('id_order',$order_id)->first();
      $confirm->status_order = 'ditolak';
      $confirm->update();

      $order_produk = Order_Produk::findOrFail($order_id);
      $order_produk->status_rating = 'belum';
      $order_produk->save();

      return redirect()->back();
      // return view('admin.confirms_order.index');
      // Session::flash('status','Berhasil di konfirmasi dengan status di tolak');
        // return view('admin.confirms_order.index');
        // return view('admin.konfirmasi_order.index');

  }


  public function detail($id)
  {
    // Dibutuhin nanti buat bedain pesenan setiap user
    // $user_id = Auth::user()->id;
      $Details = Order_Produk::where('id_order',$id)->get();

      return view('admin.order.detail',compact('Details'));
  }
}
