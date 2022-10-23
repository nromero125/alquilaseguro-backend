<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\SendResetToken;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    protected function sendResetLinkResponse(Request $request)
    {
        $input = $request->only('email');
        $validator = Validator::make($input, [
            'email' => "required|email|exists:users",
        ]);
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }
        $token = Str::random(8);

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => bcrypt($token),
            'created_at' => Carbon::now(),
        ]);

        $user = User::where('email', $request->email)->first();
        $user->notify(new SendResetToken($token));

        $response = ['data' => '', 'message' => "Se ha enviado un correo con los datos para restablecer tu contraseña."];
        return response($response, 200);
    }
}
