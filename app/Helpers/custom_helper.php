<?php

/**
 * Custom helper functions for the application
 */

if (!function_exists('formatBytes')) {
    function formatBytes($size, $precision = 2)
    {
        if ($size === 0 || $size === null) return '0 Bytes';
        
        $base = log($size, 1024);
        $suffixes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
        
        return round(pow(1024, $base - floor($base)), $precision) . ' ' . $suffixes[floor($base)];
    }
}

if (!function_exists('timeAgo')) {
    function timeAgo($datetime)
    {
        if (empty($datetime)) {
            return 'Tidak diketahui';
        }
        
        $timestamp = is_numeric($datetime) ? $datetime : strtotime($datetime);
        if ($timestamp === false) {
            return 'Tidak diketahui';
        }
        
        $time = time() - $timestamp;
        
        if ($time < 60) return 'baru saja';
        if ($time < 3600) return floor($time / 60) . ' menit yang lalu';
        if ($time < 86400) return floor($time / 3600) . ' jam yang lalu';
        if ($time < 2592000) return floor($time / 86400) . ' hari yang lalu';
        if ($time < 31536000) return floor($time / 2592000) . ' bulan yang lalu';
        
        return floor($time / 31536000) . ' tahun yang lalu';
    }
}

if (!function_exists('truncateText')) {
    function truncateText($text, $length = 100, $suffix = '...')
    {
        if (strlen($text) <= $length) {
            return $text;
        }
        
        return substr($text, 0, $length) . $suffix;
    }
}

if (!function_exists('getFileIcon')) {
    function getFileIcon($filename)
    {
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        $icons = [
            'pdf' => 'fas fa-file-pdf text-red-500',
            'doc' => 'fas fa-file-word text-blue-500',
            'docx' => 'fas fa-file-word text-blue-500',
            'xls' => 'fas fa-file-excel text-green-500',
            'xlsx' => 'fas fa-file-excel text-green-500',
            'ppt' => 'fas fa-file-powerpoint text-orange-500',
            'pptx' => 'fas fa-file-powerpoint text-orange-500',
            'jpg' => 'fas fa-file-image text-purple-500',
            'jpeg' => 'fas fa-file-image text-purple-500',
            'png' => 'fas fa-file-image text-purple-500',
            'gif' => 'fas fa-file-image text-purple-500',
            'mp4' => 'fas fa-file-video text-indigo-500',
            'avi' => 'fas fa-file-video text-indigo-500',
            'mov' => 'fas fa-file-video text-indigo-500',
            'mp3' => 'fas fa-file-audio text-pink-500',
            'wav' => 'fas fa-file-audio text-pink-500',
            'zip' => 'fas fa-file-archive text-yellow-500',
            'rar' => 'fas fa-file-archive text-yellow-500',
            'txt' => 'fas fa-file-alt text-gray-500',
        ];
        
        return $icons[$extension] ?? 'fas fa-file text-gray-500';
    }
}

if (!function_exists('generateSlug')) {
    function generateSlug($text)
    {
        // Replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        
        // Transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        
        // Remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);
        
        // Trim
        $text = trim($text, '-');
        
        // Remove duplicate -
        $text = preg_replace('~-+~', '-', $text);
        
        // Lowercase
        $text = strtolower($text);
        
        if (empty($text)) {
            return 'n-a';
        }
        
        return $text;
    }
}

if (!function_exists('isImage')) {
    function isImage($filename)
    {
        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg'];
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        return in_array($extension, $imageExtensions);
    }
}

if (!function_exists('isVideo')) {
    function isVideo($filename)
    {
        $videoExtensions = ['mp4', 'avi', 'mov', 'wmv', 'flv', 'webm', 'mkv'];
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        return in_array($extension, $videoExtensions);
    }
}

if (!function_exists('sanitizeFilename')) {
    function sanitizeFilename($filename)
    {
        // Remove any character that isn't alphanumeric, dash, underscore, or dot
        $filename = preg_replace('/[^a-zA-Z0-9\-_\.]/', '', $filename);
        
        // Remove multiple dots
        $filename = preg_replace('/\.+/', '.', $filename);
        
        return $filename;
    }
}

if (!function_exists('formatDate')) {
    function formatDate($date, $format = 'd M Y')
    {
        if (empty($date)) {
            return '-';
        }
        
        $timestamp = is_numeric($date) ? $date : strtotime($date);
        if ($timestamp === false) {
            return '-';
        }
        
        return date($format, $timestamp);
    }
}

if (! function_exists('format_date')) {
    /**
     * Format a date for display
     * 
     * @param string $date The date to format
     * @param string $format The format to use (default: 'd M Y')
     * @return string Formatted date
     */
    function format_date($date, $format = 'd M Y')
    {
        if (empty($date)) {
            return '-';
        }
        
        return date($format, strtotime($date));
    }
}

if (! function_exists('get_file_icon')) {
    /**
     * Get an icon for a file based on its type
     * 
     * @param string $filePath Path to the file
     * @param string $mimeType MIME type of the file
     * @return string CSS class for the icon
     */
    function get_file_icon($filePath, $mimeType = null)
    {
        if (empty($filePath)) {
            return 'fas fa-file text-gray-500';
        }
        
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        
        $icons = [
            // Images
            'jpg' => 'fas fa-file-image text-blue-500',
            'jpeg' => 'fas fa-file-image text-blue-500',
            'png' => 'fas fa-file-image text-blue-500',
            'gif' => 'fas fa-file-image text-blue-500',
            'webp' => 'fas fa-file-image text-blue-500',
            
            // Documents
            'pdf' => 'fas fa-file-pdf text-red-500',
            'doc' => 'fas fa-file-word text-blue-700',
            'docx' => 'fas fa-file-word text-blue-700',
            'xls' => 'fas fa-file-excel text-green-700',
            'xlsx' => 'fas fa-file-excel text-green-700',
            'ppt' => 'fas fa-file-powerpoint text-orange-600',
            'pptx' => 'fas fa-file-powerpoint text-orange-600',
            
            // Archives
            'zip' => 'fas fa-file-archive text-yellow-500',
            'rar' => 'fas fa-file-archive text-yellow-500',
            
            // Code
            'html' => 'fas fa-file-code text-purple-500',
            'css' => 'fas fa-file-code text-purple-500',
            'js' => 'fas fa-file-code text-purple-500',
            'php' => 'fas fa-file-code text-purple-500',
            
            // Video
            'mp4' => 'fas fa-file-video text-blue-500',
            'avi' => 'fas fa-file-video text-blue-500',
            'mov' => 'fas fa-file-video text-blue-500',
        ];
        
        return $icons[strtolower($extension)] ?? 'fas fa-file text-gray-500';
    }
}

if (! function_exists('debug_var')) {
    /**
     * Debug variable by writing to a log file
     * 
     * @param mixed $var Variable to debug
     * @param string $label Label for the debug output
     * @return void
     */
    function debug_var($var, $label = 'Debug')
    {
        $logPath = WRITEPATH . 'logs/debug.log';
        $output = "[" . date('Y-m-d H:i:s') . "] {$label}: " . print_r($var, true) . "\n";
        file_put_contents($logPath, $output, FILE_APPEND);
    }
}

if (!function_exists('get_thumbnail_url')) {
    /**
     * Generate thumbnail URL
     *
     * @param string|null $thumbnail Thumbnail file name
     * @return string Image URL
     */
    function get_thumbnail_url($thumbnail = null)
    {
        if ($thumbnail && file_exists(WRITEPATH . 'uploads/thumbnails/' . $thumbnail)) {
            return site_url('uploads/thumbnails/' . $thumbnail);
        }
        
        // Return default placeholder image
        return site_url('assets/images/no-image.jpg');
    }
}

if (!function_exists('get_file_url')) {
    /**
     * Generate file URL
     *
     * @param string|null $filename File name
     * @return string File URL
     */
    function get_file_url($filename = null)
    {
        if ($filename && file_exists(WRITEPATH . 'uploads/' . $filename)) {
            return site_url('uploads/' . $filename);
        }
        
        return null;
    }
}

if (!function_exists('format_bytes')) {
    /**
     * Format bytes to human readable format
     *
     * @param int $size Size in bytes
     * @param int $precision Decimal precision
     * @return string Formatted size
     */
    function format_bytes($size, $precision = 2)
    {
        if ($size <= 0) {
            return '0 B';
        }
        
        $base = log($size, 1024);
        $suffixes = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        return round(pow(1024, $base - floor($base)), $precision) . ' ' . $suffixes[floor($base)];
    }
}

if (!function_exists('get_file_type_info')) {
    /**
     * Get file type information including type name and icon
     *
     * @param string|null $filename File path or name
     * @return array File type information array with type, icon, and color
     */
    function get_file_type_info($filename = null) 
    {
        $result = [
            'type' => 'LAINNYA',
            'icon' => 'fa-file',
            'color' => 'text-gray-500'
        ];
        
        if (empty($filename)) {
            return $result;
        }
        
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        // Image files
        if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp'])) {
            $result['type'] = 'FOTO';
            $result['icon'] = 'fa-image';
            $result['color'] = 'text-green-500';
        } 
        // Document files
        else if (in_array($extension, ['pdf'])) {
            $result['type'] = 'PDF';
            $result['icon'] = 'fa-file-pdf';
            $result['color'] = 'text-red-500';
        }
        else if (in_array($extension, ['doc', 'docx'])) {
            $result['type'] = 'DOC';
            $result['icon'] = 'fa-file-word';
            $result['color'] = 'text-blue-500';
        }
        else if (in_array($extension, ['xls', 'xlsx'])) {
            $result['type'] = 'EXCEL';
            $result['icon'] = 'fa-file-excel';
            $result['color'] = 'text-green-500';
        }
        else if (in_array($extension, ['ppt', 'pptx'])) {
            $result['type'] = 'PPT';
            $result['icon'] = 'fa-file-powerpoint';
            $result['color'] = 'text-orange-500';
        }
        // Video files
        else if (in_array($extension, ['mp4', 'avi', 'mov', 'wmv', 'flv', 'webm', 'mkv'])) {
            $result['type'] = 'VIDEO';
            $result['icon'] = 'fa-file-video';
            $result['color'] = 'text-purple-500';
        }
        // Audio files
        else if (in_array($extension, ['mp3', 'wav', 'ogg', 'm4a'])) {
            $result['type'] = 'AUDIO';
            $result['icon'] = 'fa-file-audio';
            $result['color'] = 'text-pink-500';
        }
        // Archive files
        else if (in_array($extension, ['zip', 'rar', '7z', 'tar', 'gz'])) {
            $result['type'] = 'ARSIP';
            $result['icon'] = 'fa-file-archive';
            $result['color'] = 'text-yellow-500';
        }
        // Code files
        else if (in_array($extension, ['html', 'css', 'js', 'php', 'java', 'py', 'c', 'cpp'])) {
            $result['type'] = 'KODE';
            $result['icon'] = 'fa-file-code';
            $result['color'] = 'text-indigo-500';
        }
        // Text files
        else if (in_array($extension, ['txt', 'rtf', 'csv'])) {
            $result['type'] = 'TEXT';
            $result['icon'] = 'fa-file-alt';
            $result['color'] = 'text-gray-500';
        }
        
        return $result;
    }
}

if (!function_exists('get_file_extension')) {
    /**
     * Get file extension from filename
     *
     * @param string|null $filename File path or name
     * @return string File extension or empty string
     */
    function get_file_extension($filename = null) 
    {
        if (empty($filename)) {
            return '';
        }
        
        return strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    }
}

if (!function_exists('get_file_preview_url')) {
    /**
     * Generate preview URL based on file type
     *
     * @param array $work Work data containing file_path, thumbnail, mime_type
     * @return string Preview URL
     */
    function get_file_preview_url($work = []) 
    {
        // Debug paths
        $logPath = WRITEPATH . 'logs/file_paths.log';
        $debug = "Request for file: " . ($work['file_path'] ?? 'No file path') . "\n";
        
        // For empty input, return no-image placeholder
        if (empty($work) || (empty($work['file_path']) && empty($work['thumbnail']) && empty($work['external_link']))) {
            $debug .= "No file information found, returning placeholder\n";
            file_put_contents($logPath, $debug, FILE_APPEND);
            return site_url('assets/images/no-image.jpg');
        }
        
        // For YouTube links
        if (!empty($work['external_link']) && strpos($work['external_link'], 'youtube.com') !== false) {
            $videoId = '';
            parse_str(parse_url($work['external_link'], PHP_URL_QUERY), $params);
            if (isset($params['v'])) {
                $videoId = $params['v'];
                $debug .= "YouTube video found, using thumbnail: " . $videoId . "\n";
                file_put_contents($logPath, $debug, FILE_APPEND);
                return 'https://img.youtube.com/vi/' . $videoId . '/mqdefault.jpg';
            }
        }
        
        // If there's a thumbnail, use it (most common case)
        if (!empty($work['thumbnail'])) {
            $thumbnailPath = WRITEPATH . 'uploads/thumbnails/' . $work['thumbnail'];
            $debug .= "Checking thumbnail: " . $thumbnailPath . " - Exists: " . (file_exists($thumbnailPath) ? 'Yes' : 'No') . "\n";
            
            if (file_exists($thumbnailPath)) {
                $thumbnailUrl = site_url('uploads/thumbnails/' . $work['thumbnail']);
                $debug .= "Using thumbnail URL: " . $thumbnailUrl . "\n";
                file_put_contents($logPath, $debug, FILE_APPEND);
                return $thumbnailUrl;
            }
        }
        
        // For files without thumbnails, check file type
        if (!empty($work['file_path'])) {
            $filePath = WRITEPATH . 'uploads/' . $work['file_path'];
            $debug .= "Checking direct file: " . $filePath . " - Exists: " . (file_exists($filePath) ? 'Yes' : 'No') . "\n";
            
            $extension = get_file_extension($work['file_path']);
            $debug .= "File extension: " . $extension . "\n";
            
            // For images, use direct file URL
            if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp'])) {
                if (file_exists($filePath)) {
                    $fileUrl = site_url('uploads/' . $work['file_path']);
                    $debug .= "Using direct image URL: " . $fileUrl . "\n";
                    file_put_contents($logPath, $debug, FILE_APPEND);
                    return $fileUrl;
                }
            }
            
            // For PDFs, return PDF icon or preview
            if ($extension === 'pdf') {
                $debug .= "Using PDF preview image\n";
                file_put_contents($logPath, $debug, FILE_APPEND);
                return site_url('assets/images/pdf-preview.jpg');
            }
            
            // For videos, return video preview
            if (in_array($extension, ['mp4', 'avi', 'mov', 'webm', 'wmv', 'flv', 'mkv'])) {
                $debug .= "Using video preview image\n";
                file_put_contents($logPath, $debug, FILE_APPEND);
                return site_url('assets/images/video-preview.jpg');
            }
        }
        
        // Debug fallback
        $debug .= "Falling back to default placeholder\n";
        file_put_contents($logPath, $debug, FILE_APPEND);
        
        // Default to placeholder
        return site_url('assets/images/no-image.jpg');
    }
}