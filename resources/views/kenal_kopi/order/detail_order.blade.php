@extends('kenal_kopi.layouts.master_without_banner')

@section('title')
    Detail Order
@endsection


@section('content')
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- @TODO: replace SET_YOUR_CLIENT_KEY_HERE with your client key -->
    <script type="text/javascript"
      src="https://app.sandbox.midtrans.com/snap/snap.js"
      data-client-key="SB-Mid-client-gl6bbx-dcegBrJD3"></script>
    <!-- Note: replace with src="https://app.midtrans.com/snap/snap.js" for Production environment -->

    <!-- jQuery CDN – Latest Stable Versions jQuery Core 3.6.0 -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  </head>


<div class="top-brands">
  <div class="container">

    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                  @foreach($Orders as $order)
                  {{--dd($order->notes)--}}
                <ul class="list-group list-group-flush">
                  <li class="list-group-item">Kode Order <span style="margin-left:36px;">:</span><span style="margin-left:15px;">{{$order->code_order}}</span></li>
                  <li class="list-group-item">Tanggal<span style="margin-left:60px;">:</span><span style="margin-left:15px;">{{$order->order_date}}</span></li>
                  <li class="list-group-item">Nama Pemesan<span style="margin-left:15px;">:</span><span style="margin-left:15px;">{{$order->first_name." ".$order->last_name}}</span></li>
                  <li class="list-group-item">No Meja<span style="margin-left:59px;">:</span><span style="margin-left:15px;">{{$order->no_meja}}</span></li>
                  @if($order->notes === null )
                  <li class="list-group-item">Notes<span style="margin-left:70px;">:</span><textarea style="margin-left:15px;"> - </textarea></li>
                  @else
                  <li class="list-group-item" style="text-align:;">Notes<span style="margin-left:70px;">:
                    <textarea disabled style="margin:0 0 0 15px;"> {{$order->notes}}
                    </textarea>
                    <br>
                  </span>
                  </li>
                  @endif
                  @if($order->status == 'belum bayar')
                  <li class="list-group-item">Status<span style="margin-left:70px;">:</span><button style="background-color:grey; color:white; margin-left:15px" class="btn btn-secondary" disabled>{{$order->status}}</button></li>
                  @elseif($order->status == 'menunggu verifikasi')
                  <li class="list-group-item">Status<span style="margin-left:70px;">:</span><button class="btn btn-warning" style="margin-left:15px;" disabled>{{$order->status}}</button></li>
                  @elseif($order->status == 'dibayar')
                  <li class="list-group-item">Status<span style="margin-left:70px;">:</span><button class="btn btn-success" style="margin-left:15px;" disabled>{{$order->status}}</button></li>
                  @else
                  <li class="list-group-item">Status<span style="margin-left:70px;">:</span><button class="btn btn-danger" style="margin-left:15px;" disabled>{{$order->status}}</button></li>
                  @endif
                  @endforeach
                </ul>
              </div>
                <!-- box-header -->
                <div class="box-body">
                    <table class="table table-sm table-bordered bg-white">
                      <thead class="bg-primary">
                        <tr class="table-dark">
                            <th width="1%">No</th>
                            <th width="15%">Gambar</th>
                            <th width="10%">Nama Produk</th>
                            <th width="3%">Jumlah</th>
                            <th width="10%">Subtotal</th>
                            <!-- <th width="10%">Status</th> -->
                            <!-- <th width="10%">Option</th> -->
                        </tr>
                      </thead>
                        <!--ini buat inisiasi nomer-->
                        @php($i=1)
                        <!-- Buat hitung jumlah item, krna klo pake method aga tricky itugn diskonnya  -->
                        @php($sum=0)

                        <!-- ini buat ngecek klo cart kosong apa engga -->
                        @if(count($Details)>=1)

                        @foreach($Details as $detail)

                            {{--dd($detail)--}}
                            <tr>
                              <!-- No -->
                              <td align="center">{{$i++}}</td>
                              <!-- Gambar -->
                                <td ><img src="{{asset($detail->gambar_produk) }}" width="100px" height="75px" ></td>
                                <!-- Nama Produk -->
                                <td>{{ $detail->nama_produk }}</td>
                                <!-- Jumlah item -->
                                <td align="center">{{ $detail->qty }}</td>
                                <!-- Subtotal -->
                                <td>
                                    Rp. {{ number_format($detail->subtotal,0) }}
                                </td>
                                <!-- Status order di detail -->
                                {{--dd($Orders)--}}
                                <!-- @ if($Orders[0]->status == 'belum bayar')
                                <td >
                                <button style="background-color:grey; color:white;" type="button" class="btn btn-secondary disabled">{{ $detail->order->status }}</button>
                                </td>
                                @ elseif($Orders[0]->status == 'menunggu verifikasi')
                                <td>
                                  <button  type="button" class="btn btn-warning" disabled>{{ $detail->order->status }}
                                  </button></td>
                                @ elseif($Orders[0]->status == 'dibayar')
                                <td>
                                  <button  type="button" class="btn btn-success" disabled>{{ $detail->order->status }}
                                  </button></td>
                                @ else
                                <td>
                                  <button  type="button" class="btn btn-danger" disabled>{{ $detail->order->status }}
                                  </button></td>
                                @ endif -->

                                <!-- Rating -->
                                <!-- @ if($detail->status_rating == 'belum' and $detail->order->status == 'dibayar')
                                <td>
                                  <a href="#" data-toggle="modal"
                                  data-target="#Rating{{ $detail->id_order_produk}}">
                                  <input type="submit" class="btn btn-warning" value="Beri Reting"/>
                                  </a>
                                </td>
                                @ elseif($detail->status_rating == 'sudah' AND $detail->order->status == 'dibayar')
                                <td>
                                  <a href="#" data-toggle="modal"
                                  data-target="#Rating{{-- $detail->id_order_produk--}}">
                                  <input type="submit" class="btn btn-warning" value="Anda Sudah Memberi Rating pada pesanan ini"/>
                                  </a>
                                  @ else
                                  <td>
                                    <a href="#" data-toggle="modal"
                                    data-target="#Rating{{-- $detail->id_order_produk--}}">
                                    <input type="submit" class="btn btn-warning" value="Anda harus Menyelesaikan transaksi terlebih dahulu"/>
                                </td>
                                @ endif -->
                            </tr>

                        <!-- chrcking Rating -->
                        <!-- @ includeIf('kenalkopi.order.rating') -->
                        @endforeach
                        <!-- Looping buat cart -->
                        @endif
                        <!-- checking isi cart -->
                        <tr>
                            <td class="bg-primary" colspan="4" align="center" style="font-size: medium">Total</td>
                            <td align="center" class="bg-info" style="font-size: medium">Rp. {{ number_format($Orders[0]->total_price,0) }}</td>
                        </tr>
                    </table>
                </div>
                <!-- /.box-body -->
                <div class="checkout-left">

                <!-- <div class="checkout-left-basket">
                  <h4>Total Harga : Rp {{--$Orders[0]->total_price--}}</h4>
              </div> -->
                <div class="checkout-right-basket">
                  @if($Orders[0]->status == 'belum bayar')
                  <a href="{{ $PaymentUrl[0]}}">Proceed to payment</a>
                  @endif
              <!-- <button class="btn btn-primary" id="pay-button">Bayar Sekarang</button> -->
                </div>
            </div>
        </div>
      </div>
      </div>
    </div>
    </div>

    <!-- <form class="" id="callback_snap" action="index.html" method="post">
      @csrf
      <input type="hidden" name="json" id="json_callback"  value="">
    </form> -->

  <!-- <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script> -->
  <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
  <script type="text/javascript">
     // For example trigger on button clicked, or any time you need
     var payButton = document.getElementById('pay-button');
     payButton.addEventListener('click', function () {
       // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
       window.snap.pay('{{ $SnapToken[0] }}', {
         onSuccess: function(result){
           /* You may add your own implementation here */
           // alert("payment success!"); console.log(result);
          callback_snap(result);
         },
         onPending: function(result){
           /* You may add your own implementation here */
           // alert("wating your payment!"); console.log(result);
          callback_snap(result);
         },
         onError: function(result){
           /* You may add your own implementation here */
           // alert("payment failed!"); console.log(result);
          callback_snap(result);
         },
         onClose: function(){
           /* You may add your own implementation here */
           alert('you closed the popup without finishing the payment');
         }
       })
     });

     function callback_snap(result) {
       docoment.getElementById('json_callback').calue = JSON.stringify(result);
       // alert(docoment.getElementById('json_callback').calue = JSON.stringify(result));
       $('#callback_snap').submit();
     }
   </script>
@endsection


@section('bot')
    <script>
        $(document).ready(function(){
            var flash = "{{ Session::has('status') }}";
            if(flash){
                var status = "{{ Session::get('status') }}";
                swal('success', status, 'success');
            }
        });
    </script>
@endsection
