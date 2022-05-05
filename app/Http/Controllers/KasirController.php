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

class KasirController extends Controller
{
  public function index()
  {
    // ini buat nampilin daftar orde
    $produks = Produk::orderBy('nama_produk')->get();
    // $items = DB::table('penjualan_detail')
    // ->join('produk', 'produk.id_produk', '=' , 'penjualan_detail.id_produk')
    // ->join('penjualan', 'penjualan.id_penjualan', '=' , 'penjualan_detail.id_penjualan')
    // ->select(
      // 'produk.kode_produk','produk.nama_produk','produk.harga_jual','produk.diskon',
    //   'penjualan.*',
    //   'penjualan_detail.*'
    //                 )
    // ->get();

    // $id_penjualan = session('id_penjualan');
    // $penjualan = penjualan::where('$id_penjualan',$id_penjualan)->get();
    // dd($id_penjualan);
    if ($id_penjualan = session('id_penjualan')) {
        $penjualan = Penjualan::find($id_penjualan);
        // $memberSelected = $penjualan->member ?? new Member();

        // return view('penjualan_detail.index', compact('produk', 'member', 'diskon', 'id_penjualan', 'penjualan'));
        return view('admin.kasir.index', compact('produks' ,'penjualan','id_penjualan'));
    } else {
        if (auth()->user()->level == 1) {
            return redirect()->route('transaksi.create');
        } else {
            return redirect()->route('login');
        }
        // dd($penjualan = Penjualan::find($id_penjualan));
    }

    // return view('admin.kasir.index', compact('produks','items'));
    // return view('admin.kasir.index');

  }
  public function data($id)
  {
      $items = PenjualanDetail::with('produk')
          ->where('id_penjualan', $id)
          ->get();
      return $items;
      // dd($items);

      // $items = DB::table('penjualan_detail')
      // ->join('produk', 'produk.id_produk', '=' , 'penjualan_detail.id_produk')
      // ->join('penjualan', 'penjualan.id_penjualan', '=' , 'penjualan_detail.id_penjualan')
      // ->where('penjualan.id_penjualan', $id)
      // ->select(
      //   'produk.kode_produk','produk.nama_produk','produk.harga_jual','produk.diskon',
      //               'penjualan.*',
      //               'penjualan_detail.*'
      //                 )
      // ->get();
      // $items = PenjualanDetail::with('produk')
      //     ->where('id_penjualan', $id)
      //     ->get();
      // return $items;

      $data = array();
      $total = 0;
      $total_item = 0;

      foreach ($items as $item) {
          $row = array();
          $row['kode_produk'] = '<span class="label label-success">'. $item->kode_produk .'</span';
          $row['nama_produk'] = $item->nama_produk;
          $row['harga_jual']  = 'Rp. '. format_uang($item->harga_jual);
          // $row['jumlah']      = '<input type="number" class="form-control input-sm quantity" data-id="'. $item->id_penjualan_detail .'" value="'. $item->qty .'">';
          $row['jumlah']      = '<input type="number" class="form-control input-sm quantity" data-id="'. $item->id_penjualan_detail .'" value="'. $item->qty .'">';
          $row['diskon']      = $item->diskon.'%';
          // $row['diskon'] = $item->produk['nama_produk'];
          $row['subtotal']    = 'Rp. '. format_uang($item->subtotal);
          $row['aksi']        = '<div class="btn-group">
                                  <button onclick="deleteData(`'. route('transaksi.destroy', $item->id_penjualan_detail) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                              </div>';
          $data[] = $row;

          if ($item->diskon != 0 ) {
            $total += ($item->harga_jual*$item->diskon/100) * $item->qty;
            $total_item += $item->qty;
          } else {
            $total += $item->harga_jual * $item->qty;
            $total_item += $item->qty;
          }
      }
      // buat ngisi tabel di kasir
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
    // return view('admin.kasir.index', compact('produk'));
    }

    public function store(Request $request)
    {
        $produk = Produk::where('id_produk', $request->id_produk)->first();
        if (! $produk) {
            return response()->json('Data gagal disimpan', 400);
        }

        $detail = new PenjualanDetail();
        $detail->id_penjualan = $request->id_penjualan;
        $detail->id_produk = $produk->id_produk;
        $detail->harga_jual = $produk->harga_jual;
        $detail->qty = 1;
        $detail->diskon = $produk->diskon;
        $detail->subtotal = ($produk->harga_jual * $produk->diskon/100) * $produk->qty;
        $detail->save();

        return response()->json('Data berhasil disimpan', 200);
    }
    
    public function update(Request $request, $id)
    {
        $detail = PenjualanDetail::find($id);
        $detail->jumlah = $request->jumlah;
        $detail->subtotal = $detail->harga_jual * $request->jumlah;
        $detail->update();
    }

    public function destroy($id)
    {
        $detail = PenjualanDetail::find($id);
        $detail->delete();

        return response(null, 204);
    }

    public function loadForm( $total = 0, $diterima = 0)
    {
      // $bayar   = $total - ($diskon / 100 * $total);
        // $total_price  = $total;
        $kembali = ($diterima != 0) ? $diterima - $total : 0;
        $data    = [
            'totalrp' => format_uang($total),
            // 'bayar' => $bayar,
            // 'bayarrp' => format_uang($bayar),
            // 'terbilang' => ucwords(terbilang($bayar). ' Rupiah'),
            'kembalirp' => format_uang($kembali),
            'kembali_terbilang' => ucwords(terbilang($kembali). ' Rupiah'),
        ];

        return response()->json($data);
    }
}
