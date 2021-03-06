@extends('kenal_kopi.layouts.master_without_banner')

@section('title')
    Cart
@endsection

@section('content')

    @if(count($CartProduk)>=1)

<!-- checkout -->
	<div class="register">
		<div class="container">
			<h2>Konfirmasi</h2>
		<div class="login-form-grids">
      <form class="" action="{{route('payment')}}" method="post">
        @csrf
        <h6>Nomer Meja</h6>
        <input type="text" id="no_meja" name="no_meja" value="{{$no_meja}}" disabled>
        <h6>First Name</h6>
        <input type="text" id="first_name" name="first_name" value="" placeholder="First Name" required>
        <h6>Last Name</h6>
        <input type="text" id="last_name" name="last_name" value="" placeholder="Last Name (Optional)">
        <h6>Email</h6>
        <input type="text" id="customer_email" name="customer_email" value="" placeholder="Email | digunakan untuk mengirim notifikasi pembayaran" required>
        <h6>Catatan</h6>
        <textarea style="width:26em; padding:5px; color:grey;" type="text" id="notes" name="notes" value="" placeholder="Catatans"></textarea>
        <!-- <h6>Number Phone</h6>
        <input type="text" id="number_phone" name="customer_phone" value="" placeholder="Number Phone" required>
        <h6>Email</h6>
        <input type="text" id="customer_customer_email" name="customer_email" value="" placeholder="Email" required> -->

					<input type="submit" name="confirm" value="Kirim">
				</form>
			</div>
			<div class="register-home">
          <a href="{{route('cart')}}">Batal</a>
        </div>
		</div>
	</div>

    @else


<!-- register -->
	<div class="register">
		<div class="container">
			<h2>Keranjang Kosong</h2>
		</div>
			<div class="register-home">
				<a href="{{route('cart')}}">Batal</a>
			</div>
		</div>
	<!-- </div> -->
<!-- //register -->
    @endif <!-- End of cart chengking item ->
<!-- //checkout -->
	  </center>


		</div>
	</div>
<!-- //checkout -->
@endsection
