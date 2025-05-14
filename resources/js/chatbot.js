document.addEventListener("DOMContentLoaded", () => {
    const chatBtn = document.getElementById("chat-button");
    const chatBox = document.getElementById("chat-box");
    const closeBtn = document.getElementById("close-chat");
    const sendBtn = document.getElementById("send-button");
    const input = document.getElementById("user-input");
    const messages = document.getElementById("chat-messages");

    chatBtn?.addEventListener("click", () => {
        chatBox.classList.toggle("hidden");
    });

    closeBtn?.addEventListener("click", () => {
        chatBox.classList.add("hidden");
    });

    sendBtn?.addEventListener("click", sendMessage);
    input?.addEventListener("keydown", e => {
        if (e.key === "Enter") sendMessage();
    });

    function sendMessage() {
        const text = input.value.trim();
        if (!text) return;

        const userMsg = document.createElement("div");
        userMsg.className = "text-right text-gray-800";
        userMsg.textContent = "👤 " + text;
        messages.appendChild(userMsg);

        const botMsg = document.createElement("div");
        botMsg.className = "text-gray-600";
        botMsg.textContent = "🤖 Lo siento, aún soy un bot simple. Pronto podré ayudarte mejor.";
        messages.appendChild(botMsg);

        input.value = "";
        messages.scrollTop = messages.scrollHeight;
    }
});
