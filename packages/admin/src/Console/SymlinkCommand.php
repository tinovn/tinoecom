<?php

declare(strict_types=1);

namespace Tinoecom\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'tinoecom:link')]
final class SymlinkCommand extends Command
{
    protected $signature = 'tinoecom:link';

    protected $description = 'Create a symbolic link from "vendor/tinoecom" to public folder';

    public function handle(): void
    {
        $prefix = tinoecom()->prefix();
        $link = public_path($prefix);
        $target = realpath(__DIR__ . '/../../public/');

        if (file_exists($link)) {
            $this->error('The "public/' . $prefix . '" directory already exists.');
        } else {
            $this->laravel->make('files')->link($target, $link);
            $this->info('The [public/' . $prefix . '] directory has been linked.');
        }

        $this->info('The link have been created.');
    }
}
