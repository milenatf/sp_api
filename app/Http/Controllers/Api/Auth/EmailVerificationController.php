<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\EmailRequest;
use App\Models\Auth\EmailVerification;
use App\Models\User;
use App\Services\Auth\EmailVerificationService;
use App\Services\NotificationService;
use App\Services\User\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EmailVerificationController extends Controller
{
    public function __construct (
        protected EmailVerification $model,
        private EmailVerificationService $service,
        protected NotificationService $notificationService,
        private User $user,
        private UserService $userService
    ) { }

    public function resendEmail(EmailRequest $request)
    {
        // dd($request);
        $user = $this->userService->findByEmail($request->email);

        if (!$user) {
            return response()->json([
                'status' => 'failed',
                'message' => "E-mail não encontrado."
            ], 404);
        }

        // Check if the user has already completed email verification
        if ($user->email_verified_at) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Este e-mail já foi verificado.'
            ], 200);
        }

        $emailVerify = $this->service->emailVerificationHandler($user, null);

        if(!$emailVerify) {
            return response()->json([
                'status' => 'failed',
                'message' => "Não foi possível enviar o link de verificação para o e-mail {$user->email}. Por favor, reenviar o link."
            ], 201);
        }

        return response()->json([
            'status' => 'success',
            'message' => "Um email de verificação foi enviado para {$user->email}. Por favor, verifique seu e-mail para ativar sua conta."
        ], 200);
    }

    public function verify(Request $request)
    {
        $emailVerification = $this->service->getByToken($request->segment(2));

        if (!$emailVerification) {
            return response()->json([
                'status' => 'failed',
                'message' => 'O link de verificação não é válido.'
            ]);
        }

        $user = $this->userService->findByEmail($emailVerification->email);

        if (!$emailVerification || $user->email_verified_at) {
            return response()->json([
                'status' => 'failed',
                'message' => "O e-mail {$user->email} já foi verificado."
            ]);
        }

        if (now()->greaterThan($emailVerification->expired_at)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'O link expirou.',
                'userEmail' => $user->email
            ]);
        }

        $user->email_verified_at = now();

        if (!$user->save()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Não foi possível realizar a verificação de e-mail.',
                'userEmail' => $user->email
            ]);
        }

        if(!$this->delete($user->email)) {
            // Se chegar aqui, significa o e-mail foi verificado, mas o registro não foi excluido da tabela email_verifications.
            Log::info('Nao foi possivel excluir o email de verificacao do usuario '.$user->email);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Verificação realizada com sucesso!'
        ]);
    }

    public function delete(string $email)
    {
        return $this->service->delete($email);
    }
}
