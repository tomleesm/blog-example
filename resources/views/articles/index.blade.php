
<!DOCTYPE html>
<html>
  <head>
    <title>Blog ajax</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
      .templates {
        display: none;
      }
    </style>
  </head>

  <body>
    <div class="container">
    <h1>Articles</h1>


Our blog has 0 articles and counting!
<ul> </ul>
<a href="#new-article" class="new-article-link">New Article</a>
    </div>

  <div class="templates">
    <div class="template new-article">
      <h1>New Article</h1>

      <form accept-charset="UTF-8" method="post">
        <input type="hidden" name="_method" value="POST">
        <div>
          <label for="article_title">Title</label><br>
          <input type="text" name="article[title]" id="article_title" value="">
        </div>

        <div>
          <label for="article_body">Body</label><br>
          <textarea name="article[body]" id="article_body"></textarea><br>
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
          <input type="submit" name="commit" value="Create Article" data-disable-with="Create Article">
        </div>
      </form>
    </div>
  </div>
  </body>
  @vite(['resources/js/app.js'])
  <script type="module">
    // 按下 New Article 時
    $('.new-article-link').on('click', function() {
      // 把表單複製後，刪除 class template，因為它不再位於 .templates 內
      const newArticleForm = $('.template.new-article').clone().removeClass('template');
      // 選取 div 容器，清空容器，再把表單加到容器內
      $('.container').empty().append(newArticleForm);
    });
  </script>
</html>
