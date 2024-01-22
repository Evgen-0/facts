<?php

namespace App\Data;

use Illuminate\Validation\Rule;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Attributes\Validation\Max;
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
        public string $name,
        #[Max(255)]
        public string $email,
        #[Max(128)]
        public ?string $photo,
    ) {}

    public static function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:20', Rule::unique('users', 'name')
                ->ignore(request()->input('id'), 'id')],
            'email' => ['required', 'string', 'max:255', 'email', Rule::unique('users', 'email')
                ->ignore(request()->input('id'), 'id')],
        ];
    }

}
