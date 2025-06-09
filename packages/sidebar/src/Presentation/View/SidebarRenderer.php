<?php

declare(strict_types=1);

namespace Tinoecom\Sidebar\Presentation\View;

use Illuminate\Contracts\View\View;
use Tinoecom\Sidebar\Contracts\Sidebar;
use Tinoecom\Sidebar\Presentation\AbstractRenderer;
use Tinoecom\Sidebar\Presentation\SidebarRenderer as BaseSidebarRenderer;

class SidebarRenderer extends AbstractRenderer implements BaseSidebarRenderer
{
    protected string $view = 'sidebar::menu';

    public function render(Sidebar $sidebar): ?View
    {
        $menu = $sidebar->getMenu();

        if ($menu->isAuthorized()) {
            $groups = [];
            foreach ($menu->getGroups() as $group) {
                $groups[] = (new GroupRenderer($this->factory))->render($group);
            }

            return $this->factory->make($this->view, [
                'groups' => $groups,
            ]);
        }

        return null;
    }
}
