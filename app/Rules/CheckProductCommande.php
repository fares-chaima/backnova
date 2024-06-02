<?php

namespace App\Rules;

use App\Models\B_livraison;
use App\Models\BCExterne;
use App\Models\Product;
use App\Models\Quantite_livre;
use App\Models\quantité_commande;
use Closure;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\DataAwareRule;

class CheckProductCommande implements ValidationRule, DataAwareRule
{
    protected $message ='The quantity ordered must be greater than the quantity delivered.';

    /**
     * all the data under validation
    */
    protected $data = [];
 
    /**
     * Set the data under validation.
     *
     * @param  array  $data
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;
 
        return $this;
    }

 
    public function __construct(public $b_livraison)
    {
    }

    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure  $fail
     * @return void
     */
    public function validate(string $attribute, mixed $value, Closure $fail) : void
    {
        $product_id = $this->extractProductId($attribute);
        $bl = B_livraison::find($this->b_livraison);
        $bc = $bl->b_c_externe; 

        $quantityCommande = $bc->quantite_commandes->where('product_id', $product_id)
            ->first(); 

        $quantityCommande = $quantityCommande->quantity;
            
        if ($quantityCommande <= $value) { $fail($this->message); }
    }

    /**
     * extract the equivilant product id 
     * @return mixed
    */
    protected function extractProductId($attribute){
        $productIndex = explode('.', $attribute)[0]; // the index of the current validated attribute
        $productArr = $this->data[$productIndex]; // the matching product for this current validated attribute
        $productId = $productArr['product_id']; // the matching product id

        return $productId;
    }
}
