@extends('admin.layouts.master')

@section('title')
    Daftar Order
@endsection

@section('breadcrumb')
    @parent
    <li class="active">List Konfirmasi</li>
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

                            <th>#</th>
                            <th>Name</th>
                            <th>Total Price</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Proof Of Payment</th>
                            <th>Action</th>
                              <th width="5%"><i class="fa fa-cog"></i></th>
                          </thead>

                        <!--ini buat inisiasi nomer-->
                        @php($i=1)
                        @if(count($Confirms)>=1)
                        @foreach($Confirms as $confirm)

                            <tbody>
                            <tr>
                          <td>{{ $i++ }}</td>
                          <td>{{$confirm->first_name.$confirm->last_name}}</td>
                          <td>Rp. {{ number_format($confirm->total_price,0) }}</td>
                          <td>{{ $confirm->date }}</td>
                          <td>
                            @if($confirm->status_order == 'belum bayar')
                                <button type="button" class="btn bg-maroon">{{ ucwords($confirm->status_order) }}</button>
                            @elseif($confirm->status_order == 'menunggu verifikasi')
                                <button type="button" class="btn bg-orange">{{ ucwords($confirm->status_order) }}</button>
                            @elseif($confirm->status_order == 'dibayar')
                                <button type="button" class="btn btn-success">{{ ucwords($confirm->status_order) }}</button>
                            @else
                                <button type="button" class="btn bg-danger">{{ ucwords($confirm->status_order) }}</button>
                            @endif
                          </td>
                                <td>
                                    <a href="{{ url('upload/confirm/'.$confirm->image) }}" class="btn bg-maroon-active" download>Download Attachment</a>
                                </td>
                                <td>
                              <a href="{{ url('/confirmAdmin/detail/'.$confirm->id_order) }}" class="btn btn-info">Detail</a>
                              <a href="{{ url('confirmAdmin/terima/'.$confirm->id_order) }}" class="btn bg-navy">Terima</a>
                              <a href="{{ url('confirmAdmin/tolak/'.$confirm->id_order) }}" class="btn bg-red-active">Tolak</a>
                                </td>
                            </tr>
                            </tbody>
                        @endforeach

                        <!-- <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Total Price</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Proof Of Payment</th>
                            <th>Action</th>
                        </tr>
                        </tfoot> -->

                          <!-- belum bisa nampilin klo cart kosong -->
                          @else
                          <tr>
                          <td colspan="7" class="text-center">
                            <span>Anda Belum memesan barang</span>
                          </td>
                          </tr>
                          @endif
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
@endsection


@section('bot')
    <!-- DataTables -->
    <script src="{{ asset('assets/bower_components/datatables.net/js/jquery.dataTables.min.js') }} "></script>
    <script src="{{ asset('assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }} "></script>

    <script>
        $(function () {
            $('#categories').DataTable()
            // $('#categories').DataTable({
            //     'paging'      : true,
            //     'lengthChange': false,
            //     'searching'   : false,
            //     'ordering'    : true,
            //     'info'        : true,
            //     'autoWidth'   : false,
            //     // 'processing'  : true,
            //     // 'serverSide'  : true,
            //
            // })
        })
    </script>

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
