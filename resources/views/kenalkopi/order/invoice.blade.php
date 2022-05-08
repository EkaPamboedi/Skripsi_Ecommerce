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
                    <table class="table table-sm table-bordered">
                      <thead class="bg-primary">

                        <tr>
                            <th width="30%">Name Product</th>
                            <th width="20%">Qty</th>
                            <th width="30%">Subtotal</th>
                          </tr>
                        </thead>
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

                        <tr class="btn-primary">
                            <td colspan="2" class="btn-primary">Total</td>
                            <td class="btn-info">{{ $sum }}</td>
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
