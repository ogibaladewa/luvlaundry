<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $data_kategori = \App\Kategori::all();
        $data_user = \App\User::where('status', '=', 'Active')->get();
        $jumlahUser = count($data_user);
        $data_supplier = \App\Supplier::where('status', '=', 'Active')->get();
        $jumlahSupplier = count($data_supplier);
        $data_jumlahTransaksi = \App\JumlahTransaksi::whereMonth('periode', '=', 
        Carbon::now()->subMonth()->month)->get();
        $jumlahTransaksi = 0;
        foreach($data_jumlahTransaksi as $jt){
            $jumlahTransaksi = $jumlahTransaksi + $jt->jumlah;
        }
        
        $data_penggunaan = \App\Penggunaan::all();
        $data_penyediaanLalu = \App\Penyediaan::whereMonth('tanggal', '=', 
            Carbon::now()->subMonth()->month)->get();
        $jumlahPenyediaan = count($data_penyediaanLalu);
        $data_penggunaanLalu = \App\Penggunaan::whereMonth('tanggal', '=', 
            Carbon::now()->subMonth()->month)->get();

        // dd($data_penggunaanLalu);
        $kategori = [];
        $nilaiPenggunaan = [0,0,0];
        $penggunaan = [];
        foreach($data_penggunaan as $pg){
            if(!in_array($pg->barang->kategori->nama_kategori, $kategori)) {
                $kategori[] = $pg->barang->kategori->nama_kategori;
            }
        }

        //DATA UNTUK PENGGUNAAN BULAN LALU PER KATEGORI
        $id_barang = [];
        $nilaiKat = [];
        
        $data_penggunaanLK = \App\Penggunaan::whereMonth('tanggal', '=', 
        Carbon::now()->subMonth()->month)->get();
        

        // dd($data_penggunaanLK);
        for($i=0;$i<count($data_kategori);$i++){
            $simpanQTY = 0;
            $kumulatif = 0;
            if(count($data_penggunaanLK) != 0){
                for($j=0;$j<count($data_penggunaanLK);$j++){
                    if($data_penggunaanLK[$j]->barang['kategori_id'] == $data_kategori[$i]->id){
                        $simpanQTY = $data_penggunaanLK[$j]->terpakai;
                        $kumulatif = $kumulatif+$simpanQTY;
                        $nilaiKat[$i] = $kumulatif;   
                    }
                    else {
                        $simpanQTY = 0;
                        $kumulatif = $kumulatif+$simpanQTY;
                        $nilaiKat[$i] = $kumulatif;   
                    }
                }
            }
            else {
                $simpanQTY = 0;
                $kumulatif = $kumulatif+$simpanQTY;
                $nilaiKat[$i] = $kumulatif;
            }
        }

        $nilaiPenggunaanKat = array();
        for($i=0;$i<count($data_kategori);$i++){
            $nilaiPenggunaanKat[$i] = $nilaiKat[$i];
            $namaKat[$i] = $data_kategori[$i]->nama_kategori;
        }

        // dd($nilaiKat);
        // dd($nilaiPenggunaanKat);

        return view('dashboards.index',['kategori' => $kategori, 'nilaiPenggunaan' => $nilaiPenggunaan, 'jumlahUser' => $jumlahUser, 'jumlahSupplier' => $jumlahSupplier, 'jumlahTransaksi' => $jumlahTransaksi, 'jumlahPenyediaan' => $jumlahPenyediaan, 'nilaiPenggunaanKat' => $nilaiPenggunaanKat, 'namaKat' => $namaKat]);
    }
}
