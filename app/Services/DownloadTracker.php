<?php

namespace App\Services;

use App\Models\Download;

class DownloadTracker 
{
    public function create(array $validatedData)
    {
        // this might be bad practice but making this a "Service" instead
        // of a Controller was a shortcut fix to not need to construct an
        // InertiaHTTPResponse but rather just accespt an object
        
        Download::updateOrCreate(
            [
            'user_id' => $validatedData['user_id'],
            'name' => $validatedData['name'],
            'format' => $validatedData['format'],
            'quality' => $validatedData['quality'],
            ],
            []
        );
        return;
    }
}