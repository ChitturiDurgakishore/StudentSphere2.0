<x-studentUI>
    <x-slot name="MainContent">
        <style>
            html,
            body {
                height: 100%;
                margin: 0;
                padding: 0;
                background-color: #f0f2f5;
            }

            .chat-container {
                display: flex;
                flex-direction: column;
                height: 100vh;
                max-height: 100vh;
                width: 100%;
                max-width: 100%;
            }

            .chat-header {
                background-color: #007bff;
                color: white;
                text-align: center;
                padding: 1rem;
                font-weight: bold;
                font-size: 1.3rem;
            }

            .chat-body {
                flex: 1;
                overflow-y: auto;
                padding: 1rem;
                background-color: #ffffff;
            }

            .chat-footer {
                padding: 0.75rem 1rem;
                background-color: #f1f1f1;
                border-top: 1px solid #ccc;
            }

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
                padding: 0.6rem 1rem;
                border-radius: 15px;
                max-width: 80%;
                display: inline-block;
                word-wrap: break-word;
            }

            .user-badge {
                background-color: #007bff;
                color: white;
            }

            .bot-badge {
                background-color: #f1f1f1;
                color: #333;
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
                        <input type="text" id="user-input" class="form-control" placeholder="Type your message..."
                            required>
                        <button type="submit" class="btn btn-primary">Send</button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            function sendMessage(event) {
                event.preventDefault();
                const input = document.getElementById('user-input');
                const message = input.value.trim();
                if (!message) return;

                const messagesDiv = document.getElementById('messages');

                // Append user message
                messagesDiv.innerHTML += `
            <div class="text-end mb-2">
                <span class="badge bg-primary text-white p-2">${message}</span>
            </div>
        `;

                // Scroll to bottom
                document.getElementById('chatbox').scrollTop = chatbox.scrollHeight;

                // Clear input
                input.value = '';

                // Append placeholder "Thinking..."
                const thinkingElement = document.createElement('div');
                thinkingElement.classList.add('text-start', 'mb-2');
                const badge = document.createElement('span');
                badge.classList.add('badge', 'bg-light', 'text-dark', 'p-2');
                badge.textContent = "Thinking...";
                thinkingElement.appendChild(badge);
                messagesDiv.appendChild(thinkingElement);

                // Send to backend
                fetch("{{ route('student.chatbot') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            message: message
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        const fullText = data.reply;
                        badge.textContent = ''; // Clear "Thinking..."

                        const words = fullText.split(' ');
                        let index = 0;

                        const interval = setInterval(() => {
                            if (index < words.length) {
                                badge.textContent += words[index] + ' ';
                                document.getElementById('chatbox').scrollTop = chatbox.scrollHeight;
                                index++;
                            } else {
                                clearInterval(interval);
                            }
                        }, 100); // speed (ms) between each word
                    })
                    .catch(err => {
                        badge.textContent = "Error occurred!";
                        badge.classList.replace('bg-light', 'bg-danger');
                        badge.classList.replace('text-dark', 'text-white');
                        console.error(err);
                    });
            }
        </script>

    </x-slot>
</x-studentUI>
