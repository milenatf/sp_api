<?php

namespace App\Http\Resources\User;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'email' =>$this->email,
            'cpf' =>$this->cpf,
            'role' =>$this->role,
            'email_verified_at' => $this->email_verified_at ? Carbon::parse($this->email_verified_at)->format('d/m/Y H:m') : null
        ];
    }
}
