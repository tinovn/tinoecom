<?php

declare(strict_types=1);

namespace Tinoecom\Core\Models;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute as CastAttribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Arr;
use Tinoecom\Core\Contracts\HasReviews;
use Tinoecom\Core\Database\Factories\ProductFactory;
use Tinoecom\Core\Enum\Dimension\Length;
use Tinoecom\Core\Enum\Dimension\Volume;
use Tinoecom\Core\Enum\Dimension\Weight;
use Tinoecom\Core\Enum\ProductType;
use Tinoecom\Core\Models\Traits\HasDimensions;
use Tinoecom\Core\Models\Traits\HasDiscounts;
use Tinoecom\Core\Models\Traits\HasMedia;
use Tinoecom\Core\Models\Traits\HasPrices;
use Tinoecom\Core\Models\Traits\HasStock;
use Tinoecom\Core\Models\Traits\InteractsWithReviews;
use Tinoecom\Core\Observers\ProductObserver;
use Tinoecom\Core\Traits\HasSlug;
use Spatie\MediaLibrary\HasMedia as SpatieHasMedia;

/**
 * @property-read int $id
 * @property string $name
 * @property string $slug
 * @property string|null $sku
 * @property string|null $barcode
 * @property ProductType|null $type
 * @property bool $is_visible
 * @property bool $featured
 * @property Weight $weight_unit
 * @property float|null $weight_value
 * @property Length $height_unit
 * @property float|null $height_value
 * @property Length $width_unit
 * @property float|null $width_value
 * @property Length $depth_unit
 * @property float|null $depth_value
 * @property Volume $volume_unit
 * @property float|null $volume_value
 * @property int|null $security_stock
 * @property int $variants_stock
 * @property string|null $seo_title
 * @property string|null $seo_description
 * @property string|null $external_id
 * @property \Illuminate\Support\Carbon|null $published_at
 * @property array<array-key, mixed>|null $metadata
 * @property-read int $stock
 * @property-read Brand $brand
 * @property-read \Illuminate\Support\Collection<int, Channel> $channels
 * @property-read \Illuminate\Support\Collection<int, Category> $categories
 * @property-read \Illuminate\Support\Collection<int, Attribute> $options
 * @property-read \Illuminate\Support\Collection<int, Collection> $collections
 * @property-read \Illuminate\Support\Collection<int, ProductVariant> $variants
 * @property-read \Illuminate\Support\Collection<int, Price> $prices
 */
#[ObservedBy(ProductObserver::class)]
class Product extends Model implements HasReviews, SpatieHasMedia
{
    /** @use HasFactory<ProductFactory> */
    use HasFactory;

    use HasDimensions;
    use HasDiscounts;
    use HasMedia;
    use HasPrices;
    use HasSlug;
    use HasStock;
    use InteractsWithReviews;

    protected $guarded = [];

    public function getTable(): string
    {
        return tinoecom_table('products');
    }

    protected function casts(): array
    {
        return [
            'featured' => 'boolean',
            'is_visible' => 'boolean',
            'published_at' => 'datetime',
            'metadata' => 'array',
            'weight_unit' => Weight::class,
            'weight_value' => 'decimal:2',
            'width_unit' => Length::class,
            'width_value' => 'decimal:2',
            'height_unit' => Length::class,
            'height_value' => 'decimal:2',
            'depth_unit' => Length::class,
            'depth_value' => 'decimal:2',
            'volume_unit' => Volume::class,
            'volume_value' => 'decimal:2',
            'type' => ProductType::class,
        ];
    }

    protected static function newFactory(): ProductFactory
    {
        return ProductFactory::new();
    }

    public function variantsStock(): CastAttribute
    {
        $stock = 0;

        if ($this->variants->isNotEmpty()) {
            /** @var ProductVariant $variant */
            foreach ($this->variants as $variant) {
                $stock += $variant->stock;
            }
        }

        return CastAttribute::get(fn () => $stock);
    }

    public function canUseShipping(): bool
    {
        return $this->isStandard() || $this->isVariant();
    }

    public function canUseAttributes(): bool
    {
        return $this->isStandard() || $this->isVariant();
    }

    public function canUseVariants(): bool
    {
        return $this->isVariant();
    }

    public function isExternal(): bool
    {
        return $this->type === ProductType::External;
    }

    public function isVariant(): bool
    {
        return $this->type === ProductType::Variant;
    }

    public function isVirtual(): bool
    {
        return $this->type === ProductType::Virtual;
    }

    public function isStandard(): bool
    {
        return $this->type === ProductType::Standard;
    }

    /**
     * @param  Builder<Product>  $query
     */
    public function scopePublish(Builder $query): void
    {
        $query->whereDate('published_at', '<=', now())
            ->where('is_visible', true);
    }

    /**
     * @param  Builder<Product>  $query
     * @param  string|array<string>  $channel
     * @return Builder<Product>
     */
    public function scopeForChannel(Builder $query, string | array $channel): Builder
    {
        $channels = Arr::wrap($channel);

        return $query->whereHas('channels', function (Builder $query) use ($channels): void {
            $query->whereIn('id', $channels);
        });
    }

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

        $this->addMediaCollection('files')
            ->useDisk(config('tinoecom.media.storage.disk_name'));
    }

    /**
     * @return HasMany<ProductVariant, $this>
     */
    public function variants(): HasMany
    {
        // @phpstan-ignore-next-line
        return $this->hasMany(config('tinoecom.models.variant'), 'product_id');
    }

    /**
     * @return MorphToMany<Channel, $this>
     */
    public function channels(): MorphToMany
    {
        // @phpstan-ignore-next-line
        return $this->morphedByMany(config('tinoecom.models.channel'), 'productable', tinoecom_table('product_has_relations'));
    }

    /**
     * @return MorphToMany<self, $this>
     */
    public function relatedProducts(): MorphToMany
    {
        // @phpstan-ignore-next-line
        return $this->morphedByMany(config('tinoecom.models.product'), 'productable', tinoecom_table('product_has_relations'));
    }

    /**
     * @return MorphToMany<Category, $this>
     */
    public function categories(): MorphToMany
    {
        // @phpstan-ignore-next-line
        return $this->morphedByMany(config('tinoecom.models.category'), 'productable', tinoecom_table('product_has_relations'));
    }

    /**
     * @return MorphToMany<Collection, $this>
     */
    public function collections(): MorphToMany
    {
        // @phpstan-ignore-next-line
        return $this->morphedByMany(config('tinoecom.models.collection'), 'productable', tinoecom_table('product_has_relations'));
    }

    /**
     * @return BelongsTo<Brand, $this>
     */
    public function brand(): BelongsTo
    {
        // @phpstan-ignore-next-line
        return $this->belongsTo(config('tinoecom.models.brand'), 'brand_id');
    }

    /**
     * Product Attributes relation, to avoid collision with Model $attributes
     *
     * @return BelongsToMany<Attribute, $this>
     */
    public function options(): BelongsToMany
    {
        return $this->belongsToMany(Attribute::class, table: tinoecom_table('attribute_product'))
            ->withPivot([
                'attribute_value_id',
                'attribute_custom_value',
            ]);
    }
}
