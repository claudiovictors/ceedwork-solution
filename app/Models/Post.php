<?php

namespace App\Models;

use App\Enums\PostStatus;
use App\Support\ImageUrl;
use Database\Factories\PostFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'category_id',
    'author_id',
    'title',
    'slug',
    'excerpt',
    'body',
    'cover_image',
    'status',
    'is_featured',
    'published_at',
])]
class Post extends Model
{
    /** @use HasFactory<PostFactory> */
    use HasFactory, SoftDeletes;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => PostStatus::class,
            'is_featured' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    /**
     * @return BelongsTo<Category, $this>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * @param  Builder<Post>  $query
     */
    public function scopePublished(Builder $query): void
    {
        $query
            ->where('status', PostStatus::Published->value)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    /**
     * @param  Builder<Post>  $query
     */
    public function scopeFeatured(Builder $query): void
    {
        $query->where('is_featured', true);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * @return Attribute<string, never>
     */
    protected function coverUrl(): Attribute
    {
        return Attribute::get(fn (): string => ImageUrl::for($this->cover_image));
    }
}
