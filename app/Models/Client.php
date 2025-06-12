<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{

       protected $fillable = [
        'name',
        'email',
        'adresse',
        'phone',
        'point_fidelite',
        'sucursalle_id',
        
    ];

    protected
 $primaryKey = 'client_id';
 public $incrementing = true;
protected $keyType = 'int';
}
