<?php

namespace App\Scripts;
use App\Scripts\Utils;

class FFMPEG
{
    // Changed logic purely for Render.com to minmise ram usage
    // original code would work on a paid server!

    public static function convertToMP4($inputPath)
    // Smart solution for better performance on limited server

    {
        $inputPath = str_replace('\\', '/', $inputPath);

        if (!file_exists($inputPath)) {
            throw new \Exception("Input file does not exist: $inputPath");
        }

        $outputDir = storage_path('app/output');
        if (!is_dir($outputDir)) mkdir($outputDir, 0775, true);

        $baseName = Utils::getFileNameWithoutExtension($inputPath);
        $outputPath = str_replace('\\', '/', $outputDir . '/' . $baseName . '.mp4');

        //
        // 1. Probe the input file to detect codecs
        //
        $probeCmd = "ffprobe -v error -select_streams v:0 "
                . "-show_entries stream=codec_name "
                . "-of default=noprint_wrappers=1:nokey=1 "
                . escapeshellarg($inputPath) . " 2>&1";

        $videoCodec = trim(shell_exec($probeCmd));

        $probeCmdA = "ffprobe -v error -select_streams a:0 "
                . "-show_entries stream=codec_name "
                . "-of default=noprint_wrappers=1:nokey=1 "
                . escapeshellarg($inputPath) . " 2>&1";

        $audioCodec = trim(shell_exec($probeCmdA));

        //
        // 2. If already H.264 + AAC → no conversion, only remux
        //
        if ($videoCodec === "h264" && $audioCodec === "aac") {
            $cmd = "ffmpeg -y -i "
                . escapeshellarg($inputPath)
                . " -c copy "
                . escapeshellarg($outputPath)
                . " 2>&1";
            return $cmd;
        }

        //
        // 3. Otherwise → safe low-memory encode
        //
        $cmd = "ffmpeg -y -threads 1 "
            . "-i " . escapeshellarg($inputPath) . " "
            . "-max_muxing_queue_size 2048 "
            . "-c:v libx264 -preset ultrafast -tune fastdecode "
            . "-c:a aac -b:a 128k "
            . escapeshellarg($outputPath)
            . " 2>&1";

        return $cmd;
    }
}