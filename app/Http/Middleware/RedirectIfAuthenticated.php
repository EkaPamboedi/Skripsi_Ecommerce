<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;

// use Auth;
// use App\Models\User;
// use App\Models\Kategori;
// use App\Models\Member;
// use App\Models\Pembelian;
// use App\Models\Pengeluaran;
// use App\Models\Penjualan;
// use App\Models\Produk;
// use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        // $kategori = Kategori::count();
        // $produk = Produk::count();
        // $supplier = Supplier::count();
        // $member = Member::count();
        //
        // $tanggal_awal = date('Y-m-01');
        // $tanggal_akhir = date('Y-m-d');
        //
        // $data_tanggal = array();
        // $data_pendapatan = array();
        //
        // while (strtotime($tanggal_awal) <= strtotime($tanggal_akhir)) {
        //     $data_tanggal[] = (int) substr($tanggal_awal, 8, 2);
        //
        //     $total_penjualan = Penjualan::where('created_at', 'LIKE', "%$tanggal_awal%")->sum('bayar');
        //     $total_pembelian = Pembelian::where('created_at', 'LIKE', "%$tanggal_awal%")->sum('bayar');
        //     $total_pengeluaran = Pengeluaran::where('created_at', 'LIKE', "%$tanggal_awal%")->sum('nominal');
        //
        //     $pendapatan = $total_penjualan - $total_pembelian - $total_pengeluaran;
        //     $data_pendapatan[] += $pendapatan;
        //     $tanggal_awal = date('Y-m-d', strtotime("+1 day", strtotime($tanggal_awal)));
        // }
        //

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return redirect('/daftar_produk');
                // , compact('kategori', 'produk', 'supplier', 'member', 'tanggal_awal', 'tanggal_akhir', 'data_tanggal', 'data_pendapatan'));
                // return redirect(RouteServiceProvider::KENALKOPI);
                // return view('admin.home.dashboard');



            }
        }
        return $next($request);
    }
}