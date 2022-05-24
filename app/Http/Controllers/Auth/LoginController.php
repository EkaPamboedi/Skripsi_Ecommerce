<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\User;
use App\Models\Order;
use Carbon\Carbon;
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
    protected $redirectTo = '/kenalkopi/produk';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('guest')->except('logout');
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

              return redirect('Admin/dashboard');

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

    // public function attemptQrLogin(Request $request)
    // {
    //   // ini gua ubah, jadi cuman ngirim data meja controller nya.
    //   //datanya yg dicek harusnya tabel sih, but letsee
    //     if ($request->has('data')){
    //         $data = explode(',',$request->get('data'));
    //         $email = $data[0];
    //         $password = $data[1];
    //         // $no_meja = $data[2];
    //         $creadential = [
    //             'email' => $email,
    //             'password' => $password
    //
    //         ];
    //         $checking = User::where('email',$email)->first();
    //
    //     } else {
    //         $creadential = [
    //             'email' => $request->email,
    //             'password' => $request->password
    //             // 'no_meja' => $request->no_meja
    //         ];
    //         $checking = User::where('email',$request->email)->first();
    //     }
    //
    //     /* checking email */
    //     if ($checking){
    //         if(Auth::attempt($creadential)) {
    //           return response()->json([
    //               'message' => true,
    //               'redirect' => $this->redirectTo
    //           ],200);
    //         } else {
    //             return response()->json([
    //                 'message' => 'Your email or password wrong'
    //             ],404);
    //         }
    //     } else {
    //         return response()->json([
    //             'message' => 'your account not found'
    //         ],404);
    //     }
    // public function attemptQrLogin(Request $request)
    // {
    //   // ini gua ubah, jadi cuman ngirim data meja controller nya.
    //   //datanya yg dicek harusnya tabel sih, but letsee
    //     if ($request->has('data')){
    //         $data = explode(',',$request->get('data'));
    //         $email = $data[0];
    //         $password = $data[1];
    //         // $no_meja = $data[2];
    //         $creadential = [
    //             'email' => $email,
    //             'password' => $password
    //
    //         ];
    //         $checking = User::where('email',$email)->first();
    //
    //     } else {
    //         $creadential = [
    //             'email' => $request->email,
    //             'password' => $request->password
    //             // 'no_meja' => $request->no_meja
    //         ];
    //         $checking = User::where('email',$request->email)->first();
    //     }
    //
    //     /* checking email */
    //     if ($checking){
    //         if(Auth::attempt($creadential)) {
    //           return response()->json([
    //               'message' => true,
    //               'redirect' => $this->redirectTo
    //           ],200);
    //         } else {
    //             return response()->json([
    //                 'message' => 'Your email or password wrong'
    //             ],404);
    //         }
    //     } else {
    //         return response()->json([
    //             'message' => 'your account not found'
    //         ],404);
    //     }
    // }
    public function attemptQrLogin(Request $request)
    {
      // ini gua ubah, jadi cuman ngirim data meja controller nya.
      //datanya yg dicek harusnya tabel sih, but letsee
        if ($request->has('data')){
            $data = explode(',',$request->get('data'));
            // $link = $data[0];
            $no_table = $data[1];
            // $code_order = mt_rand(1000000000, 9999999999);
            $str=rand();
            $token = md5($str);
            // $order->user_id = $user_id;
            // $order = new Order;

            // $order->code_order = $code_order;
            // $order->id_order = $id_order;
            // $order->first_name = " ";
            // $order->last_name = "";
            // $order->custumer_phone = " ";
            // $order->custumer_email = "";
            // $order->no_meja = $no_meja;
            // $order->notes = "";
            // $order->customer_phone = $request->customer_phone;
            // $order->customer_email = $request->customer_email;
            // $order->total_price = 0;
            // $order->order_date = Carbon::now();
            // $order->save();
            session([
              'token' => $token,
              'no_meja' => $no_table
            ]);

            return response()->json([
                'message' => true,
                'redirect' => $this->redirectTo
            ],200);

        } else {

        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/welcome');
    }
}
