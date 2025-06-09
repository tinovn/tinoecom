<?php

declare(strict_types=1);

namespace Tinoecom\Sidebar\Presentation\View;

use Tinoecom\Sidebar\Contracts\Builder\Badge;
use Tinoecom\Sidebar\Presentation\AbstractRenderer;

class BadgeRenderer extends AbstractRenderer
{
    protected string $view = 'sidebar::badge';

    public function render(Badge $badge): ?string
    {
        if ($badge->isAuthorized()) {
            return $this->factory->make($this->view, [
                'badge' => $badge,
            ])->render();
        }

        return null;
    }
}
