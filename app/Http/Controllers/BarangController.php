<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use PDF;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        if($request->has('cari')){
            $data_barang = \App\Barang::where('nama_barang','LIKE','%'.$request->cari.'%')->get();
        }else{
            $data_barang = \App\Barang::all();
        }
        $data_kategori = \App\Kategori::all();
        
        return view('barang.index',['data_barang' => $data_barang, 'data_kategori' => $data_kategori]);
    }

    public function create(Request $request)
    {
        if($request->hasfile('foto')){
            $foto = $request->file('foto')->getClientOriginalName();
        }
        else{
            $foto = $request->foto = 'defaultbarang.png';
        }
        $this->validate($request,[
            'kode_barang' => 'required|min:7|max:7',
            'nama_barang' => 'required',
            'satuan' => 'required',
            'foto' => 'mimes:jpg,png',
            'kategori_id' => 'required',
        ]);
        DB::table('barang')->insert([
            'kode_barang' => $request->kode_barang,
            'nama_barang' => $request->nama_barang,
            'satuan' => $request->satuan,
            'deskripsi' => $request->deskripsi,
            'foto' => $foto,
            'kategori_id' => $request->kategori_id,
        ]);
        if($request->hasfile('foto')){
            $request->file('foto')->move('images/',$request->file('foto')->getClientOriginalName());
        }

        $barang_id = DB::getPdo()->lastInsertId();
        $data_cabang = \App\Cabang::all();
        for ($i=0; $i<count($data_cabang); $i++){
            DB::table('barang_cabang')->insert([
                'barang_id' => $barang_id,
                'cabang_id' => $data_cabang[$i]->id,
                'stock' => 0,
            ]);
        }
        return redirect('/barang')->with('sukses','Data Berhasil Ditambahkan !');  
    }

    public function edit($id)
    {
        $barang = \App\Barang::find($id);
        return view('barang/edit',['barang' => $barang]);
    }

    public function update(Request $request,$id)
    {
        //dd($request->all());
        $barang = \App\Barang::find($id);
        $barang->update($request -> all());
        if($request->hasfile('foto')){
            $request->file('foto')->move('images/',$request->file('foto')->getClientOriginalName());
            $barang->foto = $request->file('foto')->getClientOriginalName();
            $barang->save();
        }
        return redirect('/barang')->with('editsukses','Data Berhasil Diupdate !');  
    }

    public function delete($id)
    {
        $barang = \App\Barang::find($id);
        $barang->delete();
        return redirect('/barang')->with('hapus','Data Berhasil Dihapus !'); 
    }
    
    public function detail($id)
    {
        $barang = \App\Barang::find($id);
        return view('barang.detail',['barang' => $barang]);
    }

    public function getdatabarang()
    {
        $barang = \App\Barang::select('barang.*');

        return \DataTables::eloquent($barang)
        ->addColumn('kategori',function($b){
            return $b->kategori->nama_kategori;
        })
        ->addColumn('aksi',function($b){
            return '<a href="/barang/'.$b->id.'/edit" class="btn btn-warning btn-sm"><i class="lnr lnr-pencil"></i></a>
            <a href="/barang/'.$b->id.'/detail" class="btn btn-info btn-sm"><i class="lnr lnr-eye"></i></a>
            <a href="/barang/'.$b->id.'/delete" class="btn btn-danger btn-sm" onclick="return confirm(\'Yakin Hapus Data?\')"><i class="lnr lnr-trash"></i></a>';
        })
        ->rawColumns(['kategori','aksi'])
        ->addIndexColumn()
        ->toJson();
    }

    public function stock(Request $request)
    {
        
        $data_barang = \App\Barang::all();
        
        $data_kategori = \App\Kategori::all();
        
        return view('barang.stock',['data_barang' => $data_barang, 'data_kategori' => $data_kategori]);
    }

    public function getdatastock()
    {
        
        $barang_cabang = \App\BarangCabang::select('barang_cabang.*')->where('cabang_id', '=', auth()->user()->cabang_id);
        return \DataTables::eloquent($barang_cabang)
        ->addColumn('kode_barang',function($b){
            $kodeBarang = \App\Barang::select('kode_barang')->where('id', '=', $b->barang_id)->first();
            return $kodeBarang->kode_barang;
        })
        ->addColumn('nama_barang',function($b){
            $namaBarang = \App\Barang::select('nama_barang')->where('id', '=', $b->barang_id)->first();
            return $namaBarang->nama_barang;
        })
        ->addColumn('satuan',function($b){
            $satuanBarang = \App\Barang::select('satuan')->where('id', '=', $b->barang_id)->first();
            return $satuanBarang->satuan;
        })
        
        ->rawColumns(['kode_barang','nama_barang','satuan'])
        ->addIndexColumn()
        ->toJson();
    }

    public function laporanHarga(Request $request)
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

        if($request->has('supplier')){
            if($request->supplier == 'semua'){
                
            }
            else{
                for($i=0;$i<12;$i++){
                    $data_penyediaan[$i] = \App\Penyediaan::whereMonth('tanggal', '=', $i+1)->whereYear('tanggal', '=', $tahun_id)->where('supplier_id','=', $request['supplier'])->get();
                }
                $kategori_id = $request['kategori'];
                $supplier_id = $request['supplier'];
                $data_namaSupplierSort = \App\Supplier::where('id','=',$request->supplier)->first();
                $namaSupplierSort = $data_namaSupplierSort->nama_supplier;
            }
        }
        else{
            for($i=0;$i<12;$i++){
                $data_penyediaan[$i] = \App\Penyediaan::whereMonth('tanggal', '=', $i+1)->whereYear('tanggal', '=', $tahun_id)->where('supplier_id','=', 1)->get();
            }
            $supplier_id = '1';
            $data_namaSupplierSort = \App\Supplier::where('id','=','1')->first();
            $namaSupplierSort = $data_namaSupplierSort->nama_supplier;
        }
        
        for($i=0;$i<12;$i++){
            for($j=0;$j<count($data_penyediaan[$i]);$j++){
                $data_barangPenyediaan[$i][$j] = \App\BarangPenyediaan::where('penyediaan_id','=',$data_penyediaan[$i][$j]->id)->get();
            }
        }

        // dd($data_barangPenyediaan);

        if($request->has('kategori')){
            if($request->kategori == 'semua'){
                
            }
            else{
                $data_barangKat = \App\Barang::where('kategori_id', '=', $request['kategori'])->get();
                $kategori_id = $request['kategori'];
                $data_namaKategoriSort = \App\Kategori::where('id','=',$request->kategori)->first();
                $namaKategoriSort = $data_namaKategoriSort->nama_kategori;
            }
        }
        else{
            $data_barangKat = \App\Barang::where('kategori_id', '=', '4')->get();
            $kategori_id = '4';
            $data_namaKategoriSort = \App\Kategori::where('id','=','4')->first();
            $namaKategoriSort = $data_namaKategoriSort->nama_kategori;
        }
        
        // dd($data_barangKat);
        
        for($h=0;$h<12;$h++){
            for($i=0;$i<count($data_barangKat);$i++){
                $qtyNH[$i][$h]= 0;
                $cumHarga[$i][$h] = 0;
                $simpanHarga = 0;
                if(count($data_penyediaan[$h]) != 0){
                    for($j=0;$j<count($data_penyediaan[$h]);$j++){
                        for($k=0;$k<count($data_barangPenyediaan[$h][$j]);$k++){
                            if($data_penyediaan[$h][$j]->barang[$k]['id'] == $data_barangKat[$i]->id){
                                $simpanHarga = $data_barangPenyediaan[$h][$j][$k]->harga;
                                $loopHarga[$i][$h] = $simpanHarga;  
                                $qtyNH[$i][$h] = $qtyNH[$i][$h] + 1;
                                $cumHarga[$i][$h] = $cumHarga[$i][$h] + $loopHarga[$i][$h];
                                $nilaiHarga[$i][$h] = $cumHarga[$i][$h]/$qtyNH[$i][$h];
                            }
                            else {
                                $nilaiHarga[$i][$h] = $simpanHarga;   
                            }
                        }

                    }
                    
                }
                else {
                    $simpanHarga = 0;
                    $nilaiHarga[$i][$h] = $simpanHarga;
                }
            }
        }
        // dd($nilaiHarga);
        // dd($cumHarga);

        $nilaiHargaKat = array();
        for($h=0;$h<12;$h++){
            for($i=0;$i<count($data_barangKat);$i++){
                $nilaiHargaKat[$i] = array(
                    'nama_barang' => $data_barangKat[$i]->nama_barang,
                    'nilai' => [$nilaiHarga[$i][0],$nilaiHarga[$i][1],$nilaiHarga[$i][2],$nilaiHarga[$i][3],
                    $nilaiHarga[$i][4],$nilaiHarga[$i][5],$nilaiHarga[$i][6],$nilaiHarga[$i][7],
                    $nilaiHarga[$i][8],$nilaiHarga[$i][9],$nilaiHarga[$i][10],$nilaiHarga[$i][11],],
                );
            }
        }
        // dd($nilaiHargaKat);

        $this->exportLaporanHargaPDF($supplier_id, $kategori_id, $kategori, $data_supplier, $data_kategori, $nilaiHargaKat, $data_tahun, $tahun_id, $namaSupplierSort, $namaKategoriSort);
   
        return view('barang.laporanHarga',['supplier_id' => $supplier_id, 'kategori_id' => $kategori_id, 'kategori' => $kategori, 'data_supplier' => $data_supplier, 'data_kategori' => $data_kategori, 'nilaiHargaKat' => $nilaiHargaKat, 'data_tahun' => $data_tahun, 'tahun_id' => $tahun_id, 'namaSupplierSort' => $namaSupplierSort, 'namaKategoriSort' => $namaKategoriSort]);
    }

    public function laporanStock(Request $request)
    {
        $data_cabang = \App\Cabang::all();
        $data_supplier = \App\Supplier::all();
        $data_kategori = \App\Kategori::all();
        $data_barang = \App\Barang::all();
        

        $cabang_id = '';
        //DATA UNTUK STOCK TERKINI PADA CABANG
        
        $nilaiKatBT = [];
        $kategori_id = 0;

        if($request->has('cabang')){
                $data_barangCabang = \App\BarangCabang::where('cabang_id', '=', $request['cabang'])->get();
                $cabang_id = $request['cabang'];
                $data_namaCabangSort = \App\Cabang::where('id','=',$request->cabang)->first();
                $namaCabangSort = $data_namaCabangSort->nama_cabang;
        }
        else{
                $data_barangCabang = \App\BarangCabang::where('cabang_id', '=', 1)->get();
                $cabang_id = 1;
                $data_namaCabangSort = \App\Cabang::where('id','=',$cabang_id)->first();
                $namaCabangSort = $data_namaCabangSort->nama_cabang;
        }

        $data_barangKat = \App\Barang::all();
        
        // dd($data_barangCabang);
        // dd($data_barangKat);
        for($i=0;$i<count($data_barangKat);$i++){
            $simpanStock = 0;
            if(count($data_barangCabang) != 0){
                for($j=0;$j<count($data_barangCabang);$j++){
                    
                    if($data_barangCabang[$j]->barang_id == $data_barangKat[$i]->id){
                        $simpanStock = $data_barangCabang[$j]->stock; 
                        $nilaiStock[$i] = $simpanStock;
                    }
                    else {
                        $simpanStock = $simpanStock;
                        $nilaiStock[$i] = $simpanStock;  
                    }

                }
                
            }
            else {
                $nilaiStock[$i] = 0;
            }
        }

        $nilaiStockTerkini = array();
        for($i=0;$i<count($data_barangKat);$i++){
            $nilaiStockTerkini[$i] = array(
                'nama_barang' => $data_barangKat[$i]->nama_barang,
                'nilai' => $nilaiStock[$i],
                'kode_barang' => $data_barangKat[$i]->kode_barang,
                'satuan' => $data_barangKat[$i]->satuan,
            );
        }
        
        // dd($nilaiStockTerkini);
        // dd($nilaiPenggunaanKatBT);
        // // dd($namaKatA);
   
        return view('barang.laporanStock',['kategori_id' => $kategori_id, 'kategori_id' => $kategori_id, 'namaCabangSort' => $namaCabangSort, 'cabang_id' => $cabang_id, 'data_supplier' => $data_supplier, 'data_cabang' => $data_cabang, 'data_kategori' => $data_kategori, 'nilaiStockTerkini' => $nilaiStockTerkini]);
    }

    public function getdatalaporanstock()
    {

        $barang_cabang = \App\BarangCabang::select('barang_cabang.*')->where('cabang_id', '=', 4);
        return \DataTables::eloquent($barang_cabang)
        ->addColumn('kode_barang',function($b){
            $kodeBarang = \App\Barang::select('kode_barang')->where('id', '=', $b->barang_id)->first();
            return $kodeBarang->kode_barang;
        })
        ->addColumn('nama_barang',function($b){
            $namaBarang = \App\Barang::select('nama_barang')->where('id', '=', $b->barang_id)->first();
            return $namaBarang->nama_barang;
        })
        ->addColumn('satuan',function($b){
            $satuanBarang = \App\Barang::select('satuan')->where('id', '=', $b->barang_id)->first();
            return $satuanBarang->satuan;
        })
        
        ->rawColumns(['kode_barang','nama_barang','satuan'])
        ->addIndexColumn()
        ->toJson();
    }

    public function exportPDF()
    {
        $barang = \App\Barang::all();
        
        $pdf = PDF::loadView('export.barangPDF', ['barang' => $barang] )->setPaper('a4', 'landscape');
        return $pdf->download('dataHargaBarang.pdf');
    }
    public function exportLaporanHargaPDF()
    {
        $barang = \App\Barang::all();

        $pdf = PDF::loadView('export.laporanHargaPDF', ['barang' => $barang ] )->setPaper('a4', 'landscape');
        return $pdf->download('dataLaporanHarga.pdf');
    }
}

