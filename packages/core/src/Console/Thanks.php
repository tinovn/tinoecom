<?php

declare(strict_types=1);

namespace Tinoecom\Core\Console;

use const PHP_OS_FAMILY;

use Symfony\Component\Console\Helper\SymfonyQuestionHelper;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

final class Thanks
{
    private const FUNDING_MESSAGES = [
        '',
        '  - Star or contribute to Tinoecom:',
        '    <options=bold>https://github.com/tinoecomlabs/tinoecom</>',
        '  - Tweet something about Tinoecom on Twitter:',
        '    <options=bold>https://twitter.com/laraveltinoecom</>',
        '  - Sponsor the creator:',
        '    <options=bold>https://github.com/sponsors/mckenziearts</>',
    ];

    public function __construct(private readonly OutputInterface $output) {}

    public function __invoke(): void
    {
        $wantsToSupport = (new SymfonyQuestionHelper)->ask(
            new ArrayInput([]),
            $this->output,
            new ConfirmationQuestion(
                'Can you show us love by give a <options=bold>star ⭐️ on GitHub</>? 🙏🏻',
                true,
            )
        );

        if ($wantsToSupport === true) {
            if (PHP_OS_FAMILY === 'Darwin') {
                exec('open https://github.com/tinoecomlabs/tinoecom');
            }
            if (PHP_OS_FAMILY === 'Windows') {
                exec('start https://github.com/tinoecomlabs/tinoecom');
            }
            if (PHP_OS_FAMILY === 'Linux') {
                exec('xdg-open https://github.com/tinoecomlabs/tinoecom');
            }
        }

        foreach (self::FUNDING_MESSAGES as $message) {
            $this->output->writeln($message);
        }
    }
}
