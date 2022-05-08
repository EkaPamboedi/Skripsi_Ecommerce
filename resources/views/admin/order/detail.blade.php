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
                      <li class="list-group-item">Tanggal<span style="margin-left:60px;">:</span><span style="margin-left:15px;">{{$order->order_date}}</span></li>
                      <li class="list-group-item">Nama Pemesan<span style="margin-left:15px;">:</span><span style="margin-left:15px;">{{$order->first_name." ".$order->last_name}}</span></li>
                      <li class="list-group-item">No Meja<span style="margin-left:59px;">:</span><span style="margin-left:15px;">{{$order->no_meja}}</span></li>
                      @if($order->notes === null )
                      <li class="list-group-item">Notes<span style="margin-left:70px;">:</span><textarea style="margin-left:15px;"> - </textarea></li>
                      @else
                      <li class="list-group-item" style="text-align:;">Notes<span style="margin-left:70px;">:
                        <textarea disabled style="margin:0 0 0 15px;"> {{$order->notes}}
                        </textarea>
                        <br>
                      </span>
                      </li>
                      @endif
                      <li class="list-group-item">Status<span style="margin-left:70px;">:</span><button class="btn btn-danger" style="margin-left:15px;" disabled>{{$order->status}}</button></li>
                      @includeIf('admin.order.notes')
                      @endforeach
                    </ul>
                  </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-sm">
                       <thead class="bg-primary">
                        <tr >
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
