    const accountBtn = document.querySelector(".account-area");
    const accountModal = document.getElementById("accountModal");
    // トグル表示
    accountBtn.addEventListener("click", (e) => {
      e.stopPropagation(); // 外クリック判定を防ぐ
      const isVisible = accountModal.style.display === "block";
      accountModal.style.display = isVisible ? "none" : "block";
    });

    // モーダル外をクリックしたら閉じる
    document.addEventListener("click", (e) => {
      if (!accountModal.contains(e.target) && !accountBtn.contains(e.target)) {
        accountModal.style.display = "none";
      }
    });