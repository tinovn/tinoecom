<?php

declare(strict_types=1);

namespace Tinoecom\Tests\Admin\Features;

use Tinoecom\Facades\Tinoecom;
use Tinoecom\Tests\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->prefix = Tinoecom::prefix();

        $this->asAdmin();
    }
}
