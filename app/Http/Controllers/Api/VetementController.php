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
          $query = Vetement::query()->where("depot_id", $depot_id);
         $perPage = '10';
         $page = $request->input('page',1); // recupere la page sur laquelle l'utilisateur est actuellement ou qu'il souhaite se rendre.
      
         $totale = $query->count();

         $resultat = $query->offset(($page -1) * $perPage)->limit($perPage)->get();


       //   $vetement = Vetement::all()->where("depot_id", $depot_id)->all();
          if($resultat->count() > 0){
             return response()->json([
             "statut_code"=> "200",
             'current_page' => $page,
             'PerPage' => $perPage,
            'total_page'=> ceil($totale / $perPage),
            'items'=> $resultat,
           
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
            $vetement->sucursalle_id = $request->sucursalle_id;
           

            $vetement->save();

          return response()->json([
        'status_code'=> '200',
        'status_message' => 'Vetement enregistrer avec succès',
        
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
