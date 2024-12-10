<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;
    public $primaryKey = 'id_pesanan';
    protected $fillable = [
        'check_in', 
        'check_out', 
        'id_hotel', 
        'total', 
        'id'
    ];
    public function hotel() {
        return $this->belongsTo(Hotel::class, 'id_hotel', 'id_hotel');
    }

    public function users() {
        return $this->belongsTo(User::class, 'id', 'id');
    }

    public function payment() {
        return $this->hasMany(Payment::class, 'id_pesanan', 'id_pesanan');
    }
}