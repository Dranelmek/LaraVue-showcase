<?php

namespace App\Scripts;
use App\Scripts\Utils;

class FFMPEG
{
    public static function convertToMP4($inputPath)
    {
        // returns an FFmpeg command to convert any video format to MP4

        $inputPath = str_replace('\\', '/', $inputPath);
        $outputPath = Utils::getFileNameWithoutExtension($inputPath).'.mp4';
        $outputPath = str_replace('\\', '/', storage_path('app/output/' . $outputPath));
        $output = "ffmpeg -i " . escapeshellarg($inputPath) . " -c:v libx264 -c:a aac " . escapeshellarg($outputPath) . " 2>&1";
        return $output;
    }
}