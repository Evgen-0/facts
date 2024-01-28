<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperCollectionStat
 */
class CollectionStat extends Model
{
    use HasFactory, HasUuids;

    public function collection(): BelongsTo
    {
        return $this->belongsTo(Collection::class);
    }
}
