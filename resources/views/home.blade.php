
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
<ul class="article links"> </ul>
<a href="" class="new-article-link">New Article</a>
    </div>

  <div class="templates">
    <div class="template new-article">
      <h1>New Article</h1>

      <form accept-charset="UTF-8" method="post">
        <input type="hidden" name="_method" value="POST">
        <div>
          <label for="article_title">Title</label><br>
          <input type="text" name="article[title]" id="article_title" value="">
          <ul>
          </ul>
        </div>

        <div>
          <label for="article_body">Body</label><br>
          <textarea name="article[body]" id="article_body"></textarea>
          <ul>
          </ul>
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
    <div class="template article">
        <h1></h1>
        <p></p>
    </div>
  </div>
  </body>
  @vite(['resources/js/app.js'])
  <script type="module">
    const getArticle = function ( response ) {
        console.log( 'get an article' )
        const article = $('.template.article').clone().removeClass('template').addClass('show');
        article.children('h1').text(response.data.article.title);
        article.children('p').text(response.data.article.body)
        $('.container').empty().append(article);

        // 網址改成 /articles/123
        history.pushState(response, "", '/articles/' + response.data.article.id);
    }
    // 所有文章的連結
    $(document).ready(function () {
        const ajaxOption = {
            method: 'GET',
            url: 'http://127.0.0.1:8000/articles',
            contentType: 'application/json; charset=UTF-8',
            dataType: 'json',
            success: function ( response ) {
                console.log( 'success' )
                const articleLinks = $('.container > ul.article.links').empty();
                $.each(response.data, function (index, json) {
                   $('<li><a href="/articles/' + json.article.id + '">' + json.article.title + '</a></li>').appendTo(articleLinks);
                });
            },
            error: function ( data ) {
                console.log( 'error' )
            }
        };
        $.ajax(ajaxOption);
    });
    $('ul.article.links').on('click', 'a', function( event ) {
        event.preventDefault();
        const ajaxOption = {
            method: 'GET',
            url: $(this).attr('href'),
            contentType: 'application/json; charset=UTF-8',
            dataType: 'json',
            success: function (response) {
                getArticle(response)
            },
            error: function ( data ) {
                console.log( 'error' )
            }
        };
        $.ajax(ajaxOption);
    });
    // 按下 New Article 時
    $('.new-article-link').on('click', function() {
      event.preventDefault();
      // 把表單複製後，刪除 class template，因為它不再位於 .templates 內
      const newArticleForm = $('.template.new-article').clone().removeClass('template').addClass('show');
      // 選取 div 容器，清空容器，再把表單加到容器內
      $('.container').empty().append(newArticleForm);
      // 網址改成 /articles/create
      history.pushState({}, "", '/articles/create');
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
            success: function ( response ) {
                getArticle(response)
            },
            error: function ( data ) {
                console.log( 'error' )
                // 前端抓取驗證失敗的 json
                const errors = data.responseJSON.errors

                let errorMessageList = '';
                $.each(errors['data.article.title'], function ( index, errorMessage ) {
                    // 把錯誤訊息填到 <li>
                    errorMessageList += ( '<li>' + errorMessage + '</li>' );
                })
                $('.new-article.show > form input[name="article[title]"]+ul')
                .empty() // 刪除之前的錯誤訊息
                .append($(errorMessageList)) //附加到錯誤訊息的 <ul>

                errorMessageList = '';
                $.each(errors['data.article.body'], function ( index, errorMessage ) {
                    // 把錯誤訊息填到 <li>
                    errorMessageList += ( '<li>' + errorMessage + '</li>' );
                })
                $('.new-article.show > form textarea[name="article[body]"]+ul')
                .empty() // 刪除之前的錯誤訊息
                .append($(errorMessageList)) //附加到錯誤訊息的 <ul>
            }
        };
        $.ajax(ajaxOption);
    });
  </script>
</html>
