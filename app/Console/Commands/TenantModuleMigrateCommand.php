<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Nwidart\Modules\Commands\BaseCommand;
use Nwidart\Modules\Contracts\ConfirmableCommand;
use Stancl\Tenancy\Events\MigratingDatabase;
use Symfony\Component\Console\Input\InputOption;

class TenantModuleMigrateCommand extends BaseCommand implements ConfirmableCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'migrate:tm-fresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '特定のテナントとモジュールを指定して、マイグレーション';

    public function executeAction($name): void
    {
        $module = $this->getModuleModel($name);

        tenancy()->runForMultiple($this->option('tenants'), function ($tenant) use ($module) {
            event(new MigratingDatabase($tenant));

            $this->call('module:migrate-reset', [
                'module' => $module->getStudlyName(),
                '--database' => $this->option('database'),
                '--force' => $this->option('force'),
            ]);

            $this->call('module:migrate', [
                'module' => $module->getStudlyName(),
                '--database' => $this->option('database'),
                '--force' => $this->option('force'),
            ]);

            if ($this->option('seed')) {
                $this->call('module:seed', [
                    'module' => $module->getStudlyName(),
                ]);
            }
            event(new MigratingDatabase($tenant));
        });
    }

    /**
     * Get the console command options.
     */
    protected function getOptions(): array
    {
        return [
            ['database', null, InputOption::VALUE_OPTIONAL, 'The database connection to use.'],
            ['force', null, InputOption::VALUE_NONE, 'Force the operation to run when in production.'],
            ['seed', null, InputOption::VALUE_NONE, 'Indicates if the seed task should be re-run.'],
            ['tenants', null, InputOption::VALUE_OPTIONAL, 'Run Migration rollback in specific tenant'],
        ];
    }
}
