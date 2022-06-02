	<div class="logo_products">
		<div class="container">
		<div class="w3ls_logo_products_left1">
				<ul class="phone_email">
					<!-- <li><i class="fa fa-phone" aria-hidden="true"></i>Hubungi Kami : (+6281) 222 333</li> -->
				</ul>
			</div>
			<div class="w3ls_logo_products_left">
				<h1><a href="index.php">KENAL KOPI</a></h1>
			</div>
		<!-- <div class="w3l_search">
			<form action="search.php" method="post">
				<input type="search" name="Search" placeholder="Cari produk...">
				<button type="submit" class="btn btn-default search" aria-label="Left Align">
					<i class="fa fa-search" aria-hidden="true"> </i>
				</button>
				<div class="clearfix"></div>
			</form>
		</div> -->

			<div class="clearfix"> </div>
		</div>
	</div>
	</div>
<!-- //header -->
<!-- navigation -->
	<div class="navigation-agileits">
		<div class="container">
			<nav class="navbar navbar-default">
							<!-- Brand and toggle get grouped for better mobile display -->
							<div class="navbar-header nav_2">
								<button type="button" class="navbar-toggle collapsed navbar-toggle1" data-toggle="collapse" data-target="#bs-megadropdown-tabs">
									<span class="sr-only">Toggle navigation</span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
								</button>
							</div>
							<div class="collapse navbar-collapse" id="bs-megadropdown-tabs">
								<ul class="nav navbar-nav">
									<li class="active"><a href="{{route('kenalkopi.home')}}" class="act">Home</a></li>
									<li><a href="{{ route('kenalkopi.produk') }}">Produk</a></li>
										<ul class="dropdown-menu multi-column columns-3">
											<div class="row">
												<div class="multi-gd-img">
													<ul class="multi-column-dropdown">
														<h6>Kategori</h6>
														<!-- Nampilin dropdown buat kategori yang ada di produk -->
													{{--	@foreach($kategori_produks as $kategori_produk) --}}
														<li><a href="{{-- route('produk_show',['kategori_produk_id'=>$kategori_produk->kategori_produk_id]) --}}">{{-- $kategori_produk->nama_kategori --}}</a></li>
														{{-- @endforeach --}}
													</ul>
												</div>
											</div>
										</ul>

									<!-- <li><a href="{{--route('daftar_menu')--}}">Menu</a></li> -->
									<li><a href="{{route('daftar_order')}}">Daftar Order</a></li>
									<li style="margin-top:4px;">


											<a href="{{ route('cart') }}"><i class="fa fa-cart-arrow-down" aria-hidden="true" style="size:50%;"></i>
											</button><small class="label pull-right bg-maroon-active">{{ count(Cart::content()) }}</small>
												<!-- edit nih wkwk -->
											</a>
								</li>
								</ul>


							</div>
							</nav>
			</div>
		</div>

<!-- //navigation -->
