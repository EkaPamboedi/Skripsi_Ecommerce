<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Confirm;
use App\Models\Order;
use App\Models\Order_Produk;
use Illuminate\Http\Request;
use DB;
use Session;
use App\Models\Payments;


class ConfirmUserController extends Controller
{
  public function index($id)
    {
        $order = Order::findOrFail($id);

        return view('kenal_kopi.confirm.index', compact('order'));
    }

    public function confirm_store(Request $request)
  {
      $user_id = Auth::user()->id;
      $id_order = $request->id_order;

      return redirect('invoice/daftar_order');
  }

  public function notification(Request $request)
  {
    \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
    // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
    \Midtrans\Config::$isProduction = false;
    // Set sanitization on (default)
    \Midtrans\Config::$isSanitized = true;
    // Set 3DS transaction for credit card to true
    \Midtrans\Config::$is3ds = true;
    // dd($validSignatureKey);
		// $this->initPaymentGateway();
    // Set your Merchant Server Key

    $payload = $request->getContent();
		$notification = json_decode($payload);
    $validSignatureKey = hash("sha512", $notification->order_id . $notification->status_code . $notification->gross_amount . env('MIDTRANS_SERVER_KEY'));
    // dd($validSignatureKey);

		if ($notification->signature_key != $validSignatureKey) {
			return response(['message' => 'Invalid signature'], 403);
		}

    \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
    // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
    \Midtrans\Config::$isProduction = false;
    // Set sanitization on (default)
    \Midtrans\Config::$isSanitized = true;
    // Set 3DS transaction for credit card to true
    \Midtrans\Config::$is3ds = true;


		$code = null;
  //
		$paymentNotification = new \Midtrans\Notification();
		$order = Order::where('code_order', $paymentNotification->order_id)->firstOrFail();
    // dd($order);

		if ($order->status == 'dibayar') {
			return response(['message' => 'The order has been paid before'], 422);
		}

		$transaction = $paymentNotification->transaction_status;
		$type = $paymentNotification->payment_type;
		$orderId = $paymentNotification->order_id;
		$fraud = $paymentNotification->fraud_status;

		$vaNumber = null;
		$vendorName = null;
		if (!empty($paymentNotification->va_numbers[0])) {
			$vaNumber = $paymentNotification->va_numbers[0]->va_number;
			$vendorName = $paymentNotification->va_numbers[0]->bank;
		}

		$paymentStatus = null;
		if ($transaction == 'capture') {
			// For credit card transaction, we need to check whether transaction is challenge by FDS or not
			if ($type == 'credit_card') {
				if ($fraud == 'challenge') {
					// TODO set payment status in merchant's database to 'Challenge by FDS'
					// TODO merchant should decide whether this transaction is authorized or not in MAP
          $paymentStatus = 'challenge';
					// $paymentStatus = Payment::CHALLENGE;
				} else {
					// TODO set payment status in merchant's database to 'Success'
          $paymentStatus = 'success';
					// $paymentStatus = Payment::SUCCESS;
				}
			}
    } else if ($transaction == 'settlement') {
			// TODO set payment status in merchant's database to 'Settlement'
			$paymentStatus = 'success';
		} else if ($transaction == 'pending') {
			// TODO set payment status in merchant's database to 'Pending'
			$paymentStatus = 'pending';
		} else if ($transaction == 'deny') {
			// TODO set payment status in merchant's database to 'Denied'
			$paymentStatus = 'deny';
		} else if ($transaction == 'expire') {
			// TODO set payment status in merchant's database to 'expire'
			$paymentStatus = 'expire';
		} else if ($transaction == 'cancel') {
			// TODO set payment status in merchant's database to 'Denied'
			$paymentStatus = 'cancel';
		}

		$paymentParams = [
      'code_order' =>  $order->id_order,
			// 'code' => intval($order->code),
			'number' => Payments::generateCode(),
			'amount' => $paymentNotification->gross_amount,
			'method' => 'midtrans',
			'status' => $paymentStatus,
			'token' => $paymentNotification->transaction_id,
			'payloads' => $payload,
			'payment_type' => $paymentNotification->payment_type,
			'va_number' => $vaNumber,
			'vendor_name' => $vendorName,
			'biller_code' => $paymentNotification->biller_code,
			'bill_key' => $paymentNotification->bill_key,
		];
// dd($paymentStatus);
		$payment = Payments::create($paymentParams);

		if ($paymentStatus && $payment) {
  			DB::transaction(
				function () use ($order, $payment) {
					if (in_array($payment->status, [$paymentStatus = 'success', $transaction_status = 'settlement'])) {
						// $order->payment_status = Order::PAID;
						$order->status = 'dibayar';
						$order->update();
					}
				}
			);
		}

		$message = 'Payment status is : '. $paymentStatus;

		$response = [
			'code' => 200,
			'message' => $message,
		];

		return response($response, 200);
  }
  //
  public function completed(Request $request)
	{
    // dd($request);
		$code = $request->query('order_id');
		$order = Order::where('code_order', $code)->firstOrFail();

    // $Details = Order_Produk::where('id_order',$id)->get();
    $Infos = Order::where('code_order', '=' , $code)->get();
    $Orders = Order_Produk::leftjoin('order', 'order.id_order','=','order_produk.id_order')
        ->where('code_order',$code)
        ->join('produk', 'produk.id_produk', '=' , 'order_produk.id_produk')
        ->select(
                'order_produk.qty',
                'order_produk.subtotal',
                'produk.nama_produk',
                'produk.kode_produk',
                'produk.diskon',
                'produk.harga_jual')
        ->get();
    // dd($Infos);
    // $SnapToken = DB::table('order')->where('id_order',$id)->pluck('payment_token');
    $PaymentUrl = DB::table('order')->where('code_order',$code)->pluck('payment_url');
    //
		if ($order->status == 'belum dibayar') {
			return redirect('kenalkopi/payments/failed?order_id='. $code);
		}

		Session::flash('success', "Thank you for completing the payment process!");

		// return redirect('orders/received/'. $order->id);
    return view('kenal_kopi.order.notification',compact('code','order','Orders','PaymentUrl','Infos'));
  }

  public function unfinish(Request $request)
	{
    // dd($request);
		$code = $request->query('order_id');
		$order = Order::where('code_order', $code)->firstOrFail();

    // $Details = Order_Produk::where('id_order',$id)->get();
    $Infos = Order::where('code_order', '=' , $code)->get();
    $Orders = Order_Produk::leftjoin('order', 'order.id_order','=','order_produk.id_order')
        ->where('code_order',$code)
        ->join('produk', 'produk.id_produk', '=' , 'order_produk.id_produk')
        ->select(
                'order_produk.qty',
                'order_produk.subtotal',
                'produk.nama_produk',
                'produk.kode_produk',
                'produk.diskon',
                'produk.harga_jual')
        ->get();
    // dd($Infos);
    // $SnapToken = DB::table('order')->where('id_order',$id)->pluck('payment_token');
    $PaymentUrl = DB::table('order')->where('code_order',$code)->pluck('payment_url');
    //
		if ($order->status == 'belum dibayar') {
			return redirect('kenalkopi/payments/failed?order_id='. $code);
		}

		Session::flash('success', "Thank you for completing the payment process!");

		// return redirect('orders/received/'. $order->id);
    return view('kenal_kopi.order.notification',compact('code','order','Orders','PaymentUrl','Infos'));
  }
  public function failed(Request $request)
	{
    // dd($request);
		$code = $request->query('order_id');
		$order = Order::where('code_order', $code)->firstOrFail();

    // $Details = Order_Produk::where('id_order',$id)->get();
    $Infos = Order::where('code_order', '=' , $code)->get();
    $Orders = Order_Produk::leftjoin('order', 'order.id_order','=','order_produk.id_order')
        ->where('code_order',$code)
        ->join('produk', 'produk.id_produk', '=' , 'order_produk.id_produk')
        ->select(
                'order_produk.qty',
                'order_produk.subtotal',
                'produk.nama_produk',
                'produk.kode_produk',
                'produk.diskon',
                'produk.harga_jual')
        ->get();
    // dd($Infos);
    // $SnapToken = DB::table('order')->where('id_order',$id)->pluck('payment_token');
    $PaymentUrl = DB::table('order')->where('code_order',$code)->pluck('payment_url');
    //
		if ($order->status == 'belum dibayar') {
			return redirect('kenalkopi/payments/failed?order_id='. $code);
		}

		Session::flash('Failed', "Sorry Your Order Can't Processed!");

		// return redirect('orders/received/'. $order->id);
    return view('kenal_kopi.order.notification',compact('code','order','Orders','PaymentUrl','Infos'));
  }
}
