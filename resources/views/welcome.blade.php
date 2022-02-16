@extends('orginaizers.layouts.maincontent')

@section('content')

<input class="ip-address" style="display: none;" value={{env('IP_ADDRESS')}}></input>

<div class="contant">

    <div class="container">

        <div class="container_calendar">
            <div id="calendar"></div>
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

@endsection