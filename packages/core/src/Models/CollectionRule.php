<?php

declare(strict_types=1);

namespace Tinoecom\Core\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Tinoecom\Core\Database\Factories\CollectionRuleFactory;
use Tinoecom\Core\Enum\Operator;
use Tinoecom\Core\Enum\Rule;

/**
 * @property-read int $id
 * @property Rule $rule
 * @property Operator $operator
 * @property string $value
 * @property int $collection_id
 * @property Collection $collection
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class CollectionRule extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'rule' => Rule::class,
        'operator' => Operator::class,
    ];

    public function getTable(): string
    {
        return tinoecom_table('collection_rules');
    }

    protected static function newFactory(): CollectionRuleFactory
    {
        return CollectionRuleFactory::new();
    }

    public function getFormattedRule(): string
    {
        return Rule::options()[$this->rule->value];
    }

    public function getFormattedOperator(): string
    {
        return Operator::options()[$this->operator->value];
    }

    public function getFormattedValue(): string
    {
        if ($this->rule === Rule::ProductPrice) {
            return tinoecom_money_format((int) $this->value);
        }

        return $this->value;
    }

    public function collection(): BelongsTo
    {
        return $this->belongsTo(config('tinoecom.models.collection'), 'collection_id');
    }
}
