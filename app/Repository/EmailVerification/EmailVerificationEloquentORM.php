<?php

namespace App\Repository\EmailVerification;

use App\Models\Auth\EmailVerification;
use App\Repository\EmailVerification\EmailVerificationRepositoryInterface;

class EmailVerificationEloquentORM implements EmailVerificationRepositoryInterface
{
    public function __construct(
        protected EmailVerification $model
    ) { }

    public function getByToken(string $token): null|object
    {
        if(!$emailVerification = $this->model->where('token', $token)->first()) {
            return null;
        }

        return $emailVerification;
    }

    public function getByEmail(string $email): null|string
    {
        if(!$emailVerification = $this->model->where('email', $email)->first()) {
            return null;
        }

        return $emailVerification->email;
    }

    public function create(string $email, string $hash): bool
    {
        $data['email'] = $email;
        $data['token'] = $hash;
        $data['expired_at'] = now()->addMinutes(60);

        if(!$this->model->create($data)) {
            return false;
        }

        return true;
    }

    public function delete(string $email): bool
    {
        if(!$this->model->where('email', $email)->delete()) {
            return false;
        }

        return true;
    }
}