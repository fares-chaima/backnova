<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class quantité_commande extends Model
{
    use HasFactory;

    protected $table = 'quantite_commandes';

    protected $fillable = [
        'b_c_externe_id',
        'quantity',
        'product_id'
    ];
}
