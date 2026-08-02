document.addEventListener("DOMContentLoaded", () => {
    const chatBtn = document.getElementById("chatBtn");
    const chatPopup = document.getElementById("chatPopup");
    const closeBtn = document.getElementById("closeChat");
    const chatForm = document.getElementById("chatForm");
    const chatInput = document.getElementById("chatInput");
    const chatBody = document.getElementById("chatBody");
    const typingMessage = document.getElementById("typingMessage");

    chatBtn.onclick = () => {
        chatPopup.classList.add("show");
        chatInput.focus();
    };

    closeBtn.onclick = () => {
        chatPopup.classList.remove("show");
    };
    chatForm.addEventListener("submit", async function (e) {
        e.preventDefault();

        let message = chatInput.value.trim();

        if (message == "")
            return;

        addUser(message);

        chatInput.value = "";

        typingMessage.style.display = "flex";

        chatBody.appendChild(typingMessage);
        scrollBottom();

        try {
            const response = await fetch("aichat_api.php",
                {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ email: USER_EMAIL, message: message })
                });

            const data = await response.json();
            typingMessage.style.display = "none";
            addBot(data.reply);
        }
        catch (e) {
            typingMessage.style.display = "none";
            addBot("Server error.");
        }
    });

    function addUser(msg) {
        let div = document.createElement("div");
        div.className = "user-message";
        div.innerHTML = `<div class="user-text">${escapeHTML(msg)}</div>`;
        chatBody.appendChild(div);
        scrollBottom();
    }

    function addBot(msg) {
        let div = document.createElement("div");
        div.className = "bot-message";
        div.innerHTML = `<img src="images/mindEase.png" class="bot-logo"> <div class="bot-text"> ${escapeHTML(msg).replace(/\n/g, "<br>")} </div>`;
        chatBody.appendChild(div);
        scrollBottom();
    }

    function scrollBottom() {
        chatBody.scrollTop = chatBody.scrollHeight;
    }

    function escapeHTML(str) {
        return str.replace(/[&<>"']/g,

            function (m) {
                return ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' })[m];
            });
    }
});