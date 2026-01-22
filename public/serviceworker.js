"use strict";

// ===============================
// 📦 キャッシュ設定
// ===============================
const CACHE_NAME = "offline-v2"; // 更新を確実にするためv2に変更
const OFFLINE_URL = "/offline.html";

// 起動時にキャッシュしておく最小限のファイル
const filesToCache = [
  "/",
  OFFLINE_URL,
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
  event.waitUntil(
    Promise.all([
      self.clients.claim(),
      // 古いバージョンのキャッシュを自動削除
      caches.keys().then(function (keys) {
        return Promise.all(
          keys.filter(key => key !== CACHE_NAME).map(key => caches.delete(key))
        );
      })
    ])
  );
});

// ===============================
// 🌐 fetch（Vite最適化版）
// ===============================
self.addEventListener("fetch", function (event) {
  const url = new URL(event.request.url);

  // 1. Livewire、API、POSTリクエストは一切干渉せずにネットワークへ直通
  if (
    event.request.method !== "GET" || 
    url.pathname.includes("/livewire/") ||
    url.pathname.includes("/api/")
  ) {
    return; 
  }

  // http(s) 以外は無視
  if (!event.request.url.startsWith("http")) return;

  // 2. Viteビルド済みアセットの判定 (Cache First)
  // パスに /build/assets/ が含まれるか、ファイル名にVite特有のハッシュがある場合
  const isViteAsset = url.pathname.includes("/build/assets/") || 
                      url.pathname.match(/-[a-zA-Z0-9]{8,}\.(js|css|png|jpg|jpeg|svg|woff2?)$/);

  if (isViteAsset) {
    event.respondWith(
      caches.match(event.request).then((cachedResponse) => {
        // キャッシュがあれば即座に返す (0ms)
        if (cachedResponse) {
          return cachedResponse;
        }
        // なければ取得してキャッシュに保存
        return fetch(event.request).then((response) => {
          if (response.ok) {
            const clone = response.clone();
            caches.open(CACHE_NAME).then((cache) => cache.put(event.request, clone));
          }
          return response;
        });
      })
    );
    return;
  }

  // 3. ページ遷移（ナビゲーション）
  if (event.request.mode === "navigate") {
    event.respondWith(
      fetch(event.request).catch(function () {
        return caches.match(OFFLINE_URL);
      })
    );
    return;
  }

  // 4. その他のリソース（Network First）
  event.respondWith(
    fetch(event.request)
      .then(function (response) {
        if (response.ok) {
          const clone = response.clone();
          caches.open(CACHE_NAME).then((cache) => cache.put(event.request, clone));
        }
        return response;
      })
      .catch(function () {
        return caches.match(event.request);
      })
  );
});

// ===============================
// 🔔 push通知 / 🖱️ クリック
// ===============================
self.addEventListener("push", function (event) {
  if (!(self.Notification && self.Notification.permission === "granted")) return;
  const payload = event.data ? event.data.json() : {};
  event.waitUntil(
    self.registration.showNotification(payload.title ?? "通知", {
      body: payload.body ?? "",
      icon: payload.icon ?? "/icons/icon-192x192.png",
      data: { url: payload?.data?.url ?? "/" },
    })
  );
});

self.addEventListener("notificationclick", function (event) {
  event.preventDefault();
  event.waitUntil(clients.openWindow(event.notification.data.url));
  event.notification.close();
});