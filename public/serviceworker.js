const filesToCache = [
  '/',
  '/offline.html', // ←ちゃんとキャッシュしておく！
];

// ===============================
// 🔧 インストール処理
// ===============================
const preLoad = function () {
  return caches.open("offline").then(function (cache) {
    // caching index and important routes
    return cache.addAll(filesToCache);
  });
};

self.addEventListener("install", function (event) {
  event.waitUntil(preLoad());
  self.skipWaiting(); // 追加（即反映）
});

// ===============================
// 🚀 有効化処理
// ===============================
self.addEventListener("activate", function (event) {
  event.waitUntil(self.clients.claim());
});

// ===============================
// 🌐 fetch イベント（ここだけ修正版）
// ===============================
self.addEventListener("fetch", function (event) {
  // HTTP以外（chrome-extension, blob等）はスルー
  if (!event.request.url.startsWith('http')) return;

  event.respondWith(
    fetch(event.request)
      .then(function (response) {
        // 404だったらオフラインページへ
        if (!response || response.status === 404) {
          return caches.match('/offline.html');
        }

        // 正常レスポンスをキャッシュに保存
      if (event.request.method === 'GET') {
        const responseClone = response.clone();
        caches.open('offline').then(function (cache) {
          cache.put(event.request, responseClone);
        });
      }

        return response;
      })
      .catch(function () {
        // ネットがダメなときはキャッシュ or offline.html
        return caches.match(event.request).then(function (cached) {
          return cached || caches.match('/offline.html');
        });
      })
  );
});


"use strict";

self.addEventListener("push", function (event) {
    if (!(self.Notification && self.Notification.permission === 'granted')) return;

    const payload = event.data ? event.data.json() : {};
    event.waitUntil(
        self.registration.showNotification(payload.title, {
            body: payload.body || "",
            icon: payload.icon || "/icons/icon-192x192.png",
            data: { url: payload.url || "/" },
        })
    );
});

// notificationclick は push の外で1回だけ登録
self.addEventListener('notificationclick', function(event) {
    event.preventDefault();

    const url = event.notification.data.url;

    clients.openWindow(url).then(function(windowClient) {
      console.log('ウィンドウが開かれました:', windowClient);
    }).catch(function(error) {
      console.log('ウィンドウのオープンに失敗:', error);
    });

    event.notification.close();
});