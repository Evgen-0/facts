<?php

namespace App\Data;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Uuid;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Spatie\LaravelData\Optional;

#[MapName(SnakeCaseMapper::class)]
class CommentData extends Data
{
    public function __construct(
        #[Uuid]
        public string|Optional $id,
        #[Uuid]
        public string $userId,
        #[Max(256)]
        public string $body,
        #[Uuid]
        #[Nullable]
        public ?string $parentId,
        public UserData|Optional $user,
        public CommentData|Optional|null $parent,
    ) {
    }
}
