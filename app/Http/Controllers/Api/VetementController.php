<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\DepotRequest;
use App\Http\Requests\VetementRequest;
use App\Http\Requests\VetUpdateRequest;
use App\Models\Depot;
use App\Models\Vetement;
use Illuminate\Http\Request;

class VetementController
{

        public function index(Request $request, $depot_id)
    {
      try{
          $vetement = Vetement::all()->where("depot_id", $depot_id)->all();
          if($vetement){
             return response()->json([
            "statut_code"=> "200",
            "vetement"=> $vetement
        ]);
          }else{
              return response()->json([
            'status_message' => "Aucun vetement touver"
         ]);
          }
       
      }catch(\Exception $e){
            return response()->json([
                "error"=> $e->getMessage()
                ],402);
        }

    }

    public function register(VetementRequest $request)
    {
        $user = auth()->user();
        try {

            $vetement = new Vetement();

            $vetement->type = $request->type;
            $vetement->marque = $request->marque;
            $vetement->couleur = $request->couleur;
            $vetement->quantite = $request->quantite;
            $vetement->p_u = $request->p_u;
            $vetement->depot_id = $request->depot_id;
            $vetement->sucursalle_id = $user->sucursalle_id;

            $vetement->save();

          return response()->json([
        'status_code'=> '200',
        'status_message' => 'Vetement enregistrer avec succès',
        'vetement'=> $vetement
        ]);
        }catch(\Exception $e){
            return response()->json([
                "error"=> $e->getMessage()
                ],402);
        }
    }

    public function update(VetUpdateRequest $request, $vetement_id)
    {
       try{
        $vetement =  Vetement::find($vetement_id);

        if($vetement){
            $vetement->update([
                "type"=> $request->type,
                "marque"=> $request->marque,
                "couleur"=> $request->couleur,
                "quantite"=> $request->quantite,
                "p_u"=> $request->p_u,
            ]);
        return response()->json([
        'status_code'=> '200',
        'status_message' => 'Vetement modifier avec succès',
        'vetement'=> $vetement
        ]);
        
        }else{
         return response()->json([
            'error' => "le vetement est introuvable"
         ]);
        
        }

       }catch(\Exception $e){
            return response()->json([
                "error"=> $e->getMessage()
                ],402);
        }
    }



}
