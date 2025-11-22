<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ImageService
{
    // Upload and optimize image
    public function uploadAndOptimize($file, $directory = 'images', $maxWidth = 1920)
    {
        try {
            // Generate unique filename
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $directory . '/' . $filename;
            
            // Get image
            $image = Image::make($file);
            
            // Resize if too large
            if ($image->width() > $maxWidth) {
                $image->resize($maxWidth, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            }
            
            // Optimize quality
            $image->encode($file->getClientOriginalExtension(), 85);
            
            // Save to storage
            Storage::disk('public')->put($path, (string) $image);
            
            return $path;
            
        } catch (\Exception $e) {
            throw $e;
        }
    }

    // Create thumbnail
    public function createThumbnail($imagePath, $width = 300, $height = 300)
    {
        try {
            $image = Image::make(Storage::disk('public')->path($imagePath));
            
            // Resize to thumbnail
            $image->fit($width, $height);
            
            // Generate thumbnail path
            $pathInfo = pathinfo($imagePath);
            $thumbnailPath = $pathInfo['dirname'] . '/thumb_' . $pathInfo['basename'];
            
            // Save thumbnail
            Storage::disk('public')->put($thumbnailPath, (string) $image);
            
            return $thumbnailPath;
            
        } catch (\Exception $e) {
            throw $e;
        }
    }

    // Delete image
    public function deleteImage($imagePath)
    {
        if ($imagePath && Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
            
            // Also delete thumbnail if exists
            $pathInfo = pathinfo($imagePath);
            $thumbnailPath = $pathInfo['dirname'] . '/thumb_' . $pathInfo['basename'];
            
            if (Storage::disk('public')->exists($thumbnailPath)) {
                Storage::disk('public')->delete($thumbnailPath);
            }
            
            return true;
        }
        
        return false;
    }
}