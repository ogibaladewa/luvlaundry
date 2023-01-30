<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Penyediaan extends Model
{
    protected $table = 'penyediaan';
    protected $fillable = ['tanggal','user_id','cabang_id','supplier_id'];

    public function barang()
    {
        return $this->belongsToMany(Barang::class)->withPivot(['qty', 'harga']);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cabang()
    {
        return $this->belongsTo(Cabang::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
