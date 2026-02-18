<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\UserLimit;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SyncCentralSetting extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-central-setting';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        sleep(random_int(0, 60));

        $setting = UserLimit::first();
        $lastCentralUpdatedAt = $setting?->central_updated_at;

        $response = Http::timeout(3)
            ->retry(2, 300)
            ->withToken(config('services.central.token'))
            ->get(rtrim(config('services.central.url'), '/') . '/api/settings', [
                'since' => $lastCentralUpdatedAt,
            ]);

        if ($response->status() === 204) {
            return;
        }

        if (! $response->successful()) {
            logger()->warning('Central sync failed');

            return;
        }

        $data = $response->json();

        if (! isset($data['user_limit'], $data['updated_at'])) {
            logger()->warning('Central response invalid');

            return;
        }

        UserLimit::updateOrCreate(
            ['id' => 1],
            [
                'user_limit' => $data['user_limit'],
                'central_updated_at' => $data['updated_at'],
                'synced_at' => now(),
            ]
        );
    }
}
