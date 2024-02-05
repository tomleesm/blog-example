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
@foreach($article->comments as $comment)
  <p>
    <strong>Commenter:</strong>
    {{ $comment->commenter }}
  </p>

  <p>
    <strong>Comment:</strong>
    {{ $comment->body }}
  </p>
@endforeach

<h2>Add a comment:</h2>
<form action="{{ route('articles.comments.store', ['article' => $article->id]) }}" accept-charset="UTF-8" method="post">
    <p>
      <label for="comment_commenter">Commenter</label><br>
      <input type="text" name="comment[commenter]" id="comment_commenter">
    </p>
    <p>
      <label for="comment_body">Body</label><br>
      <textarea name="comment[body]" id="comment_body"></textarea>
    </p>
    <p>
      <input type="submit" name="commit" value="Create Comment" data-disable-with="Create Comment">
    </p>
  </form>

@endsection
