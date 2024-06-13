<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreArticleRequest;

class ArticleController extends Controller
{
    public function index()
    {
        return view('articles.index');
    }

    public function store(StoreArticleRequest $request)
    {
        $validated = $request->validated();
        return [ 'status' => 'OK' ];
    }
}
