
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
    <!-- 新增文章表單 -->
    <div class="template new-article">
      <h1>New Article</h1>

      <form accept-charset="UTF-8" method="post">
        <input type="hidden" name="_method" value="POST">
        <div>
          <label for="article_title">Title</label><br>
          <input type="text" name="article[title]" id="article_title" value="">
          <!-- 表單驗證錯誤訊息 -->
          <ul>
          </ul>
        </div>

        <div>
          <label for="article_body">Body</label><br>
          <textarea name="article[body]" id="article_body"></textarea>
          <!-- 表單驗證錯誤訊息 -->
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
    <!-- 顯示一篇文章 -->
    <div class="template article">
        <h1></h1>
        <p></p>

        <ul>
          <li><a href="">Edit</a></li>
        </ul>
    </div>
  </div>
  </body>
  @vite(['resources/js/app.js'])
  <script type="module">
    // 顯示一篇文章，response 是 json 物件，格式如下
    /**
     * {
     *   "data": {
     *     "article": {
     *       "id": 1,
     *       "title": "標題",
     *       "body": "內文"
     *     }
     *   }
     * }
     */
    const getArticle = function ( response ) {
        console.log( 'get an article' );
        // 選取顯示一篇文章的 HTML，改成 <div class="article show"> ... </div>
        const article = $('.template.article').clone().removeClass('template').addClass('show');
        // 選取 <h1></h1>，改成 <h1>{標題}</h1>
        article.children('h1').text(response.data.article.title);
        // 選取 <p></p>，改成 <p>{內文}</p>
        article.children('p').text(response.data.article.body);
        // 選取 <a href="">Edit</a>，加上屬性 href="/articles/{id}/edit"
        article.find('a:contains("Edit")').attr('href', '/articles/' + response.data.article.id + '/edit')
        // 把容器 <div class="container"> 清空，換成上述的 <div> ... </div>
        $('.container').empty().append(article);
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
                // 選取所有文章連結，並且清空，以更新成新的
                const articleLinks = $('.container > ul.article.links').empty();
                // 抓取 GET /articles 回傳的 json 物件
                $.each(response.data, function (index, json) {
                  // 建立 <li><a href="/articles/{id}">{標題}</a></li>
                  // 加到空的 <ul class="article links"> </ul> 中
                  $('<li><a href="/articles/' + json.article.id + '">' + json.article.title + '</a></li>').appendTo(articleLinks);
                });
            },
            error: function ( data ) {
                console.log( 'error' )
            }
        };
        $.ajax(ajaxOption);
    });
    // 當點選首頁的文章連結
    $('ul.article.links').on('click', 'a', function( event ) {
        event.preventDefault();
        const ajaxOption = {
            method: 'GET',
            // 觸發事件的是 <a href="/articles/{id}">{標題}</a>
            url: $(this).attr('href'),
            contentType: 'application/json; charset=UTF-8',
            dataType: 'json',
            success: function (response) {
                getArticle(response);
            },
            error: function ( data ) {
                console.log( 'error' );
            }
        };
        $.ajax(ajaxOption);
    });
    // 按下 New Article 時
    $('.new-article-link').on('click', function() {
      event.preventDefault();
      // 選取新增文章表單，複製並改成 <div class="new-article show"> ... </div> 
      const newArticleForm = $('.template.new-article').clone().removeClass('template').addClass('show');
      // 把容器 <div class="container"> 清空，換成上述的 <div> ... </div>
      $('.container').empty().append(newArticleForm);
    });
    // 當送出容器 <div class="container"> 內的新增文章表單
    $('.container').on('submit', '.new-article.show > form', function ( event ) {
        event.preventDefault();
        // this 是表單，serializeArray() 會收集所有的表單值，包含 <input type="hidden">，然後轉成陣列
        // formValue[0].value 是 <input type="hidden" name="_method" value="POST"> 的值 "POST"
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
                getArticle(response);
            },
            error: function ( data ) {
                console.log( 'error' )
                // 前端抓取驗證失敗的 json 物件
                const errors = data.responseJSON.errors

                let errorMessageList = '';
                // JSON 物件中，有包含點的 key 'data.article.title' 必須用中括號才能存取
                $.each(errors['data.article.title'], function ( index, errorMessage ) {
                    // 把錯誤訊息用字串相接填到 <li>
                    errorMessageList += ( '<li>' + errorMessage + '</li>' );
                });
                // 新增文章表單當中的 <input name="article[title]"> 同一層用來顯示表單驗證錯誤訊息的 <ul>
                $('.new-article.show > form input[name="article[title]"]+ul')
                .empty() // 清空之前的錯誤訊息
                .append($(errorMessageList)); //附加到錯誤訊息的 <ul>

                // 類似上面的內容，只是用在 <textarea name="article[body]">
                errorMessageList = '';
                $.each(errors['data.article.body'], function ( index, errorMessage ) {
                    errorMessageList += ( '<li>' + errorMessage + '</li>' );
                });
                $('.new-article.show > form textarea[name="article[body]"]+ul')
                .empty()
                .append($(errorMessageList));
            }
        };
        $.ajax(ajaxOption);
    });
  </script>
</html>
