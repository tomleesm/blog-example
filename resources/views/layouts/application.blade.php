<!DOCTYPE html>
<html>
  <head>
    <title>Blog example</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/js/app.js')
  </head>

  <body>
    @yield('content')
  </body>
</html>