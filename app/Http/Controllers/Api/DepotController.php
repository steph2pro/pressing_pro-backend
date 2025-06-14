<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\DepotRequest;
use App\Models\Depot;
use Illuminate\Http\Request;

class DepotController
{

 public function index(Request $request)
    {
        try{

                   // On charge la relation client pour chaque dépôt
       $depots = Depot::query()->with(['client:client_id,name,phone'])->get();

        // On formate la réponse pour inclure nom et phone du client
       $depots = $depots->map(function($depot) {
        return [
            'depot_id' => $depot->depot_id,
            'client_id' => $depot->client_id,
            'sucursalle_id' => $depot->sucursalle_id,
            'client_name' => $depot->client->name ?? null,
            'client_phone' => $depot->client->phone ?? null,
             'created_at' => $depot->created_at,
            'updated_at' => $depot->updated_at,
        ];
    });


       // $query = Depot::query();
         $perPage = '10';
         $page = $request->input('page',1); // recupere la page sur laquelle l'utilisateur est actuellement ou qu'il souhaite se rendre.
      
         $totale = $depots->count();

         $resultat = $depots->forPage($page, $perPage)->values();

             return response()->json([
             "statut_code"=> "200",
             'current_page' => $page,
             'PerPage' => $perPage,
            'total_page'=> ceil($totale / $perPage),
            'items'=> $resultat,
           
        ]);

        }catch(\Exception $e){
            return response()->json([
                "error"=> $e->getMessage()
                ],402);
        }
  
       

    }

    public function register(DepotRequest $request)
    {
        $user = auth()->user();

        try {

            $depot = new Depot();

            $depot->client_id  = $request->client_id;
            $depot->sucursalle_id = $request->sucursalle_id;
            
            $depot->save();

          return response()->json([
        'status_code'=> '200',
        'status_message' => 'Depot créer avec succès',
        
        ]);

        }catch(\Exception $e){
            return response()->json([
                "error"=> $e->getMessage()
                ],402);
        }
    }


    public function delete($depot_id){

        try{
        $depot =  Depot::find($depot_id);

        if($depot){
            $depot->delete();
        return response()->json([
        'status_code'=> '200',
        'status_message' => 'Depot supprimer avec succès',
        
        ]);
        }else{
             return response()->json([
            'error' => "le depot est introuvable"
         ]);
        }
        }catch(\Exception $e){
            return response()->json([
                "error"=> $e->getMessage()
                ],402);
        }
    }
}
