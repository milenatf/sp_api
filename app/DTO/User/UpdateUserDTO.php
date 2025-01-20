<?php

namespace App\DTO\User;

use App\Http\Requests\User\UpdateUserRequest;

class UpdateUserDTO {
    public function __construct(
        public string $nome,
        public string $cpf,
        public string $email,
    ) {}

    public static function makeFromRequest(UpdateUserRequest $request): self
    {
        return new self(
            $request->nome,
            $request->cpf,
            $request->email,
        );
    }
}
