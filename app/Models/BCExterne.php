<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BCExterne extends Model
{
    use HasFactory;
    protected $fillable = [
        'date','fournisseur_id'
    ];
    public function products()
    {
        return $this->belongsToMany(Product::class, 'quantite_commandes')
        ->withPivot('quantity');
    }

    public function quantite_commandes(){
        return $this->hasMany(quantité_commande::class);

    }
    
    public function fournisseur()
    {
        return $this->belongsTo(Fournisseur::class, 'fournisseur_id');
    }
}
