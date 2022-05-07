@extends('kenalkopi.layouts.master_without_banner')

@section('title')
    Cart
@endsection


  @section('content')
<div class="top-brands">
<div class="container">
<div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Riwayat Pesanan Anda</h3>
                </div>

            <!-- /.box-header -->
                <div class="box-body">
                    <table id="myTable" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Penerima</th>
                            <th>No Meja</th>
                            <th>Total Bayar</th>
                            <th>Tanggal</th>
                            <th>Kode Pesanan</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        @php($i=1)
                        <!-- ini buat ngecek klo cart kosong apa engga -->
                        @if(count($Orders)>=1)
                        @foreach($Orders as $order)
                            <tbody>
                            <tr>
                              <td class="invert">{{$i++}}</td>
                              <td>{{ $order->first_name." ".$order->last_name }}</td>
                                <td>{{ $order->no_meja }}</td>
                                <td>Rp. {{ number_format($order->total_price,0) }}</td>
                                <td>{{ $order->order_date }}</td>
                                <td align="center">{{ $order->code_order }}</td>
                                <td>
                                    @if($order->status == 'belum bayar')
                                        <button type="button" class="btn bg-maroon">{{ ucwords($order->status) }}</button>
                                    @elseif($order->status == 'menunggu verifikasi')
                                        <button type="button" class="btn bg-orange">{{ ucwords($order->status) }}</button>
                                    @elseif($order->status == 'dibayar')
                                        <button type="button" class="btn btn-success">{{ ucwords($order->status) }}</button>
                                    @else
                                        <button type="button" class="btn bg-danger">{{ ucwords($order->status) }}</button>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('detail_order', ['id' => $order->id_order]) }}" class="btn btn-info">Detail</a>

                                    <!-- @ if($order->status == 'belum bayar')
                                        <a href="{{--route('user_confirm', ['id' => $order->id_order]) --}}" class="btn btn-bitbucket">Konfirmasi Pembayaran</a>
                                    @ endif -->
                                </td>
                            </tr>
                            </tbody>
                        @endforeach

                        <tfoot>
                        <!-- <tr>
                            <th>ID</th>
                            <th>Nama Penerima</th>
                            <th>Alamat</th>
                            <th>Total Bayar</th>
                            <th>Tanggal</th>
                            <th>Kode Pesanan</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr> -->
                        </tfoot>
                        <!-- belum bisa nampilin klo cart kosong -->
                      @else
                        <tr class="rem1">
                        <td class="invert" colspan="8" class="text-center">
                          <span>Anda Belum memesan barang</span>
                        </td>
                      </tr>
                      @endif <!-- End of cart chengking item -->
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Detail Pesanan</h4>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Product</th>
                            <th>Qty</th>
                            <th>Subtotal</th>
                        </tr>
                    </table>
                    </thead>

                    <tbody id="detail-pesanan">

                    </tbody>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success pull-left" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
    </div>
    </div>

    <meta name="csrf-token" content="{{ csrf_token() }}">

  @endsection
