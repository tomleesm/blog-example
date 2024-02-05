@extends('layouts.application')

@section('content')
<h1>Articles</h1>

@php
use App\Models\Article;
@endphp

Our blog has {{ Article::publicCount() }} articles and counting!

<ul>
  @foreach($articles as $article)
    @unless($article->isArchived())
      <li>
        <a href="{{ route('articles.show', ['article' => $article->id]) }}">
          {{ $article->title }}
        </a>
      </li>
    @endunless
  @endforeach
</ul>

<a href="{{ route('articles.create') }}">New Article</a>
@endsection
