@extends('admin.layouts.master')

@section('title')
    Riwayat Order
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Daftar Penjualan</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-body table-responsive">
                <table class="table table-stiped table-bordered table-penjualan">
                    <thead>
                      <!-- Ini buat tabel Order yang sudah ada -->
                        <th width="5%">No</th>
                        <th>Tanggal</th>
                        <th>Code Order</th>
                        <th>Nama Pemesan</th>
                        <th>Jenis Pembayaran</th>
                        <th>Total Harga</th>
                        <th width="15%"><i class="fa fa-cog"></i></th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@foreach ($penjualan as $item)
@includeIf('admin.penjualan.notes')
@endforeach
@includeIf('admin.penjualan.detail')
@endsection

@push('scripts')
<script>
    let table, table1;

    $(function () {
        table = $('.table-penjualan').DataTable({
            processing: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('penjualan.data') }}',
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'tanggal'},
                {data: 'code_order'},
                {data: 'nama_pemesan'},
                {data: 'jenis_pembayaran'},
                {data: 'total_harga'},
                {data: 'aksi', searchable: false, sortable: false},
            ]
        });

        table1 = $('.table-detail').DataTable({
            processing: true,
            bSort: false,
            dom: 'Brt',
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'kode_produk'},
                {data: 'nama_produk'},
                {data: 'harga_jual'},
                {data: 'diskon'},
                {data: 'jumlah'},
                {data: 'subtotal'},
                // {data: 'bayar'},
                // {data: 'diterima'},
            ]
        })
    });

    // function showNotes() {
    //     $('#modal-notes').modal('show');
    //
    //     // table1.ajax.url($id);
    //     // table1.ajax.reload();
    // }
    // $(document).ready(function(){
    // $("#modal-notes").modal();
    // });

    function showDetail(url) {
        $('#modal-detail').modal('show');

        table1.ajax.url(url);
        table1.ajax.reload();
    }

    function deleteData(url) {
        if (confirm('Yakin ingin menghapus data terpilih?')) {
            $.post(url, {
                    '_token': $('[name=csrf-token]').attr('content'),
                    '_method': 'delete'
                })
                .done((response) => {
                    table.ajax.reload();
                })
                .fail((errors) => {
                    alert('Tidak dapat menghapus data');
                    return;
                });
        }
    }
</script>
@endpush
