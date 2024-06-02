<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Structure extends Model
{ 
     use HasFactory;
     
         protected $fillable = [
             'name',
             'responsible_id',
         ];
     
         public function responsible()
         {
             return $this->belongsTo(User::class, 'responsible_id');
         }
         public function users()
    {
        return $this->belongsToMany(User::class, 'structure_user');
    }
}
     
