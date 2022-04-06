@extends('kenalkopi.layouts.master_without_banner')

@section('title')
    Cart
@endsection


  @section('content')
    <div class="top-brands">
      <div class="container">
      <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Invoice</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">Name Product</th>
                            <th width="20%">Qty</th>
                            <th width="30%">Subtotal</th>
                        </tr>
                        @php($sum=0)
                        @foreach($CartProduk as $produk)
                            <tr>
                                <td>{{ $produk->name }}</td>
                                <td>{{ $produk->qty }}</td>
                                    @if($produk->options->diskon==null)
                                  <td>Rp.{{ number_format($subTotal = $produk->price*$produk->qty)}}</td>
                                    @else
                                  <td>Rp.{{number_format($subTotal =
                                    ($produk->price - ($produk->price * $produk->options->diskon/100))*$produk->qty)}}</td>
                                    @endif
                                    @php($sum = $sum + $subTotal)
                            </tr>
                        @endforeach

                        <tr class="btn-success">
                            <td colspan="2">Total</td>
                            <td>{{ $sum }}</td>
                        </tr>

                        <tr class="btn-info">
                            <td colspan="3">
                                Silahkan anda transfer ke BRI :<br>
                                Atas Nama<b><i>Satria Badja Hitam</i></b></br>
                                No.Rekening<b><i>12345678</i></b>
                            </td>
                        </tr>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
          </div>
        </div>
      </div>
      </div>

  @endsection
