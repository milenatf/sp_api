<?php

namespace App\DTO\Post;

use App\Http\Requests\Post\StorePostRequest;

class StorePostDTO {
    public function __construct(
        public string $title,
        public string $news,
        public string $news_type,
        public string $category,
        public string $tags,
        public string $post_url,
    ) {}

    public static function makeFromRequest(StorePostRequest $request): self
    {
        return new self(
            $request->title,
            $request->news,
            $request->news_type,
            $request->category,
            $request->tags,
            $request->post_url,
        );
    }
}
