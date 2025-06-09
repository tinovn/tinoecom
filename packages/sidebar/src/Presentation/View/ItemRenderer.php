<?php

declare(strict_types=1);

namespace Tinoecom\Sidebar\Presentation\View;

use Tinoecom\Sidebar\Contracts\Builder\Item;
use Tinoecom\Sidebar\Presentation\AbstractRenderer;
use Tinoecom\Sidebar\Presentation\ActiveStateChecker;

class ItemRenderer extends AbstractRenderer
{
    protected string $view = 'sidebar::item';

    public function render(Item $item): ?string
    {
        if ($item->isAuthorized()) {
            $items = [];
            foreach ($item->getItems() as $child) {
                $items[] = (new ItemRenderer($this->factory))->render($child);
            }

            $badges = [];
            foreach ($item->getBadges() as $badge) {
                $badges[] = (new BadgeRenderer($this->factory))->render($badge);
            }

            $appends = [];
            foreach ($item->getAppends() as $append) {
                $appends[] = (new AppendRenderer($this->factory))->render($append);
            }

            return $this->factory->make($this->view, [
                'item' => $item,
                'items' => $items,
                'badges' => $badges,
                'appends' => $appends,
                'active' => (new ActiveStateChecker)->isActive($item),
            ])->render();
        }

        return null;
    }
}
