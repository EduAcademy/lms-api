<?php
namespace App\Shared\Handler;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageUploads
{
    /**
     * Upload an image to a specific directory and return the URL.
     *
     * @param UploadedFile $image
     * @param string $directory
     * @return string|null
     */
    public static function uploadImage(UploadedFile $image, string $directory = 'students'): ?string
    {
        if ($image) {
            $path = $image->store($directory, 'public'); // Store in the 'public' disk under the specified directory
            return Storage::url($path); // Return the full URL of the stored image
        }
        return null;
    }
}
