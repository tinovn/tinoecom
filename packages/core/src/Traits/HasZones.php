<?php

declare(strict_types=1);

namespace Tinoecom\Core\Traits;

use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Tinoecom\Core\Models\Zone;

trait HasZones
{
    /**
     * @return MorphToMany<Zone, $this>
     */
    public function zones(): MorphToMany
    {
        return $this->morphToMany(Zone::class, 'zonable', tinoecom_table('zone_has_relations'));
    }
}
