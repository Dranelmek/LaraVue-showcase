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
        // prepares and shares the file converted on the server
        // this logic might need a fundamental overhaul if this
        // project is developed into a real service as the current
        // system assumes only one user cenverts at any given point
        // the application is built to not break if multiple users
        // try using it, but the users will get 40X errors as the 
        // system clears out it's temporary storage before starting
        // any process

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
        // clear serverside storage when user is done downloading

        Utils::cleanUpDirectory(storage_path('app/output/'));
        return redirect()->back()->with('fileReady', null);
    }
}
