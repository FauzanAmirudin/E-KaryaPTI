<?php

namespace App\Libraries;

use CodeIgniter\Files\File;

class FileUpload
{
    protected $uploadPath;
    protected $thumbnailPath;
    protected $allowedTypes;
    protected $maxSize;

    public function __construct()
    {
        $this->uploadPath = WRITEPATH . 'uploads/';
        $this->thumbnailPath = WRITEPATH . 'uploads/thumbnails/';
        
        $this->allowedTypes = [
            'image' => ['jpg', 'jpeg', 'png', 'gif', 'webp'],
            'video' => ['mp4', 'avi', 'mov', 'wmv'],
            'pdf' => ['pdf'],
            'archive' => ['zip', 'rar'],
        ];
        
        $this->maxSize = 10 * 1024 * 1024; // 10MB
        
        // Create directories if not exist
        if (!is_dir($this->uploadPath)) {
            mkdir($this->uploadPath, 0755, true);
        }
        if (!is_dir($this->thumbnailPath)) {
            mkdir($this->thumbnailPath, 0755, true);
        }
    }

    public function upload($file, $categoryId)
    {
        try {
            // Validate file
            $validation = $this->validateFile($file);
            if (!$validation['valid']) {
                return ['success' => false, 'message' => $validation['message']];
            }

            // Generate unique filename
            $extension = $file->getClientExtension();
            $filename = $this->generateUniqueFilename($extension);
            
            // Move file
            $file->move($this->uploadPath, $filename);
            
            $result = [
                'success' => true,
                'file_path' => $filename,
                'file_size' => $file->getSize(),
                'mime_type' => $file->getClientMimeType(),
                'thumbnail' => null,
            ];

            // Generate thumbnail if image
            if ($this->isImage($extension)) {
                $thumbnailName = $this->generateThumbnail($filename);
                $result['thumbnail'] = $thumbnailName;
            }

            return $result;

        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Gagal mengunggah file: ' . $e->getMessage()];
        }
    }

    protected function validateFile($file)
    {
        if (!$file->isValid()) {
            return ['valid' => false, 'message' => 'File tidak valid'];
        }

        if ($file->getSize() > $this->maxSize) {
            return ['valid' => false, 'message' => 'Ukuran file terlalu besar (maksimal 10MB)'];
        }

        $extension = strtolower($file->getClientExtension());
        $allowed = array_merge(...array_values($this->allowedTypes));
        
        if (!in_array($extension, $allowed)) {
            return ['valid' => false, 'message' => 'Tipe file tidak diizinkan'];
        }

        // Khusus untuk video, sangat disarankan menggunakan link
        if (in_array($extension, $this->allowedTypes['video']) && $file->getSize() > 5 * 1024 * 1024) {
            return ['valid' => false, 'message' => 'Ukuran file video terlalu besar. Untuk file video, disarankan menggunakan link eksternal (YouTube, Google Drive, dll)'];
        }

        return ['valid' => true];
    }

    protected function generateUniqueFilename($extension)
    {
        do {
            $filename = uniqid() . '_' . time() . '.' . $extension;
        } while (file_exists($this->uploadPath . $filename));
        
        return $filename;
    }

    protected function isImage($extension)
    {
        return in_array(strtolower($extension), $this->allowedTypes['image']);
    }

    protected function generateThumbnail($filename)
    {
        $sourcePath = $this->uploadPath . $filename;
        $thumbnailName = 'thumb_' . $filename;
        $thumbnailPath = $this->thumbnailPath . $thumbnailName;

        try {
            // Simple thumbnail generation using GD
            $imageInfo = getimagesize($sourcePath);
            $sourceWidth = $imageInfo[0];
            $sourceHeight = $imageInfo[1];
            $mimeType = $imageInfo['mime'];

            // Calculate thumbnail dimensions
            $thumbWidth = 400;
            $thumbHeight = 300;
            
            // Create source image
            switch ($mimeType) {
                case 'image/jpeg':
                    $sourceImage = imagecreatefromjpeg($sourcePath);
                    break;
                case 'image/png':
                    $sourceImage = imagecreatefrompng($sourcePath);
                    break;
                case 'image/gif':
                    $sourceImage = imagecreatefromgif($sourcePath);
                    break;
                default:
                    return null;
            }

            // Create thumbnail
            $thumbImage = imagecreatetruecolor($thumbWidth, $thumbHeight);
            
            // Preserve transparency for PNG and GIF
            if ($mimeType == 'image/png' || $mimeType == 'image/gif') {
                imagealphablending($thumbImage, false);
                imagesavealpha($thumbImage, true);
                $transparent = imagecolorallocatealpha($thumbImage, 255, 255, 255, 127);
                imagefilledrectangle($thumbImage, 0, 0, $thumbWidth, $thumbHeight, $transparent);
            }

            // Resize image
            imagecopyresampled($thumbImage, $sourceImage, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $sourceWidth, $sourceHeight);

            // Save thumbnail
            switch ($mimeType) {
                case 'image/jpeg':
                    imagejpeg($thumbImage, $thumbnailPath, 80);
                    break;
                case 'image/png':
                    imagepng($thumbImage, $thumbnailPath);
                    break;
                case 'image/gif':
                    imagegif($thumbImage, $thumbnailPath);
                    break;
            }

            // Clean up memory
            imagedestroy($sourceImage);
            imagedestroy($thumbImage);

            return $thumbnailName;
        } catch (\Exception $e) {
            return null;
        }
    }

    public function generateLinkThumbnail($url)
    {
        // For external links, we can use a service like screenshotapi or generate a placeholder
        // For now, we'll return null and handle it in the frontend
        return null;
    }

    public function deleteFile($filename, $thumbnail = null)
    {
        try {
            $filePath = $this->uploadPath . $filename;
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            if ($thumbnail) {
                $thumbnailPath = $this->thumbnailPath . $thumbnail;
                if (file_exists($thumbnailPath)) {
                    unlink($thumbnailPath);
                }
            }

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}