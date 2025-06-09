<?php

declare(strict_types=1);

namespace Tinoecom\Console;

use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'tinoecom:page')]
final class MakeTinoecomPageCommand extends MakePageCommand
{
    protected $signature = 'tinoecom:page {name?} {--f|force}';
}
