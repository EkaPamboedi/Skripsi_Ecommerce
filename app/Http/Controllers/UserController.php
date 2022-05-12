<?php

namespace App\Http\Controllers;

use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use PDF;
use DB;

class UserController extends Controller
{
    public function index()
    {
      $Users = User::
      where('id','>' ,'2')->get();
      // $Users = DB::table('users')->latest()->first();
      // $Users1 = User::all()->last()->email;
      // $Users = User::all()->last()->name;
      // dd($Users);
      // $Users = User::orderBy('id')->get();
      // $Users = User::get();
      // all()->pluck('name', 'id','email' ,'qr_code');

// dd($Users);
        return view('admin.user.index',compact('Users'));
    }

    public function data()
    {
        $user = User::orderBy('id', 'desc')->get();

        return datatables()
            ->of($user)
            ->addIndexColumn()
            ->addColumn('aksi', function ($user) {
                return '
                <div class="btn-group">
                    <button type="button" onclick="editForm(`'. route('user.update', $user->id) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                    <button type="button" onclick="deleteData(`'. route('user.destroy', $user->id) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                </div>
                ';
            })
            ->rawColumns(['aksi'])
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
      $name_def = User::all()->last()->name;
      $email_def = User::all()->last()->email;
      if($name_def == "user" && $email_def == "user@gmail.com"){

          $name  = $name_def. ".". 1;
          $x_mail = explode("@",$email_def);
          $mail = $x_mail[0]. "." . + 1;
          $email = $mail . "@".  $x_mail[1];
          // $user->save();

        }else {
          // code...

      // $user = "user.12";
      // $email = "user.12@gmail.com";
      //buat nambah index user
      $a = $name_def;
      $exp_a = explode("." , $a);
      $exp_a1 =$exp_a[1]+1;
      $name = $exp_a[0].".".$exp_a1;

      $b = $email_def;
      $exp_b = explode("@" , $b);
      $exp_b1= explode(".",$exp_b[0]);
      $exp_b2 =$exp_b1[1]+1;
      //$exp_b2 =$exp_b[0]."."+1;
      $email = $exp_b1[0].".".$exp_b2."@".$exp_b[1];

    }
        // echo $name_x."<br>";
        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->password = $password = (bcrypt(123456));
        $user->no_meja = $request->no_meja;
        $user->level = 2;
        $user->qr_code = $email.','.$password;
        // $user->qr_code = $request->email.$request->password.$request->no_meja;
        $user->foto = '/img/user.jpg';
        $user->save();

        return redirect()->back();
        // return response()->json('Data berhasil disimpan', 200);
        // return response()->;

    }

    // public function store(request $request)
    // {
    //   $code_order = rand();
    //   $user = new User();
    //   $user->no_meja = $request->no_meja;
    // }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        return response()->json($user);
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
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->has('password') && $request->password != "")
            $user->password = bcrypt($request->password);
            $user->no_meja = $request->no_meja;
            $user->level = 2;
            $user->qr_code = bcrypt($request->name.$request->password.$request->no_meja);
        $user->update();

        return response()->json('Data berhasil disimpan', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();


        return response(null, 204);
    }

    public function profile()
    {
        $profil = auth()->user();
        return view('admin.user.profile', compact('profil'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $user->name = $request->name;
        if ($request->has('password') && $request->password != "") {
            if (Hash::check($request->old_password, $user->password)) {
                if ($request->password == $request->password_confirmation) {
                    $user->password = bcrypt($request->password);
                } else {
                    return response()->json('Konfirmasi password tidak sesuai', 422);
                }
            } else {
                return response()->json('Password lama tidak sesuai', 422);
            }
        }

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $nama = 'logo-' . date('YmdHis') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/img'), $nama);

            $user->foto = "/img/$nama";
        }

        $user->update();

        return response()->json($user, 200);
    }
    public function printQR($id)
    {
        // $Users = User::find($id);
        // $Users = User::where('id',$id)->find();
        $Users = User::select('qr_code')->find($id);

        // dd($Users);
        // $penjualan = Penjualan::find(session('id_penjualan'));
        // if (! $penjualan) {
        //     abort(404);
        // }
        // $detail = PenjualanDetail::with('produk')
        //     ->where('id_penjualan', session('id_penjualan'))
        //     ->get();

        return view('admin.user.printQR', compact('Users'));
    }
}
