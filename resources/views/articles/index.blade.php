@extends('layouts.application')

@section('content')
<h1>Articles</h1>

<ul>
  @foreach($articles as $article)
    <li>
      {{ $article->title }}
    </li>
  @endforeach
</ul>
@endsection