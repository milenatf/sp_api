<?php

namespace App\Http\Resources\Post;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /**
         * app()->make('App\Services\User\UserService') Injeta o service UserService uma vez que o laravel
         * não usa injeção de dependencia para o construtor de um JsonRsource
         * */
        return [
            'id' => $this->id,
            'autor' => $this->user->nome,
            'title' => $this->title,
            'news' => $this->news,
            'news_type' => $this->news_type,
            'category' => $this->category,
            'tags' => $this->tags,
            'last_update_by' =>
                $this->updated_by <> null
                ? app()->make('App\Services\User\UserService')->findById($this->updated_by)->nome
                : $this->updated_by,
            'post_url' => $this->post_url,
            'created_at' => Carbon::parse($this->created_at)->format('d/m/Y H:m'),
            'last_updated' => $this->updated_at ? Carbon::parse($this->updated_at)->format('d/m/Y H:m') : null
        ];
    }
}
