<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Models\Produk;
use PDF;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kategori = Kategori::all()->pluck('nama_kategori', 'id_kategori');


        // dd($kategori);
        return view('admin.produk.index', compact('kategori'));
    }

    public function data()
    {
      // Route::/penjualan/data'
        $produk = Produk::leftJoin('kategori', 'kategori.id_kategori', 'produk.id_kategori')
            ->select('produk.*', 'nama_kategori')
            ->orderBy('kode_produk', 'asc')
            ->get();

        return datatables()
            ->of($produk)
            ->addIndexColumn()
            ->addColumn('select_all', function ($produk) {
                return '
                    <input type="checkbox" name="id_produk[]" value="'. $produk->id_produk .'">
                ';
            })
            ->addColumn('kode_produk', function ($produk) {
                return '<span class="label label-success">'. $produk->kode_produk .'</span>';
            })
            ->addColumn('nama_produk', function ($produk) {
                return '<span>'.$produk->nama_produk.'</span>';
            })
            ->addColumn('nama_kategori', function ($produk) {
                return '<span>'.$produk->nama_kategori.'</span>';
            })
            ->addColumn('deskripsi_produk', function ($produk) {
                return '<span>'.$produk->deskripsi_produk.'</span>';
            })
            ->addColumn('harga_beli', function ($produk) {
                return 'Rp.'.format_uang($produk->harga_beli);
            })
            ->addColumn('harga_jual', function ($produk) {
                return 'Rp.'.format_uang($produk->harga_jual);
            })
            ->addColumn('diskon', function ($produk) {
                return $produk->diskon .'%';
            })
            ->addColumn('stok', function ($produk) {
                return $produk->stok;
            })
            ->addColumn('gambar_produk', function ($produk) {
                return '<img src="'. $produk->gambar_produk .'" width="100px">';
            })

            ->addColumn('aksi', function ($produk) {
                return '
                <div class="btn-group-vertical">
                    <button type="button" onclick="editForm(`'. route('produk.update', $produk->id_produk) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button> <br>
                    <button type="button" onclick="deleteData(`'. route('produk.destroy', $produk->id_produk) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                </div>';
            })
            ->rawColumns(['aksi','nama_produk','nama_kategori','kode_produk','deskripsi_produk','status','gambar_produk' , 'select_all'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $produk = Produk::latest()->first() ?? new Produk();
      // temporary variable
      $saveData = $request->except('gambar_produk');

      $saveData['kode_produk'] = 'P'. tambah_nol_didepan((int)$produk->id_produk +1, 6);

      if ($request->hasFile('gambar_produk')) {
          $file = $request->file('gambar_produk');
          $nama = 'produk-' . date('YmdHis') . '.' . $file->getClientOriginalExtension();
          $file->move(public_path('/kenalkopi/produk_img'), $nama);

          $saveData['gambar_produk'] = "/kenalkopi/produk_img/$nama";
      }

      $produk = Produk::create($saveData);

      return response()->json('Data berhasil disimpan', 200);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $produk = Produk::find($id);

        return response()->json($produk);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $produk = Produk::find($id);

        if (!$request->hasFile('gambar_produk')) {
            $editData = $request->except('gambar_produk');
            $produk->update($editData);
          }
          elseif (!empty($request->file('gambar_produk')) &&
                  $request->file('gambar_produk')->isValid()) {
                    $file = $request->file('gambar_produk');
                    $nama = 'produk-' . date('YmdHis') . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('/kenalkopi/produk_img/'), $nama);

                    unlink(public_path($produk->gambar_produk));
                    $editData = $request->except('gambar_produk');
                    $editData['gambar_produk'] = "/kenalkopi/produk_img/$nama";
                    $produk->update($editData);
                  }
                  return response()->json('Data berhasil disimpan', 200);
            // $saveData['gambar_produk']= "/kenalkopi/produk_img/$nama";
      }

        // $produk = Produk::find($id);
        // $produk->update($request->all());
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $produk = Produk::find($id);
        $produk->delete();

        return response(null, 204);
    }

    public function deleteSelected(Request $request)
    {
        foreach ($request->id_produk as $id) {
            $produk = Produk::find($id);
            $produk->delete();
        }

        return response(null, 204);
    }

    // public function produk_nonaktif($produk_id){
    //   $produk = Produk::find($produk_id);
    //   $produk->status=0;
    //   $produk->save();
    //   return back();
    // }
    // public function produk_aktif($produk_id){
    //     $produk = Produk::find($produk_id);
    //     $produk->status=1;
    //     $produk->save();
    //     return back();
    //   }

    public function cetakBarcode(Request $request)
    {
        $dataproduk = array();
        foreach ($request->id_produk as $id) {
            $produk = Produk::find($id);
            $dataproduk[] = $produk;
        }

        $no  = 1;
        $pdf = PDF::loadView('produk.barcode', compact('dataproduk', 'no'));
        $pdf->setPaper('a4', 'potrait');
        return $pdf->stream('produk.pdf');
    }
}
