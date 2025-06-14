<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\LogUserRequest;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterUser;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Models\admin;
use Laravel\Sanctum\PersonalAccessToken;

class UserController
{
    public function register(UserRequest $request){
        try{

          if($request->profil == "admin"){
            $admin = new admin();

        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->profil = $request->profil;
        $admin->adresse = $request->adresse;
        $admin->phone = $request->phone;
        $admin->password = bcrypt($request->password);
        $admin->save();

          return response()->json([
        'status_code'=> '200',
        'status_message' => 'Utilisateur (admin) enregistrer avec succès',
        
      
       ]);
          }
      elseif( $request->profil == "user"){


        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->profil = $request->profil;
        $user->adresse = $request->adresse;
        $user->phone = $request->phone;
        $user->sucursalle_id = $request->sucursalle_id;
        $user->password = bcrypt($request->password);
        $user->save();

          return response()->json([
        'status_code'=> '200',
        'status_message' => 'Utilisateur enregistrer avec succès',
        
      
       ]);
}

       

        }catch(\Exception $e){
            return response()->json([
                "error"=> $e->getMessage()
                ],402);
        }
       
    }



    public function login(LogUserRequest $request){
        try{
             $admin = admin::where('email', $request->email)->first();

              //verifier si l'utilisateur existe et que le mot de passe est correct
            if(auth('web')->attempt($request->only(["email","password"]))){
              // si l'utilisateur existe, on le recupere
                $user = auth('web')->user();
                  //  on creer un token pour l'utilisateur pour les futures requetes
                 $token = $user->createToken("MA_CLEE_SECRETE_VISIBLE_AU_BACKEND")->plainTextToken;
             
                return response()->json([
                        "status_code" => "200",
                        "status_message" => "Utilisateur connecté.",
                        "token" => $token,
                    //     "sucursalle" => $sucursalle 
                        ],200); 

            }elseif($admin){
               
                $passAdmin = $admin && \Hash::check($request->password, $admin->password);
                if($passAdmin){
                 $token = $admin->createToken("MA_CLEE_SECRETE_VISIBLE_AU_BACKEND")->plainTextToken;
                }else{
                    return response()->json([
                        "error"=> "mot de passe incorrecte."
                        ],402);
                }
            return response()->json([
                "status_code" => "200",
                "status_message" => "Admin connecté.",
                "token" => $token,
            ], 200);
            
                    
                }else{
                    return response()->json([
                        "error"=> "true",
                        "status_code" => "403",
                        "status_message" => "Les informations founis sont incorrectes."

                        ]);
                }
        
        }catch(\Exception $e){
            return response()->json([
                "error"=> $e->getMessage()
                ],500);
            }
        }



public function update(UpdateUserRequest $request, $id){

    // Récupère le token envoyé dans l'en-tête Authorization
        $accessToken = request()->bearerToken();
        $token = PersonalAccessToken::findToken($accessToken);

        // Récupère l'admin lié à ce token
        $admin = null;
        if ($token && $token->tokenable_type === admin::class) {
            $admin = admin::find($token->tokenable_id);
        }

          // si la valeur de $admin est # de null alors l'admin existe 

     //   $adminToUpdate = admin::find($id);
      //  $verification =  $admin->admin_id === $adminToUpdate->admin_id;
 
     if($request->profil == "admin" && $admin != null){

 
    $adminn = new admin()::find($id);
    
    $adminn->name = request('name');
     $adminn->email = request('email');
     $adminn->profil = request('profil');
     $adminn->adresse = request('adresse');
     $adminn->phone = request('phone');
     $adminn->password = bcrypt($request->password) ;

         $adminn->save();
     return response()->json([
        'message'=> 'modification Admin effectuer',
        'statut_code' => '200',
       
        ]);

     } elseif($request->profil == "admin" && $admin == null) {
 return response()->json([
        'message'=> 'vous ne ne pouvez pas effectuer ces modifications sur admin',
         ]);
     }

     elseif($request->profil == 'user' && $admin != null){

            // ... (modifie les champs de la table user)
    $user = new User()::find($id);
    
    $user->name = request('name');
     $user->email = request('email');
     $user->profil = request('profil');
     $user->adresse = request('adresse');
     $user->phone = request('phone');
     $user->password = bcrypt($request->password) ;


         $user->save();
     return response()->json([
        'statut_code' => '200',
        'message'=> 'modification User effectuer',
       
        ]);
    }
      elseif($request->profil == "user" && $admin == null) {
 return response()->json([
        'message'=> 'vous ne ne pouvez pas effectuer ces modifications ',
         ]);
     }
}

public function delete($id)    {

    
    // Récupère le token envoyé dans l'en-tête Authorization
        $accessToken = request()->bearerToken();
        $token = PersonalAccessToken::findToken($accessToken);

        // Récupère l'admin lié à ce token
        $admin = null;
        if ($token && $token->tokenable_type === admin::class) {
            $admin = admin::find($token->tokenable_id);
        }
    // si la valeur de $admin est # de null alors l'admin existe 
       
       try {
        $user = User::find($id);
     //   dd($verification);
        if ($user && $admin != null) {
         $user->delete();
        return response()->json([
            'status_code'=> 200,
            'message'=> 'Utilisateur supprimé avec succès',
            'user_id' => $user->user_id,
        ]);
        }
         return response()->json([
                'status_code' => 404,
                'message' => 'Utilisateur non trouvé',
            ], 404);
        
    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage()
        ], 500);
    }
   
      
    }
}
