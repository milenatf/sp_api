<?php

namespace App\Services\User;

use App\DTO\User\StoreUserDTO;
use App\DTO\User\UpdateUserDTO;
use App\Repository\User\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Str;

class UserService
{

    public function __construct(
        protected UserRepositoryInterface $repository,
    ){}

    public function findById(string $user_id): User|null
    {
        return $this->repository->findById($user_id);
    }

    public function findByEmail(string $email): User|null
    {
        return $this->repository->findByEmail($email);
    }

    public function store(StoreUserDTO $dto): User|null
    {
        return $this->repository->store($dto);
    }

    public function update(UpdateUserDTO $dto): User|null
    {
        return $this->repository->update($dto);
    }

    public function generateTemporaryPassword(): string
    {
        return Str::random(16);
    }
}