$( window ).on( "load", function() { 
    getChatHistory();
});

$(document).ready(function() {

    $('#btn-send').click(function(){
        sendMessage();
        return false;   
    });

    // $('#input-form .msg-input').keypress(function(event) {
    //     if (event.keyCode === 13) {
    //       event.preventDefault();
    //       sendMessage();
    //       return false;
    //     }
    // });
});


async function sendMessage(){

    let chatForm = $('#input-form');
    let msg = $('#input-form .msg-input');   
    $('.chat-messages').append('<div class="loader"><div></div><div></div><div></div><div></div></div>');

    appendMessage('You', 'left', msg.val());

    $.ajax({
        url: 'api.php',
        method: 'POST',
        async: true,
        dataType: 'json',
        data:chatForm.serialize()

    }).done(function(resp) {        

        $('.loader').remove();

        console.log(resp);

        if(resp.text){
            appendMessage(resp.bot_name, 'right', resp.text);
            msg.val('');
            scrollToBottom();           
        }else if(resp.error){
            appendMessage('Bot', 'right', resp.error.message);
            scrollToBottom();
        }
    });
}

async function appendMessage(name, side, text) {
    
    const chat_messages = $(".chat-messages");
   
    text = htmlspecialchars(text);
    text = replaceNewlines(text);
    text = replacePattern(text);
    //text = replaceToImg(text);

    let modifiedText = replaceCodeWraps(text);

    const msgHTML = `<div class="message-wrap message-${side}">
        <div class="user-name">${name}</div>
        <div class="message">        
        ${modifiedText}
        </div>
    </div>`;
    chat_messages.append(msgHTML);    
    hljs.highlightAll();
}

async function getChatHistory() {

    let char_id = $('#char_id').val();
    $.ajax({
        url: 'api.php',
        method: 'GET',
        dataType: 'json',
        async: true,
        data:{history: true, char_id:char_id}

    }).done( function(resp){

        if(resp){
            resp.forEach((jsonObject) => {

                if(jsonObject.role=='user'){
                    appendMessage('User', 'left', jsonObject.content);
                }
                else if(jsonObject.role=='assistant'){
                    appendMessage('Bot', 'right', jsonObject.content);
                }
                scrollToBottom();
            });
        }
    });
}

function replaceCodeWraps(text) {
    let regex = /```([^`]+)```/g;
    let replacedText = text.replace(regex, '<pre><code class="language-javascript">$1</code></pre>');
    return replacedText;
}  

function htmlspecialchars(str) {
    const entities = {
      '&': '&amp;',
      '<': '&lt;',
      '>': '&gt;',
      '"': '&quot;',
      "'": '&#039;',
      '*': '<i>',
    };
    return str.replace(/[&<>"']/g, chr => entities[chr] || chr);
}

function replaceToImg(text){
    let inputString = '[image]'+text+'[image]';

    return inputString.replace(/\[image\](.*?)\[image\]/g, '<img src="$1">');
}

function replacePattern(input) {
    const pattern = /\*(.*?)\*/g;
    let output = input.replace(pattern, '<i>$1</i>');
    return output;
}

function replaceNewlines(input) {
  let output = input.replace(/\n/g, "<br>");
  return output;
}

function confirm_remove() {
  return confirm('Are you sure you want to delete');
}

function scrollToBottom() {
    let chatContent = $('.chat-messages');
    chatContent.scrollTop(chatContent.prop('scrollHeight'));
}
