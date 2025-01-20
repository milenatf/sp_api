<?php

namespace App\Models\Post;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasUuids;

    protected $fillable = [
        'created_by',
        'title',
        'news',
        'news_type',
        'category',
        'tags',
        'updated_by',
        'post_url',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}

