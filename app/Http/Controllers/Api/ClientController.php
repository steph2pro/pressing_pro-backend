<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests\ClientRequest;
use App\Models\Client;

class ClientController
{
    public function index(Request $request)
    {
        try{

         $query = Client::query();
         $perPage = '10';
         $page = $request->input('page',1); // recupere la page sur laquelle l'utilisateur est actuellement ou qu'il souhaite se rendre.
      
         $totale = $query->count();

         $resultat = $query->offset(($page -1) * $perPage)->limit($perPage)->get();

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

    public function register(ClientRequest $request)
    {
        $user = auth()->user();

        try {
        $client = new Client();

        $client->name = $request->name;
        $client->email = $request->email;
        $client->adresse = $request->adresse;
        $client->phone = $request->phone;
        $client->point_fidelite = $request->point_fidelite;
        $client->sucursalle_id = $request->sucursalle_id;
        $client->save();

          return response()->json([
        'status_code'=> '200',
        'status_message' => 'Client enregistrer avec succès',
        
        ]);

        }catch(\Exception $e){
            return response()->json([
                "error"=> $e->getMessage()
                ],402);
        }
    }


    public function update(ClientRequest $request, $client_id)
    {
        try{

   $client =  Client::find($client_id);

        if($client){
            $client->update([
                "name"=> $request->name,
                "email"=> $request->email,
                "adresse"=> $request->adresse,
                "phone"=> $request->phone,
                "point_fidelite"=> $request->point_fidelite
                ]);

         return response()->json([
        'status_code'=> '200',
        'status_message' => 'Client modifier avec succès',
        
        ]);
        
        }else{
         return response()->json([
            'error' => "le client est introuvable"
         ]);
        }
        }catch(\Exception $e){
            return response()->json([
                "error"=> $e->getMessage()
                ],402);
        }
     
    }

    public function delete($client_id){

        try{
        $client =  Client::find($client_id);

        if($client){
            $client->delete();
        return response()->json([
        'status_code'=> '200',
        'status_message' => 'Client supprimer avec succès',
        
        ]);
        }else{
             return response()->json([
            'error' => "le client est introuvable"
         ]);
        }
        }catch(\Exception $e){
            return response()->json([
                "error"=> $e->getMessage()
                ],402);
        }
    }
}
