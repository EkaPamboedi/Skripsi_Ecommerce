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
    <p style="margin: 0 20% 0 20%;float: left;">=================================================</p>
  </div>
    <br>
    <div class="text-center">
    <table width="60%" style="border: 0; margin:0 20% 0 20%;" class="text-center">
      <thead>
      <th>No</th>
      <th>Produk</th>
      <th>Harga</th>
      <th>Diskon</th>
      <th>Jumlah</th>
      <th>Subtotal</th>
    </thead>

        @foreach ($detail as $item)
        <tr>
          <td>{{$i++}}</td>
          <td>{{ $item->produk->nama_produk }}</td>
          <td>{{ $item->produk->harga_jual }}</td>
          <td>{{ $item->produk->diskon}}%</td>
          <td>{{ $item->qty}}</td>
          @if($item->produk->diskon == 0)
          <td>{{ $item->produk->harga_jual * $item->qty}}</td>
          @else
          <td>{{ ($item->produk->harga_jual - (($item->produk->harga_jual * $item->produk->diskon)/100)) * $item->qty}}</td>
          @endif
        </tr>
        @endforeach
    </table>
    <p class="text-center" style="border: 0; margin:0 20% 0 20%;">-----------------------------------</p>

    <table width="56%" style="border: 0;margin:0 20% 0 20%;">

        <tr>
            <td style="float: left;">Total Harga:</td>
            <td style="float: right;">{{ format_uang($penjualan->total_price) }}</td>
        </tr>
        <tr>
        <tr>
            <td style="float: left;">Total Bayar:</td>
            <td style="float: right;">{{ format_uang($penjualan->diterima) }}</td>
        </tr>
        <tr>
            <td style="float: left;">Diterima:</td>
            <td style="float: right;">{{ format_uang($penjualan->dikembalikan) }}</td>
        </tr>
        <tr>
            <td style="float: left;">Kembali:</td>
            <td style="float: right;">{{ format_uang($penjualan->diterima - $penjualan->bayar) }}</td>
        </tr>
    </table>

    <p style="margin: 0 20% 0 20%;float: left;">=================================================</p>
    <div class="clear-both" style="clear: both;"></div>
    <tr>
      <td style="margin: 0 0 550px 550px;float: left;">Catatan :</td>
      <td style="float: right;">{{$penjualan->notes}}.</td>
    </tr>
    <p class="text-center" style="margin-top:5%;">-- TERIMA KASIH --</p>
  </div>

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
