import $ from "jquery";
window.$ = window.jQuery = $;

import Echo from "laravel-echo";

window.Pusher = Pusher;

// chat
document.addEventListener("DOMContentLoaded", () => {
      const chatbox = document.getElementById("chat-box");
      const chatForm = document.getElementById("chat-form");
      const msgInput = document.getElementById("message");
      const notifCount = document.getElementById("notif-count");
      const notifList = document.getElementById("notif-list");

      window.Pusher = Pusher;
      window.Echo = new Echo({
            broadcaster: "pusher",
            key: "your-key",
            cluster: "ap1",
            forceTLS: true,
            authEndpoint: "/broadcasting/auth",
            auth: { headers: { "X-CSRF-TOKEN": csrf } },
      });

      // Listen chat
      Echo.private(`task.${taskId}`).listen("MessageSent", (e) => {
            chatbox.innerHTML += `<div><strong>${e.sender}:</strong> ${e.message}</div>`;
            chatbox.scrollTop = chatbox.scrollHeight;
            // trigger custom notif
            Echo.private(`user.${userId}`).whisper("newmessage", {});
      });

      // Listen notification
      Echo.private(`user.${userId}`).listen("NotificationSent", (e) => {
            alert("Notif: " + e.notification);
            loadNotif();
      });

      // Send chat
      chatForm.addEventListener("submit", (e) => {
            e.preventDefault();
            fetch("/chat/send", {
                  method: "POST",
                  headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrf,
                  },
                  body: JSON.stringify({
                        message: msgInput.value,
                        task_id: taskId,
                  }),
            }).then(() => {
                  msgInput.value = "";
            });
      });

      // ----- NOTIF -----
      function loadNotif() {
            fetch("/notifications")
                  .then((r) => r.json())
                  .then((d) => {
                        notifCount.innerText = d.length || "";
                        notifList.innerHTML = "";
                        d.forEach((n) => {
                              let li = document.createElement("li");
                              li.innerHTML = `<button data-id="${n.id}">${n.title}</button>`;
                              notifList.appendChild(li);
                        });
                  });
      }
      loadNotif();

      notifList.addEventListener("click", (e) => {
            if (e.target.dataset.id) {
                  fetch(`/notifications/${e.target.dataset.id}/read`, {
                        method: "POST",
                        headers: { "X-CSRF-TOKEN": csrf },
                  }).then(() => {
                        loadNotif();
                  });
            }
      });
});
