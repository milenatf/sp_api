<?php

namespace App\Repository\Post;

use App\DTO\Post\StorePostDTO;
use App\DTO\Post\UpdatePostDTO;
use App\Models\Post\Post;
use App\Repository\Post\PostRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class PostEloquentORM implements PostRepositoryInterface
{
    public function __construct(
        protected Post $model
    ){

    }

    public function getAll(): LengthAwarePaginator|null
    {
        $post = $this->model->with('user')->paginate(10);

        return $post;

    }

    public function getById(string $id): Post|null
    {
        $post = $this->model->find($id);

        if(!$post) return null;

        return (object) $post;
    }

    public function store(StorePostDTO $dto): Post|null
    {
        $data = get_object_vars($dto);

        $data['created_by'] = Auth::user()->id;

        $newPost = $this->model->create($data);

        if(!$newPost) return null;

        return (object) $newPost;
    }

    public function update(string $id, UpdatePostDTO $dto): Post|bool|null
    {
        if(!$post = $this->getById($id)) return null;

        $data = get_object_vars($dto);
        $data['updated_by'] = Auth::user()->id;

        try{
            $post->update($data);

            return (object) $post;

        } catch (\Exception $e) {
            return false;
        }
    }
}