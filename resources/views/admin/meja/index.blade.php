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
                <button data-toggle="modal" data-target="#DetailItem"  class="btn btn-success btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Tambah</button>

            </div>
            <div class="box-body table-responsive">
                <table class="table table-stiped table-bordered">
                    <thead>
                        <th width="5%">No</th>
                        <th>No.Meja</th>
                        <th>QR Code</th>
                        <th width="15%"><i class="fa fa-cog"></i></th>
                    </thead>
                    @php($i=1)
                    @foreach($Users as $user)

                    <tbody>
                        <th width="5%">{{$i++}}</th>
                        <th>
                          <!-- <button type="button" class="btn btn-info btn-lg" >Open Modal</button> -->
                          <button type="button" data-toggle="modal" data-target="#myModal{{$user->id}}" class="btn btn-xs btn-info btn-flat">Lihat QRcode</button>
                          <!-- <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(500)->generate($user->qr_code)) !!}"> -->
                        </th>

                        <!-- <th>Lihat Barcode</th> -->
                        <th>{{$user->name}}</th>
                        <th>{{$user->qr_code}}</th>
                        <th>{{$user->no_meja}}</th>
                        <th width="15%">
                          <div class="btn-group">
                            <button type="button" onclick="editForm(`'. route('user.update', $user->id) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                            <button type="button" onclick="deleteData(`'. route('user.destroy', $user->id) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
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

@endsection
