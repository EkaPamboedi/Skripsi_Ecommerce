<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\User;
use Auth;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
     // protected $redirectTo = RouteServiceProvider::KENALKOPI;
    protected $redirectTo = '/daftar_produk';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request, $user)
    {
      return view('admin.home.dashboard');
      // return response()->json([
      //     'success' => true,
      //     'redirect' => route($this->redirectTo)
      // ]);
    }

    public function index()
    {
    return view('welcome');
  }

    public function attemptLogin(Request $request)
    {
      //datanya yg dicek harusnya tabel sih, but letsee
        if ($request->has('data')){
            $data = explode(',',$request->get('data'));
            $email = $data[0];
            $password = $data[1];
            // $no_meja = $data[2];
            $creadential = [
                'email' => $email,
                'password' => $password
                // 'no_meja' => $no_meja
            ];
            $checking = User::where('email',$email)->first();

        } else {
            $creadential = [
                'email' => $request->email,
                'password' => $request->password
                // 'no_meja' => $request->no_meja
            ];
            $checking = User::where('email',$request->email)->first();
        }

        /* checking email */
        if ($checking){
            if(Auth::attempt($creadential)) {

              return redirect('/dashboard');

            } else {
                return response()->json([
                    'message' => 'Your email or password wrong'
                ],404);
            }
        } else {
            return response()->json([
                'message' => 'your account not found'
            ],404);
        }
    }

    public function qrCodeLogin()
    {
        return view('auth.qr-login');
    }

    public function attemptQrLogin(Request $request)
    {
      // ini gua ubah, jadi cuman ngirim data meja controller nya.
      //datanya yg dicek harusnya tabel sih, but letsee
        if ($request->has('data')){
            $data = explode(',',$request->get('data'));
            $email = $data[0];
            $password = $data[1];
            // $no_meja = $data[2];
            $creadential = [
                'email' => $email,
                'password' => $password

            ];
            $checking = User::where('email',$email)->first();

        } else {
            $creadential = [
                'email' => $request->email,
                'password' => $request->password
                // 'no_meja' => $request->no_meja
            ];
            $checking = User::where('email',$request->email)->first();
        }

        /* checking email */
        if ($checking){
            if(Auth::attempt($creadential)) {
              return response()->json([
                  'message' => true,
                  'redirect' => $this->redirectTo
              ],200);
            } else {
                return response()->json([
                    'message' => 'Your email or password wrong'
                ],404);
            }
        } else {
            return response()->json([
                'message' => 'your account not found'
            ],404);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/');
    }
}
