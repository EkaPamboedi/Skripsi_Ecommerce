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
    // buat manggil id kategoriProduk untuk pemanggilan list Kategori di nav bar ??
    // $kategori_produks = KategoriProduks::where('status_kategori_produk','1')->get();

      // $produks = Produk::orderBy('nama_produk','desc')->where('stok','>=','1')->get();
      $produks = Produk::leftJoin('kategori', 'kategori.id_kategori','produk.id_kategori')
          ->select('produk.*', 'nama_kategori')
          ->orderBy('nama_produk','desc')
          ->where('stok','>=','1')
          ->get();
          // dd($produks);
      // dd($produks);
      return view('kenalkopi.produk.index',compact('produks'));
  }

  public function insert(Request $request)
  {
    // $produk = Produk::
    // where('id_produk', $request->id_produk)->
    // first();
    $produk = Produk::leftJoin('kategori', 'kategori.id_kategori','produk.id_kategori')
        ->select('produk.*',
                 'kategori.nama_kategori')
        ->where('id_produk', $request->id_produk)
        ->first();
        // dd($produk);

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
    // dd($produk);

    // Cart::setDiscount([
    //   'id' => $request->id_produk,
    //   'options' =>[
    //     'diskon' => $produk->diskon,
    //     ],
    // ]);
    // return redirect()->route('tampil_cart')->with('');
        // Session::flash('status','Product berhasil dimasukkan ke keranjang');
        return redirect()->back();
  }


}
