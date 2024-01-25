<?php

namespace App\Models;

use App\Type\MediaType;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperFact
 */
class Fact extends Model
{
    use HasFactory, HasUuids;

    protected $with = ['user'];

    public $timestamps = false;

    protected $casts = [
        'media_type' => MediaType::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
