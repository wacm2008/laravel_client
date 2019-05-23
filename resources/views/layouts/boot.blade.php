<html>
<head>
    <title>1809a - @yield('title')</title>
    <script src="/js/jquery.js"></script>
    <script src="/bootstrap/js/bootstrap.js"></script>
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.css">
</head>
<body>
@section('sidebar')
    <h3>登录</h3>
@show

<div class="container">
    @yield('content')
</div>
</body>
</html>