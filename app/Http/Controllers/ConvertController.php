<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Converter;

class ConvertController extends Controller
{
    public function convert(Request $request)
    {
        // gets a youtube link and some settings and applies a service that 
        // uses yt-dlp and ffmpeg to convert it to mp3 or mp4 and returns the 
        // file for download
        $validatedData = $request->validate([
            'url' => 'required|url',
            'format' => 'required|in:mp3,mp4',
            'quality' => 'nullable|in:1080p,720p,480p,360p,144p',
        ]);
        Converter::debug_to_console($validatedData);
        // Conversion logic would go here
    }

}
