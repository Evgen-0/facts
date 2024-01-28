<?php

namespace App\Data;

use Illuminate\Validation\Rule;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Attributes\Validation\Json;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\Uuid;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Spatie\LaravelData\Optional;

#[MapName(SnakeCaseMapper::class)]
class CategoryData extends Data
{
    public function __construct(
        #[Uuid]
        public string|Optional $id,
        #[Max(128)]
        #[Required]
        public string $name,
        #[Nullable]
        #[Json]
        public ?string $aliases,
        #[Max(128)]
        #[Nullable]
        public ?string $photo,
        #[Max(128)]
        #[Required]
        public string $slug,
        #[Max(128)]
        #[Required]
        public string $title,
        #[Max(255)]
        #[Nullable]
        public ?string $description,
        #[Uuid]
        #[Nullable]
        public ?string $parentId,
        public CategoryData|Optional|null $parent,
    ) {
    }

    public static function rules(): array
    {
        return [
            'slug' => ['required', 'string', 'max:128', Rule::unique('categories', 'slug')
                ->ignore(request()->input('id'), 'id')],
        ];
    }
}
