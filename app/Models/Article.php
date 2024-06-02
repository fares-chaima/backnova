<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    protected $fillable = ['nom', 'tva'];
    public function chapiter()
{
    return $this->belongsTo(Chapter::class);
}

public function products()
{
    return $this->belongsToMany(Product::class);
}
}
