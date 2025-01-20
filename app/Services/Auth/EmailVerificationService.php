<?php

namespace App\Services\Auth;

use App\Repository\EmailVerification\EmailVerificationRepositoryInterface;
use App\Services\NotificationService;

class EmailVerificationService
{
    public function __construct(
        protected EmailVerificationRepositoryInterface $repository,
        protected NotificationService $notificationService
    ){}

    public function getByToken(string $token): null|object
    {
        return $this->repository->getByToken($token);
    }

    public function getByEmail(string $email): null|string
    {
        return $this->repository->getByEmail($email);
    }

    public function create($email, $hash)
    {
        return $this->repository->create($email, $hash);
    }

    public function delete(string $email)
    {
        return $this->repository->delete($email);
    }

    public function emailVerificationHandler(object $user, ?string $password): bool
    {
        if($this->getByEmail($user->email)) $this->delete($user->email);

        $hash = $this->notificationService->createHashForEmailVerification();
        $emailVerify =  $this->create($user->email, $hash);

        if(!$emailVerify) return false;

        $this->notificationService->sendEmailVerification($user, $hash, $password);

        return true;
    }
}