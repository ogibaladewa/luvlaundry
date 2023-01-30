<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'no_telp', 'alamat', 'avatar', 'status', 'remember_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getAvatar()
    {
        if(!$this->avatar){
            return asset('images/default.png');
        }
        return asset('images/'.$this->avatar);
    }

    public function cabang()
    {
        return $this->belongsTo(Cabang::class);
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
}
