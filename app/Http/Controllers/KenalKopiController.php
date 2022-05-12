<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Models\Kategori;
use Carbon\Carbon;
use App\Models\Produk;
use Cart;
use App\Models\Order;
use App\Models\Order_Produk;
use Session;

class KenalKopiController extends Controller
{
  public function index()
  {
    if ($token = session('token')) {

    $produks = Produk::leftJoin('kategori', 'kategori.id_kategori','produk.id_kategori')
    ->select('produk.*', 'nama_kategori')
    ->orderBy('nama_produk','desc')
    ->where('stok','>=','1')
    ->get();

        return view('kenal_kopi.produk.index',compact('produks'));
      }else{
        return redirect('/kenalkopi/login')->with('message', 'You need to scan Qr First!');
      }
  }

  public function insert(Request $request)
  {
    $produk = Produk::leftJoin('kategori', 'kategori.id_kategori','produk.id_kategori')
        ->select('produk.*',
                 'kategori.nama_kategori')
        ->where('id_produk', $request->id_produk)
        ->first();

    Cart::add([
      'id' => $request->id_produk,
      'qty' => $request->qty,
      'name' => $produk->nama_produk,
      'price' => $produk->harga_jual,
      'weight' => 550,
      'options' =>
      [
        'id_kategori' => $produk->id_kategori,
          'diskon' => $produk->diskon,
          'image' => $produk->gambar_produk,
        ],
    ]);
        return redirect()->back();
  }

}
