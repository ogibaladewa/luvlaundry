<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use PDF;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        if($request->has('cari')){
            $data_supplier = \App\Supplier::where('nama_supplier','LIKE','%'.$request->cari.'%')->get();
        }else{
            $data_supplier = \App\Supplier::all();
        }
        return view('supplier.index',['data_supplier' => $data_supplier]);
    }

    public function create(Request $request)
    {
        $this->validate($request,[
            'nama_supplier' => 'required',
            'no_telp' => 'required',
            'email' => 'required',
            'alamat' => 'required',
        ]);

        \App\Supplier::create($request -> all());
        return redirect('/supplier')->with('sukses','Data Berhasil Ditambahkan !');  
    }

    public function edit($id)
    {
        $supplier = \App\Supplier::find($id);
        return view('supplier/edit',['supplier' => $supplier]);
    }

    public function update(Request $request,$id)
    {
        $supplier = \App\Supplier::find($id);
        $supplier->update($request -> all());
        return redirect('/supplier')->with('editsukses','Data Berhasil Diupdate !');  
    }

    public function delete($id)
    {
        $supplier = \App\Supplier::find($id);
        $supplier->delete();
        $barang_supplier = \App\barangSupplier::where('supplier_id','=',$id)->delete();
        return redirect('/supplier')->with('hapus','Data Berhasil Dihapus !'); 
    }

    public function getdatasupplier()
    {
        $supplier = \App\Supplier::select('supplier.*');

        return \DataTables::eloquent($supplier)
        
        ->addColumn('aksi',function($s){
            return '<a href="/supplier/'.$s->id.'/barangSupplier" class="btn btn-info btn-sm"><i class="fa fa-archive"></i></a>
            <a href="/supplier/'.$s->id.'/edit" class="btn btn-warning btn-sm"><i class="lnr lnr-pencil"></i></a>
            <a href="/supplier/'.$s->id.'/delete" class="btn btn-danger btn-sm" onclick="return confirm(\'Yakin Hapus Data?\')"><i class="lnr lnr-trash"></i></a>';
        })
        ->rawColumns(['aksi'])
        ->addIndexColumn()
        ->toJson();
    }

    public function barangSupplier($id)
    {
        $data_barang_supplier = \App\Supplier::find($id);
        $data_barang = \App\Barang::all();
        $pivot = \App\BarangSupplier::where('supplier_id','=', $id);
        return view('supplier.barangSupplier',['data_barang_supplier' => $data_barang_supplier, 'data_barang' => $data_barang, 'pivot' => $pivot, 'id' => $id]);
    }

    public function addBarang(Request $request)
    {
        // dd($request->all());
        $this->validate($request,[
            'barang_id' => 'required',
            'supplier_id' => 'required',
        ]);
        $value = 0;
        for ($i=0; $i<count($request->barang_id); $i++){
            $s_id=$request->supplier_id[$i];
            //masalah disini
            if($request->barang_id[$i]!=$value){
                DB::table('barang_supplier')->insert(array(
                    array('barang_id' => $request->barang_id[$i],'supplier_id' => $request->supplier_id[$i]),
                )); 
                $value = $request->barang_id[$i];
            }
            
        
        }     

        
        return redirect('/supplier/'.$s_id.'/barangSupplier')->with('sukses','Data Berhasil Ditambahkan !');  
    }

    public function deleteBarang($barang_id,$supplier_id)
    {
         $barang_supplier = \App\BarangSupplier::where([['barang_id','=', $barang_id],['supplier_id','=', $supplier_id]])->delete();
         
        return redirect('/supplier/'.$supplier_id.'/barangSupplier')->with('hapus','Data Berhasil Dihapus !'); 
    }

    public function exportPDF()
    {
        $supplier = \App\Supplier::all();
        
        $pdf = PDF::loadView('export.supplierPDF', ['supplier' => $supplier] )->setPaper('a4', 'landscape');
        return $pdf->download('dataSupplier.pdf');
    }
}
