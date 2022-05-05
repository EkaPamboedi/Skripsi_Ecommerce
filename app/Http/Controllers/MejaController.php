<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Support\Facades\Hash;

class MejaController extends Controller
{
  public function index()
  {
    $Users = User::
    where('id','>' ,'2')->get();
    // $Users = User::orderBy('id')->get();
    // $Users = User::get();
    // all()->pluck('name', 'id','email' ,'qr_code');

  // dd($Users);
        return view('admin.meja.index',compact('Users'));
  }
}
