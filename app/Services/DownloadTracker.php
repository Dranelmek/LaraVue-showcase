<?php

namespace App\Services;

use App\Models\Download;

class DownloadTracker 
{
    public function create(array $validatedData)
    {
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