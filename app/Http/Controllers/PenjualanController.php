<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\PenjualanDetail;
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
      // ini buat nampilin daftar order
        return view('admin.penjualan.index');
    }

    //ini untuk data pada table untuk dafar order
    public function data()
    {
        $penjualan = Penjualan::orderBy('id_penjualan', 'desc')->get();
        return datatables()
            ->of($penjualan)
            ->addIndexColumn()
            ->addColumn('tanggal', function ($penjualan) {
              return tanggal_indonesia($penjualan->created_at, false);
            })
            ->addColumn('nama_pemesan', function ($penjualan) {
                return $penjualan->first_name;
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
      // $penjualan->id_member = null;
      // $penjualan->total_item = 0;
      $penjualan->code_order = mt_rand(1000000000, 9999999999);
      $penjualan->total_price = 0;
      $penjualan->first_name = "";
      $penjualan->last_name = "";
      $penjualan->notes = "";
      $penjualan->diterima = 0;
      $penjualan->dikembalikan = 0;
      $penjualan->jenis_pembayaran = "ditempat";
      // $penjualan->id_user = auth()->id();
      $penjualan->save();

        session(['id_penjualan' => $penjualan->id_penjualan]);
        return redirect()->route('transaksi.index');
    }

    public function store(Request $request)
    {
        $penjualan = Penjualan::findOrFail($request->id_penjualan);
        // $penjualan->id_member = $request->id_member;
        $penjualan->total_price = $request->total;
        // $penjualan->total_item = $request->total_item;
        $penjualan->first_name = $request->first_name;
        $penjualan->last_name = $request->last_name;
        $penjualan->notes = $request->notes;
        // $penjualan->diskon = $request->diskon;
        $penjualan->diterima = $request->diterima;
        $penjualan->dikembalikan = $request->dikembalikan;
        $penjualan->update();

        $detail = PenjualanDetail::where('id_penjualan', $penjualan->id_penjualan)->get();
        foreach ($detail as $item) {
            // $item->diskon = $request->diskon;
            // $item->update();

            $produk = Produk::find($item->id_produk);
            $produk->stok -= $item->jumlah;
            $produk->update();
        }

        return redirect()->route('transaksi.selesai');
    }

    public function show($id)
    {
        $detail = PenjualanDetail::with('produk')->where('id_penjualan', $id)->get();
        // $detail = DB::table('penjualan_detail')
        // ->join('produk',
        //       'produk.id_produk', '=' ,'penjualan_detail.id_produk')
        // ->join('penjualan',
        //       'penjualan.id_penjualan', '=' ,'penjualan_detail.id_penjualan')
        // ->select('produk.kode_produk','produk.nama_produk','produk.harga_jual','produk.diskon',
        //               'penjualan.*',
        //               'penjualan_detail.*'
        //                 )
        // ->get();
        // dd($detail);
        // $subtotal = 0;
        // $diskon = 0;
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
            // ->addColumn('bayar', function ($detail) {
            //     return 'Rp. '. format_uang($detail->bayar);
            // })
            // ->addColumn('diterima', function ($detail) {
            // })
            ->rawColumns(['kode_produk'])
            ->make(true);
    }

    public function destroy($id)
    {
        $penjualan = Penjualan::find($id);
        $detail    = PenjualanDetail::where('id_penjualan', $penjualan->id_penjualan)->get();
        foreach ($detail as $item) {
            $item->delete();
        }

        $penjualan->delete();

        return response(null, 204);
    }

    public function kasir_destroy($id)
    {
        $detail = PenjualanDetail::find($id);
        $detail->delete();

        return response(null, 204);
    }
    public function selesai()
    {
        $setting = Setting::first();

        return view('admin.penjualan.selesai', compact('setting'));
    }

    public function notaKecil()
    {   $i = 1;
        $setting = Setting::first();
        $penjualan = Penjualan::find(session('id_penjualan'));
        if (! $penjualan) {
            abort(404);
        }
        $detail = PenjualanDetail::with('produk')
            ->where('id_penjualan', session('id_penjualan'))
            ->get();

        return view('admin.penjualan.nota_kecil', compact('setting', 'penjualan','i', 'detail'));
    }

    public function notaBesar()
    {
        $setting = Setting::first();
        $penjualan = Penjualan::find(session('id_penjualan'));
        if (! $penjualan) {
            abort(404);
        }
        $detail = PenjualanDetail::with('produk')
            ->where('id_penjualan', session('id_penjualan'))
            ->get();

        $pdf = PDF::loadView('penjualan.nota_besar', compact('setting', 'penjualan', 'detail'));
        $pdf->setPaper(0,0,609,440, 'potrait');
        return $pdf->stream('Transaksi-'. date('Y-m-d-his') .'.pdf');
    }
}
