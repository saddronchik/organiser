<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Контроль исполнения поручений</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/assignments.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-select/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/summernote-0.8.18-dist/summernote-bs4.min.css') }}">
</head>
<body>

@include('assignment.includes.header')

@include('assignment.includes.top-nav')

@yield('content')


<script src="{{asset('js/jquery-3.6.0.min.js')}}"></script>
<script src="{{asset('js/bootstrap.bundle.js')}}"></script>
<script src="{{asset('vendor/summernote-0.8.18-dist/summernote-bs4.min.js')}}"></script>
<script src="{{ asset('vendor/bootstrap-select/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('js/assignment/main.js') }}"></script>
</body>
</html>

