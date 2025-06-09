<?php

declare(strict_types=1);

use Tinoecom\Core\Models\User;
use Tinoecom\Facades\Tinoecom;
use Tinoecom\Tests\TestCase;

uses(TestCase::class);

it('can log a user out', function (): void {
    $prefix = Tinoecom::prefix();

    $this
        ->actingAs(User::factory()->create())
        ->post($prefix . '/logout')
        ->assertRedirect($prefix . '/login');

    $this->assertGuest();
});
