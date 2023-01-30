<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('home');
});

Route::get('/login', 'AuthController@login')->name('login');
Route::post('/postlogin', 'AuthController@postlogin');
Route::get('/logout', 'AuthController@logout');



Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', 'DashboardController@index');
    Route::get('/user/{id}/data_diri', 'UserController@dataDiri');
    Route::get('/user/{id}/ubah_password', 'UserController@ubahPassword');
    Route::put('/user/{id}/update_password', 'UserController@updatePassword');
});


Route::group(['middleware' => ['auth', 'checkRole:admin']],function(){
    Route::get('/user', 'UserController@index');
    Route::post('/user/create', 'UserController@create');
    Route::get('/user/{id}/edit', 'UserController@edit');
    Route::post('/user/{id}/update', 'UserController@update');
    Route::get('/user/{id}/delete', 'UserController@delete');
    Route::get('/user/{id}/profile', 'UserController@profile');
    Route::get('/user/exportPDF', 'UserController@exportPDF');
    Route::get('/supplier', 'SupplierController@index');
    Route::post('/supplier/create', 'SupplierController@create');
    Route::get('/supplier/{id}/edit', 'SupplierController@edit');
    Route::post('/supplier/{id}/update', 'SupplierController@update');
    Route::get('/supplier/{id}/delete', 'SupplierController@delete');
    Route::get('/supplier/{id}/barangSupplier', 'SupplierController@barangSupplier');
    Route::post('/supplier/addBarang', 'SupplierController@addBarang');
    Route::get('/supplier/{barang_id}/{supplier_id}/deleteBarang', 'SupplierController@deleteBarang');
    Route::get('/supplier/exportPDF', 'SupplierController@exportPDF');
    Route::get('/cabang', 'CabangController@index');
    Route::post('/cabang/create', 'CabangController@create');
    Route::get('/cabang/{id}/edit', 'CabangController@edit');
    Route::post('/cabang/{id}/update', 'CabangController@update');
    Route::get('/cabang/{id}/delete', 'CabangController@delete');
    Route::get('/cabang/exportPDF', 'CabangController@exportPDF');
    Route::get('/kategori', 'KategoriController@index');
    Route::post('/kategori/create', 'KategoriController@create');
    Route::get('/kategori/{id}/edit', 'KategoriController@edit');
    Route::post('/kategori/{id}/update', 'KategoriController@update');
    Route::get('/kategori/{id}/delete', 'KategoriController@delete');
    Route::get('/kategori/exportPDF', 'KategoriController@exportPDF');
    Route::get('/barang', 'BarangController@index');
    Route::post('/barang/create', 'BarangController@create');
    Route::get('/barang/{id}/edit', 'BarangController@edit');
    Route::post('/barang/{id}/update', 'BarangController@update');
    Route::get('/barang/{id}/delete', 'BarangController@delete');
    Route::get('/barang/{id}/detail', 'BarangController@detail');
    Route::get('/barang/laporanHarga', 'BarangController@laporanHarga');
    Route::get('/barang/laporanStock', 'BarangController@laporanStock');
    Route::get('/barang/exportPDF', 'BarangController@exportPDF');
    
}); 

Route::group(['middleware' => ['auth', 'checkRole:pegawai']],function(){
    
    Route::get('/jumlahTransaksi', 'JumlahTransaksiController@index');
    Route::post('/jumlahTransaksi/create', 'JumlahTransaksiController@create');
    Route::get('/jumlahTransaksi/{id}/edit', 'JumlahTransaksiController@edit');
    Route::post('/jumlahTransaksi/{id}/update', 'JumlahTransaksiController@update');
    Route::get('/jumlahTransaksi/{id}/delete', 'JumlahTransaksiController@delete');
    Route::get('/jumlahTransaksi/exportPDF', 'JumlahTransaksiController@exportPDF');
    Route::get('/penyediaan', 'PenyediaanController@index');
    Route::post('/penyediaan/create', 'PenyediaanController@create');
    Route::get('/penyediaan/add', 'PenyediaanController@add');
    Route::post('/penyediaan/addPenyediaan', 'PenyediaanController@addPenyediaan');
    Route::get('/penyediaan/{id}/edit', 'PenyediaanController@edit');
    Route::post('/penyediaan/{id}/update', 'PenyediaanController@update');
    Route::get('/penyediaan/{id}/delete', 'PenyediaanController@delete');
    Route::get('/penyediaan/{id}/detail', 'PenyediaanController@detail');
    Route::get('/penyediaan/{barang_id}/{penyediaan_id}/deleteBarang', 'PenyediaanController@deleteBarang');
    Route::get('/penyediaan/exportPDF', 'PenyediaanController@exportPDF');
    Route::get('/penggunaan', 'PenggunaanController@index');
    Route::post('/penggunaan/create', 'PenggunaanController@create');
    Route::get('/penggunaan/add', 'PenggunaanController@add');
    Route::get('/penggunaan/{id}/edit', 'PenggunaanController@edit');
    Route::post('/penggunaan/{id}/update', 'PenggunaanController@update');
    Route::get('/penggunaan/{id}/delete', 'PenggunaanController@delete');
    Route::get('/penggunaan/exportPDF', 'PenggunaanController@exportPDF');
    Route::get('/barang/stock', 'BarangController@stock');
}); 

Route::group(['middleware' => ['auth', 'checkRole:owner']],function(){
    
    Route::get('/jumlahTransaksi/laporan', 'JumlahTransaksiController@laporan');
    Route::get('/penyediaan/laporan', 'PenyediaanController@laporan');
    Route::get('/penyediaan/laporan/penyediaan1', 'PenyediaanController@laporan1');
    Route::get('/penyediaan/laporan/penyediaan2', 'PenyediaanController@laporan2');
    Route::get('/penyediaan/laporan/penyediaan3', 'PenyediaanController@laporan3');
    Route::get('/penggunaan/laporan', 'PenggunaanController@laporan');
    Route::get('/penggunaan/laporan/penggunaan1', 'PenggunaanController@laporan1');
    Route::get('/penggunaan/laporan/penggunaan2', 'PenggunaanController@laporan2');
    Route::get('/penggunaan/laporan/penggunaan3', 'PenggunaanController@laporan3');
    Route::get('/barang/laporanHarga', 'BarangController@laporanHarga');
    Route::get('/barang/laporanStock', 'BarangController@laporanStock');
    Route::get('/barang/laporanHarga/exportPDF', 'BarangController@exportLaporanHargaPDF');
    Route::get('/jumlahTransaksi/exportJumlahExcel', 'JumlahTransaksiController@exportJumlahExcel');
}); 

Route::get('getdatauser', [
        'uses' => 'UserController@getdatauser',
        'as' => 'ajax.get.data.user',
]);

Route::get('getdatasupplier', [
    'uses' => 'SupplierController@getdatasupplier',
    'as' => 'ajax.get.data.supplier',
]);

Route::get('getdatacabang', [
    'uses' => 'CabangController@getdatacabang',
    'as' => 'ajax.get.data.cabang',
]);

Route::get('getdatakategori', [
    'uses' => 'KategoriController@getdatakategori',
    'as' => 'ajax.get.data.kategori',
]);

Route::get('getdatabarang', [
    'uses' => 'BarangController@getdatabarang',
    'as' => 'ajax.get.data.barang',
]);

Route::get('getdatastock', [
    'uses' => 'BarangController@getdatastock',
    'as' => 'ajax.get.data.stock',
]);

Route::get('getdatalaporanstock', [
    'uses' => 'BarangController@getdatalaporanstock',
    'as' => 'ajax.get.data.laporanstock',
]);

Route::get('getdatajumlahtransaksi', [
    'uses' => 'JumlahTransaksiController@getdatajumlahtransaksi',
    'as' => 'ajax.get.data.jumlahtransaksi',
]);

Route::get('getdatapenyediaan', [
    'uses' => 'PenyediaanController@getdatapenyediaan',
    'as' => 'ajax.get.data.penyediaan',
]);

Route::get('getdatapenggunaan', [
    'uses' => 'PenggunaanController@getdatapenggunaan',
    'as' => 'ajax.get.data.penggunaan',
]);