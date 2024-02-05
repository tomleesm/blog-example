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

