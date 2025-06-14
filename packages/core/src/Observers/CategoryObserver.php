<?php

declare(strict_types=1);

namespace Tinoecom\Core\Observers;

use Tinoecom\Core\Models\Category;
use Tinoecom\Core\Repositories\CategoryRepository;

final class CategoryObserver
{
    public function creating($model): void
    {
        $this->ensureParentSlugIsCorrectlySet($model);
    }

    public function updating($model): void
    {
        $this->ensureParentSlugIsCorrectlySet($model);
    }

    /**
     * Ensure that the parent slug is present on the category slug is selected
     * slug is "parent_slug_category_slug" when a parent category is choose
     */
    protected function ensureParentSlugIsCorrectlySet($category): void
    {
        if (filled($category->parent_id)) {
            /** @var Category | null $parent */
            $parent = (new CategoryRepository)
                ->getById((int) $category->parent_id, ['slug']);

            if ($parent) {
                $category->slug = $parent->slug . '-' . $category->name;
            }
        }
    }
}
