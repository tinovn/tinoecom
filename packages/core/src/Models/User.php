<?php

declare(strict_types=1);

namespace Tinoecom\Core\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tinoecom\Core\Database\Factories\UserFactory;
use Tinoecom\Core\Models\Traits\HasDiscounts;
use Tinoecom\Core\Models\Traits\HasProfilePhoto;
use Tinoecom\Traits\TwoFactorAuthenticatable;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property-read int $id
 * @property-read string $full_name
 * @property-read string $picture
 * @property string | null $first_name
 * @property string $last_name
 * @property string $email
 * @property string $avatar_type
 * @property string | null $avatar_location
 * @property string | null $phone_number
 * @property Carbon | null $email_verified_at
 * @property Carbon | null $birth_date
 * @property string | null $two_factor_recovery_codes
 * @property string | null $two_factor_secret
 * @property-read \Illuminate\Support\Collection | Order[] $orders
 */
class User extends Authenticatable
{
    use HasDiscounts;
    use HasFactory;
    use HasProfilePhoto;
    use HasRoles;
    use Notifiable;
    use TwoFactorAuthenticatable;

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
        'last_login_at',
        'last_login_ip',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'birth_date' => 'datetime',
    ];

    protected $appends = [
        'full_name',
        'picture',
        'roles_label',
        'birth_date_formatted',
    ];

    public static function boot(): void
    {
        parent::boot();

        self::deleting(function ($model): void {
            $model->roles()->detach();
            $model->addresses()->delete();
        });
    }

    protected static function newFactory(): UserFactory
    {
        return UserFactory::new();
    }

    public function isAdmin(): bool
    {
        return $this->hasRole(config('tinoecom.core.users.admin_role'));
    }

    public function isManager(): bool
    {
        return $this->hasRole(config('tinoecom.core.users.manager_role'));
    }

    public function isVerified(): bool
    {
        return $this->email_verified_at !== null;
    }

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn (): string => $this->first_name
                ? $this->first_name . ' ' . $this->last_name
                : $this->last_name
        );
    }

    protected function birthDateFormatted(): Attribute
    {
        return Attribute::make(
            get: fn (): string => $this->birth_date
                ? $this->birth_date->isoFormat('%d, %B %Y')
                : __('tinoecom::words.not_defined')
        );
    }

    protected function rolesLabel(): Attribute
    {
        $roles = $this->roles()->pluck('display_name')->toArray();

        return Attribute::make(
            get: fn (): string => count($roles)
                ? implode(', ', array_map(fn ($item) => ucwords($item), $roles))
                : 'N/A'
        );
    }

    /**
     * @param  Builder<User>  $query
     * @return Builder<User>
     */
    public function scopeCustomers(Builder $query): Builder
    {
        return $query->whereHas('roles', function (Builder $query): void {
            $query->where('name', config('tinoecom.core.users.default_role'));
        });
    }

    /**
     * @param  Builder<User>  $query
     * @return Builder<User>
     */
    public function scopeAdministrators(Builder $query): Builder
    {
        return $query->whereHas('roles', function (Builder $query): void {
            $query->whereIn('name', [
                config('tinoecom.core.users.admin_role'),
                config('tinoecom.core.users.manager_role'),
            ]);
        });
    }

    /**
     * @return HasMany<Address, $this>
     */
    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    /**
     * @return HasMany<Order, $this>
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'customer_id');
    }
}
