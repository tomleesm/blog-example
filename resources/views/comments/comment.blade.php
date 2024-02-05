@unless($comment->isArchived())
  <p>
    <strong>Commenter:</strong>
    {{ $comment->commenter }}
  </p>

  <p>
    <strong>Comment:</strong>
    {{ $comment->body }}
  </p>

  <p>
    <a data-turbo-method="delete"
       data-turbo-confirm="Are you sure?"
       href="{{ route('articles.comments.destroy',
                  ['article' => $comment->article,
                   'comment' => $comment]) }}">Destroy Comment</a>
  </p>
@endunless
