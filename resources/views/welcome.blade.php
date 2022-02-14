<!DOCTYPE html>
<html>

<head>
    <title>Органайзер</title>

    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script src="{{ asset('js/bootstrap.bundle.js') }}"></script>
    <script src="{{ asset('js/moment.min.js') }}"></script>

    <script src="{{ asset('js/todayEvent.js') }}"></script>

    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/ru.js')}}"></script>
    <script src="{{ asset('js/fullcalendar.js') }}"></script>
    <script src="{{ asset('js/chat.js') }}"></script>

    <link rel="stylesheet" href="css\fullcalendar.css" />
    <link rel="stylesheet" href="css\fullcalendar-custom.css" />
    <link rel="stylesheet" href="css\chat.css" />
    <link rel="stylesheet" href="css\bootstrap.min.css" />
    <link rel="stylesheet" href="css\emojionearea.min.css" />



</head>

<body style="background-color: #f5f5f5; ">

    <input class="ip-address" style="display: none;" value={{env('IP_ADDRESS')}}></input>

    <div class="contant" style="background-color: #f5f5f5;">

        <div class="container">

            <div class="container_chat">
                <div id="calendar">
                </div>
            </div>

            <div class="chat">

                <div class="not_cheked_Message">
                    <span></span>
                </div>
                <div class="chat-header">
                    <div class="chat-header__left"></div>
                    <h4 class="title-chat">Чат</h4>
                    <form class="delite-form" method="POST" style="display: none;">
                        @csrf
                        <button type="submit" class="btn-delite">Удалить</button>
                    </form>
                    <button class="btn-close" aria-label="Close">&times;</button>
                </div>
                <div class="login-block">
                    <form id="form-login">
                        <p class="login-title">Логин</p>
                        <input type="text" name="login" class="login-input" placeholder="Введите ваш логин" required>
                        <p><button type="submit" id="btn-log" class="btn btn-primary mt-3 mb-2">Войти</button></p>
                    </form>
                </div>
                <div class="chats-list" style="display: none;">
                    <button class="btn-down" id="btn-down" onclick="srcollDown()">&#8595;</button>
                </div>
                <div class="chat-footer" style="display: none;">
                    <div class="send-message">
                        <form class="form-input">
                            @csrf
                            <input class="input-send" id="message" name="message" placeholder="Введите сообщение">
                            <input id="username" type="text" name="username" value="" style="display: none;">
                            <input class="input-button" id="input-button" type="submit" value="&#10148">
                        </form>
                        <div id="messages"></div>
                    </div>
                </div>
            </div>

            <div id="dialog" style="display: none;">
                <div id="dialog-body">
                    <form id="dayClick" method="POST" action="{{route('eventStore')}}">
                        @csrf
                        <div class="form-group">
                            <div class="title">
                                <div class="title-event"><label class="title-text">Добавить событие</label></div>
                                <div style="color: white;"></div>
                                <div class="button-close"><a href="" type="button" aria-label="Close" class="btn-close" style="color: black;">&times;</a>
                                </div>
                            </div>
                            <div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Событие</label>
                            <input type="text" id="title" class="form-control" name="title" placeholder="Название события" required>
                        </div>
                        <div class="form-group">
                            <label>Начало события</label>
                            <input type="text" id="start" class="form-control" name="start" placeholder="Дата и время начала">
                            <input type="text" id="start2" class="form-control" name="start2 " placeholder="Дата и время начала">
                        </div>
                        <div class="form-group">
                            <label>Конец события</label>
                            <input type="datetime-local" id="end" class="form-control" name="end" placeholder="Дата и время конца">
                            <input type="text" id="end2" class="form-control" name="end2" placeholder="Дата и время конца">
                        </div>
                        <div class="form-group">
                            <label>Выберите цвет</label>
                            <select class="custom-select" id="color" name="color" required>
                                <option value="#5f01ba" style="background-color:#5f01ba; color:white">Фиолетовый</option>
                                <option value="#ee589f" style="background-color:#ee589f; color:white">Розовый</option>
                                <option value="#14b4e6" style="background-color:#14b4e6; color:white">Голубой</option>
                                <option value="#ddb40a" style="background-color:#ddb40a; color:white">Желтый</option>
                                <option value="#f0783c" style="background-color:#f0783c; color:white">Оранжевый</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Статус задачи</label>
                            <select class="custom-select" id="status" name="status" required>
                                <option value="В работе" style="background-color:green; color:white">В работе</option>
                                <option value="Закрыта" style="background-color:red; color:white">Закрыта</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Доп. информация</label>
                            <textarea id="description" class="form-control" name="description"> </textarea>
                        </div>
                        <div class="form-group">
                            <label>Кому назначена</label>
                            <input id="assigned" class="form-control" name="assigned"> </input>
                        </div>
                        <input type="hidden" id="eventId" name="event_id">
                        <div class="form-group">
                            <button type="submit" class="btn btn-success" id="update">Добавить событие</button>
                            <a href="" type="submit" class="btn btn-danger" id="deliteEvent">Удалить событие</a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="today__evet" id="today__evet" style="display: none;">
                <div class="button-close_events"><a href="" type="button" aria-label="Close" class="btn-close" style="color: black;">&times;</a></div>
                <div class="list-group">
                    <div class="body__today_event">
                        @foreach ( $eventsStatus as $eventStatus )
                        <div class="today-event__item" style="background:{{$eventStatus->color}};">
                            <div class="event__header">
                                <h3 class="event-item__title">{{$eventStatus->title}}</h3>
                                <div class="event-id">{{$eventStatus->id}}</div>
                            </div>
                            <div class="event-item__text">{{$eventStatus->description}}</div>
                            <div class="event-assigned" style="margin-bottom:-17px;">{{$eventStatus->assigned}}</div>
                            <hr class="event_hr">
                            <div class="item-event__time">
                                <img src="img\icon\time2.png" alt="Environmental Consulting">
                                <div class="event-item__start_time">{{$eventStatus->start}}</div><b>&nbsp - &nbsp</b>
                                <div class="event-item__end_time">{{$eventStatus->end}}</div>
                                <div class="event_Cheked">
                                    @if ($eventStatus->readed == null)
                                    <span>Не просмотренно<span>
                                            @else
                                            <span>Просмотренно<span>
                                                    @endif
                                </div>
                            </div>
                            <div>

                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <script>
                function convert(str) {
                    const d = new Date(str);
                    let month = '' + (d.getMonth() + 1);
                    let day = '' + d.getDate();
                    let year = d.getFullYear();
                    if (month.length < 2) month = '0' + month;
                    if (day.length < 2) day = '0' + day;
                    let hour = '' + d.getUTCHours();
                    let minutes = '' + d.getUTCMinutes();
                    let seconds = '' + d.getUTCSeconds();
                    if (hour.length < 2) hour = '0' + hour;
                    if (seconds.length < 2) seconds = '0' + seconds;
                    return [year, month, day].join('-') + ' ' + [hour, minutes, seconds].join(':');
                };

                $(document).ready(function() {

                    var calendar = $('#calendar').fullCalendar({
                        locale: 'ru',
                        eventLimit: true,
                        eventLimitText: "еще",
                        editable: false,
                        displayEventTime: false,
                        selectable: true,
                        showNonCurrentDates: false,
                        timeFormat: 'H:mm',
                        slotLabelFormat: 'H:mm',
                        defaultDate: $.fullCalendar.moment().startOf('day'),
                        firstDay: 1,

                        customButtons: {
                            todayEvent: {
                                text: 'Текущие',
                                click: function(e) {
                                    e.preventDefault();
                                    $('#today__evet').dialog({
                                        width: 650,
                                        height: 800,
                                        modal: true,
                                    })
                                }
                            },
                            KIP: {
                                text: 'КИП',
                                click: function(e) {
                                    e.preventDefault();
                                    window.location.href = 'assignments/index';
                                }
                            }
                        },

                        header: {
                            right: 'today, prev,next,KIP ',
                            center: 'title',
                            left: 'month,agendaWeek,agendaDay,todayEvent'
                        },
                        views: {
                            dayGridMonth: {
                                eventLimit: 6 // adjust to 6 only for agendaWeek/agendaDay
                            }
                        },
                        monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
                        monthNamesShort: ['Янв.', 'Фев.', 'Март', 'Апр.', 'Май', 'Июнь', 'Июль', 'Авг.', 'Сент.', 'Окт.', 'Ноя.', 'Дек.'],
                        dayNames: ["Воскресенье", "Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота"],
                        dayNamesShort: ["Воскресенье", "Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота"],
                        buttonText: {
                            today: "Сегодня",
                            month: "Месяц",
                            week: "Неделя",
                            day: "День",
                            now: "Текущие",
                        },

                        events: "{{route('allEvent')}}",
                        eventRender: function(event, element) {
                            if (event.assigned == null) {
                                event.assigned = "отсутствует"
                            }
                            element.find('.fc-title').append("<br/>" + "Кому назначена: " + event.assigned);
                        },
                        dayClick: function(date, event, view) {
                            var clickDate = date.format('YYYY-MM-DD HH:MM:SS');
                            $('#start').val(clickDate);
                            $('#deliteEvent').css("display", "none");
                            $('#start2').css("display", "none");
                            $('#end2').css("display", "none");
                            $('#dialog').dialog({
                                width: 500,
                                height: 800,
                                modal: true,
                            })
                        },

                        eventClick: function(event) {
                            $('#start').css("display", "none");
                            $('#end').css("display", "none");
                            $('#title').val(event.title);
                            $('#start2').val(convert(event.start));
                            $('#end2').val(convert(event.end));
                            $('#description').val(event.description);
                            $('#eventId').val(event.id);
                            $('#assigned').val(event.assigned);
                            let url = "{{url('/deleteEvent/')}}";
                            $('#deliteEvent').attr('href', url + '/' + event.id);
                            $('.title-text').html('Обновить событие');
                            $('#update').html('Обновить');
                            $('#dialog').dialog({
                                width: 500,
                                height: 800,
                                modal: true,
                            })
                        },

                        eventMouseover: function(calEvent, jsEvent) {
                            if (calEvent.description == null) {
                                calEvent.description = "Нет доп. информации!"
                            }
                            var tooltip = '<div class="tooltipevent">' + '<p class="ptitle">' + calEvent.title + '</p>' + '<p class="pdescript">' + calEvent.description + '</p>' + '</div>';
                            $("body").append(tooltip);
                            $(this).mouseover(function(e) {
                                $(this).css('z-index', 10000);
                                $('.tooltipevent').fadeIn('500');
                                $('.tooltipevent').fadeTo('10', 1.9);
                            }).mousemove(function(e) {
                                $('.tooltipevent').css('top', e.pageY + 10);
                                $('.tooltipevent').css('left', e.pageX + 20);
                            });
                        },
                        eventMouseout: function(calEvent, jsEvent) {
                            $(this).css('z-index', 8);
                            $('.tooltipevent').remove();
                        },
                    })
                });

                $(".chat-header").click(function() {
                    $(".chat").animate({
                        height: "55%",
                        width: "28%",
                        opacity: 0.7,
                    }, 1000)
                });

                $(".btn-close").click(function() {
                    $(".chat").animate({
                        width: "28%",
                        height: "40px",
                    }, 1000)
                    event.stopPropagation();
                });

                let form = document.querySelector('.form-input');
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    $(".emojionearea-editor").html('');
                    const formData = new FormData(this);
                    fetch('/Organiser/public/api/messages', {
                            method: 'post',
                            headers: {
                                'Accept': 'application/json'
                            },
                            body: formData
                        })
                        .then(function(response) {
                            return response.json()
                        })
                        .then(function(data) {})
                });

                $(document).ready(function() {
                    $("#message").emojioneArea({});
                });

                function srcollDown() {
                    const end = document.getElementById('end-chat');
                    end.scrollIntoView({
                        block: "center",
                        behavior: "smooth"
                    });
                }

                const ip = document.querySelector(".ip-address").value;
                if (ip === "") {
                    alert("IP сервера не задан! Повторите выполнение файла Python!")
                }

                todayEvent()

            </script>

            <script src="{{ asset('js/app.js') }}"></script>
            <script src="{{ asset('js/watchEvents.js') }}"></script>
            <script src="{{ asset('js/jquery-ui.min.js') }}"></script>
            <script src="{{ asset('js/jquery-ui.js') }}"></script>
            <script src="{{ asset('js/jquery-ui.js') }}"></script>
            <script src="{{ asset('js/emojionearea.min.js') }}"></script>
            @include('sweetalert::alert')
</body>

</html>
