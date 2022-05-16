<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Order_Produk;
use App\Models\Produk;
// use App\Models\Member;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use PDF;
use DB;

class PenjualanController extends Controller
{
    public function index()
    {
      $penjualan = Order::select('id_order')->get();
      // ini buat nampilin daftar order
        return view('admin.penjualan.index', compact('penjualan'));
    }

    //ini untuk data pada table untuk dafar order
    public function data()
    {
        $penjualan = Order::orderBy('id_order', 'desc')->get();
        return datatables()
            ->of($penjualan)
            ->addIndexColumn()
            ->addColumn('tanggal', function ($penjualan) {
              return tanggal_indonesia($penjualan->created_at, false);
            })
            ->addColumn('code_order', function ($penjualan) {
              return ($penjualan->code_order);
            })
            ->addColumn('nama_pemesan', function ($penjualan) {
                return $penjualan->first_name." ".$penjualan->last_name;
            })
            ->addColumn('jenis_pembayaran', function ($penjualan) {
                return $penjualan->jenis_pembayaran;
            })
            ->addColumn('total_harga', function ($penjualan) {
                return 'Rp. '. format_uang($penjualan->total_price);
            })
            ->addColumn('aksi', function ($penjualan) {
                return '
                <div class="btn-group">
                    <a type="button" style="margin-right: 5px;" data-placement="top" title="Lihat Notes" class="btn btn-xs btn-info btn-flat" href="'.route('penjualan.detail', $penjualan->id_order) .'">
                    <svg style="margin-top:5px;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-text" viewBox="0 0 16 16"><path d="M5 4a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1H5zm-.5 2.5A.5.5 0 0 1 5 6h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5zM5 8a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1H5zm0 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1H5z"/><path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2zm10-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1z"/></svg></a>
                    <button style="margin-right: 5px; padding:5px;" data-toggle="tooltip" data-placement="top" title="Detail Order" onclick="showDetail(`'. route('penjualan.show', $penjualan->id_order) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-eye"></i></button>
                    <button style="margin-right: 5px; padding:5px;" data-toggle="tooltip" data-placement="top" title="Hapus!" onclick="deleteData(`'. route('penjualan.destroy', $penjualan->id_order) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                </div>
                ';
            })
            ->rawColumns(['aksi', 'kode_member'])
            ->make(true);
            // ->compact('penjualan');
    }

    public function create()
    {
      $penjualan = new Order();
      // $penjualan->id_member = null;
      // $penjualan->total_item = 0;
      $penjualan->code_order = mt_rand(1000000000, 9999999999);
      $penjualan->total_price = 0;
      $penjualan->first_name = "";
      $penjualan->last_name = "";
      $penjualan->notes = "";
      $penjualan->diterima = 0;
      $penjualan->dikembalikan = 0;
      $penjualan->status = "belum bayar";
      $penjualan->jenis_pembayaran = "ditempat";
      $penjualan->stat_pemesanan = "masuk";
      // $penjualan->id_user = auth()->id();
      $penjualan->save();

        session(['id_order' => $penjualan->id_order]);
        return redirect()->route('transaksi.index');
    }

    public function store(Request $request)
    {
        $penjualan = Order::findOrFail($request->id_order);
        // $penjualan->id_member = $request->id_member;
        $penjualan->total_price = $request->total;
        // $penjualan->total_item = $request->total_item;
        $penjualan->first_name = $request->first_name;
        $penjualan->last_name = $request->last_name;
        $penjualan->no_meja = $request->no_meja;
        $penjualan->notes = $request->notes;
        // $penjualan->diskon = $request->diskon;
        $penjualan->diterima = $request->diterima;
        $penjualan->status = "dibayar";
        $penjualan->dikembalikan = $request->dikembalikan;
        $penjualan->update();

        $detail = Order_Produk::where('id_order', $penjualan->id_order)->get();
        foreach ($detail as $item) {
            // $item->diskon = $request->diskon;
            // $item->update();

            $produk = Produk::find($item->id_produk);
            $produk->stok -= $item->jumlah;
            $produk->update();
        }

        return redirect()->route('transaksi.selesai');
    }
    public function detail($id)
    {
      $Details = Order_Produk::leftJoin('produk', 'produk.id_produk', 'order_produk.id_produk')
      ->select('order_produk.*', 'produk.*')
      ->where('id_order',$id)->get();
      $Orders = Order::where('id_order',$id)->get();
      // dd($Order);
        // $Details = Order_Produk::where('id_order',$id)->get();

        return view('admin.penjualan.order_detail',compact('Details','Orders'));
    }
    public function show($id)
    {
        $detail = Order_Produk::with('produk')->where('id_order', $id)->get();
        return datatables()
            ->of($detail)
            ->addIndexColumn()
            ->addColumn('kode_produk', function ($detail) {
                return '<span class="label label-success">'. $detail->produk['kode_produk'] .'</span>';
            })
            ->addColumn('nama_produk', function ($detail) {
                return $detail->produk['nama_produk'];
            })
            ->addColumn('harga_jual', function ($detail) {
                return 'Rp. '. format_uang($detail->produk['harga_jual']);
            })
            ->addColumn('diskon', function ($detail) {
              return ($detail->produk['diskon']).'%';
            })
            ->addColumn('jumlah', function ($detail) {
                return format_uang($detail->qty);
            })
            ->addColumn('subtotal', function ($detail) {
                return 'Rp. '. format_uang($detail->subtotal);
            })
            ->addColumn('bayar', function ($detail) {
                return 'Rp. '. format_uang($detail->bayar);
            })
            ->addColumn('diterima', function ($detail) {
            })
            ->rawColumns(['kode_produk'])
            ->make(true);
    }

    public function destroy($id)
    {
        $penjualan = Order::find($id);
        $detail    = Order_Produk::where('id_order', $penjualan->id_order)->get();
        foreach ($detail as $item) {
            $item->delete();
        }

        $penjualan->delete();

        return response(null, 204);
    }

    public function kasir_destroy($id)
    {
        $detail = Order_Produk::find($id);
        $detail->delete();

        return response(null, 204);
    }
    public function selesai()
    {
        $setting = Setting::first();

        return view('admin.penjualan.selesai', compact('setting'));
    }

    public function penjualan_notaKecil($id)
    {   $i = 1;
        $setting = Setting::first();
        $penjualan = Order::find($id);
        if (! $penjualan) {
            abort(404);
        }
        $detail = Order_Produk::with('produk')
            ->where('id_order', $id)
            ->get();

        return view('admin.penjualan.nota_kecil', compact('setting', 'penjualan','i', 'detail'));
    }
    public function notaKecil()
    {   $i = 1;
        $setting = Setting::first();
        $penjualan = Order::find(session('id_order'));
        if (! $penjualan) {
            abort(404);
        }
        $detail = Order_Produk::with('produk')
            ->where('id_order', session('id_order'))
            ->get();

        return view('admin.penjualan.nota_kecil', compact('setting', 'penjualan','i', 'detail'));
    }

    public function notaBesar()
    {
        $setting = Setting::first();
        $penjualan = Order::find(session('id_order'));
        if (! $penjualan) {
            abort(404);
        }
        $detail = Order_Produk::with('produk')
            ->where('id_order', session('id_order'))
            ->get();

        $pdf = PDF::loadView('penjualan.nota_besar', compact('setting', 'penjualan', 'detail'));
        $pdf->setPaper(0,0,609,440, 'potrait');
        return $pdf->stream('Transaksi-'. date('Y-m-d-his') .'.pdf');
    }
}
