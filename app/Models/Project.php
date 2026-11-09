<?php

namespace App\Models;

use App\Support\ImageUrl;
use Database\Factories\ProjectFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'name',
    'slug',
    'category',
    'summary',
    'description',
    'logo',
    'image',
    'url',
    'technologies',
    'is_published',
    'sort_order',
])]
class Project extends Model
{
    /** @use HasFactory<ProjectFactory> */
    use HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'technologies' => 'array',
            'is_published' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    /**
     * @param  Builder<Project>  $query
     */
    public function scopePublished(Builder $query): void
    {
        $query->where('is_published', true);
    }

    /**
     * @param  Builder<Project>  $query
     */
    public function scopeOrdered(Builder $query): void
    {
        $query->orderBy('sort_order')->orderBy('name');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * @return Attribute<string, never>
     */
    protected function logoUrl(): Attribute
    {
        return Attribute::get(fn (): string => ImageUrl::for($this->logo));
    }

    /**
     * @return Attribute<string, never>
     */
    protected function imageUrl(): Attribute
    {
        return Attribute::get(fn (): string => ImageUrl::for($this->image));
    }
}
