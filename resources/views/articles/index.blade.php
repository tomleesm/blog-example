
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
      const newArticleForm = $('.template.new-article').clone().removeClass('template').addClass('show');
      // 選取 div 容器，清空容器，再把表單加到容器內
      $('.container').empty().append(newArticleForm);
    });
    $('.container').on('submit', '.new-article.show > form', function ( event ) {
        event.preventDefault();
        const formValue = $(this).serializeArray();
        const requestBody = {
            "data":
            {
              "article":
              {
                "title": formValue[1].value,
                "body": formValue[2].value
              }
            }
        };
        $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        const ajaxOption = {
            method: 'POST',
            url: 'http://127.0.0.1:8000/articles',
            contentType: 'application/json; charset=UTF-8',
            dataType: 'json',
            // JSON.stringify(): JSON 物件要轉成字串才能傳送
            data: JSON.stringify(requestBody),
            success: function ( data ) {
                console.log( 'success' )
                console.log( data )
            },
            error: function ( data ) {
                console.log( 'error' )
                console.log( data )
            }
        };
        $.ajax(ajaxOption);
    });
  </script>
</html>
