<?php

declare(strict_types=1);

namespace Tinoecom\Livewire\SlideOvers;

use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Tinoecom\Actions\Store\SaveAndDispatchDiscountAction;
use Tinoecom\Components\Separator;
use Tinoecom\Core\Enum\DiscountApplyTo;
use Tinoecom\Core\Enum\DiscountEligibility;
use Tinoecom\Core\Enum\DiscountRequirement;
use Tinoecom\Core\Enum\DiscountType;
use Tinoecom\Core\Models\Discount;
use Tinoecom\Core\Models\Zone;
use Tinoecom\Core\Repositories\ProductRepository;
use Tinoecom\Core\Repositories\UserRepository;
use Tinoecom\Livewire\Components\SlideOverComponent;

/**
 * @property Forms\Form $form
 */
class DiscountForm extends SlideOverComponent implements HasForms
{
    use InteractsWithForms;

    public Discount $discount;

    public ?array $data = [];

    public function mount(?int $discountId = null): void
    {
        abort_unless($this->authorize('add_discounts') || $this->authorize('edit_discounts'), 403);

        $this->discount = $discountId
            ? Discount::query()->find($discountId)
            : new Discount;

        $products = collect();
        $customers = collect();

        if ($discountId) {
            if ($this->discount->items()->where('condition', 'eligibility')->exists()) {
                $customerConditions = $this->discount->items()
                    ->with('discountable')
                    ->where('condition', 'eligibility')
                    ->get();

                foreach ($customerConditions as $customerCondition) {
                    $customers->push($customerCondition->discountable);
                }
            }

            if ($this->discount->items()->where('condition', 'apply_to')->exists()) {
                $productConditions = $this->discount->items()
                    ->with('discountable')
                    ->where('condition', 'apply_to')
                    ->get();

                foreach ($productConditions as $productCondition) {
                    $products->push($productCondition->discountable);
                }
            }
        }

        $this->form->fill(array_merge(
            $this->discount->toArray(),
            ['customers' => $customers->pluck('id')->all()],
            ['products' => $products->pluck('id')->all()],
        ));
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Placeholder::make('general')
                            ->label(__('tinoecom::words.general')),

                        Forms\Components\Select::make('zone_id')
                            ->label(__('tinoecom::pages/settings/zones.single'))
                            ->relationship('zone', 'name')
                            ->native(false)
                            ->hint(__('tinoecom::forms.label.optional'))
                            ->live(),

                        Forms\Components\Radio::make('type')
                            ->label(__('tinoecom::forms.label.type'))
                            ->inline()
                            ->inlineLabel(false)
                            ->options(DiscountType::class)
                            ->required()
                            ->live(),

                        Forms\Components\Grid::make()
                            ->schema([
                                Forms\Components\TextInput::make('code')
                                    ->label(__('tinoecom::forms.label.code'))
                                    ->placeholder('CMRSUMMER900')
                                    ->helperText(__('tinoecom::pages/discounts.name_helptext'))
                                    ->hintAction(
                                        Forms\Components\Actions\Action::make(__('tinoecom::words.generate'))
                                            ->color('info')
                                            ->action(function (Forms\Set $set): void {
                                                $set('code', mb_substr(mb_strtoupper(uniqid(Str::random(10))), 0, 10));
                                            }),
                                    )
                                    ->unique(table: Discount::class, column: 'code', ignoreRecord: true)
                                    ->required(),

                                Forms\Components\TextInput::make('value')
                                    ->label(
                                        fn (Forms\Get $get): ?string => match ($get('type')) {
                                            DiscountType::Percentage->value => __('tinoecom::pages/discounts.percentage'),
                                            DiscountType::FixedAmount->value => __('tinoecom::pages/discounts.fixed_amount'),
                                            default => null
                                        }
                                    )
                                    ->suffix(
                                        fn (Forms\Get $get): ?string => match ($get('type')) {
                                            DiscountType::Percentage->value => '%',
                                            DiscountType::FixedAmount->value => $get('zone_id')
                                                ? Zone::query()->find($get('zone_id'))->currency_code
                                                : tinoecom_currency(),
                                            default => null
                                        }
                                    )
                                    ->numeric()
                                    ->required(),
                            ]),

                        Forms\Components\Toggle::make('is_active')
                            ->label(__('tinoecom::forms.label.visibility'))
                            ->helperText(__('tinoecom::words.set_visibility', ['name' => __('tinoecom::pages/discounts.single')])),
                    ]),

                Separator::make(),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Placeholder::make('configuration')
                            ->label(__('tinoecom::words.configuration'))
                            ->content(new HtmlString(Blade::render(<<<'Blade'
                                <p class="text-sm leading-6 text-gray-500 dark:text-gray-400">
                                    {{ __('tinoecom::pages/discounts.configuration_description') }}
                                </p>
                            Blade))),

                        Forms\Components\Toggle::make('usage_number')
                            ->label(__('tinoecom::pages/discounts.usage_label'))
                            ->helperText(__('tinoecom::pages/discounts.usage_label_description'))
                            ->live(),

                        Forms\Components\TextInput::make('usage_limit')
                            ->label(__('tinoecom::pages/discounts.usage_value'))
                            ->placeholder('10')
                            ->integer()
                            ->numeric()
                            ->required(fn (Forms\Get $get): bool => $get('usage_number'))
                            ->visible(
                                fn (Forms\Get $get): bool => $get('usage_number') || $this->discount->usage_limit !== null
                            ),

                        Forms\Components\Toggle::make('usage_limit_per_user')
                            ->label(__('tinoecom::pages/discounts.limit_one_per_user')),

                        Forms\Components\Placeholder::make('dates')
                            ->label(__('tinoecom::pages/discounts.active_dates'))
                            ->content(new HtmlString(Blade::render(<<<'Blade'
                                <p class="text-sm leading-6 text-gray-500 dark:text-gray-400">
                                    {{ __('tinoecom::pages/discounts.active_dates_description') }}
                                </p>
                            Blade))),

                        Forms\Components\Grid::make()
                            ->schema([
                                Forms\Components\DateTimePicker::make('start_at')
                                    ->label(__('tinoecom::pages/discounts.start_date'))
                                    ->required()
                                    ->minDate(now())
                                    ->native(false),

                                Forms\Components\DateTimePicker::make('end_at')
                                    ->label(__('tinoecom::pages/discounts.end_date'))
                                    ->afterOrEqual('start_at')
                                    ->native(false),
                            ]),
                    ]),

                Separator::make(),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Placeholder::make('conditions')
                            ->label(__('tinoecom::words.conditions'))
                            ->content(new HtmlString(Blade::render(<<<'Blade'
                                <p class="text-sm leading-6 text-gray-500 dark:text-gray-400">
                                    {{ __('tinoecom::pages/discounts.condition_description') }}
                                </p>
                            Blade))),

                        Forms\Components\Radio::make('apply_to')
                            ->label(__('tinoecom::pages/discounts.applies_to'))
                            ->options(DiscountApplyTo::class)
                            ->inline()
                            ->required()
                            ->live(),

                        Forms\Components\Select::make('products')
                            ->options(
                                (new ProductRepository)
                                    ->query()
                                    ->scopes('publish')
                                    ->get()
                                    ->pluck('name', 'id')
                            )
                            ->multiple()
                            ->preload()
                            ->searchable()
                            ->optionsLimit(10)
                            ->minItems(1)
                            ->required(
                                fn (Forms\Get $get): bool => $get('apply_to') === DiscountApplyTo::Products->value
                            )
                            ->visible(
                                fn (Forms\Get $get): bool => $get('apply_to') === DiscountApplyTo::Products->value
                            ),

                        Forms\Components\Radio::make('eligibility')
                            ->label(__('tinoecom::pages/discounts.customer_eligibility'))
                            ->inline()
                            ->options(DiscountEligibility::class)
                            ->required()
                            ->live(),

                        Forms\Components\Select::make('customers')
                            ->options(
                                (new UserRepository)
                                    ->query()
                                    ->scopes('customers')
                                    ->get()
                                    ->pluck('full_name', 'id')
                            )
                            ->multiple()
                            ->preload()
                            ->searchable()
                            ->optionsLimit(10)
                            ->minItems(1)
                            ->required(
                                fn (Forms\Get $get): bool => $get('eligibility') === DiscountEligibility::Customers->value
                            )
                            ->visible(
                                fn (Forms\Get $get): bool => $get('eligibility') === DiscountEligibility::Customers->value
                            ),

                        Forms\Components\Radio::make('min_required')
                            ->label(__('tinoecom::pages/discounts.min_requirement'))
                            ->inline()
                            ->inlineLabel(false)
                            ->options(DiscountRequirement::class)
                            ->required()
                            ->live(),

                        Forms\Components\TextInput::make('min_required_value')
                            ->hiddenLabel()
                            ->numeric()
                            ->suffix(
                                fn (Forms\Get $get): ?string => match ($get('min_required')) {
                                    DiscountRequirement::Price->value => $get('zone_id')
                                        ? Zone::query()->find($get('zone_id'))->currency_code
                                        : tinoecom_currency(),
                                    default => null
                                }
                            )
                            ->required(
                                fn (Forms\Get $get): bool => $get('min_required') !== DiscountRequirement::None->value
                            )
                            ->visible(function (Forms\Get $get): bool {
                                if ($get('min_required')) {
                                    return $get('min_required') !== DiscountRequirement::None->value;
                                }

                                return false;
                            }),
                    ]),

                Separator::make(),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\KeyValue::make('metadata')
                            ->reorderable(),
                    ]),
            ])
            ->statePath('data')
            ->model($this->discount);
    }

    public static function panelMaxWidth(): string
    {
        return '3xl';
    }

    public function store(): void
    {
        $data = $this->form->getState();
        $discountFormValues = Arr::except($data, ['products', 'customers', 'usage_number']);

        $this->discount = app()->call(SaveAndDispatchDiscountAction::class, [
            'values' => $discountFormValues,
            'discountId' => $this->discount->id ?? null,
            'productsIds' => data_get($data, 'products', []),
            'customersIds' => data_get($data, 'customers', []),
        ]);

        Notification::make()
            ->title(__('tinoecom::pages/discounts.save', ['code' => $this->discount->code]))
            ->success()
            ->send();

        $this->redirectRoute(
            name: 'tinoecom.discounts.index',
            navigate: true,
        );
    }

    public function render(): View
    {
        return view('tinoecom::livewire.slide-overs.discount-form');
    }
}
