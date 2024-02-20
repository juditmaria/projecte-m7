<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TokenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function user(Request $request)
    {
        $user = User::where('email', $request->user()->email)->first();
        
        return response()->json([
            "success" => true,
            "user"    => $request->user(),
            "roles"   => [$user->role->name],
        ]);
    }

    public function register(Request $request)
    {
        // Llamar al método setUpBeforeClass del TokenTest para inicializar el usuario de prueba
        TokenTest::setUpBeforeClass();

        // Obtener el usuario de prueba del TokenTest
        $testUser = TokenTest::$testUser;

        // Validar la solicitud
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        // Crear un token para el usuario recién registrado
        $token = $testUser->createToken('authToken')->plainTextToken;

        // Devolver la respuesta JSON con el token generado y el estado de éxito
        return response()->json([
            'success' => true,
            'authToken' => $token,
            'tokenType' => 'Bearer',
        ], 201);
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
