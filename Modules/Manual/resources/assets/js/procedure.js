document.addEventListener("DOMContentLoaded", () => {
  const textareas = document.querySelectorAll(".form-area textarea");

  const autosize = (ta) => {
    ta.style.height = "auto"; // 一旦リセット
    ta.style.height = ta.scrollHeight + "px"; // 内容に合わせる
  };

  textareas.forEach((ta) => {
    autosize(ta); // 初期表示時に高さを調整
    ta.addEventListener("input", () => autosize(ta)); // 入力のたびに更新
  });

  // 画像読み込みやフォント読み込み後に高さが変わる場合の保険
  window.addEventListener("load", () => {
    textareas.forEach(autosize);
  });
});
