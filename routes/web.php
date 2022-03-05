<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });

// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/export_excel', 'Admin\Export\ExportExcelController@index');


Route::get('login',['as' => 'login', 'uses' => 'Auth\LoginController@showLoginForm']);
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout');

Route::group(['prefix'=>'/', 'middleware'=>'auth', 'namespace'=>'Admin'], function() {
    Route::pattern('id', '[0-9]+');
    Route::pattern('userId', '[0-9]+');

    Route::get('/', 'DashboardController@index');
    Route::get('/home', 'DashboardController@index');

    Route::get('cekhakakses/{hakAkses}', 'SearchController@cekHakAkses');
    Route::get('findbarang/{kolom}/{keyword}', 'SearchController@findBarang');
    Route::get('get_select_member', 'SearchController@getSelectMember');
    Route::get('get_select_suplier', 'SearchController@get_select_suplier');
    Route::get('get_select_barang', 'SearchController@getSelectBarang');
    Route::get('getinfomember/{id}', 'SearchController@getInfoMember');
    Route::get('getcountdashboard', 'SearchController@getcountdashboard');
    Route::get('menguntungkan', 'SearchController@menguntungkan');
    Route::get('daftarhabis', 'SearchController@daftarhabis');

    // Grup dan user
    Route::resource('grup', 'GrupController', ['except' => ['show', 'create']]);
    Route::get('grups', 'GrupController@grups');

    Route::resource('user', 'UserController',['except' => ['show', 'create']]);
    Route::get('users', 'UserController@users');
    Route::post('change_password', 'UserController@changePassword');
    Route::get('get_select_group', 'UserController@getSelectGroup');

    // Jenis Barang 
    Route::resource('jenis', 'JenisController',['except' => ['show', 'create']]);
    Route::get('jenises', 'JenisController@jenises');
    // Jenis Barang - end

    // Barang 
    Route::resource('barang', 'BarangController',['except' => ['create']]);
    Route::get('barangs', 'BarangController@barangs');
    Route::get('barangautokode', 'BarangController@getAutoKode');
    // Barang - end

    //Stok Opname
    Route::resource('opname', 'OpnameController',['except' => ['create', 'show', 'edit', 'update', 'destroy']]);
    // Stok Opname - end

    // Member
    Route::resource('member', 'MemberController',['except' => ['create', 'show']]);
    Route::get('members', 'MemberController@members');
    Route::get('memberautokode', 'MemberController@getAutoCode');
    // Member - end

	// Suplier
    Route::resource('suplier', 'SuplierController',['except' => ['create', 'show']]);
    Route::get('supliers', 'SuplierController@supliers');
    Route::get('suplierautokode', 'SuplierController@getAutoCode');
    // Suplier - end
	
    // /Pembelian Barang
    Route::resource('pembelian', 'PembelianController');
    Route::get('barangpembelian', 'PembelianController@barangpembelian');
    Route::get('pembelians', 'PembelianController@pembelians');
    Route::get('getpembelianautocode', 'PembelianController@getpembelianautocode');
    Route::get('getdetailbeli', 'PembelianController@getdetailbeli');
    Route::post('siapkankoreksipembelian', 'PembelianController@siapkanKoreksi');
    // Pembelian Barang end

    // Tabel Semetara
    Route::get('getsementara', 'SementaraController@getSementara');
    Route::get('getsementarajual', 'SementaraController@getSementarajual');
    Route::post('sementara', 'SementaraController@store');
    Route::get('sementara/{id}/edit', 'SementaraController@edit');
    Route::put('sementara/{id}', 'SementaraController@update');
    Route::delete('sementara/{id}', 'SementaraController@destroy');
    Route::post('sementarajual', 'SementaraController@storeJual');
    // Tabel Semetara end

    // /Penjualan Barang
    Route::resource('penjualan', 'PenjualanController');
    Route::get('barangpenjualan', 'PenjualanController@barangpenjualan');
    Route::get('penjualans', 'PenjualanController@penjualans');
    Route::get('getpenjualanautocode', 'PenjualanController@getpenjualanautocode');
    Route::get('getdetailjual', 'PenjualanController@getdetailjual');
    Route::post('siapkankoreksipenjualan', 'PenjualanController@siapkanKoreksi');

    Route::get('findbarangbykodekoreksi/{kodebarang}/{kodetransaksi}', 'PenjualanController@findBarangByKode');
    Route::get('barangpenjualankoreksi', 'PenjualanController@barangpenjualankoreksi');
    Route::get('barangfindkoreksi/{kodebarang}/{kodetransaksi}', 'PenjualanController@barangfindkoreksi');
    Route::post('sementarajualkoreksi', 'SementaraController@storeJualKoreksi');
    Route::get('sementarakoreksi/{id}/edit', 'SementaraController@editkoreksi');
    Route::put('sementaraupdatekoreksi/{id}', 'SementaraController@sementaraupdatekoreksi');
    Route::get('strukjual/{kode}', 'PenjualanController@strukjual');
    // Penjualan Barang end

    Route::get('cobastruk', 'CobaController@cobaStruk');
    Route::post('cetak', 'PenjualanController@strukjual_list');
    Route::post('cetak2', 'PenjualanController@strukjual_list2');
    Route::get('strukcetak/{kode}', 'PenjualanController@strukcetak');


    // Laporan
    Route::group(['prefix'=>'laporan','namespace'=>'Laporan'], function() {
        // Laporan barang
        Route::get('barang', 'LaporanBarangController@index');
        Route::get('barangs', 'LaporanBarangController@barangs');
        Route::post('barang', 'LaporanBarangController@preview');

        // Laporan opname
        Route::get('opname', 'LaporanOpnameController@index');
        Route::get('opnames', 'LaporanOpnameController@opnames');
        Route::post('opname', 'LaporanOpnameController@preview');

        // Laporan History
        Route::get('history', 'LaporanHistoryController@index');
        Route::get('histories', 'LaporanHistoryController@histories');
        Route::post('history', 'LaporanHistoryController@preview');
        
        // Laporan Stok hilang
        Route::get('hilang', 'LaporanHilangController@index');
        Route::get('hilangs', 'LaporanHilangController@hilangs');
        Route::post('hilang', 'LaporanHilangController@preview');

        // Laporan member
        Route::get('member', 'LaporanMemberController@index');
        Route::get('members', 'LaporanMemberController@members');
        Route::post('member', 'LaporanMemberController@preview');

        // Laporan Pembelian
        Route::get('pembelian', 'LaporanPembelianController@index');
        Route::get('pembelians', 'LaporanPembelianController@pembelians');
        Route::post('pembelian', 'LaporanPembelianController@preview');

        // Laporan Penjualan
        Route::get('penjualan', 'LaporanPenjualanController@index');
        Route::get('penjualans', 'LaporanPenjualanController@penjualans');
        Route::post('penjualan', 'LaporanPenjualanController@preview');

        // keuangan rekap
        Route::get('laba', 'RekapLabaController@index');
        Route::post('laba', 'RekapLabaController@preview');
        Route::get('getrekaplaba', 'RekapLabaController@getRekapLaba');
		
		// konsinyasi rekap
        Route::get('konsinyasi', 'RekapKonsinyasiController@index');
        Route::post('konsinyasi', 'RekapKonsinyasiController@cetak_data');
        Route::get('konsinyasis', 'RekapKonsinyasiController@konsinyasis');
        Route::get('rekapkonsinyasi/{id_suplier}', 'RekapKonsinyasiController@rekapkonsinyasi');
        Route::get('getrekapkonsinyasi', 'RekapKonsinyasiController@getrekapkonsinyasi');
        Route::post('cetakrekapkonsinyasi/cetak', 'RekapKonsinyasiController@cetakrekapkonsinyasi');
        Route::post('cetakrekapkonsinyasi_suplier/cetak', 'RekapKonsinyasiController@cetakrekapkonsinyasiForSuplier');
    });
});

Route::get('/{ggg}', function() {
    return view('error.404');
});