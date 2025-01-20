<?php

namespace App\Http\Controllers\Api\Posts;

use App\DTO\Post\StorePostDTO;
use App\DTO\Post\UpdatePostDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Http\Resources\Post\PostResource;
use App\Services\Post\PostService;

class PostController extends Controller
{
    public function __construct(
        protected PostService $service
    ){}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = $this->service->getAll();

        if(!$posts) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Não há notícias publicadas.'
            ], 404);
        }

        return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        if( !$newPost = $this->service->store(StorePostDTO::makeFromRequest($request)) ) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Não foi possível cadastrar a publicação.'
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Publicação cadastrada com sucesso.',
            'identify' => $newPost
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = $this->service->getById($id);

        if(!$post) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Publicação nao encontrada.'
            ], 404);
        }

        return response()->json(['data' => $post], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, string $id)
    {
        $post = $this->service->update($id, UpdatePostDTO::makeFromRequest($request));

        if( $post === null ) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Notícia não encontrada.'
            ], 404);
        }

        if( $post === false ) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Não foi possível alterar a noticia.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Notícia alterada com sucesso.',
            'data' => $post
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
