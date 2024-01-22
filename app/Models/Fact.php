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

    protected $with = ['formatType'];

    public $timestamps = false;

    protected $casts = [
        'media_type' => MediaType::class,
    ];

    public function formatType(): BelongsTo
    {
        return $this->belongsTo(FormatType::class);
    }
}
