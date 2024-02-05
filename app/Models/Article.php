<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comment;
use App\Concerns\Visible;

class Article extends Model
{
    use HasFactory;
    use Visible;

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
