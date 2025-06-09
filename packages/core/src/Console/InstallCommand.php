<?php

declare(strict_types=1);

namespace Tinoecom\Core\Console;

use Illuminate\Console\Command;
use Tinoecom\Core\CoreServiceProvider;
use Tinoecom\Core\Database\Seeders\TinoecomSeeder;
use Spatie\MediaLibrary\MediaLibraryServiceProvider;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Helper\ProgressBar;

use function Laravel\Prompts\confirm;

#[AsCommand(name: 'tinoecom:install')]
final class InstallCommand extends Command
{
    protected $signature = 'tinoecom:install';

    protected $description = 'Install Tinoecom core base';

    protected ProgressBar $progressBar;

    public function __construct()
    {
        parent::__construct();

        if (file_exists(config_path('tinoecom/core.php'))) {
            $this->setHidden();
        }
    }

    public function handle(): void
    {
        $this->newLine();
        $this->progressBar = $this->output->createProgressBar(3);

        $this->introMessage();

        sleep(1);

        if (! $this->progressBar->getProgress()) {
            $this->progressBar->start();
        }

        $this->newLine();
        $this->components->info('Publishing configuration...');

        $this->call('vendor:publish', ['--provider' => CoreServiceProvider::class]);
        $this->call(
            'vendor:publish',
            ['--provider' => MediaLibraryServiceProvider::class, '--tag' => 'medialibrary-migrations']
        );

        $this->progressBar->advance();

        if (confirm('Run database migrations and seeders ?')) {
            $this->setupDatabaseConfig();
        }

        if (! file_exists(config_path('tinoecom/admin.php'))) {
            $this->newLine();

            $this->line('Installing Tinoecom Admin Panel 🚧.');
            $this->call('tinoecom:panel-install');
        }
    }

    protected function setupDatabaseConfig(): void
    {
        $this->components->info('Migrating the database tables into your application 🔽');
        $this->call('migrate');

        $this->progressBar->advance();

        $this->components->info('Seed data into your database 🔽');
        $this->call('db:seed', ['--class' => TinoecomSeeder::class]);

        $this->progressBar->advance();

        // Visually slow down the installation process so that the user can read what's happening
        usleep(350000);

        $this->progressBar->finish();
    }

    protected function introMessage(): void
    {
        $this->components->info('
                _____ __
              / ___// /_  ____  ____  ____  ___  _____
              \__ \/ __ \/ __ \/ __ \/ __ \/ _ \/ ___/
             ___/ / / / / /_/ / /_/ / /_/ /  __/ /
            /____/_/ /_/\____/ .___/ .___/\___/_/
                            /_/   /_/

            Installation started. Please wait...
        ');
    }
}
