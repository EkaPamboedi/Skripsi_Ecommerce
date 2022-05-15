<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Order;
use App\Models\Order_Produk;
use App\Models\Produk;
use App\Models\Setting;
use Illuminate\Http\Request;

class PenjualanDetailController extends Controller
{
    public function index()
    {

        $produks = Produk::orderBy('nama_produk')->get();
        // Cek apakah ada transaksi yang sedang berjalan
        if ($id_order = session('id_order')) {
            $penjualan = Order::find($id_order);

            return view('admin.penjualan_detail.index', compact('produks' ,'penjualan','id_order'));

        } else {
            if (auth()->user()->level == 1) {
                return redirect()->route('transaksi.baru');
            } else {
                return redirect()->route('login');
            }
        }
    }

    public function data($id)
    {
      // untuk transaksi
        $detail = Order_Produk::with('produk')
            ->where('id_order', $id)
            ->get();

        $data = array();
        $subtotal = 0;
        $diskon = 0;
        $total = 0;
        $total_item = 0;

        foreach ($detail as $item) {
            $row = array();
            // dd($item);
            $row['kode_produk'] = '<span class="label label-success">'. $item->produk['kode_produk'] .'</span';
            $row['nama_produk'] = $item->produk['nama_produk'];
            $row['harga_jual']  = 'Rp. '. format_uang($item->produk['harga_jual']);
            $row['jumlah']      = '<input type="number" class="form-control input-sm quantity" data-id="'. $item->id_order_produk .'" value="'. $item->qty .'">';
            $row['diskon']      = $item->produk['diskon'] . '%';

            if ($item->produk['diskon'] !== 0 ) {
              $diskon = ($item->produk['harga_jual'] * $item->produk['diskon'])/100;
              // dd($total );
              $subtotal = ($item->produk['harga_jual'] - $diskon )* $item->qty;
            } else {
              $subtotal = $item->produk['harga_jual'] * $item->qty;
              // $total_item += $item->qty;
            }
            $row['subtotal']    = 'Rp. '. format_uang($subtotal);
            $row['aksi']        = '<div class="btn-group">
                                    <button onclick="deleteData(`'. route('transaksi.destroy', $item->id_order_produk) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                                </div>';
            $data[] = $row;

            $total += $subtotal;
            $total_item += $item->qty;
        }

        $data[] = [
            'kode_produk' => '
                <div class="total hide">'. $total .'</div>
                <div class="total_item hide">'. $total_item .'</div>',
            'nama_produk' => '',
            'harga_jual'  => '',
            'jumlah'      => '',
            'diskon'      => '',
            'subtotal'    => '',
            'aksi'        => '',
        ];

        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->rawColumns(['aksi', 'kode_produk', 'jumlah'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $diskon = 0;
        $subtotal = 0;

        $produk = Produk::where('id_produk', $request->id_produk)->first();
        if (! $produk) {
            return response()->json('Data gagal disimpan', 400);
        }

        $detail = new Order_Produk();
        $detail->id_order = $request->id_order;
        $detail->id_produk = $produk->id_produk;
        $detail->id_kategori = $produk->id_kategori;
        $detail->qty = 1;
        // $detail->diskon = $produk->diskon;
        if ($produk->diskon !== 0 ) {
          $diskon = ($produk->harga_jual * $produk->diskon)/100;
          // dd($total );
          $subtotal = ($produk->harga_jual - $diskon )* $detail->qty;
        } else {
          $subtotal = $produk->harga_jual * $detail->qty;
          // $total_item += $item->qty;
        }

        $detail->subtotal = $subtotal;
        $detail->save();

        return response()->json('Data berhasil disimpan', 200);
    }

    public function update(Request $request, $id)
    {


        $detail = Order_Produk::
        // find($id);
        with('produk')
        ->where('id_order_produk', $id)->find($id);
        // dd($detail);
        $detail->qty = $request->jumlah;

        if ($detail->produk['diskon'] !== 0 ) {
          $diskon = ($detail->produk['harga_jual'] * $detail->produk['diskon'])/100;
          // dd($total );
          $subtotal = ($detail->produk['harga_jual'] - $diskon )* $detail->qty;
        } else {
          $subtotal = $detail->produk['harga_jual'] * $detail->qty;
          // $total_item = $item->qty;
        }
        $detail->subtotal = $subtotal;
        $detail->update();
    }

    public function destroy($id)
    {
        $detail = Order_Produk::find($id);
        $detail->delete();

        return response(null, 204);
    }

    public function loadForm($diskon = 0, $total = 0, $diterima = 0)
    {
        $bayar   = $total - ($diskon / 100 * $total);
        $kembali = ($diterima != 0) ? $diterima - $bayar : 0;
        $data    = [
            'totalrp' => format_uang($total),
            // 'bayar' => $bayar,
            // 'bayarrp' => format_uang($bayar),
            'terbilang' => ucwords(terbilang($total). ' Rupiah'),
            'kembali' => $kembali,
            'kembalirp' => format_uang($kembali),
            'kembali_terbilang' => ucwords(terbilang($kembali). ' Rupiah'),
        ];

        return response()->json($data);
    }
}
