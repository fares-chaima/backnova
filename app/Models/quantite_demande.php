<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class quantite_demande extends Model
{
    use HasFactory;
    protected $fillable = [
        'b_c_interne_id',
        'quantity',
        'product_id'
    ];
}
