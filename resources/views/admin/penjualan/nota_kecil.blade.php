<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nota Kecil</title>

    <?php
    $style = '
    <style>
        * {
            font-family: "consolas", sans-serif;
        }
        p {
            display: block;
            margin: 3px;
            font-size: 10pt;
        }
        table td {
            font-size: 9pt;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }

        @media print {
            @page {
                margin: 0;
                size: 75mm
    ';
    ?>
    <?php
    $style .=
        ! empty($_COOKIE['innerHeight'])
            ? $_COOKIE['innerHeight'] .'mm; }'
            : '}';
    ?>
    <?php
    $style .= '
            html, body {
                width: 70mm;
            }
            .btn-print {
                display: none;
            }
        }
    </style>
    ';
    ?>

    {!! $style !!}


</head>
<body onload="window.print()">
    <button class="btn-print" style="position: absolute; right: 1rem; top: rem;" onclick="window.print()">Print</button>
    <div class="text-center">
        <h3 style="border: 0; margin:0 20% 5px 20%;">{{-- strtoupper($setting->nama_perusahaan) --}} KenalKopi</h3>
        <p>{{-- strtoupper($setting->alamat) --}} jl.Pondok Kopi</p>
    </div>
    <br>
    <div class="text-center">
        <p>{{ strtoupper(auth()->user()->name) }}</p>
        <div class="clear-both" style="clear: both;"></div>
        <p>Tgl:{{ date('d-m-Y') }}</p>
    <div class="clear-both" style="clear: both;"></div>
    <p>No  : {{ $penjualan->code_order }}</p>
    <div class="clear-both" style="clear: both;"></div>
    <p>=========================</p>

  </div>
    <br>
    <div class="clear-both" style="clear: both;"></div>
    <table class="table table-sm table-bordered">
      <thead>
      <th>Nomor</th>
      <th>Produk</th>
      <th>qty</th>
      <th>Subtotal</th>
    </thead>

        @foreach ($detail as $item)
        <tr>
          <td style="text-align:center;">{{$i++}}</td>
          <td>{{ $item->produk->nama_produk }}</td>
          <td style="text-align:center;">{{ $item->qty}}</td>
          @if($item->produk->diskon == 0)
          <td>{{ $item->produk->harga_jual * $item->qty}}</td>
          @else
          <td>{{ ($item->produk->harga_jual - (($item->produk->harga_jual * $item->produk->diskon)/100)) * $item->qty}}</td>
          @endif
        </tr>
        @endforeach
    <!-- </table> -->
      <tr>
        <td >Total:</td>
        <th colspan="row"></th>
        <th colspan="row"></th>
        <td>{{ format_uang($penjualan->diterima) }}</td>
      </tr>
        <tr>
          <td >Diterima:</td>
          <th colspan="row"></th>
          <th colspan="row"></th>
          <td>{{ format_uang($penjualan->diterima) }}</td>
        </tr>
        <tr>
          <td >Kembali:</td>
          <th colspan="row"></th>
          <th colspan="row"></th>
          <td>{{ format_uang($penjualan->dikembalikan) }}</td>
        </tr>
        <tr>
    </table>
    <!-- <div class="text-center"> -->
    <p>=========================</p>
    <div class="clear-both" style="clear: both;"></div>
    <div style="font-size:13px;" class="box-body">
       <dl>
         <dt>Catatan</dt>
         <dd>{{$penjualan->notes}}.</dd>
         <!-- <dt>No.meja</dt> -->
         <dd>{{-- $penjualan->no_meja --}}</dd>
       </dl>
     </div>
    <p class="text-center" style="margin-top:5%;">-- TERIMA KASIH --</p>
  <!-- </div> -->

    <script>
        let body = document.body;
        let html = document.documentElement;
        let height = Math.max(
                body.scrollHeight, body.offsetHeight,
                html.clientHeight, html.scrollHeight, html.offsetHeight
            );

        document.cookie = "innerHeight=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
        document.cookie = "innerHeight="+ ((height + 50) * 0.264583);
    </script>
</body>
</html>
