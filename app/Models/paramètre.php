<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class paramètre extends Model
{
    use HasFactory;
    protected $fillable = [
        'Dénomination',
        'Code_Gestionnaire',
        'adresse',
        'Téléphone',
        'photo_url',
    ];
    protected $casts = [
        'id' => 'integer',
        'Téléphone' => 'integer',
    ];
}
