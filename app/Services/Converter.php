<?php

namespace App\Services;

use App\Scripts\YTDLP;
use App\Scripts\FFMPEG;
use App\Scripts\Utils;
use Exception;

class Converter
{
    // This service contains the logic to convert YouTube videos using yt-dlp and ffmpeg
    
    public static function execute($data) {
        $url = $data['url'];
        $format = $data['format'];
        $quality = $data['quality'] ?? null;

        if ($format !== 'mp3' && $format !== 'mp4') {
            throw new Exception("Unsupported format: " . $format);
        }

        // clean up the internal storage
        $preCleanUp = Utils::cleanUpTempAndOutput();

        $script = '';

        if ($format === 'mp3') {
            $script = YTDLP::mp3Download($url);
            $MP3output = shell_exec($script);
            $output = $preCleanUp . "\n\n" . $MP3output;
            $files = Utils::getFileNamesInDirectory(storage_path('app/output/'));
            $filename = end($files);
            $response = ['name' => Utils::getFileNameWithoutExtension($filename), 'txtOut' => $output];
            return $response;
        } elseif ($format === 'mp4') {
            if ($quality) {
                $script = YTDLP::mp4Download($url, $quality);
            } else {
                $script = YTDLP::mp4Download($url);
            }
            if (strlen($script) === 0) {
                throw new Exception("No valid script generated for the given format.");
            }

            $ytdlpOutput = shell_exec($script);
            $files = Utils::getFileNamesInDirectory(storage_path('app/temp/'));
            $filename = end($files);
            $filePath = storage_path('app/temp/' . $filename);

            if (!file_exists($filePath)) {
                throw new Exception("Downloaded file not found: " . $filePath);
            }

            $script = FFMPEG::convertToMP4($filePath);
            $ffmpegOutput = shell_exec($script);
            // TODO: Handle FFmpeg processing file upload and cleanup
            $output = $preCleanUp . "\n\n" . $ytdlpOutput . "\n\nFFMPEG OUT:\n\n" . $ffmpegOutput;

            if (Utils::compareDirectories(storage_path('app/temp/'), storage_path('app/output/'))) {
                $postCleanUp = Utils::cleanUpDirectory(storage_path('app/temp/'));
                if ($postCleanUp) {
                    $output .= "\n\nTemporary files cleaned up.";
                } else {
                    $output .= "\n\nFailed to clean up temporary files.";
                }
            }
            $response = ['name' => Utils::getFileNameWithoutExtension($filename), 'txtOut' => $output];
            return $response;
        }

        // if the if-else block falls through something went wrong
        // this line "should" never be reached
        throw new Exception("Conversion failed for unknown reasons.");
    }

    public static function update()
    {
        // update the installation of yt-dlp

        $script = YTDLP::update();
        $update = shell_exec($script);
        $output = "DONE!\n" . $update;
        return $output;
    }
}