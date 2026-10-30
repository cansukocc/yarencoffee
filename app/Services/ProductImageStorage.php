<?php

namespace App\Services;

use GdImage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProductImageStorage
{
    private const DIRECTORY = 'uploads/products';

    private const MAX_WIDTH = 1400;

    private const QUALITY = 80;

    public function store(UploadedFile $file): string
    {
        $image = $this->resize(imagecreatefromstring($file->get()));
        $path = self::DIRECTORY.'/'.Str::random(40).'.webp';

        File::ensureDirectoryExists(public_path(self::DIRECTORY));
        imagewebp($image, public_path($path), self::QUALITY);

        return $path;
    }

    public function delete(string $path): void
    {
        if (Str::startsWith($path, 'uploads/') && ! Str::contains($path, '..')) {
            File::delete(public_path($path));
        }
    }

    private function resize(GdImage $image): GdImage
    {
        imagepalettetotruecolor($image);

        if (imagesx($image) > self::MAX_WIDTH) {
            $image = imagescale($image, self::MAX_WIDTH);
        }

        imagealphablending($image, false);
        imagesavealpha($image, true);

        return $image;
    }
}
