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
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Invoice Details</h3>

                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered table-hover">
                        <tr style="font-size: large;" class="btn-success" >
                          <th width="2%">No</th>
                            <th width="5%">Image Product</th>
                            <th width="10%">Name Product</th>
                            <th width="3%">Qty</th>
                            <th width="30%">Subtotal</th>
                        </tr>
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
                                <td align="center" ><img src="{{asset($detail->produk->gambar_produk) }}" width="100px" height="100px" ></td>
                                <td align="center" style="font-size: medium">{{ $detail->produk->nama_produk }}</td>
                                <td align="center" style="font-size: medium">{{ $detail->qty }}</td>
                                <td align="center" style="font-size: medium">
                                    Rp. {{ number_format($detail->subtotal,0) }}
                                </td>
                            </tr>
                            @endforeach
                            @endif

                        <tr class="btn-success">
                            <td colspan="4" align="center" style="font-size: medium">Total</td>
                            <td align="center" style="font-size: medium">Rp. {{ number_format($detail->order->total_price,0) }}</td>
                        </tr>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>
@endsection
