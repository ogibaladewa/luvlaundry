<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use PDF;

class CabangController extends Controller
{
    public function index(Request $request)
    {
        if($request->has('cari')){
            $data_cabang = \App\Cabang::where('nama_cabang','LIKE','%'.$request->cari.'%')->get();
        }else{
            $data_cabang = \App\Cabang::all();
        }
        return view('cabang.index',['data_cabang' => $data_cabang]);
    }

    public function create(Request $request)
    {
        $this->validate($request,[
            'nama_cabang' => 'required',
            'no_telp' => 'required',
            'alamat' => 'required',
        ]);

        \App\Cabang::create($request -> all());

        $cabang_id = DB::getPdo()->lastInsertId();
        $data_barang = \App\Barang::all();
        for ($i=0; $i<count($data_barang); $i++){
            DB::table('barang_cabang')->insert([
                'barang_id' =>$data_barang[$i]->id,
                'cabang_id' => $cabang_id,
                'stock' => 0,
            ]);
        }
        return redirect('/cabang')->with('sukses','Data Berhasil Ditambahkan !');  
    }

    public function edit($id)
    {
        $cabang = \App\Cabang::find($id);
        return view('cabang/edit',['cabang' => $cabang]);
    }

    public function update(Request $request,$id)
    {
        $cabang = \App\Cabang::find($id);
        $cabang->update($request -> all());
        return redirect('/cabang')->with('editsukses','Data Berhasil Diupdate !');  
    }

    public function delete($id)
    {
        $cabang = \App\Cabang::find($id);
        $cabang->delete();
        $barang_cabang = \App\BarangCabang::where('cabang_id','=',$id)->delete();
        return redirect('/cabang')->with('hapus','Data Berhasil Dihapus !'); 
    }

    public function getdatacabang()
    {
        $cabang = \App\Cabang::select('cabang.*');

        return \DataTables::eloquent($cabang)
        
        ->addColumn('aksi',function($c){
            return '<a href="/cabang/'.$c->id.'/edit" class="btn btn-warning btn-sm"><i class="lnr lnr-pencil"></i></a>
            <a href="/cabang/'.$c->id.'/delete" class="btn btn-danger btn-sm" onclick="return confirm(\'Yakin Hapus Data?\')"><i class="lnr lnr-trash"></i></a>';
        })
        ->rawColumns(['aksi'])
        ->addIndexColumn()
        ->toJson();
    }

    public function exportPDF()
    {
        $cabang = \App\Cabang::all();
        
        $pdf = PDF::loadView('export.cabangPDF', ['cabang' => $cabang] )->setPaper('a4', 'landscape');
        return $pdf->download('dataCabang.pdf');
    }
}
