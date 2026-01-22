"use strict";

// ===============================
// 📦 キャッシュ設定
// ===============================
const CACHE_NAME = "offline-v1";
const OFFLINE_URL = "/offline.html";

// キャッシュすべき静的ファイル（これらはCache Firstで高速化する）
const filesToCache = [
  "/",
  OFFLINE_URL,
  "/css/app.css", // プロジェクトに合わせてパスを調整してください
  "/js/app.js",
];

// ===============================
// 🔧 install
// ===============================
self.addEventListener("install", function (event) {
  event.waitUntil(
    caches.open(CACHE_NAME).then(function (cache) {
      return cache.addAll(filesToCache);
    })
  );
  self.skipWaiting();
});

// ===============================
// 🚀 activate
// ===============================
self.addEventListener("activate", function (event) {
  // 古いキャッシュの削除処理を入れるとより安全です
  event.waitUntil(
    Promise.all([
      self.clients.claim(),
      caches.keys().then(function (keys) {
        return Promise.all(
          keys.filter(key => key !== CACHE_NAME).map(key => caches.delete(key))
        );
      })
    ])
  );
});

// ===============================
// 🌐 fetch（最適化済み）
// ===============================
self.addEventListener("fetch", function (event) {
  const url = new URL(event.request.url);

  // 🚨 【重要】LivewireおよびPOSTリクエストは一切干渉せず、スルーさせる
  // これにより、Livewireの更新がService Workerによって遅延するのを防ぎます
  if (
    event.request.method !== "GET" || 
    url.pathname.includes("/livewire/") ||
    url.pathname.includes("/api/")
  ) {
    return; // ブラウザ標準の通信に任せる
  }

  // http(s) 以外（chrome-extension等）は無視
  if (!event.request.url.startsWith("http")) return;

  // 📄 ページ遷移（ナビゲーション）
  if (event.request.mode === "navigate") {
    event.respondWith(
      fetch(event.request).catch(function () {
        return caches.match(OFFLINE_URL);
      })
    );
    return;
  }

  // 🖼️ 静的リソース（画像・CSS・JSなど）
  // ネットワークを優先しつつ、バックグラウンドでキャッシュを更新する戦略
  event.respondWith(
    fetch(event.request)
      .then(function (response) {
        // 正常なレスポンスのみキャッシュに保存
        if (response.ok) {
          const clone = response.clone();
          caches.open(CACHE_NAME).then(function (cache) {
            cache.put(event.request, clone);
          });
        }
        return response;
      })
      .catch(function () {
        // オフライン時はキャッシュから返す
        return caches.match(event.request);
      })
  );
});

// ===============================
// 🔔 push通知
// ===============================
self.addEventListener("push", function (event) {
  if (!(self.Notification && self.Notification.permission === "granted")) return;

  const payload = event.data ? event.data.json() : {};
  const notificationUrl = payload?.data?.url ?? "/";

  event.waitUntil(
    self.registration.showNotification(payload.title ?? "通知", {
      body: payload.body ?? "",
      icon: payload.icon ?? "/icons/icon-192x192.png",
      data: {
        url: notificationUrl,
      },
    })
  );
});

// ===============================
// 👉 通知クリック
// ===============================
self.addEventListener("notificationclick", function (event) {
  event.preventDefault();
  const url = event.notification.data.url;
  event.waitUntil(clients.openWindow(url));
  event.notification.close();
});