function convert(str) {
    const d = new Date(str);
    let month = '' + (d.getMonth() + 1);
    let day = '' + d.getDate();
    let year = d.getFullYear();
    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;
    let hour = '' + d.getUTCHours();
    let minutes = '' + d.getUTCMinutes();
    if (hour.length < 2) hour = '0' + hour;
    if (minutes.length < 2) minutes = '0' + minutes;

    return [year, month, day].join('-') + ' ' + [hour, minutes].join(':');
};

$(document).ready(function () {

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
        customRender: true,
        slotEventOverlap:false,
        

        customButtons: {
            todayEvent: {
                text: 'Задач в работе - 0 шт.',
                click: function (e) {
                    e.preventDefault();
                    $('#today__evet').dialog({
                        width: 650,
                        height: 800,
                        modal: true,
                    })
                }
            },
            todayTogle: {
                id: 'todayTogle',
                text: 'Событий сегодня - 0 шт.',
                click: function (e) {
                    e.preventDefault();
                    $('#today__togle').dialog({
                        width: 650,
                        height: 800,
                        modal: true,
                    })
                }
            },
            KIP: {
                text: 'КИП',
                click: function (e) {
                    e.preventDefault();
                    window.location.href = 'assignments/index';
                }
            }
        },

        header: {
            right: 'today, prev,next,KIP ',
            center: 'title',
            left: 'month,agendaDay,todayEvent,todayTogle'
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

        events: "/organaizer/public/index",

        eventRender: function (event, element) {
            if (event.typeEvent == null) {
                event.typeEvent = 
                element.find('.fc-title').before("Задача - ");
            }else{
                element.find('.fc-title').before("Cобытие - ");
            }
            
        },
        dayClick: function (date, event, view) {
            
            var clickDate = new Date(date).toISOString();

            var clickDateEnd = new Date(date + 23*3754*1000).toISOString();

            $('#start').val(clickDate.substring(0,clickDate.length-8));
            $('#end').val(clickDateEnd.substring(0,clickDateEnd.length-8));
            $('#deliteEvent').css("display", "none");
            $('body').css("overflow", "visible");
            $('body').css("background", "black");
            $('#start2').css("display", "none");
            $('#end2').css("display", "none");
            $('#dialog').dialog({
                width: 500,
                height: 850,
                modal: true,
            })
        },


        eventClick: function (event) {
            console.log(event);
            var clickDate = new Date(event.start._d).toISOString();
            var clickDateEnd = new Date(event.end).toISOString();
            if (event.typeEvent == 'togle') {
                
                $('#chkEvent').css("display", "none");
                $('#chk').css("display", "none");
                $('#start').css("display", "none");
                $('#end').css("display", "none");
                $('#created_at').val(event.created_at); 
                $('#titleEvent').html('Событие');
                $('#repeatedEventDiv').css("display", "none");
                $('body').css("overflow", "visible");
                $('body').css("background", "black");
                $('#statusTask').css("display", "none");
                $('#assignedEvent').css("display", "none");
                $('#color').val(event.color);
                $('#textColor').val(event.textColor);
                $('#color').append(event.color);
                $('#title').val(event.title);
                $('#start2').val(clickDate.substring(0,clickDate.length-8));
                $('#start2').attr('readonly','readonly');
                $('#end2').val(clickDateEnd.substring(0,clickDateEnd.length-8));
                $('#end2').attr('readonly','readonly');
                $('#description').val(event.description);
                $('#eventId').val(event.id);
                $('#deliteEvent').html('Удалить событие');
                $('#deliteEvent').attr('href', '/organaizer/public/deleteEvent' + '/' + event.id);
                $('.title-text').html('Обновить событие');
                $('#labelStart').html('Начало события');
                $('#labelEnd').html('Конец события');
                $('#update').html('Обновить');
                $('#dialog').dialog({
                    width: 500,
                    height: 650,
                    modal: true,
                })
            }else{
                $('#chkEvent').css("display", "none");
                $('#chk').css("display", "none");
                $('#start').css("display", "none");
                $('#end').css("display", "none");
                $('#created_at').val(event.created_at); 
                $('#repeatedEventDiv').css("display", "none");
                $('body').css("overflow", "visible");
                $('body').css("background", "black");
                $('#textColor').val(event.textColor);
                $('#status').val(event.status);
                $('#status').append(event.status);
                $('#color').val(event.color);
                $('#color').append(event.color);
                $('#title').val(event.title);
                $('#start2').val(clickDate.substring(0,clickDate.length-8));
                $('#end2').val(clickDateEnd.substring(0,clickDateEnd.length-8));
                $('#description').val(event.description);
                $('#eventId').val(event.id);
                $('#assigned').val(event.assigned);
                $('#deliteEvent').attr('href', '/organaizer/public/deleteEvent' + '/' + event.id);
                $('.title-text').html('Обновить задачу');
                $('#update').html('Обновить');
                $('#dialog').dialog({
                    width: 500,
                    height: 800,
                    modal: true,
                })
            }
            
            
        },

        eventMouseover: function (calEvent, jsEvent) {
            if (calEvent.description == null) {
                calEvent.description = "Нет доп. информации!"
            }
            if (calEvent.typeEvent == null) {
                calEvent.typeEvent = "Задача"
            } else{
                calEvent.typeEvent = "Событие"
            }
            var tooltip = '<div class="tooltipevent">' + '<p class="ptitle">'+ calEvent.typeEvent + ' - ' + calEvent.title + '</p>' + '<p class="pdescript">' + calEvent.description + '</p>' + '</div>';
            $("body").append(tooltip);
            $(this).mouseover(function (e) {
                $(this).css('z-index', 10000);
                $('.tooltipevent').fadeIn('500');
                $('.tooltipevent').fadeTo('10', 1.9);
            }).mousemove(function (e) {
                $('.tooltipevent').css('top', e.pageY + 10);
                $('.tooltipevent').css('left', e.pageX + 20);
            });
        },
        eventMouseout: function (calEvent, jsEvent) {
            $(this).css('z-index', 8);
            $('.tooltipevent').remove();
        },
    })
});


$(".chat-header").click(function () {
    $(".chat").animate({
        height: "55%",
        width: "28%",
        opacity: 0.7,
    }, 1000)
});

$(".btn-close").click(function () {
    $(".chat").animate({
        width: "28%",
        height: "40px",
    }, 1000)
    event.stopPropagation();
});
$(".emojionearea").emojioneArea({
    standalone: true
});



function send() {
    let form = document.querySelector('.form-input');
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        $(".emojionearea-editor").html('');
        const formData = new FormData(this);
        fetch('/organaizer/public/api/messages', {
            method: 'post',
            headers: {
                'Accept': 'application/json'
            },
            body: formData
        })
            .then(function (response) {
                return response.json()
            })
            .then(function (data) { })
    });
}
send();

$(document).ready(function () {
    emojione.imagePathPNG = 'img/png/32/';
    $("#message").emojioneArea({
        inline: true,
        search: false,
        useInternalCDN: false,
        shortcuts:true,
        events: {
            keyup: function (editor, event) {
                if (event.which == 13) {
                    let message = this.getText();
                    let userName = document.querySelector('#username').value;

                    const formData = new FormData();
                    formData.append("username", userName)
                    formData.append("message", message)
                    $(".emojionearea-editor").html('');

                    fetch('/organaizer/public/api/messages', {
                        method: 'post',
                        headers: {
                            'Accept': 'application/json'
                        },
                        body: formData
                    })
                        .then(function (response) {
                            return response.json()
                        })
                        .then(function (data) { })
                }
            }
        }
    });
});

document.getElementById('chkEvent').addEventListener('change', toggleInputEvent);

function toggleInputEvent(evt) {
    $('#dialog').dialog({
        width: 500,
        height: 850,
        modal: true,
    })
    // document.querySelector('#startDiv').classList.toggle('hidden-div');
    // document.querySelector('#endDiv').classList.toggle('hidden-div');
    document.querySelector('#start').readOnly = false;
    document.querySelector('#end').readOnly = false;
    document.querySelector('#statusTask').classList.toggle('hidden-div');
    document.querySelector('#assignedEvent').classList.toggle('hidden-div');
    document.querySelector('#labelStart').innerHTML= 'Начало задачи';
    document.querySelector('#labelEnd').innerHTML= 'Конец задачи';
    document.querySelector('.title-text').innerHTML= 'Добавить задачу';
    document.querySelector('#titleEvent').innerHTML= 'Задача';
    
    document.querySelector('#repeatedEvent').innerHTML= 'Повторять задачу каждый год';
    document.querySelector('#update').innerHTML= 'Добавить задачу';

    document.querySelector('#typeEvent').value = '';
}

document.getElementById('chk').addEventListener('change', toggleInput);

function toggleInput(evt) {
    $('#dialog').dialog({
        width: 500,
        height: 680,
        modal: true,
    })
    document.querySelector('#start').readOnly = true;
    document.querySelector('#end').readOnly = true;
    document.querySelector('#labelStart').innerHTML= 'Начало события';
    document.querySelector('#labelEnd').innerHTML= 'Конец события';
    document.querySelector('#statusTask').classList.toggle('hidden-div');
    document.querySelector('#assignedEvent').classList.toggle('hidden-div');

    document.querySelector('.title-text').innerHTML= 'Добавить событие';
    document.querySelector('#titleEvent').innerHTML= 'Событие';
    
    document.querySelector('#repeatedEvent').innerHTML= 'Повторять событие каждый год';
    document.querySelector('#update').innerHTML= 'Добавить событие';

    document.querySelector('#typeEvent').value = 'togle';
}



function srcollDown() {
    document.querySelector('.chats-list').scrollTop = document.querySelector('.chats-list').scrollHeight
}

const ip = document.querySelector(".ip-address").value;
if (ip === "") {
    alert("IP сервера не задан! Повторите выполнение файла Python!")
}

todayEvent();

