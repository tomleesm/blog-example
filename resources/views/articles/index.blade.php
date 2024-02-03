@extends('layouts.application')

@section('content')
<h1>Articles</h1>

<ul>
  @foreach($articles as $article)
    <li>
      <a href="{{ route('articles.show', ['article' => $article->id]) }}">
        {{ $article->title }}
      </a>
    </li>
  @endforeach
</ul>

<a href="{{ route('articles.create') }}">New Article</a>
@endsection