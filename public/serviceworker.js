"use strict";

// ===============================
// 📦 キャッシュするファイル
// ===============================
const CACHE_NAME = "offline-v1";
const OFFLINE_URL = "/offline.html";

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
  event.waitUntil(self.clients.claim());
});

// ===============================
// 🌐 fetch（超重要）
// ===============================
self.addEventListener("fetch", function (event) {

  // http(s) 以外は無視
  if (!event.request.url.startsWith("http")) return;

  /**
   * 🚨 ページ遷移（通知クリック含む）
   * → 404でも offline.html に差し替えない！
   */
  if (event.request.mode === "navigate") {
    event.respondWith(
      fetch(event.request).catch(function () {
        // ネット完全死亡時のみ
        return caches.match(OFFLINE_URL);
      })
    );
    return;
  }

  /**
   * 📦 画像・CSS・JS・API 用
   */
  event.respondWith(
    fetch(event.request)
      .then(function (response) {

        // GETだけキャッシュ
        if (event.request.method === "GET" && response.ok) {
          const clone = response.clone();
          caches.open(CACHE_NAME).then(function (cache) {
            cache.put(event.request, clone);
          });
        }

        return response;
      })
      .catch(function () {
        // キャッシュがあれば返す
        return caches.match(event.request);
      })
  );
});

// ===============================
// 🔔 push
// ===============================
self.addEventListener("push", function (event) {
  if (!(self.Notification && self.Notification.permission === "granted")) return;

  const payload = event.data ? event.data.json() : {};

  const notificationUrl =
    payload?.data?.url ?? "/";

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

  event.waitUntil(
    clients.openWindow(url)
  );

  event.notification.close();
});
