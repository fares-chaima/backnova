<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quantite_livre extends Model
{
    use HasFactory;
    protected $table = 'quantite_livre';
    protected $fillable = [
        'b_reception_id',
        'quantity',
        'product_id'
    ];
}
