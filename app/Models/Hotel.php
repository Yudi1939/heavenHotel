<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;
    public $primaryKey = 'id_hotel';
    protected $fillable = [
        'cabang_hotel', 
        'desc_hotel',
        'price',
        'path',
        'img_hotel',
        'bintang'
    ];

    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'id_hotel', 'id_hotel');
    }

    public function rooms()
    {
        return $this->hasMany(Pesanan::class, 'id_hotel', 'id_hotel');
    }
}