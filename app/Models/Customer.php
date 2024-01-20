<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'kana',
        'tel',
        'email',
        'postcode',
        'address',
        'birthday',
        'gender',
        'memo',
    ];

    /**
     * @param Builder $query
     * @param string|null $input
     * @return Builder
     */
    public function scopeCustomers(Builder $query, ?string $input = null): Builder
    {
        return $query->when($input, fn(Builder $q)
            => $q->when(Customer::where('kana', 'like', $input . '%')->orWhere('tel', 'like', $input . '%')->exists(), fn(Builder $q)
            => $q->where('kana', 'like', $input . '%')->orWhere('tel', 'like', $input . '%')));
    }

    /**
     * @return HasMany
     */
    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class);
    }
}
