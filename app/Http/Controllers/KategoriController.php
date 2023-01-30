<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        if($request->has('cari')){
            $data_kategori = \App\Kategori::where('nama_kategori','LIKE','%'.$request->cari.'%')->get();
        }else{
            $data_kategori = \App\Kategori::all();
        }
        return view('kategori.index',['data_kategori' => $data_kategori]);
    }

    public function create(Request $request)
    {
        $this->validate($request,[
            'nama_kategori' => 'required',
        ]);

        \App\Kategori::create($request -> all());
        return redirect('/kategori')->with('sukses','Data Berhasil Ditambahkan !');  
    }

    public function edit($id)
    {
        $kategori = \App\Kategori::find($id);
        return view('kategori/edit',['kategori' => $kategori]);
    }

    public function update(Request $request,$id)
    {
        $kategori = \App\Kategori::find($id);
        $kategori->update($request -> all());
        return redirect('/kategori')->with('editsukses','Data Berhasil Diupdate !');  
    }

    public function delete($id)
    {
        $kategori = \App\Kategori::find($id);
        $kategori->delete();
        return redirect('/kategori')->with('hapus','Data Berhasil Dihapus !'); 
    }

    public function getdatakategori()
    {
        $kategori = \App\Kategori::select('kategori.*');

        return \DataTables::eloquent($kategori)
        
        ->addColumn('aksi',function($k){
            return '<a href="/kategori/'.$k->id.'/edit" class="btn btn-warning btn-sm"><i class="lnr lnr-pencil"></i></a>
            <a href="/kategori/'.$k->id.'/delete" class="btn btn-danger btn-sm" onclick="return confirm(\'Yakin Hapus Data?\')"><i class="lnr lnr-trash"></i></a>';
        })
        ->rawColumns(['aksi'])
        ->addIndexColumn()
        ->toJson();
    }

    public function exportPDF()
    {
        $kategori = \App\Kategori::all();
        
        $pdf = PDF::loadView('export.kategoriPDF', ['kategori' => $kategori] )->setPaper('a4', 'landscape');
        return $pdf->download('dataKategori.pdf');
    }
}
