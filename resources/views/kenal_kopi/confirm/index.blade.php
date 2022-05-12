@extends('kenal_kopi.layouts.master_without_banner')

@section('title')
    Cart
@endsection

@section('content')
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- @TODO: replace SET_YOUR_CLIENT_KEY_HERE with your client key -->
    <script type="text/javascript"
      src="https://app.sandbox.midtrans.com/snap/snap.js"
      data-client-key="SB-Mid-client-gl6bbx-dcegBrJD3"></script>
    <!-- Note: replace with src="https://app.midtrans.com/snap/snap.js" for Production environment -->
  </head>

<div class="register">
  <div class="container">
    <h2>Konfirmasi</h2>
    <div class="login-form-grids">
        <!-- <form action="{{route('confirm_store')}}" method="post" enctype="multipart/form-data" class="form-horizontal"> -->
          <!-- @
          csrf -->
        <!-- kode order -->
      <h3>Kode Order</h3>
      <strong>
        <input type="hidden" name="id_order" id="id_order" value="{{$order->id_order}}" hidden>
        <input type="text" name="code" id="code" value="{{$order->code}}" readonly class="form-control-plaintext">
      </strong>
      <h3>First Name</h3>
      <strong>
        <input type="text" name="first_name" value="{{$order->first_name}}" readonly class="form-control-plaintext">
      </strong>
      <h3>Last Name</h3>
      <strong>
        <input type="text" name="last_name" value="{{$order->last_name}}" readonly class="form-control-plaintext">
      </strong>
      <h3>Meja Pemesan</h3>
      <strong>
        <input type="text" name="orderid" value="{{$order->no_meja}}" readonly class="form-control-plaintext">
      </strong>

      <!-- <h6>Upload Bukti Pembayaran</h6>
      <label for="formFile" class="form-label">Default file input example</label>
      <div class="mb-3"> -->
        <!-- <input  type="file" id="formFile"> -->
        <!-- <input class="form-control" type="file" name="image" accept="image/*" onchange="loadFile(event)"> -->
        <!-- <br> -->
      <!-- </div> -->
        <!-- <div class="text-center" >
            <img style="border-style: hidden;" id="output"  class="rounded" width="400px" height="400">
         </div> -->

        <input id="pay-button" type="submit" name="confirm" value="Bayar">
      </form>
    </div>
    <div class="register-home">
      <a href="index.php">Batal</a>
    </div>
  </div>
</div>
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<!-- <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script> -->
<script type="text/javascript">
   // For example trigger on button clicked, or any time you need
   var payButton = document.getElementById('pay-button');
   payButton.addEventListener('click', function () {
     // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
     window.snap.pay('', {
       onSuccess: function(result){
         /* You may add your own implementation here */
         alert("payment success!"); console.log(result);
       },
       onPending: function(result){
         /* You may add your own implementation here */
         alert("wating your payment!"); console.log(result);
       },
       onError: function(result){
         /* You may add your own implementation here */
         alert("payment failed!"); console.log(result);
       },
       onClose: function(){
         /* You may add your own implementation here */
         alert('you closed the popup without finishing the payment');
       }
     })
   });
 </script>
@endsection
@push('scripts')
<script>
  var loadFile = function(event) {
    var output = document.getElementById('output');
    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = function() {
      URL.revokeObjectURL(output.src) // free memory
    }
  };
</script>
@endpush
