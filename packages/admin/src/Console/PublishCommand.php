<?php

declare(strict_types=1);

namespace Tinoecom\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'tinoecom:publish')]
final class PublishCommand extends Command
{
    protected $signature = 'tinoecom:publish {--force : Overwrite any existing files}';

    protected $description = 'Publish all of the Tinoecom resources';

    public function handle(): void
    {
        $this->call('vendor:publish', [
            '--tag' => 'tinoecom-config',
            '--force' => $this->option('force'),
        ]);

        $this->call('vendor:publish', [
            '--tag' => 'tinoecom-lang',
            '--force' => $this->option('force'),
        ]);
    }
}
