<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use PDF;

class PenyediaanController extends Controller
{
    public function index(Request $request)
    {
        $data_penyediaan = \App\Penyediaan::all();
        $data_supplier = \App\Supplier::all();
        return view('penyediaan.index',['data_penyediaan' => $data_penyediaan, 'data_supplier' => $data_supplier]);
    }

    public function add(Request $request)
    {
        $data_supplier = \App\Supplier::all();
        
        if($request->has('supplier_id')){
            $get_supplier = \App\Supplier::where('id', '=', $request['supplier_id'])->get();
            $supplier_id = $request->supplier_id;
        }
        else {
            $get_supplier = \App\Supplier::where('id', '=', 1)->get();
            $supplier_id = 1;
        }
        foreach($get_supplier as $supplier){
            $data_barang = $supplier->barang;

        }
        
        return view('penyediaan.add',['data_supplier' => $data_supplier,'supplier_id' => $supplier_id, 'data_barang' => $data_barang]);
    }

    public function create(Request $request)
    {
        $this->validate($request,[
            'tanggal' => 'required',
            'supplier_id' => 'required',
        ]);

        \App\Penyediaan::create($request -> all());
        return redirect('/penyediaan')->with('sukses','Data Berhasil Ditambahkan !');  
    }

    public function edit($id)
    {
        $penyediaan = \App\Penyediaan::find($id);
        return view('penyediaan/edit',['penyediaan' => $penyediaan]);
    }

    public function update(Request $request,$id)
    {
        $penyediaan = \App\Penyediaan::find($id);
        $penyediaan->update($request -> all());
        return redirect('/penyediaan')->with('editsukses','Data Berhasil Diupdate !');  
    }

    public function detail($id)
    {
        $data_penyediaan = \App\Penyediaan::find($id);
        return view('penyediaan.detail',['data_penyediaan' => $data_penyediaan]);
    }

    public function getdatapenyediaan()
    {
        $penyediaan = \App\Penyediaan::select('penyediaan.*');

        return \DataTables::eloquent($penyediaan)
        ->addColumn('user',function($p){
            return $p->user->name;
        })
        
        ->addColumn('cabang',function($p){
            return $p->cabang->nama_cabang;
        })

        ->addColumn('tanggalO',function($p){
            return date('d-m-Y',strtotime($p->tanggal));
        })
        
        ->addColumn('supplier',function($p){
            return $p->supplier->nama_supplier;
        })

        ->addColumn('aksi',function($p){
            return '<a href="/penyediaan/'.$p->id.'/detail" class="btn btn-info btn-sm"><i class="lnr lnr-eye"></i></a>
            <a href="/penyediaan/'.$p->id.'/delete" class="btn btn-danger btn-sm" onclick="return confirm(\'Yakin Hapus Data?\')"><i class="lnr lnr-trash"></i></a>';
        })
        ->rawColumns(['user','cabang','supplier','aksi'])
        ->addIndexColumn()
        ->toJson();
    }

    public function addPenyediaan(Request $request)
    {
        // dd($request->all());
        $this->validate($request,[
            'tanggal' => 'required',
            'supplier_id' => 'required',
            'user_id' => 'required',
            'cabang_id' => 'required',
            'barang_id' => 'required',
            'qty' => 'required',
            'harga' => 'required',
        ]);
        DB::table('penyediaan')->insert(array(
            array('tanggal' => $request->tanggal,'supplier_id' => $request->supplier_id,
                'user_id' => $request->user_id,'cabang_id' => $request->cabang_id
        ))); 
        $penyediaan_id = DB::getPdo()->lastInsertId();
        $value = 0;
        for ($i=0; $i<count($request->barang_id); $i++){
            
            if($request->barang_id[$i]!=$value){
                
                DB::table('barang_penyediaan')->insert(array(
                    array('barang_id' => $request->barang_id[$i],'harga' => $request->harga[$i],
                    'qty' => $request->qty[$i],'penyediaan_id' => $penyediaan_id),
                )); 
                
                $cabang = $request->cabang_id;
                
                $barang = \App\BarangCabang::where([['barang_id','=', $request->barang_id[$i]],['cabang_id','=', $request->cabang_id]])->first();
                $stock = $barang->stock + $request->qty[$i];    
                $barang->where([['barang_id','=', $request->barang_id[$i]],['cabang_id','=', $request->cabang_id]])
                ->update(array('stock' => $stock));
            }
            
            $value = $request->barang_id[$i];
        }     

        
        return redirect('/penyediaan')->with('sukses','Data Berhasil Ditambahkan !');  
    }

    public function delete($id)
    {
        $penyediaan = \App\Penyediaan::where('id','=',$id)->first();
        $barang_penyediaanGET = \App\BarangPenyediaan::where([['penyediaan_id','=', $id]])->get();
        // dd($barang_penyediaanGET);
        foreach($barang_penyediaanGET as $bp){
            $barang = \App\BarangCabang::where([['barang_id','=',$bp->barang_id],['cabang_id','=',$penyediaan->cabang_id]])->first();
            $stock = $barang->stock - $bp->qty;
            $barang->where([['barang_id','=',$bp->barang_id],['cabang_id','=',$penyediaan->cabang_id]])
                ->update(array('stock' => $stock));
        }
        $penyediaan = \App\Penyediaan::find($id);
        $penyediaan->delete();
        $barang_penyediaan = \App\BarangPenyediaan::where([['penyediaan_id','=', $id]])->delete();
        return redirect('/penyediaan')->with('hapus','Data Berhasil Dihapus !'); 
    }

    public function deleteBarang($barang_id,$penyediaan_id)
    {
         $barang_penyediaan = \App\BarangPenyediaan::where([['barang_id','=', $barang_id],['penyediaan_id','=', $penyediaan_id]])->delete();
         
        return redirect('/penyediaan/'.$penyediaan_id.'/detail')->with('hapus','Data Berhasil Dihapus !'); 
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
        $penyediaanPerBulan = [];
        $jumlahPerCabang = [];

        $data_barangPenyediaanLK = [];
        
    //DATA UNTUK TOTAL PENYEDIAAN
        if($request->has('cabang')){
            if($request->cabang == 'semua'){
                $data_cabangSort = \App\Cabang::all();
                $namaCabangSort = 'Semua';
            }
            else{
                $data_cabangSort = \App\Cabang::where('id','=',$request->cabang)->get();
                $cabang_id = $request->cabang;
                $data_namaCabangSort = \App\Cabang::where('id','=',$request->cabang)->first();
                $namaCabangSort = $data_namaCabangSort->nama_cabang;
            }
        }
        else{
            $data_cabangSort = \App\Cabang::all();
            $namaCabangSort = 'Semua';
        }

        for($i=0;$i<count($data_cabangSort);$i++){
            
            for($j=0;$j<12;$j++){
                
                $data_penyediaan_bulanan = \App\Penyediaan::whereMonth('tanggal', '=', $j+1)->whereYear('tanggal', '=', $tahun_id)->where('cabang_id','=',$data_cabangSort[$i]->id)->get();
                
                $penyediaanPerBulan[$i][$j] = count($data_penyediaan_bulanan);
                
            }

        }
        
        $nilaiPenyediaan = array();
        for($i=0;$i<count($data_cabangSort);$i++){
            $nilaiPenyediaan[$i] = array(
                'nama_cabang' => $data_cabangSort[$i]->nama_cabang,
                'nilai' => [$penyediaanPerBulan[$i][0],$penyediaanPerBulan[$i][1],$penyediaanPerBulan[$i][2],$penyediaanPerBulan[$i][3],
                $penyediaanPerBulan[$i][4],$penyediaanPerBulan[$i][5],$penyediaanPerBulan[$i][6],$penyediaanPerBulan[$i][7],
                $penyediaanPerBulan[$i][8],$penyediaanPerBulan[$i][9],$penyediaanPerBulan[$i][10],$penyediaanPerBulan[$i][11],],
               
            );
            
        }
        return view('penyediaan.laporan.laporan1',['cabang_id' => $cabang_id, 'data_cabang' => $data_cabang, 'nilaiPenyediaan' => $nilaiPenyediaan, 'data_tahun' => $data_tahun, 'tahun_id' => $tahun_id, 'namaCabangSort' => $namaCabangSort]);

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
        $penyediaanPerBulan = [];
        $jumlahPerCabang = [];

        $data_barangPenyediaanLK = [];

        $nilaiKatA = [];

        if($request->has('cabang')){
            if($request->cabang == 'semua'){
                for($i=0;$i<12;$i++){
                    $data_penyediaanLKA[$i] = \App\Penyediaan::whereMonth('tanggal', '=', $i+1)->whereYear('tanggal', '=', $tahun_id)->get();
                    $namaCabangSort = 'Semua';
                }
                for($i=0;$i<12;$i++){
                    for($j=0;$j<count($data_penyediaanLKA[$i]);$j++){
                        $data_barangPenyediaanLKA[$i][$j] = \App\BarangPenyediaan::where('penyediaan_id','=',$data_penyediaanLKA[$i][$j]->id)->get();
                    }
                }
            }
            else{
                for($i=0;$i<12;$i++){
                    $data_penyediaanLKA[$i] = \App\Penyediaan::whereMonth('tanggal', '=', $i+1)->whereYear('tanggal', '=', $tahun_id)->where('cabang_id','=',$request->cabang)->get();
                    $data_namaCabangSort = \App\Cabang::where('id','=',$request->cabang)->first();
                    $cabang_id = $request->cabang;
                    $namaCabangSort = $data_namaCabangSort->nama_cabang;
                }
                for($i=0;$i<12;$i++){
                    for($j=0;$j<count($data_penyediaanLKA[$i]);$j++){
                        $data_barangPenyediaanLKA[$i][$j] = \App\BarangPenyediaan::where('penyediaan_id','=',$data_penyediaanLKA[$i][$j]->id)->get();
                    }
                }
            }
        }
        else{
            for($i=0;$i<12;$i++){
                $data_penyediaanLKA[$i] = \App\Penyediaan::whereMonth('tanggal', '=', $i+1)->whereYear('tanggal', '=', $tahun_id)->get();
                $namaCabangSort = 'Semua';
            }
            for($i=0;$i<12;$i++){
                for($j=0;$j<count($data_penyediaanLKA[$i]);$j++){
                    $data_barangPenyediaanLKA[$i][$j] = \App\BarangPenyediaan::where('penyediaan_id','=',$data_penyediaanLKA[$i][$j]->id)->get();
                }
            }
        }

        // dd($data_barangPenyediaanLKA);
        for($h=0;$h<12;$h++){
            for($i=0;$i<count($data_kategori);$i++){
                $simpanQTYA = 0;
                $kumulatifA = 0;
                if(count($data_penyediaanLKA[$h]) != 0){
                    for($j=0;$j<count($data_penyediaanLKA[$h]);$j++){
                        
                        for($k=0;$k<count($data_barangPenyediaanLKA[$h][$j]);$k++){
                            if($data_penyediaanLKA[$h][$j]->barang[$k]['kategori_id'] == $data_kategori[$i]->id){
                                $simpanQTYA = $data_barangPenyediaanLKA[$h][$j][$k]->qty;
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
                    
                }
                else {
                    $simpanQTYA = 0;
                    $kumulatifA = 0;
                    $kumulatifA = $kumulatifA+$simpanQTYA;
                    $nilaiKatA[$i][$h] = $kumulatifA;
                }
            }
        }

        $nilaiPenyediaanKatA = array();
        for($h=0;$h<12;$h++){
            for($i=0;$i<count($data_kategori);$i++){
                $nilaiPenyediaanKatA[$i] = array(
                    'nama_kategori' => $data_kategori[$i]->nama_kategori,
                    'nilai' => [$nilaiKatA[$i][0],$nilaiKatA[$i][1],$nilaiKatA[$i][2],$nilaiKatA[$i][3],
                    $nilaiKatA[$i][4],$nilaiKatA[$i][5],$nilaiKatA[$i][6],$nilaiKatA[$i][7],
                    $nilaiKatA[$i][8],$nilaiKatA[$i][9],$nilaiKatA[$i][10],$nilaiKatA[$i][11],],
                );
            }
        }

        
        // dd($nilaiKatA);
        // dd($nilaiPenyediaanKatA);
        // dd($namaKatA);

        return view('penyediaan.laporan.laporan2',['kategori' => $kategori, 'cabang_id' => $cabang_id, 'namaCabangSort' => $namaCabangSort, 'data_cabang' => $data_cabang, 'nilaiPenyediaanKatA' => $nilaiPenyediaanKatA, 'data_tahun' => $data_tahun, 'tahun_id' => $tahun_id]);
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

        // dd($data_bulan);

        $cabang_id = '';
        $kategori = [];
        $penyediaanPerBulan = [];
        $jumlahPerCabang = [];

        $data_barangPenyediaanLK = [];

        $nilaiBarang = [];
        if($request->has('cabang')){
            if($request->cabang == 'semua'){
                $data_penyediaanLKB = \App\Penyediaan::whereMonth('tanggal', '=', 
                $bulan_id)->whereYear('tanggal', '=', $tahun_id)->get();
                for($j=0;$j<count($data_penyediaanLKB);$j++){
                    $data_barangPenyediaanLKB[$j] = \App\BarangPenyediaan::where('penyediaan_id','=',$data_penyediaanLKB[$j]->id)->get();
                }
                $namaCabangSort = 'Semua';
            }
            else{
                $data_penyediaanLKB = \App\Penyediaan::whereMonth('tanggal', '=', 
                $bulan_id)->whereYear('tanggal', '=', $tahun_id)->where('cabang_id','=',$request->cabang)->where('cabang_id','=',$request->cabang)->get();
                for($j=0;$j<count($data_penyediaanLKB);$j++){
                    $data_barangPenyediaanLKB[$j] = \App\BarangPenyediaan::where('penyediaan_id','=',$data_penyediaanLKB[$j]->id)->get();
                }
                $cabang_id = $request->cabang;
                $data_namaCabangSort = \App\Cabang::where('id','=',$request->cabang)->first();
                $namaCabangSort = $data_namaCabangSort->nama_cabang;
            }
        }
        else{
            $data_penyediaanLKB = \App\Penyediaan::whereMonth('tanggal', '=', 
            $bulan_id)->whereYear('tanggal', '=', $tahun_id)->get();
            for($j=0;$j<count($data_penyediaanLKB);$j++){
                $data_barangPenyediaanLKB[$j] = \App\BarangPenyediaan::where('penyediaan_id','=',$data_penyediaanLKB[$j]->id)->get();
            }
            $namaCabangSort = 'Semua';
        }

        // dd($data_barangPenyediaanLKB);
        for($i=0;$i<count($data_barang);$i++){
            $simpanQTYB = 0;
            $kumulatifB = 0;
            if(count($data_penyediaanLKB) != 0){

                for($j=0;$j<count($data_penyediaanLKB);$j++){
                    for($k=0;$k<count($data_barangPenyediaanLKB[$j]);$k++){
                        if($data_penyediaanLKB[$j]->barang[$k]['id'] == $data_barang[$i]->id){
                            $simpanQTYB = $data_barangPenyediaanLKB[$j][$k]->qty;
                            $kumulatifB = $kumulatifB+$simpanQTYB;
                            $nilaiBarang[$i] = $kumulatifB;   
                        }
                        else {
                            $simpanQTYB = 0;
                            $kumulatifB = $kumulatifB+$simpanQTYB;
                            $nilaiBarang[$i] = $kumulatifB;   
                        }
                    }
                }
            }
            else {
                $simpanQTYB = 0;
                $kumulatifB = $kumulatifB+$simpanQTYB;
                $nilaiBarang[$i] = $kumulatifB;
            }
        }

        $namaBarang =[];
        $nilaiPenyediaanBarang = array();
        for($i=0;$i<count($data_barang);$i++){
            $nilaiPenyediaanBarang[$i] = $nilaiBarang[$i];
            $namaBarang[$i] = $data_barang[$i]->nama_barang;
        }

        // dd($nilaiBarang);
        // dd($nilaiPenyediaanBarang);

        return view('penyediaan.laporan.laporan3',['kategori' => $kategori, 'cabang_id' => $cabang_id, 'data_cabang' => $data_cabang,  'nilaiPenyediaanBarang' => $nilaiPenyediaanBarang, 'namaBarang' => $namaBarang, 'data_tahun' => $data_tahun, 'tahun_id' => $tahun_id, 'data_bulan' => $data_bulan, 'bulan_id' => $bulan_id, 'namaCabangSort' => $namaCabangSort]);
    }

    public function exportPDF()
    {
        $penyediaan = \App\Penyediaan::all();
        
        $pdf = PDF::loadView('export.penyediaanPDF', ['penyediaan' => $penyediaan] )->setPaper('a4', 'landscape');
        return $pdf->download('dataPenyediaan.pdf');
    }
}
