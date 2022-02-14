require('./bootstrap');

import Echo from 'laravel-echo';
import $ from 'jquery';
import axios from 'axios';
import swal from 'sweetalert';

const ip = document.querySelector(".ip-address").value;
console.log(ip);
const audioMessage = new Audio('/Organiser/public/audio/message.mp3');

if (ip === "") {
    alert(1)
}

window.Pusher = require('pusher-js');

window.echo = new Echo({
    broadcaster: 'pusher',
    key: 'DFSSDFSF',
    cluster: 'mt1',
    wsHost: ip,
    wsPort: 6001,
    disableStats: true,
    forceTLS: false
});

const token = document.getElementsByName("csrfToken").value;

if (localStorage.getItem('UserName')) {
    let username = localStorage.getItem('UserName');
    $("#username").attr('value', username);
    $(".login-block").css("display", "none");
    $(".chats-list").show(500);
    $(".chat-footer").show(500);
    Messages();
}

function Username() {
    return new Promise(function (resolve) {
        $("#btn-log").click(function (event) {
            event.preventDefault();

            let loginText = $(".login-input").val();
            if (loginText.length === 0) {
                return;
            }
            localStorage.setItem('UserName', loginText);
            let username = localStorage.getItem('UserName');
            $("#username").attr('value', username);
            $(".login-block").css("display", "none");
            $(".chats-list").show(500);
            $(".chat-footer").show(500);
            resolve();
        });
    })
}

Username().then(function () {
    Messages()
});

function Messages() {
    let messageToDelite = [];
    let messageCheked = [];
    let arrNotCheked = '';
    fetch("/Organiser/public/api/messages", {
        headers: {
            'Content-type': 'application/json',
        }
    })
        .then(function (response) {
            return response.json()
        })
        .then(data => {
            let username = localStorage.getItem('UserName');
            data.forEach(element => {
                let dateResponse = new Date(element.created_at);
                if (element.username == username & element.readed == null) {
                    document.querySelector('.chats-list').innerHTML += `
                        <div class="messageInChat">
                            <div class="messageRight">
                                <div class="chat-title-right">
                                ${element.username}
                                </div>
                            <p class="p-right"> <div class="messageManager">
                                    ${element.message}
                                    <span class="time-right">${dateResponse.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</span>
                                </div></p>
                                <div class="messageInChat_notCheked">
                                <span>  ✓ <span>
                                <div class ="chat-item" data-id="${element.id}"></div>
                                </div>
                        </div>`
                    document.querySelector('.chats-list').scrollTop = document.querySelector('.chats-list').scrollHeight
                } else if (element.username == username & element.readed != null) {
                    document.querySelector('.chats-list').innerHTML += `
                        <div class="messageInChat">
                            <div class="messageRight">
                                <div class="chat-title-right">
                                ${element.username}
                                </div>
                            <p class="p-right"> <div class="messageManager">
                                    ${element.message}
                                    <span class="time-right">${dateResponse.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</span>
                                </div></p>
                                <div class="messageInChat_Cheked">
                                <span>  ✓✓ <span>
                                <div class ="chat-item" data-id="${element.id}"></div>
                                </div>
                        </div>`
                    document.querySelector('.chats-list').scrollTop = document.querySelector('.chats-list').scrollHeight
                }
                else if (element.username != username & element.readed == null) {
                    document.querySelector('.chats-list').innerHTML += `
                    <div class="messagefromChat_notCheked" >
                        <div class="messageLeft">
                            <div class="chat-title-left">
                            ${element.username}
                            </div>
                        <div class="Cheked">
                            <div class="messageClient">
                                ${element.message}
                                <span class="time-right">${dateResponse.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</span>
                            </div>
                            <div class="messageClient_notCheked">
                            <span>  ✓ <span>
                            </div>
                        </div>
                        <div class ="chat-item" data-id="${element.id}"></div>
                        </div>
                    </div>`
                    document.querySelector('.chats-list').scrollTop = document.querySelector('.chats-list').scrollHeight
                } else if (element.username != username & element.readed != null) {
                    document.querySelector('.chats-list').innerHTML += `
                        <div class="messagefromChat">
                            <div class="messageLeft">
                                <div class="chat-title-left">
                                ${element.username}
                                </div>
                                <div class="messageClient">
                                    ${element.message}
                                    <span class="time-right">${dateResponse.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</span>
                                </div>
                                <div class="messageClient_Cheked">
                                    <span> ✓✓ </span>
                                </div>
                                <div class ="chat-item" data-id="${element.id}"></div>
                            </div>
                        </div>`
                    document.querySelector('.chats-list').scrollTop = document.querySelector('.chats-list').scrollHeight
                }
            });

            document.querySelector('.chats-list').innerHTML += `<div class="end-chat" id="end-chat"></div>`;


            /*-----------------Сообщения к прочтению во время загрузки чата-------------*/
            let check = document.querySelectorAll('.messagefromChat_notCheked');
            arrNotCheked = check.length;
            let alertCheked = document.querySelector('.not_cheked_Message span').innerHTML = arrNotCheked;
            if (arrNotCheked == 0) {
                document.querySelector('.not_cheked_Message span').style.display = "none";
            } else {
                document.querySelector('.not_cheked_Message span').style.display = "initial";
            }

            check.forEach(function (elem) {
                elem.onmouseout = function (event) {
                    let id_cheked = elem.querySelector('.chat-item').getAttribute('data-id');
                    messageCheked.push(id_cheked)
                    /*Фильтр по повторяющимся элементам */
                    const filteredMessageCheked = messageCheked.filter((item, index) => {
                        return messageCheked.indexOf(item) === index;
                    });
                    // console.log(filteredMessageCheked);
                    axios.defaults.headers.common['X-CSRF-TOKEN'] = $('meta[name="csrf-token"]').attr('content');
                    axios.post('/Organiser/public/api/checkMessage', {
                        body: filteredMessageCheked
                    })
                        .then(function (response) {
                        })
                        .then(function () {
                        })
                        .catch(function (error) {
                        })
                }
            });

            /*-----------------Сообщения к удалению во время загрузки чата-------------*/
            let chats = document.querySelectorAll('.messageInChat');

            let messageUnDelite = [];
            let arrLength = '';

            chats.forEach(function (item) {
                let id_chat = item.querySelector('.chat-item').getAttribute('data-id');
                item.addEventListener('click', function (e) {
                    if (item.style.backgroundColor == "") {
                        item.style.backgroundColor = "#9da3b6";
                        document.querySelector('.delite-form').style.display = "initial";
                        messageToDelite.push(id_chat);
                    } else {
                        item.style.backgroundColor = "";
                        messageUnDelite.push(id_chat);
                        messageToDelite = messageToDelite.filter(function (item) {
                            return !messageUnDelite.includes(item);

                        });
                        messageUnDelite = [];
                    }
                    arrLength = messageToDelite.length
                    if (arrLength == 0) {
                        document.querySelector('.delite-form').style.display = "none";
                    }
                    else if (arrLength > 0) {
                        document.querySelector('.delite-form').style.display = "initial";
                    }
                    document.querySelector('.btn-delite').innerHTML = "Удалить: " + arrLength;
                })
            });
        })


    let delite = document.querySelector('.delite-form');
    delite.addEventListener('submit', function (e) {
        e.preventDefault();
        axios.post('/Organiser/public/api/deliteMessage', {
            body: messageToDelite
        })
            .then(function (response) {
                if (response.data.status === true) {
                    swal('Сообщения удалены!');
                    document.querySelector('.chats-list').innerHTML = `<button class="btn-down" id="btn-down" onclick="srcollDown()">&#8595;</button>`;
                }
            })
            .then(function () {
                document.querySelector('.delite-form').style.display = "none";
            })
            .catch(function (error) {
                swal("Ошибка при удалении!");
                console.log('Error ' + error);
            })
    });
}


SendMessages()
function SendMessages() {
    echo.channel('messages').listen('NewMessage', (data) => {
        let messageCheked = [];
        let arrNotCheked = '';
        let username = localStorage.getItem('UserName');
        let dateResponse = new Date(data.created_at);
        if (data.username == username & data.readed == null) {
            document.querySelector('.chats-list').innerHTML += `
                <div class="messageInChat" >
                <div class="messageRight">
            <div class="chat-title-right">
            ${data.username}
            </div>
            <p class="p-right"><div class="messageManager">
                ${data.message}
                <span class="time-right">${dateResponse.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</span>
            </div></p>
            <div class="messageInChat_notCheked">
            <span>  ✓ <span>
            <div class ="chat-item" data-id="${data.id}"></div>
            </div>
        </div>
        </div>`
            document.querySelector('.chats-list').scrollTop = document.querySelector('.chats-list').scrollHeight
        } else if (data.username == username & data.readed != null) {
            document.querySelector('.chats-list').innerHTML += `
            <div class="messageInChat" >
            <div class="messageRight">
        <div class="chat-title-right">
        ${data.username}
        </div>
        <p class="p-right"><div class="messageManager">
            ${data.message}
            <span class="time-right">${dateResponse.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</span>
        </div></p>
        <div class="messageInChat_Cheked">
        <span>  ✓✓ <span>
        <div class ="chat-item" data-id="${data.id}"></div>
        </div>
    </div>
    </div>`
            document.querySelector('.chats-list').scrollTop = document.querySelector('.chats-list').scrollHeight
        }

        else if (data.username != username & data.readed == null) {
            document.querySelector('.chats-list').innerHTML += `
            <div class="messagefromChat_notCheked" >
                <div class="messageLeft">
                    <div class="chat-title-left">
                    ${data.username}
                    </div>
                <div class="Cheked">
                    <div class="messageClient">
                        ${data.message}
                        <span class="time-right">${dateResponse.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</span>
                    </div>
                    <div class="messageClient_notCheked">
                    <span>  ✓ <span>
                    </div>
                </div>
                </div>
                <div class ="chat-item" data-id="${data.id}"></div>
            </div>`
            document.querySelector('.chats-list').scrollTop = document.querySelector('.chats-list').scrollHeight
            audioMessage.play();
        }
        else {
            document.querySelector('.chats-list').innerHTML += `
            <div class="messagefromChat">
                <div class="messageLeft">
                    <div class="chat-title-left">
                    ${data.username}
                    </div>
                    <div class="messageClient">
                        ${data.message}
                        <span class="time-right">${dateResponse.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</span>
                    </div>
                    <div class="messageClient_Cheked">
                        <span> ✓✓ </span>
                    </div>
                    <div class ="chat-item" data-id="${data.id}"></div>
                </div>
            </div>`
            document.querySelector('.chats-list').scrollTop = document.querySelector('.chats-list').scrollHeight
        }
        /*-----------------Сообщения к прочтению во время отправки сообщения-------------*/
        let check = document.querySelectorAll('.messagefromChat_notCheked');

        arrNotCheked = check.length;
        let alertCheked = document.querySelector('.not_cheked_Message span').innerHTML = arrNotCheked;
        if (arrNotCheked == 0) {
            document.querySelector('.not_cheked_Message span').style.display = "none";
        } else {
            document.querySelector('.not_cheked_Message span').style.display = "initial";
        }
        check.forEach(function (elem) {
            elem.onmouseout = function (event) {
                let id_cheked = elem.querySelector('.chat-item').getAttribute('data-id');
                messageCheked.push(id_cheked)
                /*Фильтр по повторяющимся элементам */

                //  console.log(filteredMessageCheked);
                axios.defaults.headers.common['X-CSRF-TOKEN'] = $('meta[name="csrf-token"]').attr('content');
                axios.post('/Organiser/public/api/checkMessage', {
                    body: messageCheked
                })
                    .then(function (response) {
                    })
                    .then(function () {
                    })
                    .catch(function (error) {
                    })
            }
        });

        let chats = document.querySelectorAll('.messageInChat');
        let messageToDelite = [];
        let messageUnDelite = [];
        let arrLength = '';
        chats.forEach(function (item) {

            let id_chat = item.querySelector('.chat-item').getAttribute('data-id');
            item.addEventListener('click', function (e) {

                if (item.style.backgroundColor == "") {
                    item.style.backgroundColor = "#9da3b6";
                    document.querySelector('.delite-form').style.display = "initial";
                    messageToDelite.push(id_chat);

                } else {
                    item.style.backgroundColor = "";
                    messageUnDelite.push(id_chat);
                    messageToDelite = messageToDelite.filter(function (item) {
                        return !messageUnDelite.includes(item);

                    });
                    messageUnDelite = [];
                }
                arrLength = messageToDelite.length
                if (arrLength == 0) {
                    document.querySelector('.delite-form').style.display = "none";
                }
                else if (arrLength > 0) {
                    document.querySelector('.delite-form').style.display = "initial";
                }
                document.querySelector('.btn-delite').innerHTML = "Удалить: " + arrLength;
            })
        });
        let delite = document.querySelector('.delite-form');
        delite.addEventListener('submit', function (e) {
            e.preventDefault();
            // console.log(JSON.stringify(messageToDelite));
            axios.post('/Organiser/public/api/deliteMessage', {
                body: messageToDelite
            })
                .then(function (response) {
                    if (response.data.status === true) {
                        swal('Сообщения удалены!');
                    }
                })
                .catch(function (error) {
                    swal("Ошибка при удалении!");
                    console.log('Error ' + error);
                })
        });
    });
}

echoDelete()
function echoDelete() {
    echo.channel('deleteMessages').listen('MessageDelete', (data) => {
        document.querySelector('.chats-list').innerHTML = [];
        document.querySelector('.chats-list').innerHTML = `<button class="btn-down" id="btn-down" onclick="srcollDown()">&#8595;</button>`;
        Messages()
    });
}
checkMessage()
function checkMessage() {
    echo.channel('messagesCheck').listen('CheckMessage', (data) => {
        document.querySelector('.chats-list').innerHTML = [];
        document.querySelector('.chats-list').innerHTML = `<button class="btn-down" id="btn-down" onclick="srcollDown()">&#8595;</button>`;
        Messages()
    });
}