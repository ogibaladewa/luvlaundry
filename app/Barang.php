<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barang';
    protected $fillable = ['kode_barang','nama_barang','satuan','foto','deskripsi', 'status'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function penyediaan()
    {
        return $this->belongsToMany(Penyediaan::class)->withPivot(['qty', 'harga']);
    }

    public function penggunaan()
    {
        return $this->hasMany(Penggunaan::class);
    }

    public function supplier()
    {
        return $this->belongsToMany(Supplier::class);
    }

    public function cabang()
    {
        return $this->belongsToMany(Cabang::class)->withPivot(['stock']);
    }
}
