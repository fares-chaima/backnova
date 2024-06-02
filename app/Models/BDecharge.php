<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BDecharge extends Model
{
    use HasFactory;
    protected $fillable =[
        'date',
        'observation',
        'Recovery',
    ];
}
