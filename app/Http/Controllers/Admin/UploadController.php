<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UploadController extends Controller
{
    /**
     * Handle image upload from Jodit WYSIWYG Editor
     */
    public function image(Request $request)
    {
        // Jodit sends files as an array under 'files' key, e.g. files[0], files[1], etc.
        // It can also just send single file via 'files[0]'
        if ($request->hasFile('files')) {
            $files = $request->file('files');
            
            // Handle array of files or single file
            if (!is_array($files)) {
                $files = [$files];
            }
            
            $messages = [];
            $baseurl = url('/');
            $uploadedFiles = [];
            
            foreach ($files as $file) {
                // Ensure it's an image
                if (substr($file->getMimeType(), 0, 5) != 'image') {
                    return response()->json([
                        'success' => false,
                        'message' => 'Hanya file gambar yang diperbolehkan.'
                    ]);
                }
                
                $extension = $file->getClientOriginalExtension();
                $filename = Str::random(20) . '-' . time() . '.' . $extension;
                $path = $file->storeAs('public/uploads/editor', $filename);
                
                // Add to uploaded array - Jodit expects relative paths from baseurl
                $url = Storage::url($path);
                $uploadedFiles[] = $url;
            }
            
            return response()->json([
                'success' => true,
                'time' => date('Y-m-d H:i:s'),
                'data' => [
                    'baseurl' => $baseurl,
                    'messages' => [],
                    'files' => $uploadedFiles,
                    'isImages' => array_fill(0, count($uploadedFiles), true),
                    'code' => 220
                ]
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Tidak ada file yang diunggah.'
        ]);
    }
}
