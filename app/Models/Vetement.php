<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vetement extends Model
{
       protected $fillable = [
        'type',
        'marque',
        'couleur',
        'quantite',
        'p_u',
        'depot_id',
        'sucursalle_id'
        
    ];

    // belongsTo indique que chaque enregistrement du modèle courant (ex : un vêtement) appartient à un dépôt.
     public function depot()
    {
        return $this->belongsTo(Depot::class, 'depot_id', 'depot_id');
    }

    protected
     $primaryKey = 'vetement_id';
}
