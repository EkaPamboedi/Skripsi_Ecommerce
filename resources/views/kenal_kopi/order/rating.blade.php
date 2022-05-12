{{--========================================== modal start here ========================================================--}}
<div class="modal fade" id="Rating{{$detail->id_order_produk}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
              <img src="{{asset($detail->produk->gambar_produk)}}" class="img-fluid rounded-start" alt="{{$detail->produk->nama_produk}}" style="height:210px; width:210px">
            </div>
          </div>

          <div class="col-sm-6">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">{{$detail->produk->nama_produk}}</h5>
                  <div class="rating1">
        						<span class="starRating">
        							<i class="fa fa-star blue-star" aria-hidden="true"></i></span>
        					</div>
                  <p class="card-text">{{$detail->produk->deskripsi_produk}}</p>

                <div class="snipcart-thumb agileinfo_single_right_snipcart">
                      @if($detail->produk->diskon==null)
                      <h4 class="m-sing">
                      Rp{{$detail->produk->harga_jual}}</h4>
                      @else
                      <h4 class="m-sing">{{ $final_price =  $detail->produk->harga_jual - $detail->produk->harga_jual*$detail->produk->diskon/100}}<span>Rp{{$detail->produk->harga_jual}}</span></h4>
                    </span>
                    @endif
                </div>

                <form action="{{route('rating')}}" method= "post" enctype="multipart/form-data" class="form-horizontal">
                    @csrf
                    @method('post')
  								<fieldset>

                    <input type="number" name="id_order_produk"  value="{{$detail->id_order_produk}}">
                    <input type="number" name="user_id"   value="{{$detail->order->user_id}}">
  									<input type="number" name="id_produk" value="{{$detail->produk->id_produk}}">
                    <label>Beri Rating
                    <input type="number" style="width: 5em" min="1" max="5" name="ratings" value=""/>
                    </label><br>

						        <div class="snipcart-details agileinfo_single_right_details">
                    <input type="submit"  class="button" name="" value="Submit"/>
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
