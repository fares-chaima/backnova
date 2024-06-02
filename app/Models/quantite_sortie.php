<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class quantite_sortie extends Model
{
    use HasFactory;
    protected $fillable = [
        'b_sortie_id',
        'quantity',
        'product_id'
    ];
}
