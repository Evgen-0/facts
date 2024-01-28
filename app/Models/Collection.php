<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @mixin IdeHelperCollection
 */
class Collection extends Model
{
    use HasFactory, HasUuids;

    protected $with = ['user', 'stats'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function facts(): BelongsToMany
    {
        return $this->belongsToMany(Fact::class);
    }

    public function stats(): HasOne
    {
        return $this->hasOne(CollectionStat::class);
    }
}
