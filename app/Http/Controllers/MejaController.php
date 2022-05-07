<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Tables;

use Illuminate\Support\Facades\Hash;

class MejaController extends Controller
{
  // public function index(){
  //       $data = Data::all();
  //       return view ('welcome', ['data' => $data]);
  public function index()
  {
    $tables = Tables::all();
    // $Users = User::orderBy('id')->get();
    // $Users = User::get();
    // all()->pluck('name', 'id','email' ,'qr_code');

  // dd($Users);
        return view('admin.meja.index',compact('tables'));
  }
  public function generate ($id)
   {
       $data = Data::findOrFail($id);
       $qrcode = QrCode::size(400)->generate($data->name);
       return view('qrcode',compact('qrcode'));
   }
}
