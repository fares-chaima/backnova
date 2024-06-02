<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fournisseur extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'adresse', 'number', 'email', 'NIS', 'NIF', 'RC'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function bonsDeCommandeExternes()
    {
        return $this->hasMany(BCExterne::class);
    }
    public function bReceptions()
    {
        return $this->hasMany(B_Reception::class, 'fournisseur_id');
    }
}
