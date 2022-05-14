@extends('kenal_kopi.layouts.master_without_banner')

@section('title')
    Cart
@endsection

@section('content')
<!-- checkout -->
	<div class="checkout">
		<div class="container">
			<h2>Dalam keranjangmu ada : <span>&nbsp; {{ count(Cart::content()) }} Item(s)</span></h2>
			<div class="checkout-right">
				<table class="timetable_sub">
					<thead>
            <tr>
            <!-- Nama : {{--asset($user->nama)--}}
            No. Meja {{--asset($user->meja)--}} -->
            </tr>
						<tr>
							<th>No.</th>
              <th>Aksi</th>
							<th>Produk</th>
							<th>Nama Produk</th>
              <th>Harga Satuan</th>
							<th>Jumlah Pesanan</th>
							<th>Hrga per Jumlah</th>
							</tr>
					</thead>
      <!--ini buat inisiasi nomer-->
      @php($i=1)
      <!-- Buat hitung jumlah item, krna klo pake method aga tricky itugn diskonnya  -->
      @php($sum=0)

      <!-- ini buat ngecek klo cart kosong apa engga -->
      @if(count($CartProduk)>=1)

            <!-- ini looping cart nya -->
            @foreach($CartProduk as $produk)
            <tr>
            {{--dd($produk->id_kategori)--}}
              <!-- nomer -->
  						<td class="invert">{{$i++}}</td>

              <!-- Aksi -->
              <td class="invert">
                <div class="rem">
                  <input type="hidden" name="rowId" value="{{$produk->rowId}}">
                  <a href="{{ route('remove_item', ['rowId' => $produk->rowId]) }}" type="submit" class="btn btn-danger">
                  <span aria-hidden="true"> x </span></a>
                </div>
              </td>

              <!-- gambar -->
  						<td class="invert"><a href=""><img src="{{asset($produk->options->image) }}" width="100px" height="100px" ></a></td>
              <!-- //gambar -->

              <!-- nama produk -->
              <td class="invert">{{$produk->name}}</td>
              <!-- //nama produk -->

              <!-- harga satuan -->
              @if($produk->options->diskon==null)
  						<td class="invert">Rp.{{ number_format($produk->price) }}</td>

                @else
                <td class="invert">Rp.{{number_format($produk->price - $produk->price * $produk->options->diskon/100)}}</td>
                @endif
              <!-- //harga satuan -->

              <!-- jumlah barang -->
  						<td class="invert">
  							 <div class="quantity">
  								<div class="quantity-select" style="margin-left:25%;" >
                  <form class="" action="{{route('update_cart')}}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                    <input type="hidden" name="rowId" value="{{$produk->rowId}}">
  									<input type="number" name="qty" class="form-control" height="50px" style="width:35px; height:25px; padding:0; border:5;" value="{{$produk->qty}}" min="1">
                    <button type="submit" name="update" class=" form-control btn btn-primary" value="Update"style="width:60px; height:25px; padding:0; ">Update</button>
                  </div>
                  </form>
  								</div>
  							</div>
  						</td>

              <!-- //jumlah barang -->
              <!-- harga total per pesanan -->
                @if($produk->options->diskon==null)
              <td class="invert">Rp.{{ number_format($subTotal = $produk->price*$produk->qty)}}</td>
                @else
                <td class="invert">Rp.{{number_format($subTotal =
                ($produk->price - ($produk->price * $produk->options->diskon/100))*$produk->qty)}}</td>
                @endif
                @php($sum = $sum + $subTotal)
            </tr>
            @endforeach<!-- End of looping Cart -->


            <!-- belum bisa nampilin klo cart kosong -->
          @else
            <tr class="rem1">
            <td class="invert" colspan="7" class="text-center">
              <span>Anda Belum memesan barang</span>
            </td>
          </tr>
          @endif <!-- End of cart chengking item -->

				</table>
			</div>
      <div class="checkout-left">
        <div class="checkout-left-basket">
          <h4>Total Harga : Rp {{$sum}}</h4>
          <ul>

            <!-- <li>Nama Produk<i> - </i> <span>Rp Total Harga</span></li> -->

            <!-- <li>Total (inc. 10k Ongkir)<i> - </i> <span>Rp Total Harga</span></li> -->
          </ul>
        </div>

				<div class="checkout-right-basket">
        <a href="{{ route('kenalkopi.produk') }}"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>Continue Shopping</a>
        <a href="{{route('checkout')}}"><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>Checkout</a>
      <!-- </form> -->
    </div>
				<div class="clearfix"> </div>
			</div>

		</div>
	</div>
  @endsection
