<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.basic:,name')->except(['index', 'show']);
    }

    public function index()
    {
        $articles = Article::all();
        return view('articles.index', ['articles' => $articles]);
    }

    public function show($id)
    {
        $article = Article::find($id);
        return view('articles.show', ['article' => $article]);
    }

    public function create()
    {
        return view('articles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'article.title' => 'required',
            'article.body'  => 'required|min:10',
            'article.status' => 'in:public,private,archived'
        ]);

        $article = new Article();
        $article->title = $request->input('article.title');
        $article->body = $request->input('article.body');
        $article->status = $request->input('article.status');

        if ($article->save()) {
            return redirect()->route('articles.show', ['article' => $article->id]);
        } else {
            throw new \Exception('it can not store a new article');
        }
    }

    public function edit($id)
    {
        $article = Article::find($id);
        return view('articles.edit', ['article' => $article]);
    }

    public function update($id, Request $request)
    {
        $validated = $request->validate([
            'article.title' => 'required',
            'article.body'  => 'required|min:10',
            'article.status' => 'in:public,private,archived'
        ]);

        $article = Article::find($id);
        $article->title = $request->input('article.title');
        $article->body = $request->input('article.body');
        $article->status = $request->input('article.status');

        if ($article->save()) {
            return redirect()->route('articles.show', ['article' => $article->id]);
        } else {
            throw new \Exception('it can not store a new article');
        }
    }

    public function destroy($id)
    {
        $article = Article::find($id);
        $article->comments()->delete();
        $article->delete();

        return redirect()->route('home');
    }
}
