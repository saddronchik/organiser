<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Контроль исполнения поручений</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/assignments.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-select/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/summernote-0.8.18-dist/summernote-bs4.min.css') }}">
</head>
<body>

@include('assignment.includes.header')
@include('assignment.includes.top-nav')

<main class="app-content py-4">
    @yield('content')
</main>

<footer>
    <div class="container">
        <div class="border-top pt-3">
        </div>
    </div>
</footer>


<script src="{{asset('js/jquery-3.6.0.min.js')}}"></script>
<script src="{{asset('js/bootstrap.bundle.js')}}"></script>
<script src="{{asset('vendor/summernote-0.8.18-dist/summernote-bs4.min.js')}}"></script>
<script src="{{ asset('vendor/bootstrap-select/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('js/assignment/main.js') }}"></script>
</body>
</html>

