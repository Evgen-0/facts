<?php

namespace App\Models;

use App\Type\MediaType;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperMediaFile
 */
class MediaFile extends Model
{
    use HasFactory, HasUuids;

    protected $with = ['fact'];

    protected $casts = [
        'type' => MediaType::class,
    ];

    public function fact(): BelongsTo
    {
        return $this->belongsTo(Fact::class);
    }
}
