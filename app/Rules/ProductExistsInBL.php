<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\B_livraison;

class ProductExistsInBL implements ValidationRule
{
    protected $message = 'The product id you are trying to add is not added for this bon de livraison.';

    public function __construct(public $b_livraison)
    {}
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $bl = B_livraison::find($this->b_livraison);
        $bc = $bl->b_c_externe;
        $bc_products = $bc->products;
        $exists = $bc_products->contains($value);

        if(!$exists) {$fail($this->message);};
    }
}
