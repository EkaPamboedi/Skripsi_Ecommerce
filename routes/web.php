
<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
//Admin
    DashboardController,
    // CartController,
    KategoriController,
    ProdukController,
    LaporanController,
    MemberController,
    OrderController,
    ConfirmAdminController,
    PengeluaranController,
    PembelianController,
    PembelianDetailController,
    PenjualanController,
    PenjualanDetailController,
    KasirController,
    SettingController,
    SupplierController,
    MejaController,
    UserController,
//User
    HomeController,
    KenalKopiController,
    InvoiceController,
    CartController,
    ConfirmUserController,
};
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//
// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/kenalkopi', function () {
    return redirect('/kenalkopi/login');
    // return view('kenal_kopi.index');

  });



Auth::routes();


Route::get('/kenalkopi/home', [App\Http\Controllers\Auth\LoginController::class, 'index'])->name('welcome');
Route::get('/kenalkopi/login', [App\Http\Controllers\Auth\LoginController::class, 'qrCodeLogin'])->name('kenalkopi.index');
Route::post('/kenalkopi/qrlogin', [App\Http\Controllers\Auth\LoginController::class, 'attemptQrLogin'])->name('qrlogin');


Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'attemptLogin'])->name('login');
Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');


Route::group(['middleware' => 'auth'], function () {
  Route::group(['middleware' => 'admin'], function () {

      Route::get('Admin/dashboard', [DashboardController::class, 'index'])->name('dashboard');
// BAGIAN KATEGORI
      Route::get('Admin/kategori/data', [KategoriController::class, 'data'])->name('kategori.data');
      Route::resource('Admin/kategori', KategoriController::class);

// BAGIAN PRODUK di ADMIN
      Route::get('Admin/produk/data', [ProdukController::class, 'data'])->name('produk.data');
      Route::post('Admin/produk/delete-selected', [ProdukController::class, 'deleteSelected'])->name('produk.delete_selected');
      Route::get('Admin/produk/aktif/{produk_id}', [ProdukController::class, 'aktif'])->name('produk_aktif');
      Route::get('Admin/produk/nonaktif/{produk_id}', [ProdukController::class, 'nonaktif'])->name('produk_nonaktif');
      Route::post('Admin/produk/cetak-barcode', [ProdukController::class, 'cetakBarcode'])->name('produk.cetak_barcode');
      Route::resource('Admin/produk', ProdukController::class);

      //  CETAK MEMBER
      Route::get('Admin/member/data', [MemberController::class, 'data'])->name('member.data');
      Route::post('Admin/member/cetak-member', [MemberController::class, 'cetakMember'])->name('member.cetak_member');
      Route::resource('Admin/member', MemberController::class);

      // DATA SUPPLIER
      Route::get('Admin/supplier/data', [SupplierController::class, 'data'])->name('supplier.data');
      Route::resource('Admin/supplier', SupplierController::class);


      // (LIST) ORDER DARI USER KE ADMIN
      Route::get('Admin/orders/masuk', [OrderController::class, 'data_order_masuk'])->name('order.data_masuk');
      Route::get('Admin/orders/process', [OrderController::class, 'data_order_process'])->name('order.data_process');
      Route::get('Admin/orders/ready', [OrderController::class, 'data_order_ready'])->name('order.data_ready');
      Route::get('Admin/orders/selesai', [OrderController::class, 'data_order_selesai'])->name('order.data_selesai');

      Route::post('Admin/orders/masuk/{id}', [OrderController::class, 'order_masuk'])->name('order.masuk');
      Route::post('Admin/orders/process/{id}', [OrderController::class, 'order_process'])->name('order.process');
      Route::post('Admin/orders/ready_back/{id}', [OrderController::class, 'order_ready_back'])->name('order.ready_back');
      Route::post('Admin/orders/ready/{id}', [OrderController::class, 'order_ready'])->name('order.ready');
      Route::post('Admin/orders/selesai_back/{id}', [OrderController::class, 'order_selesai_back'])->name('order.selesai_back');
      Route::post('Admin/orders/selesai/{id}', [OrderController::class, 'order_selesai'])->name('order.selesai');
      // Route::get('Admin/orders/data', [OrderController::class, 'data'])->name('order.data');
      // Route::get('Admin/orders/detail/{id}', [OrderController::class, 'show'])->name('Admin.Orders');
      Route::resource('Admin/order', OrderController::class)->except('create', 'edit');


      //
      //KONFIRMASI PEMBAYARAN DARI LIST ORDER
      Route::get('Admin/confirmAdmin/detail/{id}',[ConfirmAdminController::class, 'detail'])->name('confirmAdmin.detail');
      Route::get('Admin/confirmAdmin/terima/{id_order}',[ConfirmAdminController::class, 'terima'])->name('confirmAdmin.terima');
      Route::get('Admin/confirmAdmin/tolak/{id_order}',[ConfirmAdminController::class, 'tolak'])->name('confirmAdmin.tolak');
      Route::get('Admin/confirms_order',[ConfirmAdminController::class, 'index'])->name('confirmAdmin');

      // Daftar dan Belanja PENGELUARAN
      Route::get('Admin/pengeluaran/data', [PengeluaranController::class, 'data'])->name('pengeluaran.data');
      Route::resource('Admin/pengeluaran', PengeluaranController::class);

      // Daftar dan Belanja Bahan
      Route::get('Admin/pembelian/data', [PembelianController::class, 'data'])->name('pembelian.data');
      Route::get('Admin/pembelian/{id}/create', [PembelianController::class, 'create'])->name('pembelian.create');
      Route::resource('Admin/pembelian', PembelianController::class)
          ->except('create');

      Route::get('Admin/pembelian_detail/{id}/data', [PembelianDetailController::class, 'data'])->name('pembelian_detail.data');
      Route::get('Admin/pembelian_detail/loadform/{diskon}/{total}', [PembelianDetailController::class, 'loadForm'])->name('pembelian_detail.load_form');
      Route::resource('Admin/pembelian_detail', PembelianDetailController::class)
          ->except('create', 'show', 'edit');

      // Daftar  PENJUALAN
      // Dafrat Order Manual
      // ini root nya
      Route::get('Admin/penjualan', [PenjualanController::class, 'index'])->name('penjualan.index');
      // ini datanya
      Route::get('Admin/penjualan/data', [PenjualanController::class, 'data'])->name('penjualan.data');
      // melihat detail
      Route::get('Admin/penjualan/detail/{id}', [PenjualanController::class, 'detail'])->name('penjualan.detail');
      Route::get('Admin/penjualan/{id}', [PenjualanController::class, 'show'])->name('penjualan.show');
      Route::get('Admin/penjualan/nota-kecil/{id}', [PenjualanController::class, 'penjualan_notaKecil'])->name('penjualan.nota_kecil');
      Route::delete('Admin/penjualan/{id}', [PenjualanController::class, 'destroy'])->name('penjualan.destroy');
  // });

  // Route::group(['middleware' => 'level:1,2'], function () {
      // TRANSAKSI Baru untuk PENJUALAN
      Route::get('Admin/transaksi/baru', [PenjualanController::class, 'create'])->name('transaksi.baru');
      Route::post('Admin/transaksi/simpan', [PenjualanController::class, 'store'])->name('transaksi.simpan');
      Route::get('Admin/transaksi/selesai', [PenjualanController::class, 'selesai'])->name('transaksi.selesai');
      Route::get('Admin/transaksi/nota-kecil', [PenjualanController::class, 'notaKecil'])->name('transaksi.nota_kecil');
      Route::get('Admin/transaksi/nota-besar', [PenjualanController::class, 'notaBesar'])->name('transaksi.nota_besar');

      // Route buat kasir tapi nge load transaksi terakhir dan harus ada memeber
      // Mengedit transaksi sebelumnya

      // Load diskon, karna perhitungan diskon nya per Order. bukan peritem
      Route::get('Admin/transaksi/{id}/data', [PenjualanDetailController::class, 'data'])->name('transaksi.data');
      Route::get('Admin/transaksi/loadform/{diskon}/{total}/{diterima}', [PenjualanDetailController::class, 'loadForm'])->name('transaksi.load_form');
      // Ini transaksi.index buat route daftar Order Manual
      Route::resource('Admin/transaksi', PenjualanDetailController::class)
          ->except('create', 'show', 'edit');
  // });

  // Route::group(['middleware' => 'level:1'], function () {
      Route::get('Admin/laporan', [LaporanController::class, 'index'])->name('laporan.index');
      Route::get('Admin/laporan/data/{awal}/{akhir}', [LaporanController::class, 'data'])->name('laporan.data');
      Route::get('Admin/laporan/pdf/{awal}/{akhir}', [LaporanController::class, 'exportPDF'])->name('laporan.export_pdf');

      Route::get('Admin/user/data', [UserController::class, 'data'])->name('user.data');
      Route::resource('Admin/user', UserController::class);

      Route::get('Admin/meja/store', [MejaController::class, 'store'])->name('tables.store');
      Route::get('Admin/admin/Meja/PrintQr/{id}', [MejaController::class, 'printQR'])->name('print.Qr');
      // Route::get('qrcode/{id}', [MejaController::class, 'generate'])->name('tables.generate');
      Route::resource('Admin/meja', MejaController::class);

      // Route::get('Admin/setting', [SettingController::class, 'index'])->name('setting.index');
      // Route::get('Admin/setting/master', [SettingController::class, 'master'])->name('setting.master');
      // Route::get('Admin/setting/first', [SettingController::class, 'show'])->name('setting.show');
      // Route::post('Admin/setting', [SettingController::class, 'update'])->name('setting.update');
  // });

  // Route::group(['middleware' => 'level:1,2'], function () {
  // Route::get('Admin', [UserController::class, 'index'])->name('user.index');
      Route::get('Admin/profile', [UserController::class, 'profile'])->name('user.profile');
      Route::post('Admin/profile/update', [UserController::class, 'updateProfile'])->name('user.update_profile');
    });
});


/*########-Produk Strat Here-#######*/
// ORDER PRODUK AS USER STARTs HERE
  // memilih produk
  Route::get('/kenalkopi/recomendation',[HomeController::class,'index'])->name('kenalkopi.home');
  Route::get('/kenalkopi/produk',[KenalKopiController::class,'index'])->name('kenalkopi.produk');
  //memasukan ke cart
  Route::post('/add/cart', [KenalKopiController::class, 'insert'])->name('tambah_item');
  /*########-Produk Ends Here-#######*/


  /*########-Cart Start Here-#######*/
  // menampilkan, menambah, hapus, dan update cart
  // Route::get('/cart', [CartController::class, 'index'])->name('cart');
  Route::get('/kenalkopi/cart', [CartController::class, 'index'])->name('cart');
  Route::get('/kenalkopi/cart/remove/{rowId}', [CartController::class, 'remove'])->name('remove_item');
  Route::post('/kenalkopi/cart/update', [CartController::class, 'update'])->name('update_cart');
  // Checkout Cart, cart dilempar ke halaman checkout
  Route::get('/kenalkopi/cart/checkout', [CartController::class, 'checkout'])->name('checkout');
  // Isi nama sama meja di cart trus bayar
  Route::post('/kenalkopi/cart/payment', [CartController::class, 'payment'])->name('payment');
  /*########-Cart Ends Here-#######*/

  /*########-Invoice Starts Here-#######*/
  //halmaan sudah memesan, pesanan masuk ke list order
  Route::get('/kenalkopi/invoice', [InvoiceController::class, 'index'])->name('invoice');
  // list order dari invoice
  Route::get('/kenalkopi/daftar_order/', [InvoiceController::class, 'daftar_order'])->name('daftar_order');
  // Detail dari pesanan
  Route::get('/kenalkopi/daftar_order/detail/{id}', [InvoiceController::class, 'detail_order'])->name('detail_order');
  // Rating
  Route::post('/kenalkopi/daftar_order/detail/rating/', [InvoiceController::class, 'rating'])->name('rating');
// notification for Payments gatewaay with midtrans
  Route::post('/kenalkopi/payments/notification', [ConfirmUserController::class, 'notification'])->name('notification');
  Route::get('/kenalkopi/payments/completed', [ConfirmUserController::class, 'completed'])->name('completed');
  Route::get('/kenalkopi/payments/unfinish', [ConfirmUserController::class, 'unfinish'])->name('unfinish');
  Route::get('/kenalkopi/payments/failed', [ConfirmUserController::class, 'failed'])->name('failed');

  // Route::post('invoice/detail/rating/status_rating/', [InvoiceController::class, 'Status_rating'])->name('Status');
  /*########-Invoice Ends Here-#######*/

  /*########-Konfirmasi starts Here-#######*/
  // Route::get('/confirm/{id}', [ConfirmUserController::class, 'index'])->name('user_confirm');
  // Route::get('/confirm/payment', [ConfirmUserController::class, 'payment_midtrans'])->name('payment_midtrans');

  // Route::post('/confirm/store', [ConfirmUserController::class, 'confirm_store'])->name('confirm_store');
  // ORDER PRODUK AS USER Ends HERE



      // Notif ORDER PRODUK AS USER Start HERE
      // Route::post('/payments/notification', [ConfirmUserController::class, 'notification'])->name('notification');
      // Route::get('/payments/completed', [ConfirmUserController::class, 'completed'])->name('completed');
      // Route::get('/payments/unfinish', [ConfirmUserController::class, 'unfinish'])->name('unfinish');
      // Route::get('/payments/failed', [ConfirmUserController::class, 'failed'])->name('failed');
      // ORDER PRODUK AS USER Ends HERE
//       Route::group(['middleware' => 'auth'], function () {
//         Route::group(['middleware' => 'user'], function () {
//
//   });
//
// });
