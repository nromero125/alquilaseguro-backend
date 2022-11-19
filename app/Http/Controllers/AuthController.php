<?php

namespace App\Http\Controllers;

use App\Enums\UserTypes;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->with('owner', 'broker', 'tenant.property')->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Email o contraseña incorrectos.'],
            ]);
        }

        if ($user->status == false) {
            return response()->json(['message' => 'Usuario inactivo, por favor contacte al administrador.'], 401);
        }

        if($user->user_type == UserTypes::ADMIN) {
            return response()->json(['message' => 'Usuario equivocado.'], 401);
        }

        return response()->json(['token' => $user->createToken($request->email)->plainTextToken, 'user' => $user]);
    }

    public function logout(Request $request)
    {
        $request->user('api')->currentAccessToken()->delete();

        return response()->json(['message' => 'Desconectado correctamente.']);
    }

    public function sendResetPassword(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $token = hash_hmac('sha256', Str::random(40), env('APP_KEY'));

            DB::table('password_resets')->insert([
                'email' => $request->email,
                'token' => bcrypt($token),
                'created_at' => Carbon::now(),
            ]);

            $user->sendPasswordResetNotification($token);

            return response()->json([
                'message' => 'Correo de reseteo de contraseña enviado.',
                'success' => true,
            ]);
        }

        return response()->json([
            'message' => 'No se ha encontrado un usuario con esa dirección de correo.',
            'success' => false,
        ]);
    }
}
