<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Tables;

use Illuminate\Support\Facades\Hash;

// protected $redirectTo = '/daftar_produk';

class MejaController extends Controller
{
  // public function index(){
  //       $data = Data::all();
  //       return view ('welcome', ['data' => $data]);
  public function index()
  {
    $tables = Tables::get();
    // dd($this->redirectTo);
    // $Users = User::orderBy('id')->get();
    // $Users = User::get();
    // all()->pluck('name', 'id','email' ,'qr_code');
  // dd($Users);
        return view('admin.meja.index',compact('tables'));
  }
  public function store(request $request)
   {
       $link = "/kenalkopi/produk";
       $tables = new Tables;
       $no_meja = $tables->no_meja = $request->no_meja;
       $tables->link = $link.",".$no_meja;
       $tables->level = 2;
       $tables->save();
       // $data = Data::findOrFail($id);
       // $qrcode = QrCode::size(400)->generate($data->name);
      return redirect()->back();
   }
   public function destroy($id)
   {
       $user = User::find($id);
       $user->delete();


       return response(null, 204);
   }
   public function printQR($id)
   {
       $Tables = Tables::select('link')->find($id);
       return view('admin.meja.printQR', compact('Tables'));
   }
}
