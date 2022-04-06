@extends('admin.layouts.master')

@section('title')
    Daftar Order
@endsection

@section('breadcrumb')
    @parent
    <li class="active">List Order</li>
@endsection

@section('content')

  <div class="row">
      <div class="col-lg-12">
          <div class="box">
              <!-- <div class="box-header with-border">
                  <div class="btn-group">
                      <button onclick="addForm('{{ route('produk.store') }}')" class="btn btn-success btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Tambah</button>

                      <button onclick="deleteSelected('{{ route('produk.delete_selected') }}')" class="btn btn-danger btn-xs btn-flat"><i class="fa fa-trash"></i> Hapus</button>
                      <button onclick="cetakBarcode('{{ route('produk.cetak_barcode') }}')" class="btn btn-info btn-xs btn-flat"><i class="fa fa-barcode"></i> Cetak Barcode</button>
                  </div>
              </div> -->

              <div class="box-body table-responsive">
                  <form action="" method="post" class="form-produk" enctype="multipart/form-data">
                    @csrf
                      <table class="table table-stiped table-bordered">
                          <thead>
                              <!-- <th width="5%">
                                  <input type="checkbox" name="select_all" id="select_all">
                              </th> -->
                              <th width="5%">No</th>
                              <th>Nama Penerima</th>
                              <th>No Meja</th>
                              <th>Total Bayar</th>
                              <th>Status</th>
                              <th>Tanggal</th>
                              <th>Action</th>
                              <!-- <th>Status</th> -->
                              <!-- <th width="5%"><i class="fa fa-cog"></i></th> -->

                          </thead>
                    <!--ini buat inisiasi nomer-->
                    @php($i=1)
                    @if(count($Orders)>=1)
                    @foreach($Orders as $order)
                      <tbody>
                      <tr>
                          <td>{{ $i++ }}</td>
                        <td>{{$order->first_name."@".$order->last_name}}</td>
                          <td>{{ $order->no_meja }}</td>
                          <td><b>Rp. {{ number_format($order->total_price,0) }}</b></td>
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
                          <td><b>{{ $order->date }}</b></td>
                          <!-- <td><a href="{{-- url('/upload/confirm/'.$order->confirm->image) --}}" download="" class="btn btn-info">Download Attachment</a></td> -->
                          <td>

                              <a class="btn btn-info" href="{{ route('Admin.Orders', ['id' => $order->id_order]) }}">Detail</a>
                          </td>
                      </tr>
                      @endforeach

                    <!-- belum bisa nampilin klo cart kosong -->
                    @else
                    <tr>
                    <td colspan="7" class="text-center">
                      <span>Anda Belum memesan barang</span>
                    </td>
                    </tr>
                    @endif


                      </table>
                  </form>
              </div>
          </div>
      </div>
  </div>
@endsection
