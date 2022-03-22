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

        customButtons: {
            todayEvent: {
                text: 'Текущие',
                click: function (e) {
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
                click: function (e) {
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

        events: "/organaizer/public/index",

        eventRender: function (event, element) {
            if (event.assigned == null) {
                event.assigned = "отсутствует"
            }
            element.find('.fc-title').append("<br/>" + "Кому назначена: " + event.assigned);
        },
        dayClick: function (date, event, view) {
            
            var clickDate = new Date(date).toISOString();

            var clickDateEnd = new Date(date + 23*3754*1000).toISOString();

            $('#start').val(clickDate.substring(0,clickDate.length-8));
            $('#end').val(clickDateEnd.substring(0,clickDateEnd.length-8));
            $('#deliteEvent').css("display", "none");
            $('#start2').css("display", "none");
            $('#end2').css("display", "none");
            $('#dialog').dialog({
                width: 500,
                height: 800,
                modal: true,
            })
        },


        eventClick: function (event) {

            var clickDate = new Date(event.start._d).toISOString();
            var clickDateEnd = new Date(event.end + 23*3754*1000).toISOString();

            $('#start').css("display", "none");
            $('#end').css("display", "none");
            $('#repeatedEvent').css("display", "none");
            $('#title').val(event.title);
            $('#start2').val(clickDate.substring(0,clickDate.length-8));
            $('#end2').val(clickDateEnd.substring(0,clickDateEnd.length-8));
            $('#description').val(event.description);
            $('#eventId').val(event.id);
            $('#assigned').val(event.assigned);
            $('#deliteEvent').attr('href', '/organaizer/public/deleteEvent' + '/' + event.id);
            $('.title-text').html('Обновить событие');
            $('#update').html('Обновить');
            $('#dialog').dialog({
                width: 500,
                height: 800,
                modal: true,
            })
        },

        eventMouseover: function (calEvent, jsEvent) {
            if (calEvent.description == null) {
                calEvent.description = "Нет доп. информации!"
            }
            var tooltip = '<div class="tooltipevent">' + '<p class="ptitle">' + calEvent.title + '</p>' + '<p class="pdescript">' + calEvent.description + '</p>' + '</div>';
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
    $("#message").emojioneArea({
        inline: true,
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


function srcollDown() {
    document.querySelector('.chats-list').scrollTop = document.querySelector('.chats-list').scrollHeight
}

const ip = document.querySelector(".ip-address").value;
if (ip === "") {
    alert("IP сервера не задан! Повторите выполнение файла Python!")
}

todayEvent()
