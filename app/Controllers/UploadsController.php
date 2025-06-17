<?php

namespace App\Controllers;

use CodeIgniter\Files\File;
use CodeIgniter\HTTP\ResponseInterface;

class UploadsController extends BaseController
{
    /**
     * Serve a file from uploads directory
     * 
     * @param string $path File path
     * @return ResponseInterface
     */
    public function serveFile($path)
    {
        $filePath = WRITEPATH . 'uploads/' . $path;
        
        // Logging for debugging
        $logPath = WRITEPATH . 'logs/file_access.log';
        $debug = date('Y-m-d H:i:s') . " - Request for file: " . $path . "\n";
        $debug .= "Full path: " . $filePath . "\n";
        $debug .= "File exists: " . (file_exists($filePath) ? 'Yes' : 'No') . "\n";
        file_put_contents($logPath, $debug, FILE_APPEND);
        
        if (!file_exists($filePath) || is_dir($filePath)) {
            file_put_contents($logPath, "File not found or is directory\n\n", FILE_APPEND);
            return $this->response->setStatusCode(404, 'File not found');
        }

        $file = new File($filePath);
        
        // Set caching headers
        $response = $this->response
            ->setHeader('Content-Type', $file->getMimeType())
            ->setHeader('Content-Disposition', 'inline; filename="' . $file->getBasename() . '"')
            ->setHeader('Content-Length', $file->getSize())
            ->setHeader('Cache-Control', 'public, max-age=86400')
            ->setHeader('Expires', date('D, d M Y H:i:s', time() + 86400) . ' GMT')
            ->setBody(file_get_contents($filePath));

        file_put_contents($logPath, "File served successfully with mime type: " . $file->getMimeType() . "\n\n", FILE_APPEND);
        return $response;
    }

    /**
     * Serve a thumbnail
     * 
     * @param string $filename Thumbnail filename
     * @return ResponseInterface
     */
    public function serveThumbnail($filename)
    {
        $thumbnailPath = WRITEPATH . 'uploads/thumbnails/' . $filename;
        
        // Logging for debugging
        $logPath = WRITEPATH . 'logs/file_access.log';
        $debug = date('Y-m-d H:i:s') . " - Request for thumbnail: " . $filename . "\n";
        $debug .= "Full path: " . $thumbnailPath . "\n";
        $debug .= "File exists: " . (file_exists($thumbnailPath) ? 'Yes' : 'No') . "\n";
        file_put_contents($logPath, $debug, FILE_APPEND);
        
        if (!file_exists($thumbnailPath) || is_dir($thumbnailPath)) {
            // Return the placeholder image
            $placeholderPath = FCPATH . 'assets/images/no-image.jpg';
            
            $debug .= "Using placeholder: " . $placeholderPath . "\n";
            $debug .= "Placeholder exists: " . (file_exists($placeholderPath) ? 'Yes' : 'No') . "\n";
            file_put_contents($logPath, $debug, FILE_APPEND);
            
            if (!file_exists($placeholderPath)) {
                file_put_contents($logPath, "Placeholder not found\n\n", FILE_APPEND);
                return $this->response->setStatusCode(404, 'Image not found');
            }
            
            $file = new File($placeholderPath);
            file_put_contents($logPath, "Serving placeholder\n\n", FILE_APPEND);
            return $this->response
                ->setHeader('Content-Type', 'image/jpeg')
                ->setHeader('Content-Disposition', 'inline; filename="no-image.jpg"')
                ->setHeader('Content-Length', $file->getSize())
                ->setHeader('Cache-Control', 'public, max-age=86400')
                ->setBody(file_get_contents($placeholderPath));
        }

        $file = new File($thumbnailPath);
        file_put_contents($logPath, "Thumbnail served successfully with mime type: " . $file->getMimeType() . "\n\n", FILE_APPEND);
        
        return $this->response
            ->setHeader('Content-Type', $file->getMimeType())
            ->setHeader('Content-Disposition', 'inline; filename="' . $file->getBasename() . '"')
            ->setHeader('Content-Length', $file->getSize())
            ->setHeader('Cache-Control', 'public, max-age=86400')
            ->setHeader('Expires', date('D, d M Y H:i:s', time() + 86400) . ' GMT')
            ->setBody(file_get_contents($thumbnailPath));
    }
} 