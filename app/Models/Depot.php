<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Depot extends Model
{
     protected $fillable = [
       
        'client_id',
        'sucursalle_id',
        
    ];

    protected $primaryKey = 'depot_id';

    // hasMany indique qu’un dépôt possède plusieurs vêtements.
      public function vetements()
    {
        return $this->hasMany(Vetement::class, 'depot_id', 'depot_id');
    }

// Cette méthode permet d’accéder directement au client lié à un dépôt grâce à la clé étrangère client_id.
    public function client()
{
    return $this->belongsTo(\App\Models\Client::class, 'client_id', 'client_id');
}
}
