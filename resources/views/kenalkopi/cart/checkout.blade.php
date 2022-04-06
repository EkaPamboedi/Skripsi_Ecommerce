@extends('kenalkopi.layouts.master_without_banner')

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
      <h5>Kode Order</h5>
    		<strong>
          <!-- <input type="text" name="code" value="{{--$code_order--}}" disabled> -->
          <input type="hidden" name="user_id" value="{{$user_id}}" hidden>
        </strong>
        <h6>Nomer Meja</h6>
        <input type="text" id="user_table" name="user_table" value="{{$user_table}}" disabled>
        <h6>First Name</h6>
        <input type="text" id="first_name" name="first_name" value="" placeholder="First Name" required>
        <h6>Last Name</h6>
        <input type="text" id="last_name" name="last_name" value="" placeholder="Last Name" required>
        <!-- <h6>Number Phone</h6>
        <input type="text" id="number_phone" name="customer_phone" value="" placeholder="Number Phone" required>
        <h6>Email</h6>
        <input type="text" id="customer_email" name="customer_email" value="" placeholder="Email" required> -->

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
