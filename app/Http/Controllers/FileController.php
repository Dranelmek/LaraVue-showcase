<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use App\Scripts\Utils;

class FileController extends Controller
{
    public function download(Request $request): BinaryFileResponse
    {
        $filename = $request->query('name');
        if (!$filename) {
            abort(400, 'Filename parameter is required.');
        }

        $fullFilename = $filename . '.mp4';
        if (file_exists(storage_path('app/output/' . $filename . '.mp4'))) {
            $fullFilename = $filename . '.mp4';
        } elseif (file_exists(storage_path('app/output/' . $filename . '.mp3'))) {
            $fullFilename = $filename . '.mp3';
        } else {
            abort(404, 'File not found.');
        }

        $filePath = storage_path('app/output/' . $fullFilename);

        if (!file_exists($filePath)) {
            abort(404, 'File not found.');
        }

        return response()->download($filePath);
    }

    public function delete(Request $request)
    {
        Utils::cleanUpDirectory(storage_path('app/output/'));
        return redirect()->back()->with('fileReady', null);
    }
}
