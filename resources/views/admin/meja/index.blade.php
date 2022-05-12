@extends('admin.layouts.master')

@section('title')
    Daftar Meja
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
                <button data-toggle="modal" data-target="#form-meja"  class="btn btn-success btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Tambah</button>
            </div>
            <div class="box-body table-responsive">
                <table class="table table-stiped table-bordered">
                    <thead>
                        <!-- <th width="5%">No</th> -->
                        <th>No.Meja</th>
                        <th>QR Code</th>
                        <th width="15%"><i class="fa fa-cog"></i></th>
                    </thead>
                    @php($i=1)
                    @foreach($tables as $table)

                    <tbody>
                        <!-- <th width="5%">{{--$i++--}}</th> -->
                        <th>{{ $table->no_meja }}</th>
                        <th>
                          <!-- <button type="button" class="btn btn-info btn-lg" >Open Modal</button> -->
                          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#QRCode{{$table->id}}" >
                            Lihat QRcode</button>

                        </th>

                        <!-- <th>Lihat Barcode</th> -->
                        <th width="15%">
                          <div class="btn-group">

                            <button type="button" onclick="deleteData(`'.route('meja.destroy', $table->id) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                        </div>
                      </th>
                    </tbody>
                    @includeIf('admin.meja.qr_code')
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
@includeIf('admin.meja.form')
<script>
    // tambahkan untuk delete cookie innerHeight terlebih dahulu
    document.cookie = "innerHeight=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";

    function printQR(url, title) {
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

    function deleteData(url) {
        if (confirm('Yakin ingin menghapus data terpilih?')) {
            $.post(url, {
                    '_token': $('[name=csrf-token]').attr('content'),
                    '_method': 'delete'
                })
                .done((response) => {
                  alert('Berhasil menghapus data');
                  location.reload();
                })
                .fail((errors) => {
                    alert('Tidak dapat menghapus data');
                    return;
                });
        }
      }
</script>
@endsection
