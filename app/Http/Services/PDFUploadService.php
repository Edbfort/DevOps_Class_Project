<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PDFUploadService
{
    public function upload(Request $request)
    {
        $request->validate([
            'pdf' => 'required|file|mimes:pdf|max:5120'
        ]);

        $file = $request->file('pdf');

        $filePath = 'all-dokumen/' . $file->getClientOriginalName();

        Storage::disk('public')->put($filePath, file_get_contents($file));

        return $filePath;
    }
}
