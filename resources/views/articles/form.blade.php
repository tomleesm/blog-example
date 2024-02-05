@php
if(isset($article)) {
    $route_name = 'articles.update';
    $route_parameter = ['article' => $article->id];
    $method = 'PUT';
    $article_title = $article->title;
    $article_body = $article->body;
    $button = 'Update';
} else {
    $route_name = 'articles.store';
    $route_parameter = [];
    $method = 'POST';
    $article_title = '';
    $article_body = '';
    $button = 'Create';
}
@endphp

<form action="{{ route($route_name, $route_parameter) }}" accept-charset="UTF-8" method="post">
    @csrf
    @method($method)

    <div>
      <label for="article_title">Title</label><br>
      <input type="text" name="article[title]" id="article_title" value="{{ old('article.title', $article_title) }}">
      @foreach($errors->get('article.title') as $message)
        <div>{{ $message }}</div>
      @endforeach
    </div>

    <div>
      <label for="article_body">Body</label><br>
      <textarea name="article[body]" id="article_body">{{ old('article.body', $article_body) }}</textarea><br>
      @foreach($errors->get('article.body') as $message)
        <div>{{ $message }}</div>
      @endforeach
    </div>

    <div>
      <label for="article_status">Status</label><br>
      <select name="article[status]" id="article_status">
        <option selected="selected" value="public">public</option>
        <option value="private">private</option>
        <option value="archived">archived</option>
      </select>
    </div>

    <div>
      <input type="submit" name="commit" value="{{ $button }} Article" data-disable-with="{{ $button }} Article">
    </div>
</form>
