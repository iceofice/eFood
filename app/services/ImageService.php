<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;

class ImageService
{
    //TODO: Bloc
    public function prepareImage(UploadedFile $image = null)
    {
        if ($image) {
            $image->store('public/images');
            return $image->hashName();
        }
    }
}
