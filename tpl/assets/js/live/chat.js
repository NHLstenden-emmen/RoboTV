var livechatWebSocket, fullname, level, email, team, user_id;

const liveChat = document.getElementById("liveChat");        
const chatInput = document.getElementById("liveChatInput");

const typeMessage = () => { 
    if(event.key === 'Enter') 
    {
        sendMessage(); 
    }
}

//Senders
const sendDelete = (id) =>  livechatWebSocket.send(JSON.stringify({"type": "delete", "id": id}));
const sendPoll = (option, id) => livechatWebSocket.send(JSON.stringify({"type": "poll", "option": option, "id": id}));
const sendDrawingPoll = (stars, bot, id) => livechatWebSocket.send(JSON.stringify({"type": "drawingpoll", "bot": bot, "stars":parseInt(stars)+1, "id": id}));
const sendMessage = () => { 
        if(chatInput.value.trim() != "") {
            livechatWebSocket.send(JSON.stringify({"type": "send", "message": chatInput.value}));
        }
        chatInput.value = ""};

//Receivers
const deleteMessage = (id) => {
    var message = document.getElementById(id);
    if(message) {
        var nextMessage = message.nextElementSibling;
        if(nextMessage && nextMessage.dataset.userId  == message.dataset.userId) {
            if(message.querySelector('.user')) {
                nextMessage.prepend(message.querySelector('.user'));
            }
        }
        message.remove();
    }
}
const onLeave = (messageData) => showMessage(messageData.type,messageData.message,messageData.id, messageData.username, messageData.userid, messageData.level, messageData.team);
const showDrawingPoll = (messageData) =>  toastShow('drawing', messageData.id, 'Server | Tekening', messageData.question, messageData, messageData.length);
const showPoll = (messageData) => toastShow('default', messageData.id, 'Server | Poll', messageData.question, messageData.options, messageData.length);
const closePolls = () => { document.querySelectorAll(".drawingpoll").forEach(element => element.remove()); document.querySelectorAll(".regularpoll").forEach(element => element.remove());}


const onJoin = (messageData) => {
    if(messageData.user_id == user_id)
    {
        localStorage.setItem("fullname",  messageData.username);
        localStorage.setItem("email",  messageData.email);
        localStorage.setItem("level",  messageData.level);
        localStorage.setItem("team",   messageData.team);

        showMessage(messageData.type,messageData.message, messageData.id,localStorage.getItem("fullname"), messageData.user_id, localStorage.getItem("level"), localStorage.getItem("team"));
    } 
    else 
    {
        showMessage(messageData.type,messageData.message, messageData.id, messageData.username, messageData.user_id, messageData.level, messageData.team);
   }
}

function showMessage(type, message, id, username, userId, level = null, team = null) {
    var messageElement = document.createElement("div"); 
    messageElement.classList.add("messageBlock"); // anders herken ik hem nie in css
    messageElement.setAttribute("id", id);
    messageElement.dataset.userId = userId;

    var userHTML = "";
    if(!liveChat.hasChildNodes() || (liveChat.hasChildNodes() && userId != liveChat.lastChild.dataset.userId)) {
        if(userId == -420) {
            userHTML = `
            <p class="user">
                <img src="/tpl/assets/images/rick.png" style="width: 1.3rem; margin-right: 0.5rem;">
                "Rick Astley"
            </p>
            `;
        } else {
            var isTeam = team;
            var isMod = (level == 2); 

            username += isTeam ? " [" + team + "]" : "" + isMod ? "[MOD]" : "";
            

            userHTML = `
            <p class="user"">
                ` + (isTeam ? `<img src="/tpl/assets/images/team/` + team + `/logoResize.png" style="width: 2.5rem; margin-right: 0.5rem;">` : "")  + `
                ` + (isMod ? `<i class="fas fa-wrench" style="color: rgb(55, 22, 126); margin-right: 0.1rem;"></i>&nbsp&nbsp` : (!isTeam ? `<i class="avatar fas fa-user-circle"></i>&nbsp&nbsp` : "")) + username + `
            </p>
            `;
        }
    }
    
    var youAreMod = (localStorage.getItem("level") == 2);
    messageHTML = `
    <p class="message `+ type +`">
        ` + message + `
        ` + (youAreMod ? `<i class="far fa-trash-alt" onclick="javascript:sendDelete(`+ id +`)"></i>` : "") + `
    </p>
    `;


    messageElement.innerHTML = `
    <div class="messageContent">
        ` + userHTML + `
        ` + messageHTML + `
    </div>
    `;

    liveChat.appendChild(messageElement);

    $("#liveChat").stop().animate({ scrollTop: $("#liveChat")[0].scrollHeight}, 700);
}

function showPollResult(messageData) {
    var resultMessage = "";
    sortByValue(messageData.result).forEach(element => resultMessage += " " + element[0] + " heeft " + element[1] + " stemmen ");
    setTimeout(() => {      toastShow('default', messageData.id, 'Server | Poll resultaat', resultMessage, null, 30);}, 2000);

}

function showDrawResult(messageData) {
    var resultMessage = "";
    messageData.result.sort((a,b) => a.index - b.index).forEach((e) => resultMessage += " " + e.name + " heeft een score van " + e.score + " ");
    setTimeout(() => {      toastShow('default', messageData.id, 'Server | Poll resultaat', resultMessage, null, 30);}, 2000);
}

const updateViewerCount = (amount) => {

    var container = document.getElementById('viewerCounter');

    container.classList.add('pre-animation');
    container.innerHTML = amount;
    setTimeout(() => {
        container.classList.remove('pre-animation')
    },1000);
}

function messageListener(chatData) { 
    if(isJSON(chatData.data)) {
        var messageData = JSON.parse(chatData.data);
        switch(messageData.type) {
            case "join":
                onJoin(messageData);
            break;
            case "leave":
                onLeave(messageData);
            break;
            case "delete":
                deleteMessage(messageData.id);
            break;
            case "poll":
                showPoll(messageData);
            break;
            case "pollresult":
                showPollResult(messageData);
            break;
            case "drawingpoll":
                showDrawingPoll(messageData);
            break;
            case "drawresult":
                showDrawResult(messageData);
            break;
            case "disablepollbutton":
                disableButton(messageData.id);
            break;
            case "readysignal":
                toastShow('default', 0, 'Server | Ready', "[" + messageData.match + "] " + messageData.team + " zet jullie robot klaar!", null, 10);
            break;
            case "message":
                showMessage("", messageData.message, messageData.id, messageData.username, messageData.userid, messageData.level, messageData.team);
            break;
            case "rolled": 
                showMessage(messageData.type, messageData.username + " got rickrolled!", "rick", "Rick Astley", -420, null, null);
            break;
            case "closepolls":
                closePolls();
            break;
            case "viewerCount":
                updateViewerCount(messageData.amount);
            break;
            case "naughty": 
                window.location.href = "https://www.youtube.com/watch?v=dQw4w9WgXcQ";
            break;
        }
    }
}

function launchLiveChat(user_idInput)
{
    if ("WebSocket" in window)
    {
        user_id = user_idInput;
        livechatWebSocket = new WebSocket("ws://77.162.30.112:49152");

        livechatWebSocket.addEventListener("open", () =>  livechatWebSocket.send(JSON.stringify({"user_id": user_id, "type": "join"})));
        livechatWebSocket.addEventListener("message", (chatData) => messageListener(chatData));
        livechatWebSocket.addEventListener("close", () => {
            showMessage("Connection has been closed", 0, "Server", -1);
            console.log('Socket is closed. Reconnect will be attempted in 1 second.', e.reason);
            setTimeout(() => launchLiveChat(user_id), 1000);
        });
    }
    else
    {
        alert("WebSocket is NOT supported by your Browser!");
    }
}