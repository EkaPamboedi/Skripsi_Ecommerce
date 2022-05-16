<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\OrderExport;
use App\Exports\OrderExportPaid;
use App\Models\Order;
use App\Models\Order_Produk;
use App\Models\Penjualan;
use Auth;
// use PDF;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Perlu ditambah
        // status pemesanan seperti order masuk,on progress,ready dan Selesai
        //Order perlu penambahan field jenis pembayaran
        //Penjualan perlu penambahan field no meja
        $Orders = Order::
        where('status', '=' , 'dibayar')
        ->where('stat_pemesanan', '=' , 'masuk')
        ->select('code_order','first_name', 'last_name','customer_email', 'no_meja' ,'total_price', 'jenis_pembayaran','notes','status','updated_at')->get();

        $O_Process = Order::where('status', '=' , 'dibayar')
        ->where('stat_pemesanan', '=' , 'proses')
        ->select('code_order','first_name', 'last_name','customer_email', 'no_meja' ,'total_price', 'jenis_pembayaran','notes','status','updated_at')->get();

        $O_Ready = Order::where('status', '=' , 'dibayar')
        ->where('stat_pemesanan', '=' , 'ready')
        ->select('code_order','first_name', 'last_name','customer_email', 'no_meja' ,'total_price', 'jenis_pembayaran','notes','status','updated_at')->get();

        $O_Selesai = Order::where('status', '=' , 'dibayar')
        ->where('stat_pemesanan', '=' , 'selesai')
        ->select('code_order','first_name', 'last_name','customer_email', 'no_meja' ,'total_price', 'jenis_pembayaran','notes','status','updated_at')->get();

        return view('admin.order.index',compact('Orders','O_Process','O_Ready','O_Selesai'));
    }


    public function data_order_masuk()
    {
      $Orders = Order::
      where('status', '=' , 'dibayar')
      ->where('stat_pemesanan', '=' , 'masuk')
      ->select('id_order','code_order','first_name', 'last_name','customer_email', 'no_meja' ,'total_price', 'jenis_pembayaran','notes','status','updated_at')->get();

      return datatables()
          ->of($Orders)
          ->addIndexColumn()
          ->addColumn('order_masuk', function ($Orders) {
              return '
              <tr>
                <div  style="background-color:white;" class="info-box" >

                  <span class="info-box-icon" style="background-color:#396EB0;">
                    <span class="info-box-text" style="color:white;">'.$Orders->no_meja .' | '.$Orders->jenis_pembayaran. '</span>
                  </span>
                  <div class="info-box-content" >
                    <span class="info-box-text">'.$Orders->first_name.' ' .$Orders->last_name.'</span>
                    <span class="info-box-number">'.$Orders->code_order.'</span>
                        <div class="btn-group" role="group" aria-label="Basic example">
                          <button type="button" class="btn btn-warning btn-sm" >
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-receipt-cutoff" viewBox="0 0 16 16">
                              <path d="M3 4.5a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zM11.5 4a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1z"/>
                              <path d="M2.354.646a.5.5 0 0 0-.801.13l-.5 1A.5.5 0 0 0 1 2v13H.5a.5.5 0 0 0 0 1h15a.5.5 0 0 0 0-1H15V2a.5.5 0 0 0-.053-.224l-.5-1a.5.5 0 0 0-.8-.13L13 1.293l-.646-.647a.5.5 0 0 0-.708 0L11 1.293l-.646-.647a.5.5 0 0 0-.708 0L9 1.293 8.354.646a.5.5 0 0 0-.708 0L7 1.293 6.354.646a.5.5 0 0 0-.708 0L5 1.293 4.354.646a.5.5 0 0 0-.708 0L3 1.293 2.354.646zm-.217 1.198.51.51a.5.5 0 0 0 .707 0L4 1.707l.646.647a.5.5 0 0 0 .708 0L6 1.707l.646.647a.5.5 0 0 0 .708 0L8 1.707l.646.647a.5.5 0 0 0 .708 0L10 1.707l.646.647a.5.5 0 0 0 .708 0L12 1.707l.646.647a.5.5 0 0 0 .708 0l.509-.51.137.274V15H2V2.118l.137-.274z"/></svg></button>

                          <button type="button" class="btn btn-primary btn-sm" onclick="updateProcess(`'. route('order.process', $Orders->id_order) .'`)">
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-square" viewBox="0 0 16 16">
                              <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                              <path d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.235.235 0 0 1 .02-.022z"/></svg> </button>

                          <button type="button" class="btn btn-danger btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-square" viewBox="0 0 16 16">
                              <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                              <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                            </svg></button>
                        </div>
                  </div>
                </div>
              </tr>
              ';
          })
          ->rawColumns(['order_masuk'])
          ->make(true);

    }

    public function data_order_process()
    {
      $Orders = Order::
      where('status', '=' , 'dibayar')
      ->where('stat_pemesanan', '=' , 'process')
      ->select('id_order','code_order','first_name', 'last_name','customer_email', 'no_meja' ,'total_price', 'jenis_pembayaran','notes','status','updated_at')->get();

      return datatables()
          ->of($Orders)
          ->addIndexColumn()
          ->addColumn('order_process', function ($Orders) {
              return '
              <tr>
              <div  style="background-color:white;" class="info-box" >
                <span class="info-box-icon" style="background-color:#FFBD35;">
                    <span class="info-box-text" style="color:white;">'.$Orders->no_meja .' | '.$Orders->jenis_pembayaran. '</span>
                  </span>
                  <div class="info-box-content" >
                    <span class="info-box-text">'.$Orders->first_name.' ' .$Orders->last_name.'</span>
                    <span class="info-box-number">'.$Orders->code_order.'</span>
                        <div class="btn-group" role="group" aria-label="Basic example">
                          <button type="button" class="btn btn-warning btn-sm" >
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-receipt-cutoff" viewBox="0 0 16 16">
                              <path d="M3 4.5a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zM11.5 4a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1z"/>
                              <path d="M2.354.646a.5.5 0 0 0-.801.13l-.5 1A.5.5 0 0 0 1 2v13H.5a.5.5 0 0 0 0 1h15a.5.5 0 0 0 0-1H15V2a.5.5 0 0 0-.053-.224l-.5-1a.5.5 0 0 0-.8-.13L13 1.293l-.646-.647a.5.5 0 0 0-.708 0L11 1.293l-.646-.647a.5.5 0 0 0-.708 0L9 1.293 8.354.646a.5.5 0 0 0-.708 0L7 1.293 6.354.646a.5.5 0 0 0-.708 0L5 1.293 4.354.646a.5.5 0 0 0-.708 0L3 1.293 2.354.646zm-.217 1.198.51.51a.5.5 0 0 0 .707 0L4 1.707l.646.647a.5.5 0 0 0 .708 0L6 1.707l.646.647a.5.5 0 0 0 .708 0L8 1.707l.646.647a.5.5 0 0 0 .708 0L10 1.707l.646.647a.5.5 0 0 0 .708 0L12 1.707l.646.647a.5.5 0 0 0 .708 0l.509-.51.137.274V15H2V2.118l.137-.274z"/></svg></button>

                          <button type="button" class="btn btn-primary btn-sm" onclick="updateReady(`'. route('order.ready', $Orders->id_order) .'`)">
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-square" viewBox="0 0 16 16">
                              <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                              <path d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.235.235 0 0 1 .02-.022z"/></svg> </button>

                          <button type="button" class="btn btn-danger btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-square" viewBox="0 0 16 16">
                              <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                              <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                            </svg></button>
                        </div>
                  </div>
                </div>
              </tr>
              ';
          })
          ->rawColumns(['order_process'])
          ->make(true);

    }

    public function data_order_ready()
    {
      $Orders = Order::
      where('status', '=' , 'dibayar')
      ->where('stat_pemesanan', '=' , 'ready')
      ->select('id_order','code_order','first_name', 'last_name','customer_email', 'no_meja' ,'total_price', 'jenis_pembayaran','notes','status','updated_at')->get();

      return datatables()
          ->of($Orders)
          ->addIndexColumn()
          ->addColumn('order_ready', function ($Orders) {
              return '
              <tr>
                <div  style="background-color:white;" class="info-box" >

                  <span class="info-box-icon" style="background-color:#3FA796;">
                    <span class="info-box-text" style="color:white;">'.$Orders->no_meja .' | '.$Orders->jenis_pembayaran. '</span>
                  </span>
                  <div class="info-box-content" >
                    <span class="info-box-text">'.$Orders->first_name.' ' .$Orders->last_name.'</span>
                    <span class="info-box-number">'.$Orders->code_order.'</span>
                        <div class="btn-group" role="group" aria-label="Basic example">
                          <button type="button" class="btn btn-warning btn-sm" >
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-receipt-cutoff" viewBox="0 0 16 16">
                              <path d="M3 4.5a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zM11.5 4a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1z"/>
                              <path d="M2.354.646a.5.5 0 0 0-.801.13l-.5 1A.5.5 0 0 0 1 2v13H.5a.5.5 0 0 0 0 1h15a.5.5 0 0 0 0-1H15V2a.5.5 0 0 0-.053-.224l-.5-1a.5.5 0 0 0-.8-.13L13 1.293l-.646-.647a.5.5 0 0 0-.708 0L11 1.293l-.646-.647a.5.5 0 0 0-.708 0L9 1.293 8.354.646a.5.5 0 0 0-.708 0L7 1.293 6.354.646a.5.5 0 0 0-.708 0L5 1.293 4.354.646a.5.5 0 0 0-.708 0L3 1.293 2.354.646zm-.217 1.198.51.51a.5.5 0 0 0 .707 0L4 1.707l.646.647a.5.5 0 0 0 .708 0L6 1.707l.646.647a.5.5 0 0 0 .708 0L8 1.707l.646.647a.5.5 0 0 0 .708 0L10 1.707l.646.647a.5.5 0 0 0 .708 0L12 1.707l.646.647a.5.5 0 0 0 .708 0l.509-.51.137.274V15H2V2.118l.137-.274z"/></svg></button>

                          <button type="button" class="btn btn-primary btn-sm" onclick="updateSelesai(`'. route('order.selesai', $Orders->id_order) .'`)">
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-square" viewBox="0 0 16 16">
                              <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                              <path d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.235.235 0 0 1 .02-.022z"/></svg> </button>

                          <button type="button" class="btn btn-danger btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-square" viewBox="0 0 16 16">
                              <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                              <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                            </svg></button>
                        </div>
                  </div>
                </div>
              </tr>
              ';
          })
          ->rawColumns(['order_ready'])
          ->make(true);

    }

    public function data_order_selesai()
    {
      $Orders = Order::
      where('status', '=' , 'dibayar')
      ->where('stat_pemesanan', '=' , 'selesai')
      ->select('id_order','code_order','first_name', 'last_name','customer_email', 'no_meja' ,'total_price', 'jenis_pembayaran','notes','status','updated_at')->get();

      return datatables()
          ->of($Orders)
          ->addIndexColumn()
          ->addColumn('order_selesai', function ($Orders) {
              return '
              <tr>
                <div  style="background-color:white;" class="info-box" >

                  <span class="info-box-icon" style="background-color:#A6CF98;">
                    <span class="info-box-text" style="color:white;">'.$Orders->no_meja .' | '.$Orders->jenis_pembayaran. '</span>
                  </span>
                  <div class="info-box-content" >
                    <span class="info-box-text">'.$Orders->first_name.' ' .$Orders->last_name.'</span>
                    <span class="info-box-number">'.$Orders->code_order.'</span>
                        <div class="btn-group" role="group" aria-label="Basic example">
                          <button type="button" class="btn btn-warning btn-sm" >
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-receipt-cutoff" viewBox="0 0 16 16">
                              <path d="M3 4.5a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zM11.5 4a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1z"/>
                              <path d="M2.354.646a.5.5 0 0 0-.801.13l-.5 1A.5.5 0 0 0 1 2v13H.5a.5.5 0 0 0 0 1h15a.5.5 0 0 0 0-1H15V2a.5.5 0 0 0-.053-.224l-.5-1a.5.5 0 0 0-.8-.13L13 1.293l-.646-.647a.5.5 0 0 0-.708 0L11 1.293l-.646-.647a.5.5 0 0 0-.708 0L9 1.293 8.354.646a.5.5 0 0 0-.708 0L7 1.293 6.354.646a.5.5 0 0 0-.708 0L5 1.293 4.354.646a.5.5 0 0 0-.708 0L3 1.293 2.354.646zm-.217 1.198.51.51a.5.5 0 0 0 .707 0L4 1.707l.646.647a.5.5 0 0 0 .708 0L6 1.707l.646.647a.5.5 0 0 0 .708 0L8 1.707l.646.647a.5.5 0 0 0 .708 0L10 1.707l.646.647a.5.5 0 0 0 .708 0L12 1.707l.646.647a.5.5 0 0 0 .708 0l.509-.51.137.274V15H2V2.118l.137-.274z"/></svg></button>

                          <button type="button" class="btn btn-primary btn-sm">
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-square" viewBox="0 0 16 16">
                              <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                              <path d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.235.235 0 0 1 .02-.022z"/></svg> </button>

                          <button type="button" class="btn btn-danger btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-square" viewBox="0 0 16 16">
                              <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                              <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                            </svg></button>
                        </div>
                  </div>
                </div>
              </tr>
              ';
          })
          ->rawColumns(['order_selesai'])
          ->make(true);

    }
    public function order_process($id)
    {
      $Orders = Order::findOrFail($id);
      $Orders->stat_pemesanan = "process";
      $Orders->update();
      return response(null, 204);
    }

    public function order_ready($id)
    {
      $Orders = Order::findOrFail($id);
      $Orders->stat_pemesanan = "ready";
      $Orders->update();
      return response(null, 204);
    }

    public function order_selesai($id)
    {
      $Orders = Order::findOrFail($id);
      $Orders->stat_pemesanan = "selesai";
      $Orders->update();
      return response(null, 204);
    }

    public function show($id)
    {
      // Dibutuhin nanti buat bedain pesenan setiap user
      $Details = Order_Produk::leftJoin('produk', 'produk.id_produk', 'order_produk.id_produk')
      ->select('order_produk.*', 'produk.*')
      ->where('id_order',$id)->get();
      $Orders = Order::where('id_order',$id)->get();
      // dd($Order);
        // $Details = Order_Produk::where('id_order',$id)->get();

        return view('admin.order.detail',compact('Details','Orders'));
    }

      public function data(){

        $Orders = Order::orderBy('id_order','desc')->get();


          return datatables()
              ->of($Orders)
              ->addIndexColumn()
              ->addColumn('select_all', function ($Orders) {
                  return '
                      <input type="checkbox" name="id_order[]" value="'. $Orders->id_order .'">
                  ';
              })
              ->addColumn('atas_nama', function ($Orders) {
                  return '<span class="label label-success">'. $Orders->kode_Orders .'</span>';
              })
              ->addColumn('no_meja', function ($Orders) {
                  return '<span>'.$Orders->deskripsi_Orders.'</span>';
              })
              ->addColumn('total_price', function ($Orders) {
                  return format_uang($Orders->harga_beli);
              })
              ->addColumn('status', function ($Orders) {
                  return format_uang($Orders->harga_jual);
              })
              ->addColumn('date', function ($Orders) {
                  return format_uang($Orders->stok);
              })
              ->addColumn('action', function ($Orders) {
                  return '
                  <div class="btn-group">
                      <button type="button" onclick="editForm(`'. route('order.detail', $Orders->id_order) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                  </div>';
              })
              ->rawColumns(['aksi','kode_produk','deskripsi_produk','status','gambar_produk' , 'select_all'])
              ->make(true);
      }

}
