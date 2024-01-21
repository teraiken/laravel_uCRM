<?php

namespace App\Models;

use App\Models\Scopes\Subtotal;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * @return void
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new Subtotal);
    }
}
