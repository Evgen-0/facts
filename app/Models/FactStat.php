<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FactStat extends Model
{
    use HasFactory, HasUuids;

    protected $with = ['fact'];

    public function fact(): BelongsTo
    {
        return $this->belongsTo(Fact::class);
    }
}
