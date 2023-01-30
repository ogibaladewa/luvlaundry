<?php

namespace App\Http\Controllers;

use App\Exports\LaporanJumlahTransaksiExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Carbon\Carbon;
use PDF;

class JumlahTransaksiController extends Controller
{
    public function index(Request $request)
    {
        if($request->has('cari')){
            $data_jumlah_transaksi = \App\JumlahTransaksi::where('periode','LIKE','%'.$request->cari.'%')->get();
        }else{
            $data_jumlah_transaksi = \App\JumlahTransaksi::all();
        }
        return view('jumlahTransaksi.index',['data_jumlah_transaksi' => $data_jumlah_transaksi]);
    }

    public function create(Request $request)
    {
        $this->validate($request,[
            'periode' => 'required',
            'jumlah' => 'required',
            'total_berat' => 'required',
            'cabang_id' => 'required',
            'user_id' => 'required',
        ]);
        $dateYear = substr($request->periode, -10, 4);
        $dateMonth = substr($request->periode, -5, 2);
        // $date = $request->periode;
        // $date = str_replace('/', '-', $date);
        // $getDate = strtotime($date);
            // dd($date);
        $JT = \App\JumlahTransaksi::where('cabang_id','=',$request['cabang_id'])->whereMonth('periode', '=', 
        $dateMonth)->whereYear('periode', '=', $dateYear)->get();
        
        if(count($JT) == 0){
            \App\JumlahTransaksi::create($request -> all());

            return redirect('/jumlahTransaksi')->with('sukses','Data Berhasil Ditambahkan !');  
        }
        else {
            return redirect('/jumlahTransaksi')->with('gagal','Data Untuk Periode Ini Sudah Ada !');  
        }
        
    }

    public function edit($id)
    {
        $jumlah_transaksi = \App\JumlahTransaksi::find($id);
        return view('jumlahTransaksi/edit',['jumlah_transaksi' => $jumlah_transaksi]);
    }

    public function update(Request $request,$id)
    {
        $jumlah_transaksi = \App\JumlahTransaksi::find($id);
        $jumlah_transaksi->update($request -> all());
        return redirect('/jumlahTransaksi')->with('editsukses','Data Berhasil Diupdate !');  
    }

    public function delete($id)
    {
        $jumlah_transaksi = \App\JumlahTransaksi::find($id);
        $jumlah_transaksi->delete();
        return redirect('/jumlahTransaksi')->with('hapus','Data Berhasil Dihapus !'); 
    }

    public function getdatajumlahtransaksi()
    {
        $jumlah_transaksi = \App\JumlahTransaksi::select('jumlah_transaksi.*');

        return \DataTables::eloquent($jumlah_transaksi)
        ->addColumn('cabang',function($j){
            return $j->cabang->nama_cabang;
        })
        ->addColumn('user',function($j){
            return $j->user->name;
        })
        ->addColumn('periodeO',function($j){
            return date('M Y',strtotime($j->periode));
        })
        ->addColumn('aksi',function($j){
            return '<a href="/jumlahTransaksi/'.$j->id.'/edit" class="btn btn-warning btn-sm"><i class="lnr lnr-pencil"></i></a>
            <a href="/jumlahTransaksi/'.$j->id.'/delete" class="btn btn-danger btn-sm" onclick="return confirm(\'Yakin Hapus Data?\')"><i class="lnr lnr-trash"></i></a>';
        })
        ->rawColumns(['cabang','user','aksi'])
        ->addIndexColumn()
        ->toJson();
    }

    public function laporan(Request $request)
    {
        $data_cabang = \App\Cabang::all();
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
        // dd($data_tahun);
        // dd($data_penggunaanLalu);
        $kategori = [];
        $jumlahPerBulan = [];
        $beratPerBulan = [];
        
        for($i=0;$i<count($data_cabang);$i++){
            
            for($j=0;$j<12;$j++){
                $dataJumlah = 0;
                $dataBerat = 0;
                $data_transaksi_bulanan = \App\JumlahTransaksi::whereMonth('periode', '=', $j+1)->whereYear('periode', '=', $tahun_id)->where('cabang_id','=',$data_cabang[$i]->id)->get();
                foreach($data_transaksi_bulanan as $dtb){

                     $dataJumlah = $dtb->jumlah;
                     $dataBerat = $dtb->total_berat;
                }
                $jumlahPerBulan[$i][$j] = $dataJumlah;
                $beratPerBulan[$i][$j] = $dataBerat;
            }

        }
        // dd($jumlahPerBulan);
        
        $nilaiPenggunaan = array();
        for($i=0;$i<count($data_cabang);$i++){
            $nilaiPenggunaan[$i] = array(
                'nama_cabang' => $data_cabang[$i]->nama_cabang,
                'nilai' => [$jumlahPerBulan[$i][0],$jumlahPerBulan[$i][1],$jumlahPerBulan[$i][2],$jumlahPerBulan[$i][3],
                $jumlahPerBulan[$i][4],$jumlahPerBulan[$i][5],$jumlahPerBulan[$i][6],$jumlahPerBulan[$i][7],
                $jumlahPerBulan[$i][8],$jumlahPerBulan[$i][9],$jumlahPerBulan[$i][10],$jumlahPerBulan[$i][11],],
                'berat' => [$beratPerBulan[$i][0],$beratPerBulan[$i][1],$beratPerBulan[$i][2],$beratPerBulan[$i][3],
                $beratPerBulan[$i][4],$beratPerBulan[$i][5],$beratPerBulan[$i][6],$beratPerBulan[$i][7],
                $beratPerBulan[$i][8],$beratPerBulan[$i][9],$beratPerBulan[$i][10],$beratPerBulan[$i][11],]
            );
        }
        // dd($nilaiPenggunaan);
        

        $penggunaan = [];
        
        return view('jumlahTransaksi.laporan',['kategori' => $kategori, 'nilaiPenggunaan' => $nilaiPenggunaan, 'data_tahun' => $data_tahun, 'tahun_id' => $tahun_id ]);
    }

    public function exportPDF()
    {
        $jumlahTransaksi = \App\JumlahTransaksi::all();
        
        $pdf = PDF::loadView('export.jumlahTransaksiPDF', ['jumlahTransaksi' => $jumlahTransaksi] )->setPaper('a4', 'landscape');
        return $pdf->download('dataJumlahTransaksi.pdf');
    }

    public function exportJumlahExcel() 
    {
        return Excel::download(new LaporanJumlahTransaksiExport, 'laporanJumlahTransaksi.xlsx');
    }
}
