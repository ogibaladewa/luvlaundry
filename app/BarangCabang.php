<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BarangCabang extends Model
{
    protected $table = 'barang_cabang';
    protected $fillable = ['barang_id','cabang_id','stock'];
}
