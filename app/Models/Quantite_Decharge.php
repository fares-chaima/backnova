<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quantite_Decharge extends Model
{
    use HasFactory;
    protected $table = 'quantite_decharges';
    protected $fillable = [
        'b_decharge_id',
        'quantity',
        'product_id'
    ];
}
