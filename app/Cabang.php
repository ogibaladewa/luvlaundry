<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cabang extends Model
{
    protected $table = 'cabang';
    protected $fillable = ['nama_cabang','no_telp','alamat','status'];

    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function jumlahTransaksi()
    {
        return $this->hasMany(JumlahTransaksi::class);
    }

    public function penyediaan()
    {
        return $this->hasMany(Penyediaan::class);
    }

    public function penggunaan()
    {
        return $this->hasMany(Penggunaan::class);
    }

    public function barang()
    {
        return $this->belongsToMany(Barang::class)->withPivot(['stock']);
    }
}
