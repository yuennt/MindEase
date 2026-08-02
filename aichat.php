<!-- AI Chat Popup -->
<div class="chat-popup" id="chatPopup"> <!-- Header -->
    <div class="chat-header">
        <div class="chat-title">
            <img src="images/mindEase.png" class="chat-logo">
            <p>Mind</p>
            <span>Ease</span>
        </div>

        <button class="close-btn" id="closeChat" type="button">
            <i class="bi bi-chevron-down"></i>
        </button>
    </div>

    <!-- Chat Body -->
    <div class="chat-body" id="chatBody">
        <div class="bot-message">
            <img src="images/mindEase.png" class="bot-logo">

            <div class="bot-text">
                Hello there! How can I help you today?
            </div>
        </div>

        <!-- Typing -->
        <div class="bot-message typing-message" id="typingMessage" style="display:none;">
            <img src="images/mindEase.png" class="bot-logo">
            <div class="typing-bubble">
                <span></span> <span></span> <span></span>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="chat-footer">
        <form class="chat-form" id="chatForm">
            <input type="text" id="chatInput" placeholder="Ask anything..." autocomplete="off">

            <div class="chat-controls">
                <button type="button">
                    <i class="bi bi-emoji-smile"></i>
                </button>

                <button type="button">
                    <i class="bi bi-paperclip"></i>
                </button>

                <button type="submit" id="sendBtn">
                    <i class="bi bi-arrow-up"></i>
                </button>
            </div>
        </form>
    </div>
</div>
