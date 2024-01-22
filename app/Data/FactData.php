<?php

namespace App\Data;

use App\Type\MediaType;
use Spatie\LaravelData\Optional;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Attributes\Validation\Enum;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\Uuid;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\EnumCast;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
class FactData extends Data
{
    public function __construct(
        #[Uuid]
        public ?string $id,
        #[Uuid]
        public string $formatTypeId,
        #[WithCast(EnumCast::class)]
        #[Enum(MediaType::class)]
        public MediaType $mediaType,
        #[Max(255)]
        #[Nullable]
        public ?string $media,
        #[Max(400)]
        #[Required]
        public string $body,
        #[Max(255)]
        #[Required]
        public string $slug,
        #[Max(255)]
        #[Required]
        public string $title,
        #[Max(255)]
        #[Nullable]
        public ?string $description,
        public FormatTypeData|Optional $formatType,
    ) {
    }
}
