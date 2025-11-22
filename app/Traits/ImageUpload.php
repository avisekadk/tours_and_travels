<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait ImageUpload
{
    // Upload single image
    public function uploadImage($file, $directory = 'images')
    {
        if (!$file) {
            return null;
        }

        // Generate unique filename
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        
        // Store file
        $path = $file->storeAs($directory, $filename, 'public');
        
        return $path;
    }

    // Upload multiple images
    public function uploadMultipleImages($files, $directory = 'images')
    {
        $paths = [];

        foreach ($files as $file) {
            $paths[] = $this->uploadImage($file, $directory);
        }

        return $paths;
    }

    // Delete image
    public function deleteImage($path)
    {
        if ($path && Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->delete($path);
        }

        return false;
    }

    // Delete multiple images
    public function deleteMultipleImages($paths)
    {
        foreach ($paths as $path) {
            $this->deleteImage($path);
        }

        return true;
    }
}