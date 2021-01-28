<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

use Auth;

use Hash;

use Laravel\Passport\TokenRepository;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->all();

        if (Auth::attempt($data)) {

            $user = Auth::user();

            return response()->json([
                'message' => 'Login exitoso',
                'token' => $user->createToken('authToken')->accessToken,
                'status' => 200
            ], 200);
        } else {
            return response()->json([
                'message' => 'Las credenciales son incorrectas',
                'status' => 401
            ], 401);
        }
    }

    public function register(Request $request)
    {
        $data = $request->all();

        $user = User::create([
            'email' => $data['email'],
            'name' => $data['name'],
            'password' => Hash::make($data['password']),
        ]);

        return response()->json([
            'message' => 'Usuario registrado con éxito',
            'token' => $user->createToken('authToken')->accessToken,
            'status' => 200
        ], 200);
    }

    // una vez cada x tiempo hay que dejar un scheduled job para que purgue a todos los tokens revocados
    // https://laravel.com/docs/8.x/passport#purging-tokens
    public function logout(Request $request)
    {
        $tokenRepository = app(TokenRepository::class);

        $tokenRepository->revokeAccessToken($request->user()->token()->id);

        return response()->json([
            'message' => 'Sesión cerrada exitosamente'
        ], 200);
    }

    public function algo()
    {
        return response()->json([
            'message' => 'algo'
        ], 200);
    }
}
