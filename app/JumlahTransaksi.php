<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JumlahTransaksi extends Model
{
    protected $table = 'jumlah_transaksi';
    protected $fillable = ['periode','jumlah','total_berat','cabang_id','user_id'];

    public function cabang()
    {
        return $this->belongsTo(Cabang::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
