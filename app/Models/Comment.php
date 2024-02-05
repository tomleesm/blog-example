<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Article;
use App\Concerns\Visible;

class Comment extends Model
{
    use HasFactory;
    use Visible;

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
