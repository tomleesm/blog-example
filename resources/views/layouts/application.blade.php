<!DOCTYPE html>
<html>
  <head>
    <title>Blog example</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf_token" content="{{ csrf_token() }}">
  </head>

  <body>
    @yield('content')
  </body>
</html>