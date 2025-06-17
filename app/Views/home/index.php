<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<!-- Hero Section -->
<section class="gradient-bg text-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl md:text-6xl font-bold mb-6">
            Temukan dan Jelajahi<br>
            <span class="text-yellow-300">Karya Mahasiswa PTI</span>
        </h1>
        <p class="text-xl md:text-2xl mb-8 text-gray-200 max-w-3xl mx-auto">
            Platform galeri karya mahasiswa Program Teknologi Informasi. 
            Eksplorasi berbagai karya inovatif dari poster, video, aplikasi web hingga karya fotografi.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="<?= site_url('/galeri') ?>" class="bg-white text-primary-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors inline-flex items-center justify-center">
                <i class="fas fa-images mr-2"></i>
                Lihat Semua Karya
            </a>
            <?php if (!session()->get('is_logged_in')): ?>
                <a href="<?= site_url('/register') ?>" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-primary-600 transition-colors inline-flex items-center justify-center">
                    <i class="fas fa-user-plus mr-2"></i>
                    Bergabung Sekarang
                </a>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Featured Works Carousel -->
<?php if (!empty($featuredWorks)): ?>
<section class="py-16 bg-white dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                Karya Unggulan
            </h2>
            <p class="text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                Karya-karya terpilih yang menunjukkan kreativitas dan inovasi terbaik mahasiswa PTI
            </p>
        </div>
        
        <div class="relative" x-data="carousel()">
            <div class="overflow-hidden rounded-xl">
                <div class="flex transition-transform duration-500 ease-in-out" :style="`transform: translateX(-${currentSlide * 100}%)`">
                    <?php foreach ($featuredWorks as $work): ?>
                        <div class="w-full flex-shrink-0">
                            <div class="bg-gray-100 dark:bg-gray-800 rounded-xl overflow-hidden shadow-lg">
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-0">
                                    <!-- Image/Preview -->
                                    <div class="relative h-64 lg:h-96">
                                        <?php if ($work['thumbnail']): ?>
                                            <img src="<?= get_thumbnail_url($work['thumbnail']) ?>" 
                                                 alt="<?= esc($work['title']) ?>"
                                                 class="w-full h-full object-cover">
                                        <?php else: ?>
                                            <div class="w-full h-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center">
                                                <i class="fas fa-image text-white text-6xl"></i>
                                            </div>
                                        <?php endif; ?>
                                        <div class="absolute top-4 left-4">
                                            <span class="bg-primary-600 text-white px-3 py-1 rounded-full text-sm font-medium">
                                                <?= esc($work['category_name']) ?>
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <!-- Content -->
                                    <div class="p-8 flex flex-col justify-center">
                                        <h3 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white mb-4">
                                            <?= esc($work['title']) ?>
                                        </h3>
                                        <p class="text-gray-600 dark:text-gray-400 mb-6 line-clamp-3">
                                            <?= esc(substr($work['description'], 0, 200)) ?>...
                                        </p>
                                        <div class="flex items-center justify-between mb-6">
                                            <div class="flex items-center space-x-2">
                                                <div class="w-8 h-8 bg-primary-600 rounded-full flex items-center justify-center">
                                                    <span class="text-white text-sm font-medium">
                                                        <?= strtoupper(substr($work['user_name'], 0, 1)) ?>
                                                    </span>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900 dark:text-white">
                                                        <?= esc($work['user_name']) ?>
                                                    </p>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                                        <?= $work['year'] ?>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="flex items-center text-gray-500 dark:text-gray-400 text-sm">
                                                <i class="fas fa-eye mr-1"></i>
                                                <?= number_format($work['views']) ?>
                                            </div>
                                        </div>
                                        <a href="<?= site_url('/karya/' . $work['slug']) ?>" 
                                           class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors inline-flex items-center justify-center">
                                            <i class="fas fa-eye mr-2"></i>
                                            Lihat Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <!-- Navigation Arrows -->
            <button @click="prevSlide()" class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white dark:bg-gray-800 text-gray-800 dark:text-white p-3 rounded-full shadow-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button @click="nextSlide()" class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white dark:bg-gray-800 text-gray-800 dark:text-white p-3 rounded-full shadow-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                <i class="fas fa-chevron-right"></i>
            </button>
            
            <!-- Dots Indicator -->
            <div class="flex justify-center mt-6 space-x-2">
                <?php for ($i = 0; $i < count($featuredWorks); $i++): ?>
                    <button @click="currentSlide = <?= $i ?>" 
                            class="w-3 h-3 rounded-full transition-colors"
                            :class="currentSlide === <?= $i ?> ? 'bg-primary-600' : 'bg-gray-300 dark:bg-gray-600'">
                    </button>
                <?php endfor; ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Categories Section -->
<section class="py-16 bg-gray-50 dark:bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                Jelajahi Kategori
            </h2>
            <p class="text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                Temukan karya berdasarkan kategori yang Anda minati
            </p>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php foreach ($categories as $category): ?>
                <a href="<?= site_url('/kategori/' . $category['slug']) ?>" 
                   class="group bg-white dark:bg-gray-900 rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-primary-100 dark:bg-primary-900 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-primary-200 dark:group-hover:bg-primary-800 transition-colors">
                            <?php
                            $icons = [
                                'poster' => 'fas fa-image',
                                'video' => 'fas fa-video',
                                'pdf' => 'fas fa-file-pdf',
                                'web' => 'fas fa-globe',
                                'foto' => 'fas fa-camera',
                                'aplikasi' => 'fas fa-mobile-alt',
                            ];
                            $icon = $icons[strtolower($category['name'])] ?? 'fas fa-folder';
                            ?>
                            <i class="<?= $icon ?> text-2xl text-primary-600 dark:text-primary-400"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                            <?= esc($category['name']) ?>
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-3">
                            <?= esc($category['description'] ?? 'Koleksi karya ' . strtolower($category['name'])) ?>
                        </p>
                        <div class="flex items-center justify-center text-primary-600 dark:text-primary-400 text-sm font-medium">
                            <span><?= $category['works_count'] ?> Karya</span>
                            <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Latest Works Section -->
<?php if (!empty($latestWorks)): ?>
<section class="py-16 bg-white dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row justify-between items-center mb-12">
            <div>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    Karya Terbaru
                </h2>
                <p class="text-gray-600 dark:text-gray-400">
                    Karya-karya terbaru yang baru saja diunggah oleh mahasiswa PTI
                </p>
            </div>
            <a href="<?= site_url('/galeri') ?>" 
               class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors inline-flex items-center mt-4 sm:mt-0">
                Lihat Semua
                <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php foreach ($latestWorks as $work): ?>
                <div class="group bg-gray-50 dark:bg-gray-800 rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    <!-- Thumbnail -->
                    <div class="relative h-48 overflow-hidden">
                        <?php if ($work['thumbnail']): ?>
                            <img src="<?= get_thumbnail_url($work['thumbnail']) ?>" 
                                 alt="<?= esc($work['title']) ?>"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        <?php else: ?>
                            <div class="w-full h-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center">
                                <i class="fas fa-image text-white text-3xl"></i>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Category Badge -->
                        <div class="absolute top-3 left-3">
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
    </div>
</section>
<?php endif; ?>

<!-- CTA Section -->
<section class="py-16 bg-primary-600">
    <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
            Siap Berbagi Karya Anda?
        </h2>
        <p class="text-xl text-primary-100 mb-8">
            Bergabunglah dengan komunitas mahasiswa PTI dan showcase karya terbaik Anda
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <?php if (session()->get('is_logged_in')): ?>
                <a href="<?= site_url('/unggah') ?>" 
                   class="bg-white text-primary-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors inline-flex items-center justify-center">
                    <i class="fas fa-plus mr-2"></i>
                    Unggah Karya Sekarang
                </a>
            <?php else: ?>
                <a href="<?= site_url('/register') ?>" 
                   class="bg-white text-primary-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors inline-flex items-center justify-center">
                    <i class="fas fa-user-plus mr-2"></i>
                    Daftar Sekarang
                </a>
                <a href="<?= site_url('/login') ?>" 
                   class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-primary-600 transition-colors inline-flex items-center justify-center">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Masuk
                </a>
            <?php endif; ?>
        </div>
    </div>
</section>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
function carousel() {
    return {
        currentSlide: 0,
        totalSlides: <?= count($featuredWorks) ?>,
        
        nextSlide() {
            this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
        },
        
        prevSlide() {
            this.currentSlide = (this.currentSlide - 1 + this.totalSlides) % this.totalSlides;
        },
        
        init() {
            // Auto-play carousel
            setInterval(() => {
                this.nextSlide();
            }, 5000);
        }
    }
}
</script>
<?= $this->endSection() ?>