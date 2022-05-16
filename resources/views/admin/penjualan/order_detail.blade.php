@extends('admin.layouts.master')

@section('title')
    Detail Order
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Detail Order</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <!-- <h3 class="box-title">Detail Order</h3> -->
                    <ul class="list-group">

                      @foreach($Orders as $order)
                      {{--dd($order->notes)--}}
                      <li class="list-group-item">Kode Order <span style="margin-left:36px;">:</span><span style="margin-left:15px;">{{$order->code_order}}</span></li>
                      <li class="list-group-item">Tanggal<span style="margin-left:60px;">:</span><span style="margin-left:15px;">{{$order->updated_at}}</span></li>
                      <li class="list-group-item">Nama Pemesan<span style="margin-left:15px;">:</span><span style="margin-left:15px;">{{$order->first_name." ".$order->last_name}}</span></li>
                      <li class="list-group-item">No Meja<span style="margin-left:59px;">:</span><span style="margin-left:15px;">{{$order->no_meja}}</span></li>
                      <!-- Notes -->
                      @if($order->notes === null )
                      <li class="list-group-item">Notes<span style="margin-left:70px;">:</span><span style="margin-left:15px;"> - </span></li>
                      @else
                      <li class="list-group-item" style="text-align:;">Notes<span style="margin-left:70px;">:
                        <span disabled style="margin:0 0 0 15px;"> {{$order->notes}}
                        </span>
                        <br>
                      </span>
                      </li>
                      @endif
                      <!-- Jenis Pembayaran -->
                      @if($order->jenis_pembayaran == 'ditempat')
                        <li class="list-group-item">Pembayaran<span style="margin-left:30px;">:</span><button style=" color:white; margin-left:15px" class="btn btn-primary" disabled>{{$order->jenis_pembayaran}}</button></li>
                        @else
                        <li class="list-group-item">Pembayaran<span style="margin-left:30px;">:</span><button class="btn btn-success" style="margin-left:15px;" disabled>{{$order->jenis_pembayaran}}</button></li>
                      @endif

                      @if($order->status == 'belum bayar')
                        <li class="list-group-item">Status<span style="margin-left:65px;">:</span><button style="background-color:grey; color:white; margin-left:15px" class="btn btn-secondary" disabled>{{$order->status}}</button></li>
                        @elseif($order->status == 'menunggu verifikasi')
                        <li class="list-group-item">Status<span style="margin-left:65px;">:</span><button class="btn btn-warning" style="margin-left:15px;" disabled>{{$order->status}}</button></li>
                        @elseif($order->status == 'dibayar')
                        <li class="list-group-item">Status<span style="margin-left:65px;">:</span><button class="btn btn-success" style="margin-left:15px;" disabled>{{$order->status}}</button></li>
                        @else
                        <li class="list-group-item">Status<span style="margin-left:65px;">:</span><button class="btn btn-danger" style="margin-left:15px;" disabled>{{$order->status}}</button></li>
                        @endif
                      @endforeach

                      @if($order->stat_pemesanan == 'masuk')
                      <li class="list-group-item">Proses Order <span style="margin-left:25px;">:</span><button class="btn" style=" background-color:#396EB0; margin-left:15px; color : white; " disabled>{{$order->stat_pemesanan}}</button></li>
                      @elseif($order->stat_pemesanan == 'process')
                      <li class="list-group-item">Proses Order <span style="margin-left:25px;">:</span><button class="btn" style=" background-color:#FFBD35; margin-left:15px; color : white; " disabled>{{$order->stat_pemesanan}}</button></li>
                      @elseif($order->stat_pemesanan == 'ready')
                      <li class="list-group-item">Proses Order <span style="margin-left:25px;">:</span><button class="btn" style=" background-color:#3FA796; margin-left:15px; color : white; " disabled>{{$order->stat_pemesanan}}</button></li>
                      @else
                      <li class="list-group-item">Proses Order <span style="margin-left:25px;">:</span><button class="btn" style=" background-color:#A6CF98; margin-left:15px; color : black; " disabled>{{$order->stat_pemesanan}}</button></li>
                      @endif

                      @if($order->jenis_pembayaran == 'ditempat' && $order->status =='dibayar')
                      <li style=" list-style-type:none; margin-top:15px;float:right;"><button class="btn btn-warning btn-flat" onclick="notaKecil('{{ route('penjualan.nota_kecil', $order->id_order) }}', 'Nota Kecil')">Cetak Nota</button></li>
                      @endif
                    </ul>

                  </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-sm table-bordered" >
                       <thead class="bg-primary">
                        <tr style="border-color:black;">
                          <th width="2%">No</th>
                          <th width="15%">Gambar</th>
                          <th width="10%">Nama Produk</th>
                          <th width="3%">Jumlah</th>
                          <th width="10%">Subtotal</th>
                          <th width="10%">Status</th>
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
                              <td class="center">{{$i++}}</td>
                                <td><img src="{{asset($detail->gambar_produk) }}" width="100px" height="100px" ></td>
                                <td style="font-size: medium">{{ $detail->nama_produk }}</td>
                                <td style="font-size: medium">{{ $detail->qty }}</td>
                                <td style="font-size: medium">{{ $Orders[0]->status }}</td>
                                <td style="font-size: medium">
                                    Rp. {{ number_format($detail->subtotal,0) }}
                                </td>
                            </tr>
                            @endforeach
                            @endif

                        <tr>
                            <td class="bg-primary" colspan="5" align="center" style="font-size: medium">Total</td>
                            <td align="center" class="bg-info" style="font-size: medium">Rp. {{ number_format($Orders[0]->total_price,0) }}</td>
                        </tr>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script>
function notaKecil(url, title) {
    popupCenter(url, title, 625, 500);
}
function popupCenter(url, title, w, h) {
    const dualScreenLeft = window.screenLeft !==  undefined ? window.screenLeft : window.screenX;
    const dualScreenTop  = window.screenTop  !==  undefined ? window.screenTop  : window.screenY;

    const width  = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
    const height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

    const systemZoom = width / window.screen.availWidth;
    const left       = (width - w) / 2 / systemZoom + dualScreenLeft
    const top        = (height - h) / 2 / systemZoom + dualScreenTop
    const newWindow  = window.open(url, title,
    `
        scrollbars=yes,
        width  = ${w / systemZoom},
        height = ${h / systemZoom},
        top    = ${top},
        left   = ${left}
    `
    );

    if (window.focus) newWindow.focus();
}
</script>
@endpush
