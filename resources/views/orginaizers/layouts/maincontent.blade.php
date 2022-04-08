<!DOCTYPE html>
<html>
<head>
    <title>Органайзер</title>

    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.js') }}"></script>
    <script src="{{ asset('js/moment.min.js') }}"></script>
    <script src="{{ asset('js/todayEvent.js') }}"></script>
    <script src="{{ asset('js/fullcalendar.js') }}"></script>
    <script src="{{ asset('js/ru.js')}}"></script>

    <link rel="stylesheet" href="css\fullcalendar.css" />
    <link rel="stylesheet" href="css\fullcalendar-custom.css" />
    <link rel="stylesheet" href="css\chat.css" />
    <link rel="stylesheet" href="css\bootstrap.min.css" />
    <link rel="stylesheet" href="css\emojionearea.min.css" />
</head>
<body>

    @yield('content')
    
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/watchEvents.js') }}"></script>
    <script src="{{ asset('js/watchTogle.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <script src="{{ asset('js/jquery.textcomplete.js') }}"></script>
    <script src="{{ asset('js/emojione.min.js') }}"></script>
    <script src="{{ asset('js/emojionearea.min.js') }}"></script>
    <script src="{{ asset('js/calendar.js') }}"></script>

    @include('sweetalert::alert')
</body>
</html>