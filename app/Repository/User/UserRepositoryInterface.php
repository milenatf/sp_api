<?php

namespace App\Repository\User;

use App\DTO\User\StoreUserDTO;
use App\DTO\User\UpdateUserDTO;
use App\Models\User;

interface UserRepositoryInterface
{
    public function findById(string $user_id): User|null;
    public function findByEmail(string $email): User|null;
    public function store(StoreUserDTO $dto): User|null;
    public function update(UpdateUserDTO $dto): User|null;
}
