function todayEvent() {
    let eventItem = document.querySelectorAll(".today-event__item")
    eventItem.forEach(function(elemitem) {
        let title = elemitem.querySelector('.event-item__title').textContent;
        let startTime = elemitem.querySelector('.event-item__start_time').textContent;
        let endTime = elemitem.querySelector('.event-item__end_time').textContent;
        let description = elemitem.querySelector('.event-item__text').textContent;
        let id = elemitem.querySelector('.event-id').textContent;
        let assigned = elemitem.querySelector('.event-assigned').textContent;

        elemitem.addEventListener('click', function(e) {

            fetch('/laravel-fullcalender/public/api/checkEvent' + '/' + id, {
                    method: 'PUT',
                    body: id,
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json; charset=UTF-8',
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then((response) => {
                    return response.json();
                })
                .then((data) => {
                    console.log(data);
                });
            $('#today__evet').css("display", "none")
            $('#start').css("display", "none");
            $('#end').css("display", "none");
            $('#title').val(title);
            $('#start2').val(convert(startTime));
            $('#end2').val(convert(endTime));
            $('#description').val(description);
            $('#eventId').val(id);
            $('#assigned').val(assigned);
            $('#deliteEvent').attr('href', '/laravel-fullcalender/public/deleteEvent' + '/' + id);
            $('.title-text').html('Обновить событие');
            $('#update').html('Обновить');
            $('#dialog').dialog({
                width: 500,
                height: 800,
                modal: true,
            })
        })
    })
}