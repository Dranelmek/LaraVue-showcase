<?php

namespace App\Http\Controllers;

use App\Models\Download;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DownloadController extends Controller
{
    public function downloads(Request $request): \Inertia\Response
    {
        if (! $request->user()) {
            return Inertia::render('Home', [
            'userDownloads' => null,
        ]);
        }
        $uid = $request->user()->id;
        $downloads = Download::where('user_id', $uid)->latest()->get();
        return Inertia::render('Home', [
            'userDownloads' => $downloads,
        ]);
    }
    
    public function destroy(Request $request)
    {
        $downloadId = $request->id;
        $download = Download::find($downloadId);
        if (! $request->user()) {
            abort(403, 'You are not logged in.');
        } else if ($download->user_id !== $request->user()->id) {
            abort(403, 'You are not authorized to delete this post.');
        } else {
            $download->delete();
        }
        return Inertia::location(route('home'));
    }
}
