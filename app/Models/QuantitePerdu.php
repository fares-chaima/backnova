<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuantitePerdu extends Model
{
    use HasFactory;
    protected $table = 'qunatite_perdus';

    
    protected $fillable = ['product_id', 'inventaire_id', 'quantity', 'Observation'];

    
}
