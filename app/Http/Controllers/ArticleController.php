<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreArticleRequest;
use App\Models\Article;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::get();

        $articleObjectList = [];
        foreach($articles as $article)
        {
            $articleObjectList[] = [
                'article' =>
                    [
                        'id' => $article->id,
                        'title' => $article->title,
                    ]
            ];
        }

        return ['data' => $articleObjectList ];
    }

    public function store(StoreArticleRequest $request)
    {
        $validated = $request->validated();

        $article = Article::create([
            'title' => $validated['data']['article']['title'],
            'body' => $validated['data']['article']['body']
        ]);

        return $this->articleToJSON($article);
    }

    public function show(Article $article)
    {
        return $this->articleToJSON($article);
    }

    private function articleToJSON(Article $article)
    {
        return [
            'data' => [
                'article' => [
                    'id' => $article->id,
                    'title' => $article->title,
                    'body' => $article->body
                ]
            ]
        ];
    }
}
