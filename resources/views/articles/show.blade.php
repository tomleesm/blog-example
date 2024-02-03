@extends('layouts.application')

@section('content')
<h1>{{ $article->title }}</h1>

<p>{{ $article->body }}</p>

<ul>
  <li><a href="{{ route('articles.edit', ['article' => $article->id]) }}">Edit</a></li>
</ul>
@endsection