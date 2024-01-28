<?php

namespace App\Data;

use Illuminate\Validation\Rule;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\Uuid;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Spatie\LaravelData\Optional;

#[MapName(SnakeCaseMapper::class)]
class FactData extends Data
{
    public function __construct(
        #[Uuid]
        public string|Optional $id,
        #[Max(128)]
        public string $heading,
        #[Max(400)]
        #[Nullable]
        public ?string $body,
        #[Uuid]
        #[Required]
        public string $userId,
        #[Uuid]
        #[Nullable]
        public ?string $categoryId,
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
        public CategoryData|Optional $category,
    ) {
    }

    public static function rules(): array
    {
        return [
            'slug' => ['required', 'string', 'max:128', Rule::unique('facts', 'slug')
                ->ignore(request()->input('id'), 'id')],
        ];
    }
}
