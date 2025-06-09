<?php

declare(strict_types=1);

namespace Tinoecom\Console;

use Illuminate\Console\Command;
use Tinoecom\Core\Console\Thanks;
use Tinoecom\TinoecomServiceProvider;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Helper\ProgressBar;

#[AsCommand(name: 'tinoecom:panel-install')]
final class InstallCommand extends Command
{
    protected ProgressBar $progressBar;

    protected $signature = 'tinoecom:panel-install';

    protected $description = 'Install Tinoecom e-commerce admin panel';

    public function __construct()
    {
        parent::__construct();

        if (file_exists(config_path('tinoecom/admin.php'))) {
            $this->setHidden();
        }
    }

    public function handle(): void
    {
        $this->newLine();
        $this->progressBar = $this->output->createProgressBar(3);
        sleep(1);

        $this->components->info('Installation of Tinoecom Panel, publish assets and config files');

        if (! $this->progressBar->getProgress()) {
            $this->progressBar->start();
        }

        $this->call('vendor:publish', ['--provider' => TinoecomServiceProvider::class]);
        $this->progressBar->advance();

        $this->components->info('Publish filament assets 🎨...');
        $this->call('filament:assets');

        $this->components->info('Enable Tinoecom symlink for storage 📎...');
        $this->call('tinoecom:link');
        $this->progressBar->advance();

        $this->completeSetup();

        if (! $this->option('no-interaction')) {
            (new Thanks($this->output))();
        }
    }

    protected function completeSetup(): void
    {
        $this->progressBar->finish();

        $this->components->info("
                                      ,@@@@@@@,
                              ,,,.   ,@@@@@@/@@,  .oo8888o.
                           ,&%%&%&&%,@@@@@/@@@@@@,8888\\88/8o
                          ,%&\\%&&%&&%,@@@\\@@@/@@@88\\88888/88'
                          %&&%&%&/%&&%@@\\@@/ /@@@88888\\88888'
                          %&&%/ %&%%&&@@\\ V /@@' `88\\8 `/88'
                          `&%\\ ` /%&'    |.|        \\ '|8'
                              |o|        | |         | |
                              |.|        | |         | |
       ======================== Installation Complete 🚀 ======================
        ");

        $this->comment("Before create an admin user you have to change the extend class of your User Model to The Tinoecom User Model 'Tinoecom\\Core\\Models\\User'");
        $this->comment("To create a user, run 'php artisan tinoecom:user'");
    }
}
