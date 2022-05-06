<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tables;

use Illuminate\Support\Facades\Hash;

class MejaController extends Controller
{
  public function index()
  {
    $tables = Tables::get();
    // $Users = User::orderBy('id')->get();
    // $Users = User::get();
    // all()->pluck('name', 'id','email' ,'qr_code');

  // dd($Users);
        return view('admin.meja.index',compact('tables'));
  }
}
