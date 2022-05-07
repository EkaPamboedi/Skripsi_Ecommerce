<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\OrderExport;
use App\Exports\OrderExportPaid;
use App\Models\Order;
use App\Models\Order_Produk;
use Auth;
// use PDF;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // $orders = Order::all()->pluck('nama_kategori', 'id_kategori');
        // $Orders = Order::all()->pluck('nama_kategori', 'id_kategori');


        $Orders = Order::orderBy('id_order','desc')->get();

        return view('admin.order.index',compact('Orders'));
    }

    public function show($id)
    {
      // Dibutuhin nanti buat bedain pesenan setiap user
      // $user_id = Auth::user()->id;
      $Details = Order_Produk::leftJoin('produk', 'produk.id_produk', 'order_produk.id_produk')
      ->select('order_produk.*', 'produk.*')
      ->where('id_order',$id)->get();
      $Orders = Order::where('id_order',$id)->select('status','total_price')->get();

        // $Details = Order_Produk::where('id_order',$id)->get();

        return view('admin.order.detail',compact('Details','Orders'));
    }

      public function data(){
          // $orders = Order::leftJoin('kategori', 'kategori.id_kategori', 'produk.id_kategori')
          //     ->select('produk.*', 'nama_kategori')
          //     ->orderBy('kode_produk', 'asc')
          //     ->get();
        $Orders = Order::orderBy('id_order','desc')->get();


          return datatables()
              ->of($Orders)
              ->addIndexColumn()
              ->addColumn('select_all', function ($Orders) {
                  return '
                      <input type="checkbox" name="id_order[]" value="'. $Orders->id_order .'">
                  ';
              })
              ->addColumn('atas_nama', function ($Orders) {
                  return '<span class="label label-success">'. $Orders->kode_Orders .'</span>';
              })
              ->addColumn('no_meja', function ($Orders) {
                  return '<span>'.$Orders->deskripsi_Orders.'</span>';
              })
              ->addColumn('total_price', function ($Orders) {
                  return format_uang($Orders->harga_beli);
              })
              ->addColumn('status', function ($Orders) {
                  return format_uang($Orders->harga_jual);
              })
              ->addColumn('date', function ($Orders) {
                  return format_uang($Orders->stok);
              })
              ->addColumn('action', function ($Orders) {
                  return '
                  <div class="btn-group">
                      <button type="button" onclick="editForm(`'. route('order.detail', $Orders->id_order) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                  </div>';
              })
              ->rawColumns(['aksi','kode_produk','deskripsi_produk','status','gambar_produk' , 'select_all'])
              ->make(true);
      }

}
