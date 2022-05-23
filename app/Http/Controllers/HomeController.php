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
      if ($token = session('token')) {
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

          $id_order = Order::where('login_token', '=' , $token ,  'AND' , 'order.status', '=' , 'dibayar')
          ->orderBy('id_order','DESC')->select('id_order')->first();
          $order_id = $id_order->id_order;
          // dd($id_order);
          //
          $id_order_produk = Order_Produk::where('id_order', $order_id)->orderBy('qty' , 'DESC')->select('id_order_produk')->first();
          $id_produk = $id_order_produk->id_order_produk;
          // dd($id_produk);

        // INPUTAN ID DARI PRODUK YG DIORDER
        $id = Order_Produk::where('id_order_produk', '=', $id_produk)->select('id_produk')
        ->get()->toArray();
        // $selectedId = Order_Produk::where('id_order_produk', '=', $id_produk)->select('id_produk')
        // ->get();
        $selectedId = $id[0];
        // dd($id);
        // dd($selectedId);

        if (is_null($selectedId)) {
          throw new Exception('Can\'t find product with that ID.');
        }else {
          $selectedProduct = $products;
        }

          //Iterates over each value in the array passing them to the callback function. If the callback function returns true, the current value from array is returned into the result array.

          //jadi kalo dari return nya menemukan id_produk yang sama, maka id_produk itu akan masu ksebagai isi di variable //
          //$selectedProduct sebagai produk yang ingin di bandingkan nantinya.
          $selectedProduct = array_filter($products, function ($product) use ($selectedId){
            return $product->id_produk === $selectedId;
          });

          if (count($selectedProduct)) {
              $selectedProduct = $selectedProduct[array_keys($selectedProduct)[0]];
          }

            $productSimilarity = new ProductSimilarity($products);
            $similarityMatrix  = $productSimilarity->calculateSimilarityMatrix();
            $products          = $productSimilarity->getProductsSortedBySimilarity($selectedId, $similarityMatrix);

        //Kemiripan perproduk dengan semua produk
        // dd($productSimilarity);
        // dd($similarityMatrix);
        // dd($productSimilarity);
        // dd($products);

            return view('kenal_kopi.home.index', compact('selectedId', 'selectedProduct', 'products'));
          }
        //   }
        else {
          return redirect('/kenalkopi/login');
        }

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
