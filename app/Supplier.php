<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'supplier';
    protected $fillable = ['nama_supplier', 'no_telp', 'email', 'alamat', 'status'];

    public function penyediaan()
    {
        return $this->hasMany(Penyediaan::class);
    }

    public function barang()
    {
        return $this->belongsToMany(Barang::class);
    }
}
