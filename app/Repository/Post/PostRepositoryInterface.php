<?php

namespace App\Repository\Post;

use App\DTO\Post\StorePostDTO;
use App\DTO\Post\UpdatePostDTO;
use App\Models\Post\Post;
use Illuminate\Pagination\LengthAwarePaginator;

interface PostRepositoryInterface
{
    public function getAll(): LengthAwarePaginator|null;
    public function getById(string $id): Post|null;
    public function store(StorePostDTO $dto): Post|null;
    public function update(string $id, UpdatePostDTO $dto): Post|bool|null;
}