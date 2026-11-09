<?php

namespace App\Models;

use App\Support\ImageUrl;
use Database\Factories\ServiceFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['title', 'slug', 'icon', 'summary', 'image', 'is_active', 'sort_order'])]
class Service extends Model
{
    /** @use HasFactory<ServiceFactory> */
    use HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    /**
     * @return HasMany<ServiceItem, $this>
     */
    public function items(): HasMany
    {
        return $this->hasMany(ServiceItem::class)->orderBy('sort_order');
    }

    /**
     * @param  Builder<Service>  $query
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }

    /**
     * @param  Builder<Service>  $query
     */
    public function scopeOrdered(Builder $query): void
    {
        $query->orderBy('sort_order')->orderBy('title');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * @return Attribute<string, never>
     */
    protected function imageUrl(): Attribute
    {
        return Attribute::get(fn (): string => ImageUrl::for($this->image));
    }
}
