<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Notifications\WebPushNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request as FacadesRequest;

final class WebPushController
{
    public function index()
    {
        return view('setting.notification');
    }

    public function subscribe(Request $req)
    {
        /** @var User ログインユーザ */
        $user = Auth::user();

        $user->updatePushSubscription(
            $req->post('endpoint'),
            $req->post('public_key'),
            $req->post('auth_token'),
            $req->post('encoding'),
        );

        return response()->json([
            'message' => 'Subscribed!',
        ]);
    }

    public function unsubscribe(Request $req)
    {
        /** @var User ログインユーザ */
        $user = Auth::user();

        $user->deletePushSubscription($req->post('endpoint'));

        return response()->json(['message' => 'Unsubscribed!']);
    }

    public function send()
    {
        /** @var User ログインユーザ */
        $user = Auth::user();

        $url = FacadesRequest::getSchemeAndHttpHost();

        $user->notify(
            new WebPushNotification(
                title: 'エルフルサービス',
                message: '通知の設定ありがとうございます。',
                image: '',
                url: $url,
            )
        );

        return back()->withInput();
    }
}
