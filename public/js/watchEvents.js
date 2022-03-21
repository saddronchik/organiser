function countEvents() {
    let todatEvent = document.querySelector('.fc-clear');
    fetch("/organaizer/public/messageWatch", {
        headers: {
            'Content-type': 'application/json',
        }
    })
        .then(function (response) {
            return response.json()
        })
        .then(data => {
            todatEvent.innerHTML =
                `<div class = "countEvents">
                    <div class = "eventStart">${data.eventInWokrs}</div>
                    <div class = "eventNotReaded">${data.eventNotChecked}</div>
                </div>`;
        })

}
setTimeout(countEvents, 1700);

function eventsWatch() {
    let eventsWatch = document.querySelector('.countEvents')
    eventsWatch.addEventListener('click', function (e) {
        e.preventDefault();
        $('#today__evet').dialog({
            width: 650,
            height: 800,
            modal: true,
        })
    })
}
setTimeout(eventsWatch, 1800);