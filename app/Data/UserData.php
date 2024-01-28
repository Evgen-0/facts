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
class UserData extends Data
{
    public function __construct(
        #[Uuid]
        public string|Optional $id,
        #[Max(20)]
        #[Required]
        public string $name,
        #[Max(255)]
        #[Required]
        public string $email,
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
    ) {}

    public static function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:20', Rule::unique('users', 'name')
                ->ignore(request()->input('id'), 'id')],
            'email' => ['required', 'string', 'max:255', 'email', Rule::unique('users', 'email')
                ->ignore(request()->input('id'), 'id')],
            'slug' => ['required', 'string', 'max:128', Rule::unique('users', 'slug')
                ->ignore(request()->input('id'), 'id')],
        ];
    }

}
