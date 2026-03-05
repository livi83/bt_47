<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Moj web</title>
</head>
<body>
  <nav>
    <a href="{{ url('/') }}">Home</a>
    <a href="{{ url('/about') }}">About</a>
    <a href="{{ url('/contact') }}">Contact</a>
  </nav>
  
  <hr>

  <main>
    @yield('content')
  </main>

  <hr>
  <footer>© {{ date('Y') }}</footer>
</body>
</html>