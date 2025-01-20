<?php

namespace App\Repository\EmailVerification;

interface EmailVerificationRepositoryInterface
{
    public function getByToken(string $token): null|object;
    public function getByEmail(string $email): null|string;
    public function create(string $email, string $hash): bool;
    public function delete(string $email);
}
