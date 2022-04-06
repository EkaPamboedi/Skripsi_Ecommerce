@extends('admin.layouts.master')

@section('title')
    Daftar User
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Daftar User</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-header with-border">
              <!-- <button onclick="addForm('{{ route('user.store') }}')" class="btn btn-success btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Tambah</button> -->
                <button data-toggle="modal" data-target="#DetailItem"  class="btn btn-success btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Tambah</button>

            </div>
            <div class="box-body table-responsive">
                <table class="table table-stiped table-bordered">
                    <thead>
                        <th width="5%">No</th>
                        <th>QR Code</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No.Meja</th>
                        <th width="15%"><i class="fa fa-cog"></i></th>
                    </thead>
                    @php($i=1)
                    @foreach($Users as $user)

                    <tbody>
                        <th width="5%">{{$i++}}</th>
                        <th>
                          <!-- <button type="button" onclick="addForm('{{ route('produk.store') }}')" class="btn btn-xs btn-info btn-flat">Lihat QRcode</button> -->
                          <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(500)->generate($user->qr_code)) !!} ">
                        </th>
                        <!-- <th>Lihat Barcode</th> -->
                        <th>{{$user->name}}</th>
                        <th>{{$user->email}}</th>
                        <th>{{$user->no_meja}}</th>
                        <th width="15%">
                          <div class="btn-group">
                            <button type="button" onclick="editForm(`'. route('user.update', $user->id) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                            <button type="button" onclick="deleteData(`'. route('user.destroy', $user->id) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                        </div>
                      </th>
                    </tbody>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>

@includeIf('admin.user.form')
@endsection

@push('scripts')
<script>
    let table;

    // $(function () {
    //     table = $('.table').DataTable({
    //         processing: true,
    //         autoWidth: false,
    //         ajax: {
    //             url: '{{ route('user.data') }}',
    //         },
    //         columns: [
    //             {data: 'DT_RowIndex', searchable: false, sortable: false},
    //             {data: 'qr_code'},
    //             {data: 'name'},
    //             {data: 'email'},
    //             {data: 'no_meja'},
    //             {data: 'aksi', searchable: false, sortable: false},
    //         ]
    //     });

    //     $('#modal-form').validator().on('submit', function (e) {
    //         if (! e.preventDefault()) {
    //             $.post($('#modal-form form').attr('action'), $('#modal-form form').serialize())
    //                 .done((response) => {
    //                     $('#modal-form').modal('hide');
    //                     table.ajax.reload();
    //                 })
    //                 .fail((errors) => {
    //                     alert('Tidak dapat menyimpan data');
    //                     return;
    //                 });
    //         }
    //     });
    // });
    //
    // function addForm(url) {
    //     $('#modal-form').modal('show');
    //     $('#modal-form .modal-title').text('Tambah User');
    //
    //     $('#modal-form form')[0].reset();
    //     $('#modal-form form').attr('action', url);
    //     $('#modal-form [name=_method]').val('post');
    //     $('#modal-form [name=name]').focus();
    //
    //     $('#password, #password_confirmation').attr('required', true);
    // }
    //
    // function editForm(url) {
    //     $('#modal-form').modal('show');
    //     $('#modal-form .modal-title').text('Edit User');
    //
    //     $('#modal-form form')[0].reset();
    //     $('#modal-form form').attr('action', url);
    //     $('#modal-form [name=_method]').val('put');
    //     $('#modal-form [name=name]').focus();
    //
    //     $('#password, #password_confirmation').attr('required', false);
    //
    //     $.get(url)
    //         .done((response) => {
    //             $('#modal-form [name=name]').val(response.name);
    //             $('#modal-form [name=email]').val(response.email);
    //         })
    //         .fail((errors) => {
    //             alert('Tidak dapat menampilkan data');
    //             return;
    //         });
    // }
    //
    // function deleteData(url) {
    //     if (confirm('Yakin ingin menghapus data terpilih?')) {
    //         $.post(url, {
    //                 '_token': $('[name=csrf-token]').attr('content'),
    //                 '_method': 'delete'
    //             })
    //             .done((response) => {
    //                 table.ajax.reload();
    //             })
    //             .fail((errors) => {
    //                 alert('Tidak dapat menghapus data');
    //                 return;
    //             });
    //     }
    // }
</script>
@endpush
