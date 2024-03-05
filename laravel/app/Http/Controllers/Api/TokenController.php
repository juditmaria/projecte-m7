<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Api\TokenTest;

class TokenController extends Controller
{
    public function user(Request $request)
    {
        $user = User::where('email', $request->user()->email)->first();
        
        return response()->json([
            "success" => true,
            "user"    => [
                "id"         => $user->id,
                "name"       => $user->name,
                "email"      => $user->email,
                "created_at" => $user->created_at,
                "updated_at" => $user->updated_at,
            ],
            "roles"   => [$user->role->name],
        ]);
    }
    

    public function register(Request $request)
    {
        // Validar la solicitud
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);
    
        // Crear el usuario de prueba
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password), // Asegúrate de encriptar la contraseña
        ]);
        
        // Guardar el usuario en la base de datos
        $user->save();
    
        // Crear un token para el usuario recién registrado
        $token = $user->createToken('authToken')->plainTextToken;
    
        // Devolver la respuesta JSON con el token generado y el estado de éxito
        return response()->json([
            'success' => true,
            'authToken' => $token,
            'tokenType' => 'Bearer',
        ]);
    }
    
        

   public function login(Request $request)
   {
       $credentials = $request->validate([
           'email'     => 'required|email',
           'password'  => 'required',
       ]);
       if (Auth::attempt($credentials)) {
           // Get user
           $user = User::where([
               ["email", "=", $credentials["email"]]
           ])->firstOrFail();
           // Revoke all old tokens
           $user->tokens()->delete();
           // Generate new token
           $token = $user->createToken("authToken")->plainTextToken;
           // Token response
           return response()->json([
               "success"   => true,
               "authToken" => $token,
               "tokenType" => "Bearer"
           ], 200);
       } else {
           return response()->json([
               "success" => false,
               "message" => "Invalid login credentials"
           ], 401);
       }
   }

   public function logout(Request $request)
   {
       $request->user()->currentAccessToken()->delete();

       return response()->json([
           'success' => true,
           'message' => 'Logged out successfully',
       ]);
   }
}
