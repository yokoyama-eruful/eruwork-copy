<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Account\Models\Profile;
use Modules\Board\Models\BoardLike;
use Modules\Board\Models\BoardPost;
use Modules\Calendar\Models\Schedule;
use Modules\Chat\Models\Group;
use Modules\HourlyRate\Models\HourlyRate;
use Modules\Manual\Models\ManualFile;
use Modules\Manual\Models\ManualFolder;
use Modules\Shift\Models\DraftSchedule;
use Modules\Shift\Models\Manager as ShiftManager;
use Modules\Timecard\Database\Seeders\TimecardDatabaseSeeder;
use Modules\Timecard\Models\WorkTime;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class TestSeeder extends Seeder
{
    public function run(): void
    {
        $this->user();
        $this->hourlyRates();
        $this->calendar();
        $this->shift();
        $this->timecard();
        $this->board();
        $this->chat();
        $this->manual();
    }

    private function user()
    {
        $adminUser = User::factory()->create([
            'login_id' => 'test',
        ]);

        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $memberRole = Role::firstOrCreate(['name' => 'member']);

        $registerPermission = Permission::firstOrCreate(['name' => 'register']);

        $adminRole->givePermissionTo($registerPermission);
        $adminUser->assignRole($adminRole);

        Profile::create([
            'user_id' => $adminUser->id,
            'name' => '店長',
            'name_kana' => 'テンチョウ',
            'contract_type' => '正社員',
        ]);

        $members = [
            ['name' => '佐藤 美咲', 'kana' => 'さとう みさき'],
            ['name' => '高橋 陽斗', 'kana' => 'たかはし はると'],
            ['name' => '田中 彩花', 'kana' => 'たなか あやか'],
            ['name' => '伊藤 恒一', 'kana' => 'いとう こういち'],
            ['name' => '山本 凛', 'kana' => 'やまもと りん'],
        ];

        foreach ($members as $i => $member) {
            $user = User::factory()->create([
                'login_id' => 'test' . ($i + 1),
            ]);

            $user->assignRole($memberRole);

            Profile::create([
                'user_id' => $user->id,
                'name' => $member['name'],
                'name_kana' => $member['kana'],
                'contract_type' => 'アルバイト',
            ]);
        }
    }

    private function hourlyRates(): void
    {
        $members = User::role('member')->get();

        $effectiveDate = Carbon::now()->startOfYear()->toDateString();

        foreach ($members as $user) {
            HourlyRate::create([
                'user_id' => $user->id,
                'rate' => rand(220, 280) * 5,
                'effective_date' => $effectiveDate,
            ]);
        }
    }

    private function calendar()
    {
        $users = User::all();
        $schedules = [];

        $today = Carbon::today();

        $monthStart = $today->copy()->startOfMonth();
        $monthEnd = $today->copy()->endOfMonth();
        $daysInMonth = (int) $monthStart->diffInDays($monthEnd);

        foreach ($users as $user) {

            // 🔥 当日の予定（必ず1件）
            $startHour = rand(8, 19); // 19 + 3 = 22
            $workHours = rand(3, 6);

            if ($startHour + $workHours > 22) {
                $workHours = 22 - $startHour;
            }

            $startTime = $today->copy()->setTime($startHour, 0);
            $endTime = $startTime->copy()->addHours($workHours);

            $schedules[] = [
                'user_id' => $user->id,
                'title' => '打ち合わせ',
                'date' => $today->toDateString(),
                'start_time' => $startTime,
                'end_time' => $endTime,
            ];

            // 🎲 今月ランダム予定（2件）
            for ($i = 0; $i < 2; $i++) {

                $randomDate = $monthStart->copy()
                    ->addDays(rand(0, $daysInMonth));

                $startHour = rand(8, 19);
                $workHours = rand(3, 6);

                if ($startHour + $workHours > 22) {
                    $workHours = 22 - $startHour;
                }

                $startTime = $randomDate->copy()->setTime($startHour, 0);
                $endTime = $startTime->copy()->addHours($workHours);

                $schedules[] = [
                    'user_id' => $user->id,
                    'title' => '〇〇に訪問',
                    'date' => $randomDate->toDateString(),
                    'start_time' => $startTime,
                    'end_time' => $endTime,
                ];
            }
        }

        Schedule::insert($schedules);
    }

    private function board()
    {
        $posts = [
            [
                'user_id' => 1,
                'title' => '🌟 社内掲示板のお知らせ 🌟',
                'contents' => '<p>みなさん、お疲れさまです！💡</p><p>この掲示板では、正社員・アルバイト関係なく、全員に役立つ情報をお知らせします📢<br>シフトの確認、イベント情報、業務連絡など、大切な情報を見逃さないようにしましょう！</p>',
                'status' => '掲載',
            ],
            [
                'user_id' => 2,
                'title' => '🍀 アルバイトからのお知らせ 🍀',
                'contents' => '<p>みなさん、こんにちは！</p><p>シフトや業務に関する大切な情報をお知らせします！</p><p>シフト交代や休憩のルールなど、全員が確認しておきたい内容ですので、ぜひチェックしてください！</p>',
                'status' => '掲載',
            ],
            [
                'user_id' => 3,
                'title' => '🌟 シフト調整＆お願い 🌟',
                'contents' => '<p>お疲れさまです！</p><p>今月のシフト調整についてお知らせします。もしシフト変更が必要な場合や、代わりに入れる方がいればご連絡ください！</p><p>また、業務中のちょっとした気づきや改善点があれば、みんなで共有してより良い職場にしていきましょう！</p>',
                'status' => '掲載',
            ],
            [
                'user_id' => 4,
                'title' => '🎉 休憩室の使い方について 🎉',
                'contents' => '<p>みなさん、こんにちは！</p><p>休憩室が混雑することがありますので、みんなが快適に過ごせるように、休憩時間を守り、ゴミの処理をきちんと行いましょう🗑️</p><p>協力よろしくお願いします！</p>',
                'status' => '掲載',
            ],
        ];

        $createdPosts = [];
        foreach ($posts as $post) {
            $createdPosts[] = BoardPost::create($post);
        }

        $users = User::all();

        $boardShows = [];

        foreach ($users as $user) {
            foreach ($createdPosts as $post) {
                $boardShows[] = [
                    'user_id' => $user->id,
                    'post_id' => $post->id,
                ];
            }
        }

        DB::table('board__post_read_statuses')->insert($boardShows);

        BoardLike::insert($boardShows);
    }

    private function chat()
    {
        $users = User::all();
        $admin = User::role('admin')->first();
        $kitchenGroup = Group::create([
            'name' => 'キッチンチーム',
            'is_dm' => false,
        ]);
        $hallGroup = Group::create([
            'name' => 'ホールチーム',
            'is_dm' => false,
        ]);

        $memberUsers = $users->filter(fn ($user) => $admin ? $user->id !== $admin->id : true)->values();
        $kitchenMembers = $memberUsers->take(3)->pluck('id')->all();
        $hallMembers = $memberUsers->slice(3)->pluck('id')->all();

        if ($admin) {
            $kitchenMembers[] = $admin->id;
            $hallMembers[] = $admin->id;
        }

        $kitchenGroup->users()->sync($kitchenMembers);
        $hallGroup->users()->sync($hallMembers);

        $userIds = $users->pluck('id')->values();

        for ($i = 0; $i < $userIds->count(); $i++) {
            for ($j = $i + 1; $j < $userIds->count(); $j++) {

                $userA = $userIds[$i];
                $userB = $userIds[$j];

                // すでにDMが存在するかチェック
                $exists = Group::where('is_dm', true)
                    ->whereHas('users', fn ($q) => $q->where('users.id', $userA))
                    ->whereHas('users', fn ($q) => $q->where('users.id', $userB))
                    ->exists();

                if ($exists) {
                    continue;
                }

                // DMグループ作成
                $dmGroup = Group::create([
                    'name' => null,
                    'is_dm' => true,
                ]);

                $dmGroup->users()->sync([$userA, $userB]);
            }
        }
    }

    private function timecard()
    {
        $this->call(TimecardDatabaseSeeder::class);

        $members = User::role('member')->get();
        $timecards = [];
        $today = Carbon::today();

        foreach ($members as $user) {

            // 今月（1〜15日）
            $currentMonthStart = Carbon::now()->startOfMonth();

            foreach (range(1, 15) as $day) {
                $date = $currentMonthStart->copy()->setDay($day);

                if ($date->gte($today)) {
                    continue;
                }

                // 出勤時間（6:00〜18:00）
                $inHour = rand(6, 18);
                $inMinute = rand(0, 5) * 10;

                $inTime = $date->copy()->setTime($inHour, $inMinute);

                // 勤務時間（3〜8時間）
                $workHours = rand(3, 8);
                $outTime = $inTime->copy()->addHours($workHours);

                // 22時超え防止
                if ($outTime->hour > 22) {
                    $outTime = $date->copy()->setTime(22, 0);
                }

                $timecards[] = [
                    'user_id' => $user->id,
                    'in_time' => $inTime,
                    'out_time' => $outTime,
                ];
            }

            // 先月（1〜25日）
            $previousMonthStart = Carbon::now()->subMonth()->startOfMonth();

            foreach (range(1, 25) as $day) {
                $date = $previousMonthStart->copy()->setDay($day);

                if ($date->gte($today)) {
                    continue;
                }

                $inHour = rand(6, 18);
                $inMinute = rand(0, 5) * 10;

                $inTime = $date->copy()->setTime($inHour, $inMinute);

                $workHours = rand(3, 8);
                $outTime = $inTime->copy()->addHours($workHours);

                if ($outTime->hour > 22) {
                    $outTime = $date->copy()->setTime(22, 0);
                }

                $timecards[] = [
                    'user_id' => $user->id,
                    'in_time' => $inTime,
                    'out_time' => $outTime,
                ];
            }
        }

        WorkTime::insert($timecards);
    }

    private function shift(): void
    {
        $users = User::all();
        $members = User::role('member')->get();

        $today = Carbon::today();

        // 今月（提出期間）
        $thisMonthStart = $today->copy()->startOfMonth();
        $thisMonthEnd = $today->copy()->endOfMonth();

        // 来月（シフト期間）
        $nextMonthStart = $today->copy()->addMonth()->startOfMonth();
        $nextMonthEnd = $today->copy()->addMonth()->endOfMonth();

        // シフト管理（openのみ）
        $openManager = ShiftManager::create([
            'start_date' => $nextMonthStart->toDateString(),
            'end_date' => $nextMonthEnd->toDateString(),
            'submission_start_date' => $thisMonthStart->toDateString(),
            'submission_end_date' => $thisMonthEnd->toDateString(),
        ]);

        // 提出ステータス
        foreach ($members as $member) {
            DB::table('shift__manager_user')->insert([
                'user_id' => $member->id,
                'shift_manager_id' => $openManager->id,
                'status' => '提出済',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $periodDays = (int) floor(
            Carbon::parse($openManager->start_date)
                ->diffInDays(Carbon::parse($openManager->end_date))
        );
        foreach ($members as $member) {
            for ($i = 0; $i < 10; $i++) {

                // 日付ランダム
                $date = Carbon::parse($openManager->start_date)
                    ->addDays(rand(0, $periodDays));

                // 開始時間（6〜19時）
                $startHour = rand(6, 19);

                // 勤務時間（3〜最大6時間）
                $workHours = rand(3, 6);

                // 終了時間が22時超えないように調整
                if ($startHour + $workHours > 22) {
                    $workHours = 22 - $startHour;
                }

                $startTime = $date->copy()->setTime($startHour, 0);
                $endTime = $startTime->copy()->addHours($workHours);

                DraftSchedule::create([
                    'user_id' => $member->id,
                    'manager_id' => $openManager->id,
                    'date' => $date->toDateString(),
                    'start_time' => $startTime,
                    'end_time' => $endTime,
                    'status' => '未承認',
                ]);
            }
        }
    }

    private function manual(): void
    {
        $admin = User::role('admin')->first();

        if (! $admin) {
            return;
        }

        // フォルダ作成
        $hallFolder = ManualFolder::create([
            'title' => 'ホール',
            'user_id' => $admin->id,
        ]);

        $kitchenFolder = ManualFolder::create([
            'title' => 'キッチン',
            'user_id' => $admin->id,
        ]);

        /*
        |--------------------------------------------------------------------------
        | ホール用マニュアル
        |--------------------------------------------------------------------------
        */

        // 接客の基本
        ManualFile::create([
            'title' => '接客の基本',
            'user_id' => $admin->id,
            'manual__folder_id' => $hallFolder->id,
            'status' => '掲載',
            'details' => [
                [
                    'title' => '基本姿勢',
                    'content' => 'お客様に気持ちよく過ごしていただくため、明るい挨拶と笑顔を心がけます。',
                ],
                [
                    'title' => '身だしなみ',
                    'content' => '清潔感のある服装を保ち、髪型や手元にも注意します。',
                ],
            ],
            'steps' => [
                [
                    'title' => '入店時の対応',
                    'content' => '来店されたお客様に「いらっしゃいませ」と挨拶します。',
                    'file' => '',
                ],
                [
                    'title' => '席への案内',
                    'content' => '人数を確認し、空いている席へ案内します。',
                    'file' => '',
                ],
                [
                    'title' => '注文対応',
                    'content' => '注文内容を復唱し、オーダーを入力します。',
                    'file' => '',
                ],
                [
                    'title' => '退店時の挨拶',
                    'content' => 'お会計後、「ありがとうございました」とお礼を伝えます。',
                    'file' => '',
                ],
            ],
        ]);

        // レジ対応
        ManualFile::create([
            'title' => 'レジ対応',
            'user_id' => $admin->id,
            'manual__folder_id' => $hallFolder->id,
            'status' => '掲載',
            'details' => [
                [
                    'title' => '対応方針',
                    'content' => '正確でスムーズな会計を行い、お客様をお待たせしないようにします。',
                ],
            ],
            'steps' => [
                [
                    'title' => '金額確認',
                    'content' => '注文内容と会計金額を確認します。',
                    'file' => '',
                ],
                [
                    'title' => '支払い対応',
                    'content' => '現金・キャッシュレス決済に対応します。',
                    'file' => '',
                ],
                [
                    'title' => '会計完了',
                    'content' => 'お釣りや控えを渡し、お礼を伝えます。',
                    'file' => '',
                ],
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | キッチン用マニュアル
        |--------------------------------------------------------------------------
        */

        // 調理の基本
        ManualFile::create([
            'title' => '調理の基本',
            'user_id' => $admin->id,
            'manual__folder_id' => $kitchenFolder->id,
            'status' => '掲載',
            'details' => [
                [
                    'title' => '調理方針',
                    'content' => '決められたレシピを守り、安定した品質の料理を提供します。',
                ],
                [
                    'title' => '時間意識',
                    'content' => '提供時間を意識し、効率的に作業します。',
                ],
            ],
            'steps' => [
                [
                    'title' => 'オーダー確認',
                    'content' => '入ったオーダーを確認し、調理を開始します。',
                    'file' => '',
                ],
                [
                    'title' => '調理作業',
                    'content' => 'レシピに従って調理を行います。',
                    'file' => '',
                ],
                [
                    'title' => '盛り付け',
                    'content' => '見た目にも配慮し、丁寧に盛り付けます。',
                    'file' => '',
                ],
            ],
        ]);

        // 衛生管理・清掃
        ManualFile::create([
            'title' => '衛生管理・清掃',
            'user_id' => $admin->id,
            'manual__folder_id' => $kitchenFolder->id,
            'status' => '掲載',
            'details' => [
                [
                    'title' => '衛生意識',
                    'content' => '食中毒防止のため、常に清潔な環境を維持します。',
                ],
            ],
            'steps' => [
                [
                    'title' => '作業前準備',
                    'content' => '手洗い・消毒を行ってから作業を開始します。',
                    'file' => '',
                ],
                [
                    'title' => '営業中清掃',
                    'content' => '汚れた箇所はその都度清掃します。',
                    'file' => '',
                ],
                [
                    'title' => '営業後清掃',
                    'content' => '調理台・床・機器を清掃し、翌営業に備えます。',
                    'file' => '',
                ],
            ],
        ]);
    }
}
