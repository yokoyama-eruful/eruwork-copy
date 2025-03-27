<?php

declare(strict_types=1);

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

final class WebPushNotification extends Notification
{
    use Queueable;

    public function __construct(
        private string $title,
        private string $message,
        private string $image,
        private string $url,
    ) {}

    public function via()
    {
        return [WebPushChannel::class];
    }

    public function toWebPush()
    {
        return (new WebPushMessage)
            ->title($this->title)
            ->body($this->message)
            ->image($this->image)
            ->data(['url' => $this->url]);
    }
}
