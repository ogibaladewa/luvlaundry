<?php

namespace App\Exports;

use App\JumlahTransaksi;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;


class LaporanJumlahTransaksiExport implements FromView
{
    public function view(): View
    {
        return view('jumlahTransaksi.laporan');
    }
}
