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
                    <?= renderWorkThumbnail($work, 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-300') ?>
                    
                    <!-- Category Badge -->
                    <div class="absolute top-3 left-3">
                        <span class="bg-black bg-opacity-70 text-white px-2 py-1 rounded text-xs font-medium">
                            <?= esc($work['category_name']) ?>
                        </span>
                    </div>
                    
                    <!-- Hover Overlay -->
                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-all duration-300 flex items-center justify-center">
                        <a href="<?= base_url('/karya/' . $work['slug']) ?>" 
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