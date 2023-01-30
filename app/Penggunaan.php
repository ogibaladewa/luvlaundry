<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Penggunaan extends Model
{
    protected $table = 'penggunaan';
    protected $fillable = ['tanggal','terpakai','user_id','cabang_id','barang_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cabang()
    {
        return $this->belongsTo(Cabang::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
