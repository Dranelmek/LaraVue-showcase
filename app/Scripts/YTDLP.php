<?php

namespace App\Scripts;

class YTDLP
{
    // contains methods that return execution strings for yt-dlp commands
    
    public static function update()
    {
        // simple update command
        $output = "yt-dlp -U 2>&1";
        return $output;
    }

    public static function mp3Download($url)
    {
        $output = "yt-dlp -x --audio-format mp3 -o " . storage_path('app/output/%(title)s.%(ext)s') . " " . escapeshellarg($url) . " 2>&1";
        return $output;
    }

    public static function mp4Download($url, $quality = null)
    {
        $outPath = str_replace('\\', '/', storage_path('app/temp/%(title)s.%(ext)s'));
        $qualityOption = "yt-dlp -f \"bv*[height<=" . rtrim($quality, 'p') . "]+ba/b\" -o " . $outPath . " " . escapeshellarg($url) . " 2>&1";
        $noQualityOption = "yt-dlp -o " . $outPath . " " . escapeshellarg($url) . " 2>&1";
        return $quality ? $qualityOption : $noQualityOption;
    }
}