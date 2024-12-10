<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class chart extends Model
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

    public function user() {
        return $this->belongsTo(User::class, 'id', 'id');
    }
}
