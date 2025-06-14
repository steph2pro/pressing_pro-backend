<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\createSucursalleRequest;
use Illuminate\Http\Request;
use App\Models\Sucursalle;
use App\Models\admin;
use Laravel\Sanctum\PersonalAccessToken;

class SucursalleController
{
    public function register(createSucursalleRequest $request)
    {
          $accessToken = request()->bearerToken();
        $token = PersonalAccessToken::findToken($accessToken);

        // Récupère l'admin lié à ce token
        $admin = null;
        if ($token && $token->tokenable_type === admin::class) {
            $admin = admin::find($token->tokenable_id);
        }
        try {


    if ($admin) {
            
        $sucursalle = new Sucursalle();

        $sucursalle->name = $request->name;
        $sucursalle->email = $request->email;
        $sucursalle->phone = $request->phone;
        $sucursalle->adresse = $request->adresse;
        $sucursalle->ville = $request->pays;
        $sucursalle->pays = $request->pays;
        $sucursalle->statut = $request->statut;
    

        $sucursalle->save();

        return response()->json([
        'status_code'=> '200',
        'status_message' => 'Sucursalle créer avec succès',
        
      
       ]);
    }
        }catch(\Exception $e){
            return response()->json([
                "error"=> $e->getMessage(),
                "message"=> "echec"
                ],401);
        }


    }
}
