<?php

namespace App\Scripts;
use App\Scripts\Utils;

class FFMPEG
{
    public static function convertToMP4($inputPath)
{
    // Normalize slashes
    $inputPath = str_replace('\\', '/', $inputPath);

    // Ensure file exists
    if (!file_exists($inputPath)) {
        throw new \Exception("Input file does not exist: $inputPath");
    }

    // Determine output directory
    $outputDir = storage_path('app/output');
    if (!is_dir($outputDir)) {
        mkdir($outputDir, 0775, true);
    }

    // Build output filename
    $baseName = Utils::getFileNameWithoutExtension($inputPath);
    $outputPath = $outputDir . '/' . $baseName . '.mp4';

    // Normalize again
    $outputPath = str_replace('\\', '/', $outputPath);

    // Build ffmpeg command
    $cmd = "ffmpeg -y -i "
        . escapeshellarg($inputPath)
        . " -c:v libx264 -preset fast -c:a aac "
        . escapeshellarg($outputPath)
        . " 2>&1";

    return $cmd;
}

}