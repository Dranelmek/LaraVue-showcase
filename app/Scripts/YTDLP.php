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
        $cookiesFile = storage_path('cookies/cookies.txt');

        $tempPath  = storage_path("app/temp");
        $finalPath = storage_path("app/output");

        // yt-dlp writes final file using home=...
        // fragments and .ytdl temp go into temp=...
        $outFormat = "%(title)s.%(ext)s";

        return 'yt-dlp '
            . '--cookies ' . escapeshellarg($cookiesFile) . ' '
            . '--restrict-filenames '
            . '--extractor-args "youtube:player_client=android" '
            . '--paths temp=' . escapeshellarg($tempPath) . ' '
            . '--paths home=' . escapeshellarg($finalPath) . ' '
            . '-x --audio-format mp3 '
            . '-o ' . escapeshellarg($outFormat) . ' '
            . escapeshellarg($url)
            . " 2>&1";
    }


    public static function mp4Download($url, $quality = null)
    {
        $cookiesFile = storage_path('cookies/cookies.txt');

        $tempPath  = storage_path("app/temp");   // final MP4 lives here
        $workPath  = storage_path("app/temp");   // also used as temp workspace

        $outFormat = "%(title)s.%(ext)s";

        $cmd = 'yt-dlp '
            . '--cookies ' . escapeshellarg($cookiesFile) . ' '
            . '--restrict-filenames '
            . '--extractor-args "youtube:player_client=android" '
            . '--paths temp=' . escapeshellarg($workPath) . ' '
            . '--paths home=' . escapeshellarg($tempPath) . ' ';

        if ($quality) {
            $height = rtrim($quality, "p");
            $cmd .= "-f " . escapeshellarg("bv*[height<={$height}]+ba/b") . " ";
        }

        $cmd .= '-o ' . escapeshellarg($outFormat) . ' '
            . escapeshellarg($url)
            . " 2>&1";

        return $cmd;
    }

}
