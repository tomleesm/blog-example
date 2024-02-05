@extends('layouts.application')

@section('content')
<h1>{{ $article->title }}</h1>

<p>{{ $article->body }}</p>

<ul>
  <li><a href="{{ route('articles.edit', ['article' => $article->id]) }}">Edit</a></li>
  <li><a data-turbo-method="delete"
         data-turbo-confirm="Are you sure?"
         href="{{ route('articles.destroy', ['article' => $article->id]) }}">Destroy</a></li>
</ul>

<h2>Comments</h2>
@each('comments.comment', $article->comments, 'comment')

<h2>Add a comment:</h2>
@include('comments.form')

@endsection
