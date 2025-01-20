<?php
namespace App\Services\Post;

use App\DTO\Post\StorePostDTO;
use App\DTO\Post\UpdatePostDTO;
use App\Repository\Post\PostRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class PostService
{
    public function __construct(
        protected PostRepositoryInterface $repository,
    ){}

    public function getAll(): LengthAwarePaginator|null
    {
        return $this->repository->getAll();
    }

    public function getById(string $id): object|null
    {
        return $this->repository->getById($id);
    }

    public function store(StorePostDTO $dto): object|null
    {
        return $this->repository->store($dto);
    }

    public function update(string $id, UpdatePostDTO $dto): object|bool|null
    {
        return $this->repository->update($id, $dto);
    }
}