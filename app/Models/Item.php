<?php

namespace App\Models;

use App\Enums\ItemStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Item extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'memo',
        'price',
        'is_selling',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_selling' => ItemStatus::class,
    ];

    /**
     * @return BelongsToMany
     */
    public function purchases(): BelongsToMany
    {
        return $this->belongsToMany(Purchase::class)->withPivot('quantity');
    }

    /**
     * @param Builder $builder
     * @param ItemStatus|null $status
     * @return Builder
     */
    public function scopeIsSelling(Builder $builder, ?ItemStatus $status): Builder
    {
        return $builder->when($status, fn (Builder $q) => $q->where('is_selling', $status->value));
    }
}
