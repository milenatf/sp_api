<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function signin(Request $request)
    {
        $user = $this->user->where('email', $request->email)->first();

        // When the user does not exist
        if(!$user) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Email not found.'
            ], 404);
        }

        // When the email has not yet been verified
        if(!$user->email_verified_at) {
            return response()->json([
                'status' => 'failed',
                'message' => ' Please check your email to activate your account.'
            ], 403);
        }

        // Incorrect credentials
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'The provided credentials are incorrect.'
            ], 401);

        }

        $user->tokens()->delete(); // Exclui todos os tokens do usuário.

        $token = $user->createToken($request->header('User-Agent'))->plainTextToken;

        // When login was successful
        return response()->json([
            'status' => 'success',
            'message' =>'Login realizado com sucesso.',
            'token' => $token
        ], 201);
    }

    public function me()
    {
        /** @var User $user */
        $me = auth()->user()->only(['nome', 'email']);


        return response()->json($me, 200);
    }

    public function logout()
    {
        /** @var User $user */
        $user = auth()->user();

        if(!$user->tokens()->delete()) {
            return response()->json([
                'status'=> 'failed',
                'message' => 'Não foi possível realizar o logout!'
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Logout realizado com sucesso.'
        ], 200);
    }
}
