<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img style="width:50px; height:45px;" src="{{ url(auth()->user()->foto ?? '') }}" class="img-circle img-profil" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ auth()->user()->name}}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li>
                <a href="{{ route('dashboard') }}">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>

          <!-- if (auth()->user()->level == 1) -->
            <li class="header">ADMIN ONLY</li>
            <li>
                <a href="{{ route('kategori.index') }}">
                    <i class="fa fa-cube"></i> <span>Kategori</span>
                </a>
            </li>
            <li>
                <a href="{{ route('produk.index') }}">
                    <i class="fa fa-cubes"></i> <span>Produk</span>
                </a>
            </li>
            <li>
                <a href="{{ route('supplier.index') }}">
                    <i class="fa fa-truck"></i> <span>Supplier</span>
                </a>
            </li>


            <li class="header">TRANSAKSI</li>
            <li>
              <!-- Optional -->
                <a href="{{ route('pengeluaran.index') }}">
                    <i class="fa fa-money"></i> <span>Pengeluaran</span>
                </a>
            </li>

            <!-- Pembelian produk, bahan baku dll. -->
            <li>
                <a href="{{ route('pembelian.index') }}">
                    <i class="fa fa-download"></i> <span>Belanja Stok</span>
                </a>
            </li>
            <!-- Penjualan produk, bahan baku dll. -->
            <li>
                <a href="{{ route('transaksi.baru') }}">
                    <i class="fa fa-cart-arrow-down"></i> <span>Kasir</span>
                </a>
            </li>
            <!-- <li>
                <a href="{{-- route('order_manual.index') --}}">
                    <i class="fa fa-cart-arrow-down"></i> <span>Kasir</span>
                </a>
            </li> -->
            <!-- <li>
                <a href="{{-- route('transaksi.index') --}} ">
                    <i class="fa fa-cart-arrow-down"></i> <span>Transaksi Aktif</span>
                </a>
            </li> -->
            <!-- <li>
                <a href="{{-- route('transaksi.baru') --}}">
                    <i class="fa fa-cart-arrow-down"></i> <span>Transaksi Baru</span>
                </a>
            </li> -->
            <li class="header">REPORT</li>
            <li>
                <a href="{{ route('order.index') }}">
                    <i class="fa fa-money"></i> <span>List Order</span>
                </a>
            </li>
            <li>
                <a href="{{ route('penjualan.index') }}">
                    <i class="fa fa-upload"></i> <span>Order Manual</span>
                </a>
            </li>
            <li>
                <a href="{{ route('laporan.index') }}">
                    <i class="fa fa-file-pdf-o"></i> <span>Laporan</span>
                </a>
            </li>


            <li class="header">SYSTEM</li>
            <li>
                <a href="{{-- route('dashboard.index') --}}">
                    <i class="fa fa-users"></i> <span>Pengaturan</span>
                </a>
            </li>
            <li><a href="{{ route('meja.index') }}">
                    <i class="fa fa-tables"></i> <span>Pengaturan Meja</span>
                </a>
            </li>
<!--
            <li>
                <a href="{{ route("setting.index") }}">
                    <i class="fa fa-cogs"></i> <span>Pengaturan</span>
                </a>
            </li>
-->
            <!-- else -->

            <!-- <li>
                <a href="{{-- route('transaksi.index') --}}">
                    <i class="fa fa-cart-arrow-down"></i> <span>Transaksi Aktif</span>
                </a>
            </li>
            <li>
                <a href="{{-- route('transaksi.baru') --}}">
                    <i class="fa fa-cart-arrow-down"></i> <span>Transaksi Baru</span>
                </a>
            </li> -->

            <!-- endif
-->
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
