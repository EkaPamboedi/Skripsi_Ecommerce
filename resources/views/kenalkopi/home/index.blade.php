@extends('kenalkopi.layouts.master')

@section('title')
Kenal Kopi
@endsection

@section('content')
  <!-- top-brands -->
	<div class="top-brands">
		<div class="container">
		<h2>Produk Kami</h2>
			<div class="grid_3 grid_5">
				<div class="bs-example bs-example-tabs" role="tabpanel" data-example-id="togglable-tabs">
					<div id="myTabContent" class="tab-content">
						<div role="tabpanel" class="tab-pane fade in active" id="expeditions" aria-labelledby="expeditions-tab">
							<div class="agile-tp">
								<h5>Penawaran Terbaik Minggu Ini</h5>
								</div>
								<div class="agile_top_brands_grids">

	                <!--CHART PRODUK -->
									@foreach($products as $produk)
									<div class="col-md-4 top_brand_left">
										<div class="hover14 column">
											<div class="agile_top_brand_left_grid">
												<div class="agile_top_brand_left_grid_pos">
													<!-- <img src="images/offer.png" alt=" " class="img-responsive" /> -->
												</div>
												<div class="agile_top_brand_left_grid1">

	                        <figure>
														<div class="snipcart-item block" >

															<div class="snipcart-thumb">
	                            <!-- Link Produk Detail klo di klik gambarnya-->
																<a href="">
	                            <!--End Produk Detail  -->

	                              <!-- Gambar Produk -->
	                              <img title=" " alt="" src="{{asset($produk->gambar_produk)}}" width="200px" height="200px" /></a>

	                              <p>{{$produk->nama_produk}}</p>
																<h5 class="card-title">Similarity: {{ round($produk->similarity * 100, 1) }}%</h5>


	                              <div class="stars">
															<!-- rating -->
																</div>
	                              @if($produk->diskon==null)
	                              <h4>Rp{{$produk->harga_jual}}</h4>
	                              @else
	                              <h4>{{ $final_price = $produk->harga_jual - $produk->harga_jual*$produk->diskon/100}}<span>Rp{{$produk->harga_jual}}</span></h4>
													</div>
	                            @endif
															<div class="snipcart-details top_brand_home_details">
	                            <!-- Trigger modal -->
	                        <form class="" action="" method="post">
														<fieldset>
															<a href="#" data-toggle="modal"
	                            data-target="#DetailItem{{ $produk->id_produk}}" >
	                              <input type="submit" class="button" value="Lihat Produk"/>
	                            </a>
														</fieldset>
	                        </form>
															</div>
														</div>
													</figure>
												</div>
											</div>
										</div>
									</div>

									@includeIf('kenalkopi.home.form')

	                @endforeach


									<div class="clearfix"> </div>
								</div>
							</div>


			</div>
		</div>
	</div>
<!-- //top-brands -->
@endsection
