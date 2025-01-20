<?php
namespace App\Services;

use App\Models\User;
use App\Notifications\SendEmailVerificationNotification;
use App\Notifications\SendPasswordResetNotification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class NotificationService
{
    public function createHashForEmailVerification()
    {
        return str_replace('/', '.', Hash::make(Str::random(256)));
    }

    public function sendEmailVerification(User $user, string $hash, ?string $password)
    {
        Notification::send($user, new SendEmailVerificationNotification($hash, $password));
    }

    public function sendPasswordResetEmail(User $user, string $token)
    {
        Notification::send($user, new SendPasswordResetNotification($token));
    }
}