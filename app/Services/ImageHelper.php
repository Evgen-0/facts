<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Process;
use Intervention\Image\Interfaces\ImageInterface;
use Intervention\Image\Laravel\Facades\Image;
use Intervention\Image\Typography\FontFactory;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ImageHelper
{
    /**
     * @throws Exception
     */
    public static function createImage($state, $path): void
    {
        if (!self::validateState($state)) {
            return;
        }

        $realImage = self::getRealImage($state);

        if (!$realImage) {
            return;
        }

        $image = Image::read($realImage->path());
        list($x, $y) = self::determinePosition($image, $state['position']);

        if ($state['content']) {
            self::applyTextToImage($image, $state, $x, $y);
            self::saveImage($image, $path);
            Process::run('chmod 777 ' . storage_path('app/public/image/temp/' . $path));
            if (!self::ensureImageSaved(storage_path('app/public/image/temp/' . $path))) {
                throw new Exception("Зображення не було збережено вчасно.");
            }
            Process::run('cp ' . storage_path('app/public/image/temp/' . $path) . ' ' . storage_path('app/livewire-tmp/' . $path));
        }
    }

    protected static function validateState($state): bool
    {
        return !empty($state['body']) && is_array($state['body']) && count($state['body']) > 0;
    }

    protected static function getRealImage($state): ?TemporaryUploadedFile
    {
        $realImage = $state['body'][array_key_first($state['body'])];

        if ($realImage instanceof TemporaryUploadedFile && $realImage->exists()) {
            return $realImage;
        }

        return null;
    }

    protected static function determinePosition($image, $position): array
    {
        $x = $image->width() / 2;
        $y = $position === 'top' ? $image->height() * 0.25 : $image->height() * 0.75;

        return [$x, $y];
    }

    protected static function applyTextToImage($image, $state, $x, $y): void
    {
        $hslColor = $state['hsl_color'];
        $size = $state['fontSize'];
        $fontType = $state['font'];

        $image->text($state['content'], $x, $y, function (FontFactory $font) use ($fontType, $image, $hslColor, $size) {
            self::configureFont($font, $fontType, $image, $hslColor, $size);
        });
    }

    protected static function configureFont(FontFactory $font, $fontType, $image, $hslColor, $size): void
    {
        $font->filename(public_path($fontType));
        $font->size($size);
        $font->color($hslColor);
        $font->align('center');
        $font->valign('middle');
        $font->wrap($image->width() * 0.8);
    }

    protected static function saveImage(ImageInterface $image, $path): void
    {
        $fullPath = storage_path('app/public/image/temp/' . $path);
        $image->toPng()->save($fullPath);
    }

    protected static function ensureImageSaved($path, $maxAttempts = 10, $interval = 100): bool
    {
        $attempt = 0;
        while (!file_exists($path) && filesize($path) > 0 && $attempt < $maxAttempts) {
            usleep($interval * 1000); // Пауза в мікросекундах
            $attempt++;
        }

        return file_exists($path);
    }
}
