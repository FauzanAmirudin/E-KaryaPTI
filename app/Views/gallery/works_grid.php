<?php if (empty($works)): ?>
    <div class="text-center py-12">
        <i class="fas fa-search text-6xl text-gray-300 dark:text-gray-600 mb-4"></i>
        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Tidak ada karya ditemukan</h3>
        <p class="text-gray-600 dark:text-gray-400">Coba ubah filter pencarian Anda</p>
    </div>
<?php else: ?>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        <?php foreach ($works as $work): ?>
            <div class="group bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <!-- Thumbnail -->
                <div class="relative h-48 overflow-hidden">
                    <?php if ($work['file_type'] === 'link' && strpos($work['external_link'] ?? '', 'youtube.com') !== false): ?>
                        <?php
                        $videoId = '';
                        parse_str(parse_url($work['external_link'], PHP_URL_QUERY), $params);
                        if (isset($params['v'])) {
                            $videoId = $params['v'];
                        }
                        ?>
                        <div class="embed-responsive-item">
                            <img src="https://img.youtube.com/vi/<?= $videoId ?>/mqdefault.jpg"
                                 alt="<?= esc($work['title']) ?>"
                                 class="w-full h-full object-cover">
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="bg-red-600 text-white rounded-full p-3 opacity-90">
                                    <i class="fab fa-youtube text-xl"></i>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <?php 
                        // Get file type info using the helper function
                        $fileInfo = get_file_type_info($work['file_path'] ?? '');
                        $extension = get_file_extension($work['file_path'] ?? '');
                        
                        // Get appropriate preview URL
                        $previewUrl = get_file_preview_url($work);
                        
                        // Check if this is a video file
                        $isVideo = in_array($extension, ['mp4', 'avi', 'mov', 'wmv', 'flv', 'webm', 'mkv']);
                        
                        // Check if this is a PDF
                        $isPdf = ($extension === 'pdf');
                        
                        // Check if the file is an image without thumbnail
                        $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp']) && empty($work['thumbnail']);
                        ?>
                        
                        <!-- Debug info, hilangkan nanti -->
                        <?php if (ENVIRONMENT === 'development'): ?>
                        <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-70 text-white text-xs p-1" style="font-size:7px; overflow-x:auto; white-space:nowrap;">
                            Preview: <?= $previewUrl ?><br>
                            File: <?= $work['file_path'] ?><br>
                            Type: <?= $extension ?> (<?= $isImage ? 'Image' : ($isVideo ? 'Video' : ($isPdf ? 'PDF' : 'Other')) ?>)
                        </div>
                        <?php endif; ?>
                        
                        <div class="relative w-full h-full bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-700">
                            <!-- Show file icon with background if no thumbnail -->
                            <?php if (empty($work['thumbnail']) && !$isImage): ?>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <div class="text-center">
                                        <div class="inline-block bg-white dark:bg-gray-700 p-3 rounded-full shadow-md mb-2">
                                            <i class="fas <?= $fileInfo['icon'] ?> <?= $fileInfo['color'] ?> text-3xl"></i>
                                        </div>
                                        <div class="text-xs font-medium text-gray-700 dark:text-gray-300"><?= $fileInfo['type'] ?></div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Show preview based on file type -->
                            <img src="<?= $previewUrl ?>"
                                 alt="<?= esc($work['title']) ?>"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300 <?= (empty($work['thumbnail']) && !$isImage) ? 'opacity-0' : '' ?>"
                                 onerror="this.onerror=null; this.classList.add('opacity-0');">
                            
                            <!-- Video play button if it's a video file -->
                            <?php if ($isVideo): ?>
                                <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                                    <div class="bg-black bg-opacity-50 text-white rounded-full p-4 shadow-lg">
                                        <i class="fas fa-play"></i>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <!-- PDF indicator if it's a PDF file -->
                            <?php if ($isPdf): ?>
                                <div class="absolute bottom-2 right-2 bg-white dark:bg-gray-800 rounded-md px-2 py-1 shadow text-xs font-bold">
                                    <i class="fas fa-file-pdf text-red-500 mr-1"></i> PDF
                                </div>
                            <?php endif; ?>
                            
                            <!-- File Type Indicator -->
                            <div class="absolute top-0 left-0 bg-black bg-opacity-70 text-white px-3 py-1 m-3 rounded-md text-xs font-medium">
                                <i class="fas <?= $fileInfo['icon'] ?> <?= $fileInfo['color'] ?> mr-1"></i>
                                <?= $fileInfo['type'] ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Category Badge -->
                    <div class="absolute top-3 right-3">
                        <span class="bg-black bg-opacity-70 text-white px-2 py-1 rounded text-xs font-medium">
                            <?= esc($work['category_name']) ?>
                        </span>
                    </div>
                    
                    <!-- Hover Overlay -->
                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-all duration-300 flex items-center justify-center">
                        <a href="<?= site_url('/karya/' . $work['slug']) ?>" 
                           class="bg-white text-gray-900 px-4 py-2 rounded-lg font-semibold opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0 transition-all duration-300">
                            <i class="fas fa-eye mr-2"></i>Lihat Detail
                        </a>
                    </div>
                </div>
                
                <!-- Content -->
                <div class="p-4">
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-2 line-clamp-2">
                        <?= esc($work['title']) ?>
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-3 line-clamp-2">
                        <?= esc(substr($work['description'], 0, 100)) ?>...
                    </p>
                    
                    <!-- Author & Stats -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <div class="w-6 h-6 bg-primary-600 rounded-full flex items-center justify-center">
                                <span class="text-white text-xs font-medium">
                                    <?= strtoupper(substr($work['user_name'], 0, 1)) ?>
                                </span>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-gray-900 dark:text-white">
                                    <?= esc($work['user_name']) ?>
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    <?= $work['year'] ?>
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center text-gray-500 dark:text-gray-400 text-xs">
                            <i class="fas fa-eye mr-1"></i>
                            <?= number_format($work['views']) ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>