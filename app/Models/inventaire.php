<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class inventaire extends Model
{
    use HasFactory;
    
    protected $table = 'inventaires';

    protected $fillable = ['date'];
}
