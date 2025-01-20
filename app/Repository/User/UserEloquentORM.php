<?php

namespace App\Repository\User;

use App\DTO\User\StoreUserDTO;
use App\DTO\User\UpdateUserDTO;

use App\Models\User;
use App\Repository\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class UserEloquentORM implements UserRepositoryInterface
{
    public function __construct(
        protected User $model
    ){

    }

    public function findById(string $user_id): User|null
    {
        $user = $this->model->where('id', $user_id)->first();

        if(!$user) return null;

        return $user;
    }

    public function findByEmail(string $email): User|null
    {
        $user = $this->model->where('email', $email)->first();

        if(!$user)return null;

        return $user;
    }

    public function store(StoreUserDTO $dto): User|null
    {
        $data = get_object_vars($dto);

        $newUser = $this->model->create($data);

        if(!$newUser) return null;

        return (object) $newUser;
    }

    public function update(UpdateUserDTO $dto): User|null
    {
        if(!$user = $this->findById(Auth::user()->id)) return null;

        $user->update((array) $dto);

        return $user;
    }

}