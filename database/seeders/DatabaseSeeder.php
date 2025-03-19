<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Carbon\CarbonImmutable;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Account\Models\Profile;
use Modules\Board\Models\BoardAttachment;
use Modules\Board\Models\BoardLike;
use Modules\Board\Models\BoardPost;
use Modules\Calendar\Models\PublicHoliday;
use Modules\Calendar\Models\Schedule as CalendarSchedule;
use Modules\Chat\Database\Seeders\ChatDatabaseSeeder;
use Modules\Chat\Models\Group;
use Modules\Chat\Models\Message;
use Modules\Chat\Models\MessageImage;
use Modules\Chat\Models\MessageRead;
use Modules\Shift\Models\DraftSchedule;
use Modules\Shift\Models\Manager;
use Modules\Shift\Models\Schedule;
use Modules\Timecard\Models\BreakTime;
use Modules\Timecard\Models\WorkTime;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        $adminUser = User::factory()->create([
            'login_id' => 'test',
        ]);

        $adminRole = Role::create(['name' => 'admin']);
        $memberRole = Role::create(['name' => 'member']);

        $registerPermission = Permission::create(['name' => 'register']);

        $adminRole->givePermissionTo($registerPermission);

        $adminUser->assignRole($adminRole);

        Manager::factory()->count(5)->create();
        WorkTime::factory()->count(50)->create();
        BreakTime::factory()->count(50)->create();
        DraftSchedule::factory()->count(50)->create();
        Schedule::factory()->count(50)->create();
        Group::factory()->count(50)->create();
        Message::factory()->count(50)->create();
        Message::factory()->count(10)->withImages()->create();
        MessageImage::factory()->count(10)->create();
        MessageRead::factory()->count(100)->create();

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

        foreach ($holidays as $holiday) {
            PublicHoliday::create([
                'date' => CarbonImmutable::parse($holiday['date']),
                'name' => $holiday['name'],
            ]);
        }

        CalendarSchedule::factory()->count(50)->create();
        BoardPost::factory()->count(50)->create();
        BoardLike::factory()->count(100)->create();
        BoardAttachment::factory()->count(100)->create();
        Profile::factory()->count(10)->create();

        $this->call(ChatDatabaseSeeder::class); // ChatGroupUserSeederを追加
    }
}
