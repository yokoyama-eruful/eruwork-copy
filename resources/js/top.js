(() => {
  // ====== 設定（Deck 用）======
  const GAP_FIXED = 15; // “ずらし”の上限(px)
  const SAFE = 1;       // 右端の安全余白(px)
  const MIN_W = 140;    // カード最小幅(px)

  // ====== モーダル（共通）======
  const modal = document.getElementById("cardModal");
  const modalTitle = document.getElementById("modalTitle");
  const modalBody = document.getElementById("modalBody");
  const modalClose = document.getElementById("modalClose");

  function openModalFromCard(card) {
    const titleEl = card.querySelector(".title");
    const bodyEl = card.querySelector(".body");
    if (modalTitle) modalTitle.textContent = titleEl ? titleEl.textContent : "詳細";
    if (modalBody) modalBody.textContent = bodyEl ? bodyEl.textContent : "内容がありません。";
    if (typeof modal?.showModal === "function") modal.showModal();
    else modal?.setAttribute("open", "");
    modalClose?.focus({ preventScroll: true });
  }

  function closeModal() {
    if (modal?.hasAttribute("open")) modal.close?.();
    modal?.removeAttribute("open");
  }

  modal?.addEventListener("click", (e) => {
    const r = modal.getBoundingClientRect();
    const inside = e.clientX >= r.left && e.clientX <= r.right && e.clientY >= r.top && e.clientY <= r.bottom;
    if (!inside) closeModal();
  });
  modalClose?.addEventListener("click", closeModal);
  window.addEventListener("keydown", (e) => {
    if (e.key === "Escape" && modal?.hasAttribute("open")) closeModal();
  });

  // ====== レイアウト（単一デッキ）======
  function layoutDeck(deckEl) {
    const cards = Array.from(deckEl.querySelectorAll(".card"));
    const n = cards.length;
    if (!n) return;

    deckEl.style.removeProperty("width");
    const deckW = deckEl.clientWidth;

    // 狭いときは gap を自動縮小
    let gapMax = n > 1 ? (deckW - SAFE - MIN_W) / (n - 1) : 0;
    gapMax = Math.max(0, gapMax);
    const gap = Math.min(GAP_FIXED, gapMax);

    const cardW = Math.max(MIN_W, deckW - gap * (n - 1) - SAFE);

    cards.forEach((c, i) => {
      if (!c.hasAttribute("tabindex")) c.setAttribute("tabindex", "0");
      if (!c.hasAttribute("role")) c.setAttribute("role", "button");
      if (!c.hasAttribute("aria-selected")) c.setAttribute("aria-selected", "false");

      c.style.position = "absolute";
      c.style.left = "0";
      c.style.width = cardW + "px";
      c.style.transform = `translateX(${i * gap}px)`;
      c.style.zIndex = String(i + 1); // 右に行くほど前面
    });
  }

  function layoutAllDecks() {
    document.querySelectorAll(".deck").forEach(layoutDeck);
  }

  // ====== 右端へ移動（クリック動作）======
  function isRightmost(card) {
    const deckEl = card.closest(".deck");
    if (!deckEl) return false;
    const last = Array.from(deckEl.querySelectorAll(".card")).pop();
    return last === card;
  }

  function moveToRight(card) {
    const deckEl = card.closest(".deck");
    if (!deckEl) return;
    // 1) 選択状態をリセット
    deckEl.querySelectorAll(".card").forEach((c) => c.setAttribute("aria-selected", "false"));
    // 2) 末尾へ移動（DOM順を変える）
    deckEl.appendChild(card);
    // 3) レイアウト更新
    layoutDeck(deckEl);
    // 4) このカードを選択状態に
    card.setAttribute("aria-selected", "true");
    card.focus({ preventScroll: true });
  }

  // ====== イベント委譲（全デッキ共通）======
  document.addEventListener("click", (e) => {
    const card = e.target.closest(".deck .card");
    if (!card) return;

    if (isRightmost(card)) {
      // すでに右端＝選択中 → モーダル
      openModalFromCard(card);
    } else {
      moveToRight(card);
    }
  });

  document.addEventListener("keydown", (e) => {
    if (e.key !== "Enter" && e.key !== " ") return;
    const card = e.target.closest?.(".deck .card");
    if (!card) return;
    e.preventDefault();

    if (isRightmost(card)) openModalFromCard(card);
    else moveToRight(card);
  });

  // ====== リサイズ追従（Deck）======
  function observeDecks() {
    const ro = new ResizeObserver(() => layoutAllDecks());
    document.querySelectorAll(".deck").forEach((el) => ro.observe(el));
    window.addEventListener("resize", layoutAllDecks);
  }

  // ===============================
  // gNav開閉 + 背景ブラー Overlay + アコーディオン（nav.js統合）
  // ===============================
  function initNavAndOverlay() {
    const MOBILE_MAX = 440; // @media (max-width: 440px)
    const isMobile = () => window.innerWidth <= MOBILE_MAX;

    // ★ ピン留め（PCのみ有効）：.acc[data-pinned] を閉じさせない
    const isPinnedNode = (node) => {
      if (!node || isMobile()) return false;
      const acc = node.closest?.(".acc");
      return !!acc?.hasAttribute("data-pinned");
    };

    const btnGNav = document.querySelector(".btn-gNav");
    const gNav = document.querySelector(".gNav");
    const header = document.querySelector("header.header");
    const hColor = document.querySelector("#h-color");
    const logo = document.getElementById("main-logo");
    if (!gNav) return;

    let lastScrollY = window.scrollY;
    let savedScrollY = 0;

    // ===== Scroll lock helpers =====
    const lockScroll = () => {
      savedScrollY = window.scrollY;
      document.body.classList.add("fixed");
      document.body.style.top = `-${savedScrollY}px`;
    };
    const unlockScroll = () => {
      document.body.classList.remove("fixed");
      document.body.style.top = "";
      window.scrollTo(0, savedScrollY);
    };

    // ===== Overlay（背景ブラー用）=====
    const ensureOverlay = () => {
      let el = document.getElementById("overlay");
      if (!el) {
        el = document.createElement("div");
        el.id = "overlay";
        el.className = "overlay";
      }
      if (el.parentElement !== document.body) {
        document.body.prepend(el); // body直下へ
      }
      return el;
    };
    const overlay = ensureOverlay();
    overlay.addEventListener("click", () => {
      if (gNav.classList.contains("open")) closeDrawer();
    });

    // ===== Drawer open/close (SP) =====
    const openDrawer = () => {
      gNav.classList.add("open");
      btnGNav?.classList.add("open");
      overlay.classList.add("active"); // 背景ブラーON
      lockScroll();
    };
    const closeDrawer = () => {
      gNav.classList.remove("open");
      btnGNav?.classList.remove("open");
      overlay.classList.remove("active"); // 背景ブラーOFF
      unlockScroll();
    };
    const toggleDrawer = () => (gNav.classList.contains("open") ? closeDrawer() : openDrawer());

    btnGNav?.addEventListener("click", (e) => {
      e.preventDefault();
      toggleDrawer();
    });

    // ドロワー外クリックで閉じる（SP時のみ）
    document.addEventListener("click", (e) => {
      if (!isMobile()) return;
      if (!gNav.classList.contains("open")) return;
      const inDrawer = e.target.closest(".gNav") || e.target.closest(".btn-gNav");
      if (!inDrawer) closeDrawer();
    });

    // Esc で閉じる（SPドロワー / PCフライアウト）
    document.addEventListener("keydown", (e) => {
      if (e.key !== "Escape") return;
      if (gNav.classList.contains("open")) closeDrawer();
      closeAllPanels();
    });

    // ===== Header color / show-hide on scroll =====
    const updateHeader = () => {
      if (!header || !hColor || !logo) return;

      const current = window.scrollY;
      const triggerTop = hColor.offsetTop;
      const winH = window.innerHeight;
      const bodyH = document.body.offsetHeight;

      if (current >= triggerTop) {
        header.classList.add("change-color");
        logo.src = "img/logo.png";
        btnGNav?.classList.add("cyan");
      } else {
        header.classList.remove("change-color");
        logo.src = "img/logo-w.png";
        btnGNav?.classList.remove("cyan");
      }

      if (current > lastScrollY && current > triggerTop) {
        header.classList.add("hide-header");
      } else {
        header.classList.remove("hide-header");
      }

      if (winH + current >= bodyH - 5) {
        header.classList.remove("hide-header");
      }

      lastScrollY = current;
    };
    window.addEventListener("scroll", updateHeader, { passive: true });
    updateHeader();

    // ===== Accordion helpers =====

    // SP: max-height でアニメ、PC: クラスのみ
    function openPanel(btn, panel) {
      // 同階層の兄弟を閉じる（ただしピン留めは閉じない）
      closeSiblings(panel.id);

      btn.setAttribute("aria-expanded", "true");
      panel.hidden = false;
      panel.classList.remove("is-closing");

      if (isMobile()) {
        const h = panel.scrollHeight;
        panel.style.maxHeight = h + "px";
      } else {
        panel.style.maxHeight = "";
      }
      panel.classList.add("is-open");

      if (isMobile()) {
        const onEnd = (ev) => {
          if (ev.propertyName !== "max-height") return;
          panel.style.maxHeight = panel.scrollHeight + "px";
          panel.removeEventListener("transitionend", onEnd);
        };
        panel.addEventListener("transitionend", onEnd, { once: true });
      }

      // 下端はみ出し時の補正（SPのみ）
      requestAnimationFrame(() => {
        if (!isMobile()) return;
        const rect = panel.getBoundingClientRect();
        const over = rect.bottom - window.innerHeight;
        if (over > 0) {
          const drawer = panel.closest(".gNav");
          if (drawer) drawer.scrollBy({ top: over + 20, behavior: "smooth" });
          else window.scrollBy({ top: over + 20, behavior: "smooth" });
        }
      });
    }

    function closePanel(btn, panel) {
      // ★ PCでピン留めは閉じさせない
      if (isPinnedNode(btn) || isPinnedNode(panel)) return;

      btn.setAttribute("aria-expanded", "false");
      panel.classList.remove("is-open");
      panel.classList.add("is-closing");

      if (isMobile()) {
        const h = panel.scrollHeight;
        panel.style.maxHeight =
          panel.style.maxHeight === "" || panel.style.maxHeight === "none"
            ? h + "px"
            : panel.style.maxHeight;
        void panel.offsetHeight; // reflow
        panel.style.maxHeight = "0px";
      } else {
        panel.style.maxHeight = "";
      }

      const onEnd = (ev) => {
        if (ev.target !== panel || (isMobile() && ev.propertyName !== "max-height")) return;
        panel.hidden = true;
        panel.classList.remove("is-closing");
        panel.style.maxHeight = "";
        panel.removeEventListener("transitionend", onEnd);
      };
      if (isMobile()) {
        panel.addEventListener("transitionend", onEnd);
      } else {
        requestAnimationFrame(() => onEnd({ target: panel, propertyName: "max-height" }));
      }
    }

    function closeSiblings(currentId) {
      document.querySelectorAll(".acc-btn").forEach((b) => {
        const id = b.getAttribute("aria-controls");
        if (!id || id === currentId) return;
        const p = document.getElementById(id);
        if (!p || p.hidden) return;
        // ★ ピン留めは閉じない
        if (isPinnedNode(b) || isPinnedNode(p)) return;
        closePanel(b, p);
      });
    }

    function closeAllPanels() {
      document.querySelectorAll(".acc-btn").forEach((b) => {
        const id = b.getAttribute("aria-controls");
        const p = id ? document.getElementById(id) : null;
        if (!p || p.hidden) return;
        // ★ ピン留めは閉じない
        if (isPinnedNode(b) || isPinnedNode(p)) return;
        closePanel(b, p);
      });
    }

    // クリック（開閉トグル）
    document.addEventListener("click", (e) => {
      const btn = e.target.closest(".acc-btn");
      if (!btn) return;

      const panelId = btn.getAttribute("aria-controls");
      const panel = panelId ? document.getElementById(panelId) : null;
      if (!panel) return;

      const expanded = btn.getAttribute("aria-expanded") === "true";
      expanded ? closePanel(btn, panel) : openPanel(btn, panel);
    });

    // PC：外側クリックでフライアウトを閉じる（ただしピン留めは閉じない）
    document.addEventListener("click", (e) => {
      if (isMobile()) return;
      const hitSide = e.target.closest(".side-menu");
      const hitPanel = e.target.closest(".acc-panel");
      if (!hitSide && !hitPanel) closeAllPanels(); // closeAllPanels 側で pinned 除外
    });

    // ★ PC時、ピン留め要素は初期オープン状態に整える（保険）
    const initPinnedOpen = () => {
      if (isMobile()) return;
      document.querySelectorAll(".acc[data-pinned]").forEach((acc) => {
        const btn = acc.querySelector(".acc-btn");
        const panelId = btn?.getAttribute?.("aria-controls");
        const panel = panelId ? document.getElementById(panelId) : null;
        if (!btn || !panel) return;
        btn.setAttribute("aria-expanded", "true");
        panel.hidden = false;
        panel.classList.add("is-open");
        panel.style.maxHeight = ""; // PCは max-height 未使用
      });
    };
    initPinnedOpen();

    // ===== Resize: SP→PC/PC→SP でクリアリング =====
    let lastIsMobile = isMobile();
    window.addEventListener("resize", () => {
      const nowIsMobile = isMobile();

      // SP→PC: ドロワーが開いていたら閉じる
      if (!nowIsMobile && document.body.classList.contains("fixed")) {
        gNav.classList.remove("open");
        btnGNav?.classList.remove("open");
        overlay.classList.remove("active");
        unlockScroll();
      }

      // PC↔SP切替時にアコーディオンのインライン値を掃除/再評価
      document.querySelectorAll(".acc-panel").forEach((p) => {
        if (nowIsMobile) {
          // SPでは hidden でない is-open のものは実高に合わせ直す
          if (!p.hidden && p.classList.contains("is-open")) {
            p.style.maxHeight = p.scrollHeight + "px";
          }
        } else {
          // PCでは max-height は使わない
          p.style.maxHeight = "";
        }
      });

      // ★ ビューポートがPCになった直後にピン留め状態を再確定
      if (!nowIsMobile && lastIsMobile) {
        initPinnedOpen();
      }
      lastIsMobile = nowIsMobile;
    });

    // 画像等の読込で高さが増えた場合に追随（SP時）
    document.querySelectorAll(".acc-panel img").forEach((img) => {
      img.addEventListener("load", () => {
        const p = img.closest(".acc-panel.is-open");
        if (!p) return;
        if (isMobile()) {
          p.style.maxHeight = p.scrollHeight + "px";
        }
      });
    });
  }

  // ===============================
  // スライダー（中央寄せ / ドット連動）
  // ===============================
  function initSliders() {
    const sliders = document.querySelectorAll(".slider");
    if (!sliders.length) return;

    const GAP = 16; // CSSのgapに合わせる

    sliders.forEach((root) => {
      const wrapper = root.querySelector(".slides-wrapper");
      if (!wrapper) return;

      // 直下の子（<a>）がスライド1枚
      const items = Array.from(wrapper.children);
      if (!items.length) return;

      // --- ガター（左右パディング）で初期から中央寄せ ---
      const setGutters = () => {
        const viewportW = wrapper.clientWidth;  // 見えている幅
        const itemW = items[0].offsetWidth;     // 1枚の幅（例：90%）
        const gutter = Math.max((viewportW - itemW) / 2, 0);
        wrapper.style.paddingLeft = `${gutter}px`;
        wrapper.style.paddingRight = `${gutter}px`;
      };

      // --- インデックス取得（1枚幅 + GAP 基準） ---
      const getStep = () => items[0].offsetWidth + GAP;

      const clamp = (n, min, max) => Math.min(Math.max(n, min), max);
      const getIndex = () => {
        const STEP = getStep();
        const raw = Math.round(wrapper.scrollLeft / STEP);
        return clamp(raw, 0, items.length - 1);
      };

      // --- ページネーション（既存の .pagination span を使う前提） ---
      const dotsRoot = root.querySelector(".pagination");
      const dots = dotsRoot ? Array.from(dotsRoot.querySelectorAll("span")) : [];
      const setDot = (idx) => dots.forEach((d, i) => d.classList.toggle("active", i === idx));

      // ドットクリックで該当スライドへ
      dots.forEach((dot, i) => {
        dot.addEventListener("click", () => {
          wrapper.scrollTo({ left: i * getStep(), behavior: "smooth" });
          setDot(i);
        });
      });

      // スクロールに連動
      let ticking = false;
      wrapper.addEventListener("scroll", () => {
        if (ticking) return;
        ticking = true;
        requestAnimationFrame(() => {
          setDot(getIndex());
          ticking = false;
        });
      });

      // 初期化
      setGutters();
      setDot(0);

      // リサイズ時も再計算
      window.addEventListener("resize", () => {
        const currentIdx = getIndex();
        setGutters();
        // ガター変化で位置がずれないよう、同じインデックスへ補正
        wrapper.scrollTo({ left: currentIdx * getStep() });
        setDot(currentIdx);
      });
    });
  }

  // ===============================
  // 初期化（DOM準備後）
  // ===============================
  const init = () => {
    layoutAllDecks();
    observeDecks();
    initNavAndOverlay();
    initSliders();
  };

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", init);
  } else {
    init();
  }
})();
