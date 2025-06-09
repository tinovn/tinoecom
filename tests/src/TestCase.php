<?php

declare(strict_types=1);

namespace Tinoecom\Tests;

use BladeUI\Heroicons\BladeHeroiconsServiceProvider;
use BladeUI\Icons\BladeIconsServiceProvider;
use Codeat3\BladePhosphorIcons\BladePhosphorIconsServiceProvider;
use CodeWithDennis\FilamentSelectTree\FilamentSelectTreeServiceProvider;
use Filament\Actions\ActionsServiceProvider;
use Filament\Forms\FormsServiceProvider;
use Filament\Notifications\NotificationsServiceProvider;
use Filament\Support\SupportServiceProvider;
use Filament\Tables\TablesServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use JaOcero\RadioDeck\RadioDeckServiceProvider;
use Livewire\LivewireServiceProvider;
use Mckenziearts\BladeUntitledUIIcons\BladeUntitledUIIconsServiceProvider;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\TestCase as BaseTestCase;
use RyanChandler\BladeCaptureDirective\BladeCaptureDirectiveServiceProvider;
use Tinoecom\Core\CoreServiceProvider;
use Tinoecom\Core\Database\Seeders\TinoecomSeeder;
use Tinoecom\Core\Models\User;
use Tinoecom\TinoecomServiceProvider;
use Tinoecom\Sidebar\SidebarServiceProvider;
use Spatie\LivewireWizard\WizardServiceProvider;
use Spatie\MediaLibrary\MediaLibraryServiceProvider;
use Spatie\Permission\PermissionServiceProvider;
use TailwindMerge\Laravel\TailwindMergeServiceProvider;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;
    use WithWorkbench;

    protected bool $seed = true;

    protected string $seeder = TinoecomSeeder::class;

    protected function setUp(): void
    {
        parent::setUp();

        $this->loadLaravelMigrations();

        // Freeze time to avoid timestamp errors
        $this->freezeTime();
    }

    protected function getPackageProviders($app): array
    {
        return [
            ActionsServiceProvider::class,
            BladeCaptureDirectiveServiceProvider::class,
            BladeHeroiconsServiceProvider::class,
            BladeUntitledUIIconsServiceProvider::class,
            BladePhosphorIconsServiceProvider::class,
            BladeIconsServiceProvider::class,
            CoreServiceProvider::class,
            PermissionServiceProvider::class,
            LivewireServiceProvider::class,
            TinoecomServiceProvider::class,
            SidebarServiceProvider::class,
            FormsServiceProvider::class,
            SupportServiceProvider::class,
            NotificationsServiceProvider::class,
            TablesServiceProvider::class,
            MediaLibraryServiceProvider::class,
            TailwindMergeServiceProvider::class,
            RadioDeckServiceProvider::class,
            FilamentSelectTreeServiceProvider::class,
            WizardServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('auth.providers.users.model', User::class);
        $app['config']->set('view.paths', [
            ...$app['config']->get('view.paths'),
            __DIR__ . '/../../packages/admin/resources/views',
        ]);
    }

    protected function asAdmin(): TestCase
    {
        return $this->actingAs($this->makeAdminUser(), config('tinoecom.auth.guard'));
    }

    protected function makeAdminUser(): User
    {
        $admin = User::factory()->create();

        $admin->assignRole(config('tinoecom.core.users.admin_role'));

        return $admin;
    }
}
