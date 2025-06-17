<?php

namespace App\Controllers;

class MediaController extends BaseController
{
    /**
     * Serve file dari writable uploads folder
     */
    public function serve($filename)
    {
        $path = WRITEPATH . 'uploads/' . $filename;
        
        if (!file_exists($path)) {
            return $this->response->setStatusCode(404, 'File not found');
        }

        $file = new \CodeIgniter\Files\File($path);
        $mimeType = $file->getMimeType();
        
        header('Content-Type: ' . $mimeType);
        header('Content-Disposition: inline; filename="' . basename($path) . '"');
        header('Content-Length: ' . filesize($path));
        
        readfile($path);
        exit;
    }

    /**
     * Serve thumbnail dari writable uploads/thumbnails folder
     */
    public function thumbnail($filename)
    {
        $path = WRITEPATH . 'uploads/thumbnails/' . $filename;
        
        if (!file_exists($path)) {
            // Jika thumbnail tidak ada, gunakan placeholder
            $placeholderPath = FCPATH . 'assets/images/no-image.jpg';
            if (file_exists($placeholderPath)) {
                header('Content-Type: image/jpeg');
                header('Content-Disposition: inline; filename="no-image.jpg"');
                header('Content-Length: ' . filesize($placeholderPath));
                readfile($placeholderPath);
                exit;
            }
            
            return $this->response->setStatusCode(404, 'File not found');
        }

        $file = new \CodeIgniter\Files\File($path);
        $mimeType = $file->getMimeType();
        
        header('Content-Type: ' . $mimeType);
        header('Content-Disposition: inline; filename="' . basename($path) . '"');
        header('Content-Length: ' . filesize($path));
        
        readfile($path);
        exit;
    }
} 