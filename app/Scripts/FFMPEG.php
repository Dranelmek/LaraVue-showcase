<?php

namespace App\Scripts;
use App\Scripts\Utils;

class FFMPEG
{
    public static function convertToMP4($inputPath)
    {
        // Changed logic purely for Render.com to minmise ram usage
        // original code would work on a paid server!
        
        $inputPath = str_replace('\\', '/', $inputPath);

        if (!file_exists($inputPath)) {
            throw new \Exception("Input file does not exist: $inputPath");
        }

        $outputDir = storage_path('app/output');
        if (!is_dir($outputDir)) {
            mkdir($outputDir, 0775, true);
        }

        $baseName = Utils::getFileNameWithoutExtension($inputPath);
        $outputPath = str_replace('\\', '/', $outputDir . '/' . $baseName . '.mp4');

        // Low-memory FFmpeg command
        $cmd = "ffmpeg -y "
            . "-threads 1 "
            . "-fflags +low_delay "
            . "-rtbufsize 8M "
            . "-buffer_size 8M "
            . "-max_muxing_queue_size 2048 "
            . "-i " . escapeshellarg($inputPath) . " "
            . "-c:v libx264 -preset ultrafast -tune fastdecode "
            . "-c:a aac -b:a 128k "
            . escapeshellarg($outputPath)
            . " 2>&1";

        return $cmd;
    }
}