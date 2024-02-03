@extends('layouts.application')

@section('content')
<h1>Edit Article</h1>

<form action="{{ route('articles.update', ['article' => $article->id]) }}" accept-charset="UTF-8" method="post">
    @csrf
    @method('put')
    
    <div>
      <label for="article_title">Title</label><br>
      <input type="text" name="article[title]" id="article_title" value="{{ old('article.title') }}">
      @foreach($errors->get('article.title') as $message)
        <div>{{ $message }}</div>
      @endforeach
    </div>
  
    <div>
      <label for="article_body">Body</label><br>
      <textarea name="article[body]" id="article_body">{{ old('article.body') }}</textarea><br>
      @foreach($errors->get('article.body') as $message)
        <div>{{ $message }}</div>
      @endforeach
    </div>

    <div>
      <input type="submit" name="commit" value="Create Article" data-disable-with="Create Article">
    </div>
</form>
@endsection