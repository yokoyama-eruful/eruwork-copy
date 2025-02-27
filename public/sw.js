"use strict";

self.addEventListener("install", function (event) {
    // インストール時に必要な処理があればここに記述
    self.skipWaiting();
});

self.addEventListener("activate", function (event) {
    // アクティベート時に必要な処理があればここに記述
    event.waitUntil(self.clients.claim());
});

self.addEventListener("fetch", function (event) {
    event.respondWith(
        caches.match(event.request).then(function (response) {
            return response || fetch(event.request);
        })
    );
});