<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\User;
use Exception;
use Session;
use DB;

use Illuminate\Http\Request;
use App\Models\Ratings;
use App\Models\ProductSimilarity;
// use App\Models\Order;
// use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Order_Produk;
use App\Models\Order;
use App\Models\Setting;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function DataSimiliarity(Request $request, $id){

     }

    public function index(){
      // $Produks = Produk::get();
        // $products        = json_decode(file_get_contents(storage_path('data/products-data.json')));
      // $products = Produk::leftJoin('ratings', 'produk.id_produk', 'ratings.id_produk')
      //                     ->select('ratings.ratings',
      //                               'ratings.user_id',
      //                               'produk.*')
      //                     ->orderBy('ratings.id_produk', 'asc')
      //                     ->get()->toArray();
        $products = DB::table('produk')
        ->join('kategori', 'kategori.id_kategori', '=', 'produk.id_kategori')
        ->get([
          'produk.*',
          'kategori.nama_kategori',
          ])->toArray();


        // INPUTAN ID DARI GAMBAR YG DIPILIH
        $selectedId =
        // intval(
        DB::table('order_produk')
        ->join('order', 'order.id_order', '=', 'order_produk.id_order')
        // ->select('id_produk')
          ->where('order.status', '=' ,'dibayar' )
          // ->where('nama_produk', '=' ,'martabak telor' )
          // ->take(5)
          ->get('order_produk.id_produk')
          // ->pluck('id_produk')
          // ->value('id_produk')
          ->first();
          // ->toArray();
        // dd($selectedId);
        // dd($products);

        if (is_null($selectedId)) {
          throw new Exception('Can\'t find product with that ID.');
        }else {
          // code...
          $selectedProduct = $products[0];
        }
        // dd($selectedProduct);



        // foreach ($selectedIds as $selectedId) {
          // dd($selectedIds);
          // dd($selectedId/);

          // foreach ($selectedIds as $selectedId) {
          $selectedProduct = array_filter($products, function ($product) use ($selectedId){
            return $product->id_produk === $selectedId->id_produk;

          });


        // }

        // dd($selectedProduct);
          // if ($selectedProduct > 1) {
          if (count($selectedProduct)) {
              $selectedProduct = $selectedProduct[array_keys($selectedProduct)[0]];
          }
          // Produk yg di cari kemiripannya
          // dd($selectedProduct);

            $productSimilarity = new ProductSimilarity($products);
            $similarityMatrix  = $productSimilarity->calculateSimilarityMatrix();
            $products          = $productSimilarity->getProductsSortedBySimilarity($selectedId, $similarityMatrix);
        // }

        //Kemiripan perproduk dengan semua produk
        // dd($similarityMatrix);
        // dd($productSimilarity);
        // dd($products);

            return view('kenalkopi.home.index', compact('selectedId', 'selectedProduct', 'products'));
        //   }
        // else {
        //   return view('kenalkopi.home.index', compact('products'));
        // }

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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


}
