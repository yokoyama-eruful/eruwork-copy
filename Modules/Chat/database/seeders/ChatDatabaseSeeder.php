<?php

declare(strict_types=1);

namespace Modules\Chat\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChatDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = range(1, 10); // ユーザーIDの範囲
        $groups = range(1, 50); // グループIDの範囲

        foreach ($groups as $groupId) {
            $randomUsers = array_rand(array_flip($users), rand(1, 5)); // 各グループに1〜5人のユーザーをランダムに割り当てる

            if (! is_array($randomUsers)) {
                $randomUsers = [$randomUsers];
            }

            foreach ($randomUsers as $userId) {
                DB::table('chat__group_user')->insert([
                    'user_id' => $userId,
                    'group_id' => $groupId,
                ]);
            }
        }
    }
}
