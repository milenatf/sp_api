<?php

namespace App\Http\Controllers\Api\Register;

use App\DTO\User\StoreUserDTO;
use App\DTO\User\UpdateUserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\User\UserResource;
use App\Services\User\UserService;
use App\Models\User;
use App\Services\NotificationService;
use App\Services\Auth\EmailVerificationService;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct(
        protected EmailVerificationService $emailVerificationservice,
        private User $user,
        protected UserService $service
    ) { }

    public function create(StoreUserRequest $request)
    {
        $roleLoggedUser = Auth::user()->role;

        if($roleLoggedUser !== 'Master' && $roleLoggedUser !== 'Admin') {
            return response()->json([
                'status' => 'failed',
                'message' => 'Você não tem permissão para realizar esta ação.'
            ]);
        }

        $newUserRole = $roleLoggedUser === 'Master' ? 'Admin' : 'Operador';

        $request['role'] = $newUserRole;
        $request['owner_id'] = Auth::user()->id;
        $request['password'] = $this->service->generateTemporaryPassword();

        if($roleLoggedUser === 'Admin') $request['admin_id'] = Auth::user()->id;

        if( !$newUser = $this->service->store(StoreUserDTO::makeFromRequest($request)) ) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Não foi possível adicionar o usuário.'
            ], 500);
        }

        $this->emailVerificationservice->emailVerificationHandler($newUser, $request->password);

        return response()->json([
            'status' => 'success',
            'message' => 'Usuário cadastrado com sucesso. Uma mensagem de verificação foi enviada para o e-mail informado.',
            'identify' => $newUser->id
        ], 201);
    }

    public function show(string $identify)
    {
        if(!$user = $this->service->findById($identify)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Usuário não encontrado.'
            ], 404);
        }

        return new UserResource($user);
    }

    public function update(UpdateUserRequest $request)
    {
        if(!$this->service->update(UpdateUserDTO::makeFromRequest($request))) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Usuário não encontrado.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Atualização realizada com  successo.',
        ], 200);
    }
}
