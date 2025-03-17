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
            transition: background 0.3s ease;
        }

        .sidebar {
            display: none;  /* Initially hidden */
            width: 250px;
            height: 100%;
            background-color: #f8f9fa;
            position: fixed;
            left: 0;
            top: 0;
            overflow-y: auto;
            transition: transform 0.3s ease-in-out;
        }
        .sidebar.active {
            display: block;  /* Show when active */
        }
        .dark-mode .sidebar {
            background: #042429;
            color: white;
        }

.sidebar-title {
    text-align: center;
    font-size: 20px;
    margin-bottom: 15px;
    font-weight: bold;
}
.dark-mode .sidebar-title {
            background: #042429;
            color: white;
        }


.user-list-container {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.user-card {
    display: flex;
    align-items: center;
    padding: 12px;
    background: #34495e;
    border-radius: 8px;
    cursor: pointer;
    transition: background 0.3s;
}

.user-card:hover {
    background: #3b5998;
}

.user-card.active {
    background: #1abc9c;
}

.user-icon {
    font-size: 30px;
    color: white;
    margin-right: 12px;
}

.user-info {
    display: flex;
    flex-direction: column;
}

.user-name {
    font-size: 16px;
    font-weight: bold;
}

.user-status {
    font-size: 12px;
    color: #bdc3c7;
}
        .dark-mode {
            background-color: #121212;
            color: white;
        }

        .chat-container {
            width: 110vh;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            transition: background 0.3s ease, color 0.3s ease;
        }

        .dark-mode .chat-container {
            background: #042429;
            color: white;
        }

        .chat-header {
            background: #007bff;
            color: white;
            padding: 15px;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .theme-toggle {
            background: none;
            border: none;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        .chat-area {
            height: 80vh;
            overflow-y: auto;
            padding: 10px;
            display: flex;
            flex-direction: column;
        }

        .chat-message {
            max-width: 70%;
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 10px;
            font-size: 14px;
            word-wrap: break-word;
        }

        .chat-message.sent {
            align-self: flex-end;
            background: #007bff;
            color: white;
            text-align: right;
            padding: 10px;
            border-radius: 10px;
            margin-left: auto;
        }

        .chat-message.received {
            align-self: flex-start;
            background: #e1e1e1;
            color: black;
            text-align: left;
            padding: 10px;
            border-radius: 10px;
            margin-right: auto;
        }

        .dark-mode .chat-message.sent {
            background: #4a90e2;
        }

        .dark-mode .chat-message.received {
            background: #333;
            color: white;
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

        .dark-mode .chat-input input {
            background: #333;
            color: white;
            border: 1px solid #555;
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

    </style>
</head>
<body>



    <div class="sidebar" id="sidebar">
        <h3 class="sidebar-title">Users</h3>
        <div class="user-list-container">
            @foreach($users as $user)
            <div class="user-card" data-id="{{ $user->id }}" data-name="{{ $user->name }}">

                <div class="user-info">
                    <h4 class="user-name">{{ $user->name }}</h4>
                    <p class="user-status">Online</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
<div class="chat-container">
    <div class="chat-header d-flex align-items-center p-2">
        <i class="fas fa-user-circle me-2"></i> {{ $receiver->name }}
        <button class="user-list-btn" id="user-list-btn"><i class="fas fa-users"></i></button>
        <button class="theme-toggle" id="theme-toggle">
            <i class="fas fa-moon"></i>
        </button>
    </div>

    <div class="chat-area" id="chat_area">
        @foreach($messages as $message)
            <div class="chat-message {{ $message->sender == auth()->id() ? 'sent' : 'received' }}">
                <strong>{{ $message->sender == auth()->id() ? 'You' : $receiver->name }}:</strong>
                {{ $message->message }}
                <small>{{ $message->created_at->format('H:i') }}</small>
            </div>
        @endforeach
    </div>

    <div class="chat-input">
        <input type="text" id="message" placeholder="Type a message...">
        <button id="send">Send</button>
    </div>
</div>

<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
   document.getElementById("user-list-btn").addEventListener("click", function () {
            var sidebar = document.getElementById("sidebar");
            sidebar.classList.toggle("active");
        });
    // Theme Toggle Functionality
   const themeToggle = document.getElementById("theme-toggle");
    const body = document.body;

    function updateThemeIcon(isDark) {
        if (isDark) {
            themeToggle.innerHTML = '<i class="fas fa-sun"></i>'; // Light mode icon
        } else {
            themeToggle.innerHTML = '<i class="fas fa-moon"></i>'; // Dark mode icon
        }
    }

    function toggleTheme() {
        body.classList.toggle("dark-mode");
        const isDark = body.classList.contains("dark-mode");
        localStorage.setItem("theme", isDark ? "dark" : "light");
        updateThemeIcon(isDark);
    }

    // Load theme preference
    if (localStorage.getItem("theme") === "dark") {
        body.classList.add("dark-mode");
    }
    updateThemeIcon(body.classList.contains("dark-mode"));

    themeToggle.addEventListener("click", toggleTheme);


// get user
$(document).on("click", ".user-card", function () {
    let userId = $(this).data("id");

    // Redirect to the correct chat URL
    window.location.href = `/chat/${userId}`;
});

// Chat Send Message Logic
$(document).on("click", "#send", function () {
    let messageText = $("#message").val().trim();
    let currentTime = new Date().toLocaleTimeString();
    let receiverId = "{{ $receiver->id }}"; // Get receiver ID from PHP

    if (messageText === "") {
        alert("Message cannot be empty!");
        return;
    }

    $.post(`/chat/${receiverId}`, {
        message: messageText,
        _token: "{{ csrf_token() }}"
    },
    function (data, status) {
        console.log("Message sent successfully!", data);

        let senderMessage = `
            <div class="chat-message sent">
                <strong>You:</strong> ${messageText}
                <small>${currentTime}</small>
            </div>
        `;
        $("#chat_area").append(senderMessage);
        $("#message").val("");
        $("#chat_area").scrollTop($("#chat_area")[0].scrollHeight);
    });
});

    // Pusher Event Listener for Incoming Messages
    Pusher.logToConsole = true;
    var pusher = new Pusher('527d7bcf6834500b15f5', { cluster: 'eu' });

    var userId = "{{ auth()->id() }}";
    var channel = pusher.subscribe(`chat${userId}`);

    channel.bind("chatMessage", function (data) {
        let isSender = (data.sender_id == userId);

        let messageHTML = `
            <div class="chat-message ${isSender ? 'sent' : 'received'}">
                <strong>${isSender ? 'You' : "{{ $receiver->name }}"}</strong>: ${data.message}
                <small>${new Date().toLocaleTimeString()}</small>
            </div>
        `;

        $("#chat_area").append(messageHTML);
        $("#chat_area").scrollTop($("#chat_area")[0].scrollHeight);
    });


</script>

</body>
</html>
