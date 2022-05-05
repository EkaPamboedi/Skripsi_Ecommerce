<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order_manual;
use App\Models\Order_Produk_manual;
use App\Models\Produk;

class OrderManualController extends Controller
{
    public function index()
    {
      return view('admin.kasir.index');
    }
    public function data()
    {
      // $Orders = Order_manual::leftJoin('order_produk_manual', 'order_produk_manual.id_order_manual)', 'order_manual.id_order_manual')
      //     ->select('order_manual.*', 'order_produk_manual.jumlah_item','order_produk_manual.subtotal' )
      //     ->orderBy('kode_produk', 'asc')
      //     ->get();
          $Orders = Order_manual::join('order_produk_manual', 'order_produk_manual.id_order_manual', '=', 'order_manual.id_order_manual')
                                  ->join('produk', 'produk.id_produk', '=' , 'order_produk_manual.id_produk')
                                  ->select('order_manual.*', 'order_produk_manual.jumlah_item','order_produk_manual.subtotal')->get();
                                  // dd($Orders);
          // $detail = PembelianDetail::with('produk')
          //     ->where('id_pembelian', $id)
          //     ->get();

          // $penjualan = Penjualan::with('member')->orderBy('id_penjualan', 'desc')->get();

          return datatables()
              ->of($penjualan)
              ->addIndexColumn()
              ->addColumn('total_item', function ($penjualan) {
                  return format_uang($penjualan->total_item);
              })
              ->addColumn('total_harga', function ($penjualan) {
                  return 'Rp. '. format_uang($penjualan->total_harga);
              })
              ->addColumn('bayar', function ($penjualan) {
                  return 'Rp. '. format_uang($penjualan->bayar);
              })
              ->addColumn('tanggal', function ($penjualan) {
                  return tanggal_indonesia($penjualan->created_at, false);
              })
              ->addColumn('kode_member', function ($penjualan) {
                  $member = $penjualan->member->kode_member ?? '';
                  return '<span class="label label-success">'. $member .'</spa>';
              })
              ->editColumn('diskon', function ($penjualan) {
                  return $penjualan->diskon . '%';
              })
              ->editColumn('kasir', function ($penjualan) {
                  return $penjualan->user->name ?? '';
              })
              ->addColumn('aksi', function ($penjualan) {
                  return '
                  <div class="btn-group">
                      <button onclick="showDetail(`'. route('penjualan.show', $penjualan->id_penjualan) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-eye"></i></button>
                      <button onclick="deleteData(`'. route('penjualan.destroy', $penjualan->id_penjualan) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                  </div>
                  ';
              })
              ->rawColumns(['aksi', 'kode_member'])
              ->make(true);
      }

    public function create()
    {
        $penjualan = new Penjualan();
        $penjualan->id_member = null;
        $penjualan->total_item = 0;
        $penjualan->total_harga = 0;
        $penjualan->diskon = 0;
        $penjualan->bayar = 0;
        $penjualan->diterima = 0;
        $penjualan->id_user = auth()->id();
        $penjualan->save();

        session(['id_penjualan' => $penjualan->id_penjualan]);
        return redirect()->route('transaksi.index');
    }
}
