{{--========================================== modal start here ========================================================--}}
<div class="modal fade" id="DetailItem{{$produk->id_produk}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          </button>
        </h5>
      </div>

      <div class="modal-body" style="margin-left:10%;margin-right:10%;">
        <div class="card mb-3" style="max-width: 540px;">
          <div class="row">

            <div class="col-sm-6">
              <div class="card-body">
              <img src="{{asset($produk->gambar_produk)}}" class="img-fluid rounded-start" alt="{{$produk->nama_produk}}" style="height:210px; width:210px">
            </div>
          </div>

          <div class="col-sm-6">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">{{$produk->nama_produk}}</h5>
                  <div class="rating1">
        						<span class="starRating">
        							<i class="fa fa-star blue-star" aria-hidden="true"></i></span>
        					</div>
                  <p class="card-text">{{$produk->deskripsi_produk}}</p>

                <div class="snipcart-thumb agileinfo_single_right_snipcart">
                      @if($produk->diskon==null)
                      <h4 class="m-sing">
                      Rp{{$produk->harga_jual}}</h4>
                      @else
                      <h4 class="m-sing">{{ $final_price =  $produk->harga_jual - $produk->harga_jual*$produk->diskon/100}}<span>Rp{{$produk->harga_jual}}</span></h4>
                    </span>
                    @endif
                </div>

                <form action="{{route('tambah_item')}}" method="post" enctype="multipart/form-data" class="form-horizontal">
                    @csrf
                    @method('post')
                    @csrf
  								<fieldset>
                    <input type="hidden" name="id_produk" value="{{$produk->id_produk}}">
  									<input type="hidden" name="id_kategori" value="{{$produk->id_kategori}}">
                    <label>Masukan Jumlah
                    <input type="number" style="width: 5em" min="1" name="qty" value=""/>
                  </label><br>
						<div class="snipcart-details agileinfo_single_right_details">
  									<input type="submit"  class="button" name="" value="Add"/>
                    </fieldset>
      					</form>

              </div>
            </div>
          </div>
          </div>
      </div>
      </div>

    </div>
  </div>
</div>
{{--============================================ modal end here ======================================================--}}
