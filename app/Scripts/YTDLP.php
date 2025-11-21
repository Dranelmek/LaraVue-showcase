<?php

namespace App\Scripts;

class YTDLP
{
    // contains methods that return execution strings for yt-dlp commands

    public static function update()
    {
	    // simple update command
        return "yt-dlp -U 2>&1";
    }

    public static function mp3Download($url)
    {
        $cookiesFile = storage_path('cookies/cookies.txt.gz');
        $out = storage_path("app/output/%(title)s.%(ext)s");

        return 'yt-dlp --cookies ' . $cookiesFile . ' --extractor-args "youtube:player_client=android" -x --audio-format mp3 -o ' .
            escapeshellarg($out) . " " .
            escapeshellarg($url) .
            " 2>&1";
    }

    public static function mp4Download($url, $quality = null)
    {
        $cookiesFile = storage_path('cookies/cookies.txt.gz');
        $out = storage_path("app/temp/%(title)s.%(ext)s");

        $cmd = 'yt-dlp --cookies ' . $cookiesFile . ' --extractor-args "youtube:player_client=android" ';

        if ($quality) {
            $height = rtrim($quality, "p");
            $cmd .= "-f " . escapeshellarg("bv*[height<={$height}]+ba/b") . " ";
        }

        $cmd .= "-o " . escapeshellarg($out) . " " . escapeshellarg($url) . " 2>&1";

        return $cmd;
    }
}
