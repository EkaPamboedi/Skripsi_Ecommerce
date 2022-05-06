<?php

namespace App\Http\Controllers;
// namespace App\Http\Controllers\Auth;
// use Illuminate\Database\Eloquent\Model;

use Auth;
use App\Models\User;
use App\Models\Kategori;
use App\Models\Member;
use App\Models\Pembelian;
use App\Models\Pengeluaran;
use App\Models\Penjualan;
use App\Models\Produk;
use App\Models\Order;
use App\Models\Setting;
use App\Models\Supplier;
use Illuminate\Http\Request;


class DashboardController extends Controller
{
  /**
 * Create a new controller instance.
 *
 * @return void
 */
public function __construct()
{
    $this->middleware('auth');
}

/**
 * Show the application dashboard.
 *
 * @return \Illuminate\Contracts\Support\Renderable
 */
// public function indexx()
// {
//     $data = User::find(Auth::user()->id);
//     // dd($data);
//     if ($data) {
//         return view('admin.home.home',compact('data'));
//     }
//
//     abort(404);
// }
  public function index(){
          $kategori = Kategori::count();
          $produk = Produk::count();
          $supplier = Supplier::count();
          // $setting = Setting::get();
          $order = Order::count() + Penjualan::count();
          // $order1 = Penjualan::count();
          // $order2 = Order::count();
          // dd($order2);

          $tanggal_awal = date('Y-m-01');
          $tanggal_akhir = date('Y-m-d');

          $data_tanggal = array();
          $data_pendapatan = array();

          while (strtotime($tanggal_awal) <= strtotime($tanggal_akhir)) {
              $data_tanggal[] = (int) substr($tanggal_awal, 8, 2);

              $total_penjualan = Penjualan::where('created_at', 'LIKE', "%$tanggal_awal%")->sum('diterima');
              $total_pembelian = Pembelian::where('created_at', 'LIKE', "%$tanggal_awal%")->sum('bayar');
              $total_pengeluaran = Pengeluaran::where('created_at', 'LIKE', "%$tanggal_awal%")->sum('nominal');

              $pendapatan = $total_penjualan - $total_pembelian - $total_pengeluaran;
              $data_pendapatan[] += $pendapatan;
              $tanggal_awal = date('Y-m-d', strtotime("+1 day", strtotime($tanggal_awal)));
          }
// Original
          // if (auth()->user()->level == 1) {
          //     return view('admin.home.dashboard', compact('kategori', 'produk', 'supplier', 'member', 'tanggal_awal', 'tanggal_akhir', 'data_tanggal', 'data_pendapatan'));
          // } else {
          //     return view('kenalkopi.produk.index');
          // }
// Menghapus member
          if (auth()->user()->level == 1) {
              return view('admin.home.dashboard', compact('order','kategori', 'produk', 'supplier', 'tanggal_awal', 'tanggal_akhir', 'data_tanggal', 'data_pendapatan'));
          } else {
              return view('kenalkopi.produk.index');
          }
      }
}
