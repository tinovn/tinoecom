<?php

declare(strict_types=1);

namespace Tinoecom\Core\Models\Traits;

use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

trait HasMedia
{
    use InteractsWithMedia;

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(config('tinoecom.media.storage.collection_name'))
            ->useDisk(config('tinoecom.media.storage.disk_name'))
            ->acceptsMimeTypes(config('tinoecom.media.accepts_mime_types'))
            ->useFallbackUrl(tinoecom_fallback_url());

        $this->addMediaCollection(config('tinoecom.media.storage.thumbnail_collection'))
            ->singleFile()
            ->useDisk(config('tinoecom.media.storage.disk_name'))
            ->acceptsMimeTypes(config('tinoecom.media.accepts_mime_types'))
            ->useFallbackUrl(tinoecom_fallback_url());
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $conversions = config('tinoecom.media.conversions', []);

        foreach ($conversions as $key => $conversion) {
            $this->addMediaConversion($key)
                ->fit(
                    Fit::Fill,
                    $conversion['width'],
                    $conversion['height']
                )->keepOriginalImageFormat();
        }
    }
}
