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
            document.querySelector('.fc-todayEvent-button').innerHTML = `<div class = ""> Задач в работе - ${data.eventInWokrs} шт.</div>`;
            // todatEvent.innerHTML =
            //     `<div class = "fc-corner-right">${data.eventInWokrs}</div>`;
        })

}
setTimeout(countEvents, 1600);

// function eventsWatch() {
//     let eventsWatch = document.querySelector('.countEvents')
//     eventsWatch.addEventListener('click', function (e) {
//         e.preventDefault();
//         $('#today__evet').dialog({
//             width: 650,
//             height: 800,
//             modal: true,
//         })
//     })
// }
// setTimeout(eventsWatch, 1800);