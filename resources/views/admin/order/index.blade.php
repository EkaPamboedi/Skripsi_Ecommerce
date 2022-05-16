@extends('admin.layouts.master')

@section('title')
    Process Order
@endsection

@section('breadcrumb')
    @parent
    <li class="active">List Order</li>
@endsection

@section('content')


    <div class="row">
      <div class="col-md-3">
        <div class="box box-default">

          <!-- /.box-header -->
          <div class="box-body">
            <table class="table-order-masuk">
              <thead>
                <!-- <th width="5%">No</th> -->
                  <th>
                    <div class="box-header with-border">
                      <!-- <i class="fa fa-bullhorn"></i> -->
                      <h3 class="box-title">Order Masuk</h3>
                    </div>
                  </th>
            </thead>

            <!-- <div class="col-s,/-3"> -->
            <tbody>

            </tbody>
          </table>
          <!-- /.info-box -->

          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- /.col -->

      <div class="col-md-3">
        <div class="box box-default">

          <!-- /.box-header -->
          <div class="box-body">
            <table class="table-order-process">
              <thead>
                <!-- <th width="5%">No</th> -->
                  <th>
                    <div class="box-header with-border">
                      <!-- <i class="fa fa-bullhorn"></i> -->
                      <h3 class="box-title">Order Process</h3>
                    </div>
                  </th>
            </thead>

            <!-- <div class="col-s,/-3"> -->
            <tbody>

            </tbody>
          </table>
          <!-- /.info-box -->

          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>

      <div class="col-md-3">
        <div class="box box-default">

          <!-- /.box-header -->
          <div class="box-body">
            <table class="table-order-ready">
              <thead>
                <!-- <th width="5%">No</th> -->
                  <th>
                    <div class="box-header with-border">
                      <!-- <i class="fa fa-bullhorn"></i> -->
                      <h3 class="box-title">Order Ready</h3>
                    </div>
                  </th>
            </thead>

            <!-- <div class="col-s,/-3"> -->
            <tbody>

            </tbody>
          </table>
          <!-- /.info-box -->

          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>

      <div class="col-md-3">
        <div class="box box-default">

          <!-- /.box-header -->
          <div class="box-body">
            <table class="table-order-selesai">
              <thead>
                <!-- <th width="5%">No</th> -->
                  <th>
                    <div class="box-header with-border">
                      <!-- <i class="fa fa-bullhorn"></i> -->
                      <h3 class="box-title">Order Selesai</h3>
                    </div>
                  </th>
            </thead>

            <!-- <div class="col-s,/-3"> -->
            <tbody>

            </tbody>
          </table>
          <!-- /.info-box -->

          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>


    </div>
    <!-- /.row -->
    <!-- END ALERTS AND CALLOUTS -->
@endsection
@push('scripts')
<script>
let table, table1, table2, table3;
// let table, table1;


$(function () {
    table = $('.table-order-masuk').DataTable({
        processing: true,
        searching: false,
        paging: false,
        autoWidth: false,
        ajax: {
            url: '{{ route('order.data_masuk') }}',
        },
        columns: [
            {data: 'order_masuk'},

        ]
    });
    table1 = $('.table-order-process').DataTable({
        processing: true,
        searching: false,
        paging: false,
        autoWidth: false,
        ajax: {
            url: '{{ route('order.data_process') }}',
        },
        columns: [
            {data: 'order_process'},

        ]
    });
    table2 = $('.table-order-ready').DataTable({
        processing: true,
        searching: false,
        paging: false,
        autoWidth: false,
        ajax: {
            url: '{{ route('order.data_ready') }}',
        },
        columns: [
            {data: 'order_ready'},

        ]
    });
    table3 = $('.table-order-selesai').DataTable({
        processing: true,
        searching: false,
        paging: false,
        autoWidth: false,
        ajax: {
            url: '{{ route('order.data_selesai') }}',
        },
        columns: [
            {data: 'order_selesai'},

        ]
    });
  });
  function updateMasuk(url) {
    if (confirm('Ubah prodes order kembali ke awal?')) {
        $.post(url, {
                '_token': $('[name=csrf-token]').attr('content'),
                '_method': 'post'
            })
            .done((response) => {
                table1.ajax.reload();
                table.ajax.reload();
            })
            .fail((errors) => {
                alert('Gagal memproses data kembali ke awal');
                return;
            });
    }
  }
  function updateProcess(url) {
    if (confirm('Ubah proses order ke tahap Proses?')) {
        $.post(url, {
                '_token': $('[name=csrf-token]').attr('content'),
                '_method': 'post'
            })
            .done((response) => {
                table.ajax.reload();
                table1.ajax.reload();
            })
            .fail((errors) => {
                alert('Gagal memproses ketahap Proses');
                return;
            });
    }
  }
  function updateReadyBack(url) {
    if (confirm('Ubah proses order ke tahap Proses?')) {
        $.post(url, {
                '_token': $('[name=csrf-token]').attr('content'),
                '_method': 'post'
            })
            .done((response) => {
                table1.ajax.reload();
                table2.ajax.reload();
            })
            .fail((errors) => {
                alert('Gagal memproses data ketahap Proses');
                return;
            });
    }

}
    function updateReady(url) {
      if (confirm('Ubah proses order ke tahap Ready?')) {
          $.post(url, {
                  '_token': $('[name=csrf-token]').attr('content'),
                  '_method': 'post'
              })
              .done((response) => {
                  table1.ajax.reload();
                  table2.ajax.reload();
              })
              .fail((errors) => {
                  alert('Gagal memproses data ketahap Ready');
                  return;
              });
      }

  }
  function updateSelesaiBack(url) {
    if (confirm('Ubah proses order ke tahap Ready??')) {
        $.post(url, {
                '_token': $('[name=csrf-token]').attr('content'),
                '_method': 'post'
            })
            .done((response) => {
                table2.ajax.reload();
                table3.ajax.reload();
            })
            .fail((errors) => {
                alert('Gagal memproses data ketahap Ready');
                return;
            });
    }

}
  function updateSelesai(url) {
    if (confirm('Ubah proses order ke tahap Selesai??')) {
        $.post(url, {
                '_token': $('[name=csrf-token]').attr('content'),
                '_method': 'post'
            })
            .done((response) => {
                table2.ajax.reload();
                table3.ajax.reload();
            })
            .fail((errors) => {
                alert('Gagal memproses data ketahap Selesai');
                return;
            });
          }
    }

</script>
@endpush
