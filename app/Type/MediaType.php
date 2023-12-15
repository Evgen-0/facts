<?php

namespace App\Type;

use App\Trait\EnumerableMethods;

enum MediaType: string
{
    use EnumerableMethods;

    case photo = 'Photo';

    case gif = 'Gif';

    case video = 'Video';

    case text = 'Text';
}
