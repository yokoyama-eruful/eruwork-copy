<?php

declare(strict_types=1);

namespace Modules\Setting\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Modules\Timecard\Models\Rule;
use Modules\Timecard\Models\TimecardUser;
use Modules\Timecard\Models\WagePremium;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rule = Rule::first();

        $wagePremium = WagePremium::first();

        $pin = '';

        if ($rule->rule == 'public') {
            $pin = Crypt::decryptString(TimecardUser::first()->pin_encrypted);
        }

        return view('setting::index', ['rule' => $rule, 'wagePremium' => $wagePremium, 'pin' => $pin]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        DB::transaction(function () use ($request) {
            Rule::updateOrCreate(
                [],
                ['rule' => $request->rule],
            );

            WagePremium::updateOrCreate(
                [],
                [
                    'pay_unit' => $request->pay_unit,
                    'overtime_rate' => $request->overtimeRate,
                    'night_rate' => $request->nightRate,
                ],
            );

            $pin = mb_str_pad((string) random_int(0, 9999), 4, '0', STR_PAD_LEFT);

            TimecardUser::updateOrCreate(
                [],
                ['pin_encrypted' => Crypt::encryptString($pin)],
            );
        });

        return redirect()
            ->route('setting.index')
            ->with('success', '設定を更新しました');
    }
}
