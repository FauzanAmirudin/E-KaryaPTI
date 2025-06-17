<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="bg-white dark:bg-gray-900 min-h-screen">
    <!-- Header -->
    <div class="bg-gradient-to-r from-primary-600 to-primary-800 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-6">
                Jelajahi Semua Kategori
            </h1>
            <p class="text-xl text-primary-100 max-w-3xl mx-auto">
                Temukan berbagai jenis karya mahasiswa PTI berdasarkan kategori yang Anda minati
            </p>
        </div>
    </div>

    <!-- Categories Grid -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            <?php foreach ($categories as $category): ?>
                <a href="<?= base_url('/kategori/' . $category['slug']) ?>" 
                   class="group bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 overflow-hidden">
                    
                    <!-- Category Header -->
                    <div class="bg-gradient-to-br from-primary-500 to-primary-700 p-8 text-center">
                        <div class="w-20 h-20 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                            <?php
                            $icons = [
                                'poster' => 'fas fa-image',
                                'video' => 'fas fa-video',
                                'pdf' => 'fas fa-file-pdf',
                                'web' => 'fas fa-globe',
                                'foto' => 'fas fa-camera',
                                'aplikasi' => 'fas fa-mobile-alt',
                                'dokumen' => 'fas fa-file-alt',
                                'presentasi' => 'fas fa-presentation',
                            ];
                            $icon = $icons[strtolower($category['name'])] ?? 'fas fa-folder';
                            ?>
                            <i class="<?= $icon ?> text-3xl text-white"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-2">
                            <?= esc($category['name']) ?>
                        </h3>
                        <div class="bg-white bg-opacity-20 rounded-full px-4 py-1 inline-block">
                            <span class="text-white font-medium">
                                <?= $category['works_count'] ?> Karya
                            </span>
                        </div>
                    </div>

                    <!-- Category Content -->
                    <div class="p-6">
                        <p class="text-gray-600 dark:text-gray-400 text-center mb-6 leading-relaxed">
                            <?= esc($category['description'] ?? 'Koleksi karya ' . strtolower($category['name']) . ' dari mahasiswa PTI') ?>
                        </p>
                        
                        <!-- View Button -->
                        <div class="text-center">
                            <span class="inline-flex items-center text-primary-600 dark:text-primary-400 font-semibold group-hover:text-primary-800 dark:group-hover:text-primary-300 transition-colors">
                                Lihat Karya
                                <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                            </span>
                        </div>
                    </div>

                    <!-- Hover Effect Overlay -->
                    <div class="absolute inset-0 bg-primary-600 bg-opacity-0 group-hover:bg-opacity-5 transition-all duration-300 rounded-2xl"></div>
                </a>
            <?php endforeach; ?>
        </div>

        <!-- Empty State -->
        <?php if (empty($categories)): ?>
            <div class="text-center py-16">
                <i class="fas fa-folder-open text-6xl text-gray-300 dark:text-gray-600 mb-6"></i>
                <h3 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">
                    Belum Ada Kategori
                </h3>
                <p class="text-gray-600 dark:text-gray-400 max-w-md mx-auto">
                    Kategori karya akan muncul di sini setelah administrator menambahkannya.
                </p>
            </div>
        <?php endif; ?>
    </div>

    <!-- CTA Section -->
    <div class="bg-gray-50 dark:bg-gray-800 py-16">
        <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                Siap Berbagi Karya Anda?
            </h2>
            <p class="text-xl text-gray-600 dark:text-gray-400 mb-8">
                Bergabunglah dengan komunitas mahasiswa PTI dan showcase karya terbaik Anda
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <?php if (session()->get('is_logged_in')): ?>
                    <a href="<?= base_url('/unggah') ?>" 
                       class="bg-primary-600 hover:bg-primary-700 text-white px-8 py-3 rounded-lg font-semibold transition-colors inline-flex items-center justify-center">
                        <i class="fas fa-plus mr-2"></i>
                        Unggah Karya Sekarang
                    </a>
                    <a href="<?= base_url('/galeri') ?>" 
                       class="border border-primary-600 text-primary-600 dark:text-primary-400 px-8 py-3 rounded-lg font-semibold hover:bg-primary-50 dark:hover:bg-primary-900 transition-colors inline-flex items-center justify-center">
                        <i class="fas fa-images mr-2"></i>
                        Lihat Semua Karya
                    </a>
                <?php else: ?>
                    <a href="<?= base_url('/register') ?>" 
                       class="bg-primary-600 hover:bg-primary-700 text-white px-8 py-3 rounded-lg font-semibold transition-colors inline-flex items-center justify-center">
                        <i class="fas fa-user-plus mr-2"></i>
                        Daftar Sekarang
                    </a>
                    <a href="<?= base_url('/galeri') ?>" 
                       class="border border-primary-600 text-primary-600 dark:text-primary-400 px-8 py-3 rounded-lg font-semibold hover:bg-primary-50 dark:hover:bg-primary-900 transition-colors inline-flex items-center justify-center">
                        <i class="fas fa-images mr-2"></i>
                        Jelajahi Karya
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>