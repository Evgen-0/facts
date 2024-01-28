<?php

namespace App\Data;

use Illuminate\Support\Optional;
use Illuminate\Validation\Rule;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\Uuid;
use Spatie\LaravelData\Data;

class TagData extends Data
{
    public function __construct(
        #[Uuid]
        public string|Optional $id,
        #[Max(256)]
        #[Required]
        public string $name,
        #[Max(128)]
        #[Nullable]
        public ?string $image,
        #[Max(128)]
        #[Required]
        public string $slug,
        #[Max(128)]
        #[Required]
        public string $title,
        #[Max(255)]
        #[Nullable]
        public ?string $description,
    ) {
    }

    public static function rules(): array
    {
        return [
            'slug' => ['required', 'string', 'max:128', Rule::unique('tags', 'slug')
                ->ignore(request()->input('id'), 'id')],
        ];
    }
}
