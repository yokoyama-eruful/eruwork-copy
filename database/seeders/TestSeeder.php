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
use Modules\Calendar\Models\PublicHoliday;
use Modules\Calendar\Models\Schedule;
use Modules\Chat\Models\Group;
use Modules\Timecard\Models\WorkTime;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class TestSeeder extends Seeder
{
    public function run(): void
    {
        $this->user();
        // $this->board();
        // $this->calendar();
        // $this->chat();
        // $this->timecard();
        // $this->shift();
    }

    private function user()
    {
        $adminUser = User::factory()->create([
            'login_id' => 'test',
        ]);

        $adminRole = Role::create(['name' => 'admin']);
        $memberRole = Role::create(['name' => 'member']);

        $registerPermission = Permission::create(['name' => 'register']);

        $adminRole->givePermissionTo($registerPermission);

        $adminUser->assignRole($adminRole);

        Profile::create([
            'user_id' => $adminUser->id,
            'name' => '店長',
            'name_kana' => 'テンチョウ',
            'contract_type' => '正社員',
        ]);

        foreach (range(1, 7) as $i) {
            $user = User::factory()->create([
                'login_id' => 'test' . $i,
            ]);

            $user->assignRole($memberRole);

            Profile::create([
                'user_id' => $user->id,
                'name' => 'スタッフ' . $i,
                'name_kana' => 'スタッフ' . $i,
                'contract_type' => 'アルバイト',
            ]);
        }
    }

    private function board()
    {
        BoardPost::insert(
            [
                [
                    'user_id' => 1,
                    'title' => '🌟 社内掲示板のお知らせ 🌟',
                    'contents' => '<p>みなさん、お疲れさまです！💡</p><p>この掲示板では、正社員・アルバイト関係なく、全員に役立つ情報をお知らせします📢<br>シフトの確認、イベント情報、業務連絡など、大切な情報を見逃さないようにしましょう！</p>',
                    'status' => '掲載',
                ],
                [
                    'user_id' => 2,
                    'title' => '🍀 アルバイトからのお知らせ 🍀',
                    'contents' => '<p>みなさん、こんにちは！アルバイトの○○です😊</p><p>シフトや業務に関する大切な情報をお知らせします！</p><p>シフト交代や休憩のルールなど、全員が確認しておきたい内容ですので、ぜひチェックしてください！</p>',
                    'status' => '掲載',
                ],
                [
                    'user_id' => 3,
                    'title' => '🌟 シフト調整＆お願い 🌟',
                    'contents' => '<p>お疲れさまです！アルバイトの○○です😊</p><p>今月のシフト調整についてお知らせします。もしシフト変更が必要な場合や、代わりに入れる方がいればご連絡ください！</p><p>また、業務中のちょっとした気づきや改善点があれば、みんなで共有してより良い職場にしていきましょう！</p>',
                    'status' => '掲載',
                ],
                [
                    'user_id' => 4,
                    'title' => '🎉 休憩室の使い方について 🎉',
                    'contents' => '<p>みなさん、こんにちは！アルバイトの○○です！</p><p>休憩室が混雑することがありますので、みんなが快適に過ごせるように、休憩時間を守り、ゴミの処理をきちんと行いましょう🗑️</p><p>協力よろしくお願いします！</p>',
                    'status' => '掲載',
                ],
                [
                    'user_id' => 5,
                    'title' => '📝 業務の進行確認について 📝',
                    'contents' => '<p>お疲れさまです！アルバイトの○○です！</p><p>業務の進行について、もし不明点があればすぐに聞いてください。進行中に疑問があれば早めに確認して、ミスを防ぎましょう💡</p><p>みんなで協力して、スムーズに仕事を進めていきましょう！</p>',
                    'status' => '掲載',
                ],
                [
                    'user_id' => 6,
                    'title' => '🍻 アルバイト飲み会のお知らせ 🍻',
                    'contents' => '<p>こんにちは！アルバイトの○○です！</p><p>来月、アルバイトのみんなで飲み会を開こうと思っています🍻</p><p>参加したい方は○○まで連絡してください！楽しみにしています！</p>',
                    'status' => '掲載',
                ],
                [
                    'user_id' => 7,
                    'title' => '🔄 シフト交代のお願い 🔄',
                    'contents' => '<p>お疲れさまです！アルバイトの○○です。</p><p>○月○日のシフトを交代してくれる方を探しています！</p><p>シフトが合わない場合、調整可能な方は連絡ください。お手数をおかけしますが、よろしくお願いします！</p>',
                    'status' => '掲載',
                ],
                [
                    'user_id' => 8,
                    'title' => '📣 新しいアルバイトが入りました！ 📣',
                    'contents' => '<p>こんにちは！アルバイトの○○です。</p><p>新しく○○さんが仲間に加わりました！みんなで温かく迎えて、協力していきましょう！</p><p>何か困ったことがあれば、お互い助け合いましょう！</p>',
                    'status' => '掲載',
                ],
            ]
        );

        $users = User::all();
        $posts = BoardPost::all();

        $boardShows = [];

        foreach ($users as $user) {
            foreach ($posts as $post) {
                $boardShows[] = [
                    'user_id' => $user->id,
                    'post_id' => $post->id,
                ];
            }
        }

        DB::table('board__post_read_statuses')->insert($boardShows);

        BoardLike::insert($boardShows);
    }

    private function calendar()
    {
        $holidays = [
            ['date' => '2025-01-01', 'name' => '元日'],
            ['date' => '2025-01-13', 'name' => '成人の日'],
            ['date' => '2025-02-11', 'name' => '建国記念の日'],
            ['date' => '2025-02-23', 'name' => '天皇誕生日'],
            ['date' => '2025-03-20', 'name' => '春分の日'],
            ['date' => '2025-04-29', 'name' => '昭和の日'],
            ['date' => '2025-05-03', 'name' => '憲法記念日'],
            ['date' => '2025-05-04', 'name' => 'みどりの日'],
            ['date' => '2025-05-05', 'name' => 'こどもの日'],
            ['date' => '2025-07-21', 'name' => '海の日'],
            ['date' => '2025-08-11', 'name' => '山の日'],
            ['date' => '2025-09-15', 'name' => '敬老の日'],
            ['date' => '2025-09-23', 'name' => '秋分の日'],
            ['date' => '2025-10-13', 'name' => 'スポーツの日'],
            ['date' => '2025-11-03', 'name' => '文化の日'],
            ['date' => '2025-11-23', 'name' => '勤労感謝の日'],
        ];

        PublicHoliday::insert($holidays);

        $users = User::all();

        $schedules = [];

        foreach ($users as $user) {
            for ($i = 0; $i < 5; $i++) {
                $randomHour = rand(6, 15);
                $randomMinute = rand(0, 5) * 10;
                $randomTime = Carbon::today()->setTime($randomHour, $randomMinute);

                $addHour = rand(1, 6);

                $schedules[] = [
                    'user_id' => $user->id,
                    'title' => '予定',
                    'date' => now()->addDays(rand(1, 30)),
                    'start_time' => $randomTime,
                    'end_time' => $randomTime->addHours($addHour),
                ];
            }
        }

        Schedule::insert($schedules);
    }

    private function chat()
    {
        $users = User::all();
        $groupId = 1;

        for ($i = 0; $i < count($users); $i++) {
            for ($j = $i + 1; $j < count($users); $j++) {
                $groups[] = ['is_dm' => true];

                $groupUsers[] = ['group_id' => $groupId, 'user_id' => $users[$i]->id];
                $groupUsers[] = ['group_id' => $groupId, 'user_id' => $users[$j]->id];

                $groupId++;
            }
        }

        Group::insert($groups);

        DB::table('chat__group_user')->insert($groupUsers);

        $group = Group::create([
            'name' => '全体',
            'is_dm' => false,
        ]);

        $allMemberGroup = [];
        foreach ($users as $user) {
            $allMemberGroup[] = ['group_id' => $group->id, 'user_id' => $user->id];
        }

        DB::table('chat__group_user')->insert($allMemberGroup);
    }

    private function timecard()
    {
        $users = User::all();
        $timecards = [];

        foreach ($users as $user) {
            $usedDates = [];

            for ($i = 0; $i < 15; $i++) {
                do {
                    $randomDate = Carbon::today()->addDays(rand(1, 30))->toDateString();
                } while (in_array($randomDate, $usedDates));

                $usedDates[] = $randomDate;

                $randomHour = rand(6, 15);
                $randomMinute = rand(0, 5) * 10;
                $randomTime = Carbon::parse($randomDate)->setTime($randomHour, $randomMinute);

                $addHour = rand(1, 6);

                $timecards[] = [
                    'user_id' => $user->id,
                    'date' => $randomDate,
                    'in_time' => $randomTime,
                    'out_time' => $randomTime->copy()->addHours($addHour),
                ];
            }
        }

        WorkTime::insert($timecards);
    }

    private function shift() {}
}
