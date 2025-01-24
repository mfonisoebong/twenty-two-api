<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    @yield('head')

    <style>
        body {
            font-family: system-ui;
        }
    </style>

</head>
<body style="padding: 15px; font-size: 14px">
@include('partials.emails._header')

@yield('content')

@include('partials.emails._footer', [
    'role' => 'admin'
])

</body>
</html>
