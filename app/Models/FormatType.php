<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperFormatType
 */
class FormatType extends Model
{
    use HasFactory, HasUuids;

    public $timestamps = false;
}
