<x-studentUI>
<x-slot name="MainContent">
<style>
html, body {
    height: 100%;
    margin: 0;
    padding: 0;
    background-color: #f0f2f5;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* Chat container inside main content */
.chat-container {
    display: flex;
    flex-direction: column;
    height: 80vh; /* fixed height */
    max-height: 80vh;
    width: 100%;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    background-color: #ffffff;
}

/* Header */
.chat-header {
    background: linear-gradient(90deg, #4361ee, #3f37c9);
    color: #fff;
    text-align: center;
    padding: 1rem;
    font-weight: bold;
    font-size: 1.25rem;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

/* Chat body */
.chat-body {
    flex: 1;
    overflow-y: auto;
    padding: 1rem;
    background-color: #f9fafb;
}

/* Footer */
.chat-footer {
    padding: 0.75rem 1rem;
    background-color: #f1f1f1;
    border-top: 1px solid #ccc;
}

/* Messages */
.message {
    margin-bottom: 0.75rem;
    display: flex;
    flex-direction: column;
}

.user-message {
    align-items: flex-end;
}

.bot-message {
    align-items: flex-start;
}

.badge-custom {
    padding: 0.65rem 1rem;
    border-radius: 20px;
    max-width: 75%;
    word-wrap: break-word;
    font-size: 0.95rem;
    line-height: 1.3;
}

/* User and bot styles */
.user-badge {
    background-color: #4361ee;
    color: white;
    border-radius: 20px;
}

.bot-badge {
    background-color: #e6eafc;
    color: #212529;
    border-radius: 20px;
}

/* Input */
.input-group .form-control {
    border-radius: 50px 0 0 50px;
}
.input-group .btn {
    border-radius: 0 50px 50px 0;
    background-color: #4361ee;
    color: #fff;
    font-weight: 500;
    transition: all 0.3s ease;
}
.input-group .btn:hover {
    background-color: #3f37c9;
    transform: translateY(-2px);
}
</style>

<div class="chat-container">
    <div class="chat-header">
        🎓 Student Chatbot Assistant
    </div>

    <div class="chat-body" id="chatbox">
        <div id="messages">
            <div class="message bot-message">
                <span class="badge-custom bot-badge">Hi! Ask me anything related to your studies 📚</span>
            </div>
        </div>
    </div>

    <div class="chat-footer">
        <form id="chat-form" onsubmit="sendMessage(event)">
            <div class="input-group">
                <input type="text" id="user-input" class="form-control" placeholder="Type your message..." required>
                <button type="submit" class="btn">Send</button>
            </div>
        </form>
    </div>
</div>

<script>
function sendMessage(event) {
    event.preventDefault();
    const input = document.getElementById('user-input');
    const message = input.value.trim();
    if(!message) return;

    const messagesDiv = document.getElementById('messages');

    // Append user message
    const userDiv = document.createElement('div');
    userDiv.classList.add('message', 'user-message');
    const userBadge = document.createElement('span');
    userBadge.classList.add('badge-custom', 'user-badge');
    userBadge.textContent = message;
    userDiv.appendChild(userBadge);
    messagesDiv.appendChild(userDiv);

    // Scroll to bottom
    const chatbox = document.getElementById('chatbox');
    chatbox.scrollTop = chatbox.scrollHeight;

    // Clear input
    input.value = '';

    // Append bot "Thinking..."
    const botDiv = document.createElement('div');
    botDiv.classList.add('message', 'bot-message');
    const botBadge = document.createElement('span');
    botBadge.classList.add('badge-custom', 'bot-badge');
    botBadge.textContent = "Thinking...";
    botDiv.appendChild(botBadge);
    messagesDiv.appendChild(botDiv);
    chatbox.scrollTop = chatbox.scrollHeight;

    // Send message to backend
    fetch("{{ route('student.chatbot') }}", {
        method: 'POST',
        headers: {
            'Content-Type':'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({message: message})
    })
    .then(res => res.json())
    .then(data => {
        // Remove "Thinking..."
        botBadge.textContent = '';
        const reply = data.reply || "Sorry, I couldn't understand that 🤖";
        const words = reply.split(' ');
        let index = 0;

        const interval = setInterval(() => {
            if(index < words.length) {
                botBadge.textContent += words[index] + ' ';
                chatbox.scrollTop = chatbox.scrollHeight;
                index++;
            } else clearInterval(interval);
        }, 80);
    })
    .catch(err => {
        botBadge.textContent = "Error occurred!";
        botBadge.classList.replace('bot-badge', 'bg-danger');
        botBadge.classList.replace('text-dark', 'text-white');
        console.error(err);
    });
}
</script>
</x-slot>
</x-studentUI>
