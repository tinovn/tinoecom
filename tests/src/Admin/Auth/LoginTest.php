<?php

declare(strict_types=1);

use Livewire\Livewire;
use Tinoecom\Core\Models\User;
use Tinoecom\Facades\Tinoecom;
use Tinoecom\Livewire\Pages\Auth\Login;
use Tinoecom\Tests\TestCase;

uses(TestCase::class);

describe(Login::class, function (): void {
    it('can render login page', function (): void {
        $this->get(Tinoecom::prefix() . '/login')
            ->assertSuccessful();
    });

    it('can authenticate', function (): void {
        $this->assertGuest();

        $userToAuthenticate = User::factory()->create();
        $userToAuthenticate->assignRole(config('tinoecom.core.users.admin_role'));

        Livewire::test(Login::class)
            ->set('email', $userToAuthenticate->email)
            ->set('password', 'password')
            ->call('authenticate')
            ->assertRedirect(Tinoecom::prefix() . '/dashboard');

        $this->assertAuthenticatedAs($userToAuthenticate, config('tinoecom.auth.guard'));
    });
})->group('authenticate');
