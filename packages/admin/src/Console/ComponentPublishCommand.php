<?php

declare(strict_types=1);

namespace Tinoecom\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Finder\Finder;

use function Laravel\Prompts\select;

#[AsCommand(name: 'tinoecom:component:publish')]
final class ComponentPublishCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tinoecom:component:publish
                    {name? : The name of the components config file to publish}
                    {--all : Publish all components config files}
                    {--force : Overwrite any existing components configuration files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish livewire components files in your application';

    /**
     * Execute the console command.
     *
     * @return int|void
     */
    public function handle()
    {
        $config = $this->getBaseConfigurationFiles();

        if (! $this->argument('name') && $this->option('all')) {
            foreach ($config as $key => $file) {
                $this->publish($key, $file, $this->getTinoecomComponentsConfigFolder() . '/' . $key . '.php');
            }

            return;
        }

        $name = (string) (! $this->argument('name') ? select(
            label: 'Which components configuration file would you like to publish?',
            options: collect($config)->map(fn (string $path) => ucfirst(basename($path, '.php'))),
        ) : $this->argument('name'));

        if (! $name && ! isset($config[$name])) {
            $this->components->error('Unrecognized component configuration file.');

            return 1;
        }

        $this->publish($name, $config[$name], $this->getTinoecomComponentsConfigFolder() . '/' . $name . '.php');
    }

    /**
     * Publish the given file to the given destination.
     */
    protected function publish(string $name, string $file, string $destination): void
    {
        if (file_exists($destination) && ! $this->option('force')) {
            $this->components->error("The '{$name}' components configuration file already exists.");

            return;
        }

        if (! File::exists($this->getTinoecomComponentsConfigFolder())) {
            File::makeDirectory($this->getTinoecomComponentsConfigFolder());
        }

        copy($file, $destination);

        $this->components->info("Published '{$name}' components configuration file.");
    }

    /**
     * Get an array containing the base configuration files.
     */
    protected function getBaseConfigurationFiles(): array
    {
        $config = [];

        foreach (Finder::create()->files()->name('*.php')->in(__DIR__ . '/../../config/components') as $file) {
            $name = basename($file->getRealPath(), '.php');

            $config[$name] = $file->getRealPath();
        }

        return collect($config)->sortKeys()->all();
    }

    protected function getTinoecomComponentsConfigFolder(): string
    {
        return $this->laravel->configPath() . '/tinoecom/components';
    }
}
