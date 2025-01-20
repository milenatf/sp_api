<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\EmailRequest;
use App\Http\Requests\Auth\PasswordResetRequest;
use App\Services\NotificationService;
use App\Services\User\UserService;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    public function __construct(
        private UserService $userService,
        private NotificationService $notificationService
    ) { }
    public function sendPasswordResetLink(EmailRequest $request)
    {
        // $user = $this->userService->findByEmail($request->email);

        // if (!$user) {
        //     return response()->json([
        //         'status' => 'failed',
        //         'message' => 'Email não encontrado.'
        //     ], 404);
        // }

        // Send notification to the user's email
        $status = Password::sendResetLink($request->only('email'));

        // if ($status === Password::RESET_LINK_SENT) {
        //     // Envia a notificação usando o NotificationService
        //     $token = Password::getRepository()->create($user); // Gera o token manualmente
        //     $this->notificationService->sendPasswordResetEmail($user, $token);

        //     return response()->json(['message' => __('passwords.sent')]);
        // }

        return $status === Password::RESET_LINK_SENT
            ? response()->json(['message' => __($status)])
            : response()->json([
                'status' => 'failed',
                'message' => __($status)
            ], 422);
    }

    public function passwordReset(PasswordResetRequest $request)
    {
        dd($request->all());
    }
}
