<?php

namespace App\Data;

use Illuminate\Validation\Rule;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\Uuid;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class CollectionData extends Data
{
    public function __construct(
        #[Uuid]
        public string|Optional $id,
        #[Uuid]
        #[Required]
        public string $userId,
        #[Max(128)]
        #[Required]
        public string $name,
        #[Max(128)]
        #[Required]
        public string $slug,
        #[Max(128)]
        #[Required]
        public string $title,
        #[Max(255)]
        #[Nullable]
        public ?string $description,
        public UserData|Optional $user,
    ) {
    }

    public static function rules(): array
    {
        return [
            'slug' => ['required', 'string', 'max:128', Rule::unique('collections', 'slug')
                ->ignore(request()->input('id'), 'id')],
        ];
    }
}
