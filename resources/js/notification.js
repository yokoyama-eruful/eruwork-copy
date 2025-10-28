
const csrftoken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// サービスワーカーの登録
const registerServiceWorker = () => {
    if ("serviceWorker" in navigator) {
        window.addEventListener("load", () => {
            navigator.serviceWorker.register("/serviceworker.js");
        });
    }
};

// 通知サポートのチェック
const checkNotificationSupport = () => {
    if (!('Notification' in window)) {
        alert("This browser does not support notifications.");
    }
};

// Base64からUint8Arrayへの変換
const urlBase64ToUint8Array = (base64String) => {
    const padding = "=".repeat((4 - base64String.length % 4) % 4);
    const base64 = (base64String + padding).replace(/\-/g, "+").replace(/_/g, "/");
    const rawData = window.atob(base64);
    const outputArray = new Uint8Array(rawData.length);

    for (let i = 0; i < rawData.length; ++i) {
        outputArray[i] = rawData.charCodeAt(i);
    }

    return outputArray;
};

// プッシュ通知を有効化
const enablePushNotifications = () => {
    navigator.serviceWorker.ready.then((registration) => {
        registration.pushManager.getSubscription().then((subscription) => {
            if (subscription) {
                console.log('Subscription already exists.');
                return subscription;
            }

            const VAPID_PUBLIC_KEY = import.meta.env.VITE_VAPID_PUBLIC_KEY;
            const serverKey = urlBase64ToUint8Array(VAPID_PUBLIC_KEY);
            return registration.pushManager.subscribe({
                userVisibleOnly: true,
                applicationServerKey: serverKey
            });
        }).then((subscription) => {
            if (!subscription) {
                alert("Error occured while subscribing");
                return;
            }

            subscribe(subscription);
        });
    });
};

// プッシュ通知を無効化
const disablePushNotifications = () => {
    navigator.serviceWorker.ready.then((registration) => {
        registration.pushManager.getSubscription().then((subscription) => {
            if (!subscription) {
                console.log('No subscription found.');
                return;
            }

            console.log('Found subscription, unsubscribing...');
            subscription.unsubscribe().then(() => {
                fetch('/webPush/unsubscribe', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrftoken
                    },
                    body: JSON.stringify({
                        endpoint: subscription.endpoint
                    })
                }).then(response => response.json())
                    .then(data => console.log('Success:', data))
                    .catch(error => console.error('Error:', error));
            });
        });
    });
};

// サブスクリプションをサーバーに送信
const subscribe = (sub) => {
    const key = sub.getKey('p256dh');
    const token = sub.getKey('auth');
    const contentEncoding = (PushManager.supportedContentEncodings || ['aesgcm'])[0];
    const data = {
        endpoint: sub.endpoint,
        public_key: key ? btoa(String.fromCharCode.apply(null, new Uint8Array(key))) : null,
        auth_token: token ? btoa(String.fromCharCode.apply(null, new Uint8Array(token))) : null,
        encoding: contentEncoding
    };

    fetch('/webPush/subscribe', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrftoken
        },
        body: JSON.stringify(data)
    }).then(response => response.json())
        .then(data => {
            console.log('Success:', data);
            window.location.href = '/webPush/welcomeMessage';
    })
        .catch(error => {
            console.error('Error:', error);
});
};

//通知クリック時の
self.addEventListener('notificationclick', function(event) {
    event.notification.close(); // 通知を閉じる
    clients.openWindow(event.notification.data.url); // 通知に関連するURLを開く
});

document.addEventListener('DOMContentLoaded', () => {
    registerServiceWorker();

Livewire.on('enablePush', () => {
        enablePushNotifications(); 
    });

    Livewire.on('disablePush', () => {
        disablePushNotifications(); 
    });
});

// 初期化関数
const init = () => {
    registerServiceWorker();
    checkNotificationSupport();
};

// 初期化を実行
init();
