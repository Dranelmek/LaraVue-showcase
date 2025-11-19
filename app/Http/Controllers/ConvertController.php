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
        // uses yt-dlp and ffmpeg to convert it to mp3 or mp4 on the server

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
            // if a user is logged in use the DownloadTracker service
            // to save the download to the user's history

            $db = new DownloadTracker;
            $data = [
                'user_id' => $request->user()->id,
                'name' => $convertOutput['name'],
                'format' => $validatedData['format'],
                'quality' => $validatedData['quality'],
            ];
            $db->create($data);
        }

        // $convertOutput is an associative array that stores the file name 
        // for the front end and the text output of the conversion process 
        // for potential future logging
        return redirect()->back()->with('fileReady', $convertOutput);
    }
    
    public function update(Request $request) {
        // this function exists only to manually update the installation of yt-dlp
        // it is hard coded to only fire when db user 1 (me) sends a request from /update
        // there is 100% better execution for this but the feature is not needed for the showcase
        
        if (! $request->user()) {
            return Inertia::location(route('home'));
        }
        
        if ($request->user()->id === 1){
            $response = Converter::update();
            dd(shell_exec("which yt-dlp") . "\n" . $response);
            return Inertia::location(route('home'));
        }
        return Inertia::location(route('home'));
    }
}
