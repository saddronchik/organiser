// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.echo = new Echo({
//     broadcaster: 'pusher',
//     key: 'DFSSDFSF',
//     cluster:'mt1',
//     wsHost: '127.0.0.1',
//     wsPort: 6001,
//     forceTLS: false
// });


// echo.channel('messages').listen('NewMessage',(data)=>{
//     console.log();
// })


// fetch('http://127.0.0.1:8000/api/messages',{
//     headers:{
//         'Content-type':'application/json'
//     }
// }).then(function (response) {
//     return response.json()
// })

// .then(data=>{
//     console.log(data)
//     data.forEach(element => {
        
//         document.querySelector('.chats-list').innerHTML +=`
//         <div class="messagefromChat">
//             <div class="chat-title-left">
//                     2
//             </div>
//             <div class="messageClient">
//                 ${element.message}
//                 <span class="time-right">${element.created_at}</span>
//             </div>
//         </div>
//         `
//     });
// })