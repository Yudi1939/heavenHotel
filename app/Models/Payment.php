<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $primaryKey='id_payment';
    protected $fillable=['payment_method','payment_status','id_pesanan'];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan', 'id_pesanan');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'id_pesanan', 'id');
    }
}
