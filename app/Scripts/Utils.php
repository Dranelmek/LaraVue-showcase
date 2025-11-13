<?php

namespace App\Scripts;

class Utils
{
    public static function getFileNamesInDirectory($directory)
    {
        $files = [];
        if (is_dir($directory)) {
            if ($dh = opendir($directory)) {
                while (($file = readdir($dh)) !== false) {
                    if ($file !== '.' && $file !== '..') {
                        $files[] = $file;
                    }
                }
                closedir($dh);
            }
        }
        return $files;
    }

    public static function getFileNameWithoutExtension($filePath)
    {
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        return basename($filePath, '.' . $extension);
    }

    public static function cleanUpDirectory($directory)
    {
        if (is_dir($directory)) {
            $files = scandir($directory);
            foreach ($files as $file) {
                if ($file !== '.' && $file !== '..') {
                    unlink($directory . DIRECTORY_SEPARATOR . $file);
                }
            }
            return true;
        } else {
            return false;
        }
    }

    public static function cleanUpTempAndOutput()
    {
        self::cleanUpDirectory(storage_path('app/temp/'));
        self::cleanUpDirectory(storage_path('app/output/'));
        return "temp and output directories cleaned up.";
    }

    public static function compareDirectories($dir1, $dir2)
    {
        {
            if (!is_dir($dir1) || !is_dir($dir2)) {
                return false;
            }

            $collectBaseNames = function($dir) {
                $names = [];
                $files = scandir($dir);
                if ($files === false) {
                    return $names;
                }
                foreach ($files as $file) {
                    if ($file === '.' || $file === '..') {
                        continue;
                    }
                    $full = $dir . DIRECTORY_SEPARATOR . $file;
                    if (!is_file($full)) {
                        continue;
                    }
                    $names[] = self::getFileNameWithoutExtension($file);
                }
                return array_values(array_unique($names));
            };

            $names1 = $collectBaseNames($dir1);
            $names2 = $collectBaseNames($dir2);

            sort($names1);
            sort($names2);

            return $names1 === $names2;
        }
    }
}