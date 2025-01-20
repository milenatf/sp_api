<?php

namespace App\DTO\User;

use App\Http\Requests\User\StoreUserRequest;
use Illuminate\Support\Facades\Hash;

class StoreUserDTO {
    public function __construct(
        public string $nome,
        public string $cpf,
        public string $email,
        public string $role,
        public ?string $owner_id,
        public ?string $password,
    ) {}

    public static function makeFromRequest(StoreUserRequest $request): self
    {
        return new self(
            $request->nome,
            $request->cpf,
            $request->email,
            $request->role,
            $request->owner_id,
            Hash::make($request->password)
        );
    }
}
