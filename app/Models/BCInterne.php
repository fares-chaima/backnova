<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class BCInterne extends Model
{
    public $statusRepresentation = [
        0 => 'not_sent_from_con', 
        1 => 'sent_from_con_to_res', 
        2 => 'sent_from_res_to_dir', 
        3 => 'sent_from_dir_to_mag',
    ];
    protected $statusesPerRole = [
        'magasinier' => [
            'sent_from_dir_to_mag' => 'pret'
        ],
        'directeur' => [
            'sent_from_res_to_dir' => 'pret',
            'sent_from_dir_to_mag' => 'envoye'
        ],
        'responsable' => [
            'sent_from_con_to_res' => 'pret',
            'sent_from_res_to_dir' => 'envoye'
        ],
        'consomateur' => [
            'not_sent_from_con' => 'pret',
            'sent_from_con_to_res' => 'envoye'
        ]
    ];

    use HasFactory;
    protected $fillable = [
        'date',
        'status',
        'type',
        'observation',
        'Recovery',

    ];
    protected $casts = [
        'type' => 'boolean',
    ];
    public function products()
    {
        return $this->belongsToMany(Product::class, 'quantite_demandes')
        ->withPivot('quantity');
    }
    public function quantite_demandes(){
        return $this->hasMany(quantite_demande::class);
    }
    /**
     * define new accessor that returns 
     * the string represention for the status string
     * @return string
    */
    public function getStatusAttribute($value){
        return $this->statusRepresentation[$value];
    }
   
    public function getStatus(){
         $role = auth()->user()->role; 
         $roleName = $role->name;
       

        return array_key_exists($this->status, $this->statusesPerRole[$roleName])
        ? $this->statusesPerRole[$roleName][$this->status]
        : 'not_accesible';
    }

    public function scopeBSortie(Builder $builder){
        return $builder->where('type', true)->where('status', 3);
    }
    public function scopeBDecharge(Builder $builder){
        return $builder->where('type', false)->where('status', 3);
    }
    public function users()
    {
        return $this->belongsTo(User::class, 'User_id');
    }
}
