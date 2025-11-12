<?php

namespace App\Services;

class Converter
{
    // This service would contain the logic to convert YouTube videos using yt-dlp and ffmpeg
    // lets do some tests first
    public static function debug_to_console($data) {
        $output = $data;
        if (is_array($output))
            $output = implode(',', $output);

        echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
    }
}

// Todo: Implement actual conversion logic using yt-dlp and ffmpeg