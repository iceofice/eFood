<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;

class ImageService
{
    /**
     * Store image into the storage.
     *
     * @param UploadedFile|null $image
     * @return string|null Image path
     */
    public function prepareImage(UploadedFile $image = null)
    {
        if ($image) {
            $image->store('public/images');
            return $image->hashName();
        }
    }
}
