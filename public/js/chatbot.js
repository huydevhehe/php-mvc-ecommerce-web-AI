const chatbotData = [
  {
    keywords: ["xin chao", "hello", "chao", "hi", "hê lô", "hế lô"],
    answer: "Chào bạn! Mình là Bot hỗ trợ của ShopeeFood. Bạn cần giúp gì?"
  },
  {
    keywords: ["cam on", "cảm ơn", "thank", "cám ơn", "cámơn"],
    answer: "Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi! Nếu cần thêm trợ giúp, hãy cho mình biết nhé."
  },
  {
    keywords: ["gioi thieu", "shopeefood la gi", "ung dung", "app nay", "shopeefood"],
    answer: "ShopeeFood là ứng dụng đặt món ăn trực tuyến, giao hàng nhanh chóng và tiện lợi."
  },
  {
    keywords: ["tro giup", "giup", "ho tro", "support"],
    answer: "Bạn có thể hỏi về món ăn, giảm giá, giờ mở cửa hoặc cách đặt hàng."
  },
  {
    keywords: ["lien he", "sdt", "email", "hotline", "lienlac"],
    answer: "Bạn có thể liên hệ với chúng tôi qua hotline 1900-1234 hoặc email."
  },
  {
    keywords: ["thanh toan", "tra tien", "quét mã", "qr", "momo", "payment"],
    answer: "Chúng tôi hỗ trợ thanh toán bằng tiền mặt, Quét QR và ví điện tử."
  },
  {
    keywords: ["danh gia", "feedback", "gop y", "đánh giá"],
    answer: "Chúng tôi rất mong nhận được đánh giá của bạn để cải thiện dịch vụ."
  },
  {
    keywords: ["mon ngon", "goi y mon", "an gi", "goi mon", "mon an"],
    answer: "Bạn có thể thử Gà rán giòn cay hoặc Combo Mì Ý nhé!"
  },
  {
    keywords: ["giam gia", "voucher", "ma khuyen mai", "uu dai"],
    answer: "Hiện tại có mã FREESHIP50 và GIAM10K áp dụng tại thanh toán."
  },
  {
    keywords: ["mo cua", "gio hoat dong", "thoi gian", "luc nao mo"],
    answer: "Chúng tôi mở cửa từ 9h sáng đến 10h tối hàng ngày."
  },
  {
    keywords: ["giao hang", "ship", "dat ship", "van chuyen"],
    answer: "ShopeeFood có hỗ trợ giao hàng tận nơi trong bán kính 5km."
  },
  {
    keywords: ["dat mon", "mua", "chon mon", "goi mon"],
    answer: "Bạn chỉ cần chọn món và bấm 'Mua ngay' là xong!"
  },
  {
    keywords: ["khach hang", "khach hang la", "khach la gi"],
    answer: "Thượng đế!"
  }
];

function sendChat() {
  const input = document.getElementById("chat-input");
  const content = document.getElementById("chat-content");
  const message = input.value.trim();
  if (!message) return;

  content.innerHTML += `<div><strong>Bạn:</strong> ${message}</div>`;
  saveMessage("Bạn", message);

  const normalized = normalizeText(message);
  let reply = "🤖 Xin lỗi, mình chưa hiểu ý bạn. Vui lòng thử lại!";

  for (let item of chatbotData) {
    for (let keyword of item.keywords) {
      if (normalized.includes(keyword)) {
        reply = item.answer;
        break;
      }
    }
    if (reply !== "🤖 Xin lỗi, mình chưa hiểu ý bạn. Vui lòng thử lại!") break;
  }

  const typing = document.createElement("div");
  typing.id = "typing-indicator";
  typing.innerHTML = "<em>⏳ Bot đang nhập...</em>";
  content.appendChild(typing);
  content.scrollTop = content.scrollHeight;

  setTimeout(() => {
    typing.remove();
    typeReply(reply, content);
  }, 800);

  input.value = "";
}

function typeReply(text, container) {
  const botLine = document.createElement("div");
  botLine.innerHTML = "<strong>Bot:</strong> ";
  container.appendChild(botLine);

  let index = 0;
  const typingInterval = setInterval(() => {
    botLine.innerHTML += text.charAt(index);
    index++;
    container.scrollTop = container.scrollHeight;

    if (index === text.length) {
      clearInterval(typingInterval);
      saveMessage("Bot", text);
    }
  }, 35);
}

function normalizeText(str) {
  return str
    .toLowerCase()
    .normalize("NFD")
    .replace(/[\u0300-\u036f]/g, "")
    .replace(/[^\w\s]/gi, '')
    .replace(/\s+/g, ' ')
    .trim();
}

function saveMessage(who, msg) {
  const history = JSON.parse(localStorage.getItem("chat_history") || "[]");
  history.push({ who, msg });
  localStorage.setItem("chat_history", JSON.stringify(history));
}

function restoreChat() {
  const content = document.getElementById("chat-content");
  const history = JSON.parse(localStorage.getItem("chat_history") || "[]");
  for (let { who, msg } of history) {
    content.innerHTML += `<div><strong>${who}:</strong> ${msg}</div>`;
  }
  content.scrollTop = content.scrollHeight;
}

function resetChat() {
  localStorage.removeItem("chat_history");
  localStorage.removeItem("chatbox_shown");

  document.getElementById("chat-content").innerHTML = "";
  document.getElementById("chat-content").classList.add("chat-hidden");
  document.getElementById("chat-input-wrapper").classList.add("chat-hidden");

  const btn = document.querySelector('.btn-chat');
  const note = document.querySelector('.note');
  const noShow = document.querySelector('.no-show-btn');
  if (btn) btn.style.display = "block";
  if (note) note.style.display = "block";
  if (noShow) noShow.style.display = "block";
}

function disableAutoChat() {
  localStorage.setItem('chatbox_disabled', 'true');
  hideChatbox();
}

function hideChatbox() {
  document.getElementById("ai-chat-popup").style.display = "none";
}

function openChat() {
  // hiện lại khi bấm chat
  document.getElementById("chat-content").classList.remove("chat-hidden");
  document.getElementById("chat-input-wrapper").classList.remove("chat-hidden");

  const btn = document.querySelector('.btn-chat');
  const note = document.querySelector('.note');
  const noShow = document.querySelector('.no-show-btn');
  if (btn) btn.style.display = "none";
  if (note) note.style.display = "none";
  if (noShow) noShow.style.display = "none";

  restoreChat();
}

document.addEventListener("DOMContentLoaded", () => {
  const input = document.getElementById("chat-input");
  if (input) {
    input.addEventListener("keyup", function (e) {
      if (e.key === "Enter") sendChat();
    });
  }
});
