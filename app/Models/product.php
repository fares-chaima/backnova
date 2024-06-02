<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'description', 'quantity', 'price', 'min'
    ];

    public function fournisseur()
    {
        return $this->belongsTo(Fournisseur::class);
    }


    public function articles()
    {
        return $this->belongsToMany(Article::class);
    }

    public function bcExternes()
    {
        return $this->belongsToMany(BCExterne::class, 'quantite_commandes')
                    ->withPivot('quantity');
    }

    /**
     * return the delieverd quantity of this product
     * for a given bl
     * 
     * @usage $product->getDelivredQuantityForBLivraison($b_livraison_id)
     * @param integer $b_livraison_id
     * @return integer
    */
    public function getDelivredQuantityForBLivraison($b_livraison_id){
        return Quantite_livre::where('b_livraison_id', $b_livraison_id)
        ->where('product_id', $this->id)
        ->first()
        ?->quantity;
    }
}