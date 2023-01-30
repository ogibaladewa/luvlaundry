<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BarangSupplier extends Model
{
    protected $table = 'barang_supplier';
    protected $fillable = ['barang_id','supplier_id'];
}
