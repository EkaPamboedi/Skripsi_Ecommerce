
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



// Route::get('/kenalkopi',function(){
Auth::routes();
//   return view('auth.qr-login');
// })->name('qr_login');

// Route::get('/', function () {
//     return view('welcome');
// })->name('welcome');


// Route::group(['middleware' => 'auth'], function () {
// });

Route::get('/welcome', [App\Http\Controllers\Auth\LoginController::class, 'index'])->name('welcome');
Route::get('/kenalkopi/login', [App\Http\Controllers\Auth\LoginController::class, 'qrCodeLogin'])->name('kenalkopi.index');
Route::post('/kenalkopi/qrlogin', [App\Http\Controllers\Auth\LoginController::class, 'attemptQrLogin'])->name('qrlogin');
// Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'attemptQrLogin'])->name('login');
// Route::get('/welcome', [App\Http\Controllers\Auth\LoginController::class, 'index'])->name('welcome');
// Route::get('/qr_login', [App\Http\Controllers\Auth\LoginController::class, 'qrCodeLogin'])->name('qr_login');
// Route::post('/qrlogin', [App\Http\Controllers\Auth\LoginController::class, 'attemptQrLogin'])->name('qrlogin');


Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'attemptLogin'])->name('login');
Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
// Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'attemptLogin'])->name('login');
// Auth::routes();


Route::group(['middleware' => 'auth'], function () {
  Route::group(['middleware' => 'admin'], function () {

      // Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'attemptLogin'])->name('login');
// Route::get('/home', 'HomeController@index')->name('home');

// Auth::routes();
      Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
// BAGIAN KATEGORI
      Route::get('/kategori/data', [KategoriController::class, 'data'])->name('kategori.data');
      Route::resource('/kategori', KategoriController::class);

// BAGIAN PRODUK di ADMIN
      Route::get('/produk/data', [ProdukController::class, 'data'])->name('produk.data');
      Route::post('/produk/delete-selected', [ProdukController::class, 'deleteSelected'])->name('produk.delete_selected');
      Route::get('/produk/aktif/{produk_id}', [ProdukController::class, 'aktif'])->name('produk_aktif');
      Route::get('/produk/nonaktif/{produk_id}', [ProdukController::class, 'nonaktif'])->name('produk_nonaktif');
      Route::post('/produk/cetak-barcode', [ProdukController::class, 'cetakBarcode'])->name('produk.cetak_barcode');
      Route::resource('/produk', ProdukController::class);

      //  CETAK MEMBER
      Route::get('/member/data', [MemberController::class, 'data'])->name('member.data');
      Route::post('/member/cetak-member', [MemberController::class, 'cetakMember'])->name('member.cetak_member');
      Route::resource('/member', MemberController::class);

      // DATA SUPPLIER
      Route::get('/supplier/data', [SupplierController::class, 'data'])->name('supplier.data');
      Route::resource('/supplier', SupplierController::class);


      // (LIST) ORDER DARI USER KE ADMIN
      Route::get('/orders/data', [OrderController::class, 'data'])->name('order.data');
      Route::get('/orders/detail/{id}', [OrderController::class, 'show'])->name('Admin.Orders');
      Route::resource('/order', OrderController::class)->except('create', 'edit');


      //
      //KONFIRMASI PEMBAYARAN DARI LIST ORDER
      Route::get('/confirmAdmin/detail/{id}',[ConfirmAdminController::class, 'detail'])->name('confirmAdmin.detail');
      Route::get('/confirmAdmin/terima/{id_order}',[ConfirmAdminController::class, 'terima'])->name('confirmAdmin.terima');
      Route::get('/confirmAdmin/tolak/{id_order}',[ConfirmAdminController::class, 'tolak'])->name('confirmAdmin.tolak');
      Route::get('/confirms_order',[ConfirmAdminController::class, 'index'])->name('confirmAdmin');

      // Daftar dan Belanja PENGELUARAN
      Route::get('/pengeluaran/data', [PengeluaranController::class, 'data'])->name('pengeluaran.data');
      Route::resource('/pengeluaran', PengeluaranController::class);

      // Daftar dan Belanja Bahan
      Route::get('/pembelian/data', [PembelianController::class, 'data'])->name('pembelian.data');
      Route::get('/pembelian/{id}/create', [PembelianController::class, 'create'])->name('pembelian.create');
      Route::resource('/pembelian', PembelianController::class)
          ->except('create');

      Route::get('/pembelian_detail/{id}/data', [PembelianDetailController::class, 'data'])->name('pembelian_detail.data');
      Route::get('/pembelian_detail/loadform/{diskon}/{total}', [PembelianDetailController::class, 'loadForm'])->name('pembelian_detail.load_form');
      Route::resource('/pembelian_detail', PembelianDetailController::class)
          ->except('create', 'show', 'edit');

      // Daftar  PENJUALAN
      // Dafrat Order Manual
      // ini root nya
      Route::get('/penjualan', [PenjualanController::class, 'index'])->name('penjualan.index');
      // ini datanya
      Route::get('/penjualan/data', [PenjualanController::class, 'data'])->name('penjualan.data');
      // melihat detail
      Route::get('/penjualan/{id}', [PenjualanController::class, 'show'])->name('penjualan.show');
      Route::delete('/penjualan/{id}', [PenjualanController::class, 'destroy'])->name('penjualan.destroy');
  // });

  // Route::group(['middleware' => 'level:1,2'], function () {
      // TRANSAKSI Baru untuk PENJUALAN
      Route::get('/transaksi/baru', [PenjualanController::class, 'create'])->name('transaksi.baru');
      Route::post('/transaksi/simpan', [PenjualanController::class, 'store'])->name('transaksi.simpan');
      Route::get('/transaksi/selesai', [PenjualanController::class, 'selesai'])->name('transaksi.selesai');
      Route::get('/transaksi/nota-kecil', [PenjualanController::class, 'notaKecil'])->name('transaksi.nota_kecil');
      Route::get('/transaksi/nota-besar', [PenjualanController::class, 'notaBesar'])->name('transaksi.nota_besar');

      // Route buat kasir tapi nge load transaksi terakhir dan harus ada memeber
      // Mengedit transaksi sebelumnya

      // Load diskon, karna perhitungan diskon nya per Order. bukan peritem
      Route::get('/transaksi/{id}/data', [PenjualanDetailController::class, 'data'])->name('transaksi.data');
      Route::get('/transaksi/loadform/{diskon}/{total}/{diterima}', [PenjualanDetailController::class, 'loadForm'])->name('transaksi.load_form');
      // Ini transaksi.index buat route daftar Order Manual
      Route::resource('/transaksi', PenjualanDetailController::class)
          ->except('create', 'show', 'edit');
  // });

  // Route::group(['middleware' => 'level:1'], function () {
      Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
      Route::get('/laporan/data/{awal}/{akhir}', [LaporanController::class, 'data'])->name('laporan.data');
      Route::get('/laporan/pdf/{awal}/{akhir}', [LaporanController::class, 'exportPDF'])->name('laporan.export_pdf');

      Route::get('/user/data', [UserController::class, 'data'])->name('user.data');
      Route::resource('/user', UserController::class);

      Route::get('/meja/store', [MejaController::class, 'store'])->name('tables.store');
      // Route::get('qrcode/{id}', [MejaController::class, 'generate'])->name('tables.generate');
      Route::resource('/meja', MejaController::class);

      Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
      Route::get('/setting/first', [SettingController::class, 'show'])->name('setting.show');
      Route::post('/setting', [SettingController::class, 'update'])->name('setting.update');
  // });

  // Route::group(['middleware' => 'level:1,2'], function () {
      // Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
      Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
      Route::get('/print/Qr/{id}', [UserController::class, 'printQR'])->name('print.Qr');
      Route::post('/profile/update', [UserController::class, 'updateProfile'])->name('user.update_profile');
      // Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
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
      Route::group(['middleware' => 'auth'], function () {
        Route::group(['middleware' => 'user'], function () {

  });

});
