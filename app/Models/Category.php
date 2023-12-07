<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperCategory
 */
class Category extends Model
{
    use HasFactory, HasUuids;

    protected $with = ['parent'];

    public $timestamps = false;

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
