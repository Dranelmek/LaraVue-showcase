<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Services\Converter;
use App\Services\DownloadTracker;
use Exception;

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
        
        try {
            $convertOutput = Converter::execute($validatedData);
        } catch (Exception $e) {
            return back()->withErrors([
                'conv' => 'Conversion failed: ' . $e->getMessage(),
            ]);
        }
        if ($request->user()) {
            $db = new DownloadTracker;
            $data = [
                'user_id' => $request->user()->id,
                'name' => $convertOutput['name'],
                'format' => $validatedData['format'],
                'quality' => $validatedData['quality'],
            ];
            $db->create($data);
        }
        // potentially store $convertOutput in logs
        return redirect()->back()->with('fileReady', $convertOutput);
    }
}
