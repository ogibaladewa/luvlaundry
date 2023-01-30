<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use PDF;

class PenggunaanController extends Controller
{
    public function index(Request $request)
    {
        $data_penggunaan = \App\Penggunaan::all();
        $data_barang = \App\Barang::all();
        return view('penggunaan.index',['data_penggunaan' => $data_penggunaan, 'data_barang' => $data_barang]);
    }

    public function create(Request $request)
    {
        $this->validate($request,[
            'tanggal' => 'required',
            'barang_id' => 'required',
            'user_id' => 'required',
            'cabang_id' => 'required',
            'terpakai' => 'required',
        ]);

        \App\Penggunaan::create($request -> all());

        $barang = \App\BarangCabang::where([['barang_id','=', $request->barang_id],['cabang_id','=', $request->cabang_id]])->first();
                $stock = $barang->stock - $request->terpakai;    
                $barang->where([['barang_id','=', $request->barang_id],['cabang_id','=', $request->cabang_id]])
                ->update(array('stock' => $stock));
                
        return redirect('/penggunaan')->with('sukses','Data Berhasil Ditambahkan !');  
    }

    public function edit($id)
    {
        $penggunaan = \App\Penggunaan::find($id);
        return view('penggunaan/edit',['penggunaan' => $penggunaan]);
    }

    public function update(Request $request,$id)
    {
        $penggunaan = \App\Penggunaan::find($id);
        $penggunaan->update($request -> all());
        return redirect('/penggunaan')->with('editsukses','Data Berhasil Diupdate !');  
    }

    public function delete($id)
    {
        $penggunaan = \App\Penggunaan::where('id','=',$id)->first();
        $barang = \App\BarangCabang::where([['barang_id','=',$penggunaan->barang_id],['cabang_id','=',$penggunaan->cabang_id]])->first();
        $stock = $barang->stock + $penggunaan->terpakai; 
        $barang->where([['barang_id','=',$penggunaan->barang_id],['cabang_id','=',$penggunaan->cabang_id]])
                ->update(array('stock' => $stock));  
        // dd($stock);
        $penggunaan = \App\Penggunaan::find($id);
        $penggunaan->delete();
        return redirect('/penggunaan')->with('hapus','Data Berhasil Dihapus !'); 
    }

    public function getdatapenggunaan()
    {
        $penggunaan = \App\Penggunaan::select('penggunaan.*');

        return \DataTables::eloquent($penggunaan)
        ->addColumn('user',function($p){
            return $p->user->name;
        })
        
        ->addColumn('cabang',function($p){
            return $p->cabang->nama_cabang;
        })

        ->addColumn('barang',function($p){
            return $p->barang->nama_barang;
        })

        ->addColumn('satuan',function($p){
            return $p->barang->satuan;
        })

        ->addColumn('tanggalO',function($p){
            return date('d-m-Y',strtotime($p->tanggal));
        })
        
        ->addColumn('aksi',function($p){
            return '
            
            <a href="/penggunaan/'.$p->id.'/delete" class="btn btn-danger btn-sm" onclick="return confirm(\'Yakin Hapus Data?\')"><i class="lnr lnr-trash"></i></a>';
        })
        ->rawColumns(['kategori','aksi','tanggalO'])
        ->addIndexColumn()
        ->toJson();
    }

    public function laporan1(Request $request)
    {
        $data_cabang = \App\Cabang::all();
        $data_supplier = \App\Supplier::all();
        $data_kategori = \App\Kategori::all();
        $data_barang = \App\Barang::all();
        $data_tahun=[];
        $tahun_id = date("Y");
        $digit = 10;
        for ($i=0;$i<30;$i++){
            $data_tahun[$i] = '20'.$digit;
            $digit++;
        }
        
        if($request->has('tahun')){
            $tahun_id = $request['tahun'];
        }


        $cabang_id = '';
        $kategori = [];
        $penggunaanPerBulan = [];
        $jumlahPerCabang = [];

        $data_barangPenggunaanLK = [];
        
        $id_barang = [];

        $nilaiKatBT = [];

        if($request->has('cabang')){
            if($request->cabang == 'semua'){
                for($i=0;$i<12;$i++){
                    $data_penggunaanLKBT[$i] = \App\Penggunaan::whereMonth('tanggal', '=', $i+1)->whereYear('tanggal', '=', $tahun_id)->get();
                }
                $namaCabangSort = 'semua';
            }
            else{
                for($i=0;$i<12;$i++){
                    $data_penggunaanLKBT[$i] = \App\Penggunaan::whereMonth('tanggal', '=', $i+1)->whereYear('tanggal', '=', $tahun_id)->where('cabang_id', '=', $request['cabang'])->get();
                }
                $cabang_id = $request->cabang;
                $data_namaCabangSort = \App\Cabang::where('id','=',$request->cabang)->first();
                $namaCabangSort = $data_namaCabangSort->nama_cabang;
            }
        }
        else{
            for($i=0;$i<12;$i++){
                $data_penggunaanLKBT[$i] = \App\Penggunaan::whereMonth('tanggal', '=', $i+1)->whereYear('tanggal', '=', $tahun_id)->get();
            }
            $namaCabangSort = 'semua';
        }

        if($request->has('kategori')){
            if($request->kategori == 'semua'){
                
            }
            else{
                $data_barangKat = \App\Barang::where('kategori_id', '=', $request['kategori'])->get();
                $kategori_id = $request['kategori'];
                $data_KategoriSort = \App\Kategori::where('id','=',$kategori_id)->first();
                $namaKategoriSort = $data_namaKategoriSort->nama_kategori;
            }
        }
        else{
            $data_barangKat = \App\Barang::where('kategori_id', '=', '2')->get();
            $kategori_id = '2';
            $data_KategoriSort = \App\Kategori::where('id','=',$kategori_id)->first();
            $namaKategoriSort = $data_KategoriSort->nama_kategori;
        }
       
        // dd($data_penggunaanLKBT);
        for($h=0;$h<12;$h++){
            for($i=0;$i<count($data_barangKat);$i++){
                $simpanQTYBT = 0;
                $kumulatifBT = 0;
                if(count($data_penggunaanLKBT[$h]) != 0){
                    for($j=0;$j<count($data_penggunaanLKBT[$h]);$j++){
                        
                        if($data_penggunaanLKBT[$h][$j]->barang['id'] == $data_barangKat[$i]->id){
                            $simpanQTYBT = $data_penggunaanLKBT[$h][$j]->terpakai;
                            $kumulatifBT = $kumulatifBT+$simpanQTYBT;
                            $nilaiKatBT[$i][$h] = $kumulatifBT;   
                        }
                        else {
                            $simpanQTYBT = 0;
                            $kumulatifBT = $kumulatifBT+$simpanQTYBT;
                            $nilaiKatBT[$i][$h] = $kumulatifBT;   
                        }

                    }
                    
                }
                else {
                    $simpanQTYBT = 0;
                    $kumulatifBT = 0;
                    $kumulatifBT = $kumulatifBT+$simpanQTYBT;
                    $nilaiKatBT[$i][$h] = $kumulatifBT;
                }
            }
        }

        $nilaiPenggunaanKatBT = array();
        for($h=0;$h<12;$h++){
            for($i=0;$i<count($data_barangKat);$i++){
                $nilaiPenggunaanKatBT[$i] = array(
                    'nama_barang' => $data_barangKat[$i]->nama_barang,
                    'nilai' => [$nilaiKatBT[$i][0],$nilaiKatBT[$i][1],$nilaiKatBT[$i][2],$nilaiKatBT[$i][3],
                    $nilaiKatBT[$i][4],$nilaiKatBT[$i][5],$nilaiKatBT[$i][6],$nilaiKatBT[$i][7],
                    $nilaiKatBT[$i][8],$nilaiKatBT[$i][9],$nilaiKatBT[$i][10],$nilaiKatBT[$i][11],],
                );
            }
        }

        
        // dd($nilaiKatBT);
        // dd($nilaiPenggunaanKatBT);

        return view('penggunaan.laporan.laporan1',['kategori_id' => $kategori_id, 'namaCabangSort' => $namaCabangSort, 'namaKategoriSort' => $namaKategoriSort, 'kategori' => $kategori, 'data_kategori' => $data_kategori, 'cabang_id' => $cabang_id, 'data_cabang' => $data_cabang, 'nilaiPenggunaanKatBT' => $nilaiPenggunaanKatBT, 'data_tahun' => $data_tahun, 'tahun_id' => $tahun_id]);
    }

    public function laporan2(Request $request)
    {
        $data_cabang = \App\Cabang::all();
        $data_supplier = \App\Supplier::all();
        $data_kategori = \App\Kategori::all();
        $data_barang = \App\Barang::all();
        $data_tahun=[];
        $tahun_id = date("Y");
        $digit = 10;
        for ($i=0;$i<30;$i++){
            $data_tahun[$i] = '20'.$digit;
            $digit++;
        }
        
        if($request->has('tahun')){
            $tahun_id = $request['tahun'];
        }


        $cabang_id = '';
        $kategori = [];
        $penggunaanPerBulan = [];
        $jumlahPerCabang = [];

        $data_barangPenggunaanLK = [];
        
        $id_barang = [];

        $nilaiKatA = [];

        if($request->has('cabang')){
            if($request->cabang == 'semua'){
                for($i=0;$i<12;$i++){
                    $data_penggunaanLKA[$i] = \App\Penggunaan::whereMonth('tanggal', '=', $i+1)->whereYear('tanggal', '=', $tahun_id)->get();
                }
                $namaCabangSort = 'semua';
            }
            else{
                for($i=0;$i<12;$i++){
                    $data_penggunaanLKA[$i] = \App\Penggunaan::whereMonth('tanggal', '=', $i+1)->whereYear('tanggal', '=', $tahun_id)->where('cabang_id', '=', $request['cabang'])->get();
                }
                $cabang_id = $request->cabang;
                $data_namaCabangSort = \App\Cabang::where('id','=',$request->cabang)->first();
                $namaCabangSort = $data_namaCabangSort->nama_cabang;
            }
        }
        else{
            for($i=0;$i<12;$i++){
                $data_penggunaanLKA[$i] = \App\Penggunaan::whereMonth('tanggal', '=', $i+1)->whereYear('tanggal', '=', $tahun_id)->get();
            }
            $namaCabangSort = 'semua';
        }

        // dd($data_penggunaanLKA);
        for($h=0;$h<12;$h++){
            for($i=0;$i<count($data_kategori);$i++){
                $simpanQTYA = 0;
                $kumulatifA = 0;
                if(count($data_penggunaanLKA[$h]) != 0){
                    for($j=0;$j<count($data_penggunaanLKA[$h]);$j++){
                        
                        if($data_penggunaanLKA[$h][$j]->barang['kategori_id'] == $data_kategori[$i]->id){
                            $simpanQTYA = $data_penggunaanLKA[$h][$j]->terpakai;
                            $kumulatifA = $kumulatifA+$simpanQTYA;
                            $nilaiKatA[$i][$h] = $kumulatifA;   
                        }
                        else {
                            $simpanQTYA = 0;
                            $kumulatifA = $kumulatifA+$simpanQTYA;
                            $nilaiKatA[$i][$h] = $kumulatifA;   
                        }

                    }
                    
                }
                else {
                    $simpanQTYA = 0;
                    $kumulatifA = 0;
                    $kumulatifA = $kumulatifA+$simpanQTYA;
                    $nilaiKatA[$i][$h] = $kumulatifA;
                }
            }
        }

        $nilaiPenggunaanKatA = array();
        for($h=0;$h<12;$h++){
            for($i=0;$i<count($data_kategori);$i++){
                $nilaiPenggunaanKatA[$i] = array(
                    'nama_kategori' => $data_kategori[$i]->nama_kategori,
                    'nilai' => [$nilaiKatA[$i][0],$nilaiKatA[$i][1],$nilaiKatA[$i][2],$nilaiKatA[$i][3],
                    $nilaiKatA[$i][4],$nilaiKatA[$i][5],$nilaiKatA[$i][6],$nilaiKatA[$i][7],
                    $nilaiKatA[$i][8],$nilaiKatA[$i][9],$nilaiKatA[$i][10],$nilaiKatA[$i][11],],
                );
            }
        }

        
        // dd($nilaiKatA);
        // // dd($nilaiPenggunaanKatA);
        // // dd($namaKatA);

        return view('penggunaan.laporan.laporan2',['kategori' => $kategori, 'data_kategori' => $data_kategori, 'cabang_id' => $cabang_id, 'data_cabang' => $data_cabang, 'nilaiPenggunaanKatA' => $nilaiPenggunaanKatA, 'data_tahun' => $data_tahun, 'tahun_id' => $tahun_id, 'namaCabangSort' => $namaCabangSort]);
    }
    
    public function laporan3(Request $request)
    {
        $data_cabang = \App\Cabang::all();
        $data_supplier = \App\Supplier::all();
        $data_kategori = \App\Kategori::all();
        $data_barang = \App\Barang::all();
        $data_tahun=[];
        $tahun_id = date("Y");
        $digit = 10;
        for ($i=0;$i<30;$i++){
            $data_tahun[$i] = '20'.$digit;
            $digit++;
        }
        
        if($request->has('tahun')){
            $tahun_id = $request['tahun'];
        }

        $data_bulan = array();
                    
        $data_bulan = array(
            'nama_bulan' => ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],
            'id_bulan' => [1,2,3,4,5,6,7,8,9,10,11,12],
        );

        // $data_bulan=['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        $bulan_id = date("n")-1;

        if($request->has('bulan')){
            $bulan_id = $request['bulan'];
        }


        $cabang_id = '';
        $kategori = [];
        $penggunaanPerBulan = [];
        $jumlahPerCabang = [];

        $data_barangPenggunaanLK = [];
        
        $id_barang = [];

        if($request->has('cabang')){
            if($request->cabang == 'semua'){
                $data_penggunaanLKB = \App\Penggunaan::whereMonth('tanggal', '=', 
                $bulan_id)->whereYear('tanggal', '=', $tahun_id)->get();
                $namaCabangSort = 'semua';
            }
            else{
                $data_penggunaanLKB = \App\Penggunaan::whereMonth('tanggal', '=', 
                $bulan_id)->whereYear('tanggal', '=', $tahun_id)
                ->where('cabang_id', '=', $request['cabang'])->get();
                $cabang_id = $request->cabang;
                $data_namaCabangSort = \App\Cabang::where('id','=',$request->cabang)->first();
                $namaCabangSort = $data_namaCabangSort->nama_cabang;
            }
        }
        else{
            $data_penggunaanLKB = \App\Penggunaan::whereMonth('tanggal', '=', 
            $bulan_id)->whereYear('tanggal', '=', $tahun_id)->get();
            $namaCabangSort = 'semua';
        }

        // dd($data_penggunaanLKB);
        for($i=0;$i<count($data_barang);$i++){
            $simpanQTY = 0;
            $kumulatif = 0;
            if(count($data_penggunaanLKB) != 0){
                for($j=0;$j<count($data_penggunaanLKB);$j++){
                    if($data_penggunaanLKB[$j]->barang['id'] == $data_barang[$i]->id){
                        $simpanQTY = $data_penggunaanLKB[$j]->terpakai;
                        $kumulatif = $kumulatif+$simpanQTY;
                        $nilaiBarang[$i] = $kumulatif;   
                    }
                    else {
                        $simpanQTY = 0;
                        $kumulatif = $kumulatif+$simpanQTY;
                        $nilaiBarang[$i] = $kumulatif;   
                    }
                }
            }
            else {
                $simpanQTY = 0;
                $kumulatif = $kumulatif+$simpanQTY;
                $nilaiBarang[$i] = $kumulatif;
            }
        }

        $nilaiPenggunaanBarang = [];
        $namaBarang = [];
        $nilaiPenggunaanKatB = array();
        for($i=0;$i<count($data_barang);$i++){
            $nilaiPenggunaanBarang[$i] = $nilaiBarang[$i];
            $namaBarang[$i] = $data_barang[$i]->nama_barang;
        }

        return view('penggunaan.laporan.laporan3',['data_bulan' => $data_bulan, 'bulan_id' => $bulan_id, 'namaCabangSort' => $namaCabangSort, 'kategori' => $kategori, 'data_kategori' => $data_kategori, 'cabang_id' => $cabang_id, 'data_cabang' => $data_cabang, 'nilaiPenggunaanBarang' => $nilaiPenggunaanBarang, 'namaBarang' => $namaBarang, 'data_tahun' => $data_tahun, 'tahun_id' => $tahun_id]);

    }
    public function exportPDF()
    {
        $penggunaan = \App\Penggunaan::all();
        
        $pdf = PDF::loadView('export.penggunaanPDF', ['penggunaan' => $penggunaan] )->setPaper('a4', 'landscape');
        return $pdf->download('dataPenggunaan.pdf');
    }
}
