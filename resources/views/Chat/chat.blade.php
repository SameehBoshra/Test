<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <title>Chat App</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f5f5f5;
        }

        .chat-container {
            width: 400px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        .chat-header {
            background: #007bff;
            color: white;
            padding: 15px;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
        }

        .chat-area {
            height: 350px;
            overflow-y: auto;
            padding: 10px;
            display: flex;
            flex-direction: column;
        }

        .message {
            max-width: 80%;
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .sent {
            align-self: flex-end;
            background: #007bff;
            color: white;
        }

        .received {
            align-self: flex-start;
            background: #e1e1e1;
        }

        .chat-input {
            display: flex;
            padding: 10px;
            border-top: 1px solid #ccc;
        }

        .chat-input input {
            flex: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            outline: none;
        }

        .chat-input button {
            margin-left: 10px;
            padding: 10px 15px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .chat-input button:hover {
            background: #0056b3;
        }
        .chat-area {
    display: flex;
    flex-direction: column;
}

.chat {
    padding: 10px;
    border-radius: 10px;
    max-width: 60%;
}

/* لون خلفية المرسل */
.bg-success {
    background-color: #cbf6ff;
}

/* لون خلفية المستلم */
.bg-secondary {
    background-color: #7ddfe8;
}
.bg-primary {
    background-color: #31f0bd;  /* أزرق */
}
    </style>
</head>
<body>

<div class="chat-container">
    <div class="chat-header d-flex align-items-center p-2">
        <i class="fas fa-user-circle me-2"></i>
         {{ $receiver->name }}
    </div>
     <div class="chat-area" id="chat_area">

    </div>
    <div class="chat-input">
        <input type="text" id="message" placeholder="Type a message...">
        <button id="send">Send</button>
    </div>
</div>
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

<script>
    $(document).on("click", "#send", function () {
        let messageText = $("#message").val().trim();

        if (messageText === "") {
            alert("Message cannot be empty!");
            return;
        }

        $.post("/chat/{{ $receiver->id }}",  // FIXED: Ensure correct URL
        {
            message: messageText,

        },
        function (data, status) {
            console.log("Data: " + data + "\nStatus: " + status);

            let senderMessage = `
    <div class="d-flex flex-row p-3">
        <div class="chat ml-2 p-3 bg-primary text-white rounded">
            <i class="fas fa-user-circle me-2"></i> ${messageText}
        </div>
    </div>
`;

            $("#chat_area").append(senderMessage);
            $("#message").val(""); // Clear input field
        })
    });

    Pusher.logToConsole = true;

var pusher = new Pusher('527d7bcf6834500b15f5', {
 cluster: 'eu'
 });
 var userId = "{{ auth()->id() }}"; // ✅ Correct way to pass PHP variable to JS
 var channel = pusher.subscribe('chat'+userId);
 channel.bind("chatMessage", function (data) {
    let isSender = (data.sender_id == userId); // تحقق إذا كان المرسل هو المستخدم الحالي

    let messageHTML = `
        <div class="d-flex p-3 ${isSender ? 'align-self-end' : 'align-self-start'}" style="direction: rtl;">

            <div class="chat p-3 ${isSender ? 'bg-success text-white' : 'bg-secondary text-white'}">
               <i class="fas fa-user-circle me-2"></i>  ${data.message}
            </div>
        </div>
    `;

    $("#chat_area").append(messageHTML);
});



</script>


</body>
</html>
