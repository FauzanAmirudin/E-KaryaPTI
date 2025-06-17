<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="bg-white dark:bg-gray-900 min-h-screen">
    <!-- Breadcrumb -->
    <div class="bg-gray-50 dark:bg-gray-800 border-b dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <nav class="flex items-center space-x-2 text-sm">
                <a href="<?= site_url('/') ?>" class="text-gray-500 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400">
                    Beranda
                </a>
                <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                <a href="<?= site_url('/galeri') ?>" class="text-gray-500 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400">
                    Galeri
                </a>
                <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                <a href="<?= site_url('/kategori/' . $work['category_slug']) ?>" class="text-gray-500 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400">
                    <?= esc($work['category_name']) ?>
                </a>
                <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                <span class="text-gray-900 dark:text-white font-medium">
                    <?= esc($work['title']) ?>
                </span>
            </nav>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Work Title -->
                <div class="mb-6">
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                        <?= esc($work['title']) ?>
                    </h1>
                    <div class="flex items-center space-x-4 text-sm text-gray-600 dark:text-gray-400">
                        <span class="bg-primary-100 dark:bg-primary-900 text-primary-800 dark:text-primary-200 px-3 py-1 rounded-full font-medium">
                            <?= esc($work['category_name']) ?>
                        </span>
                        <span class="flex items-center">
                            <i class="fas fa-calendar mr-1"></i>
                            <?= $work['year'] ?>
                        </span>
                        <span class="flex items-center">
                            <i class="fas fa-eye mr-1"></i>
                            <?= number_format($work['views']) ?> views
                        </span>
                    </div>
                </div>

                <!-- Work Preview -->
                <div class="mb-8" x-data="workPreview()">
                    <?php if ($work['file_type'] === 'file' && $work['file_path']): ?>
                        <?php 
                        $extension = pathinfo($work['file_path'], PATHINFO_EXTENSION);
                        $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                        $isVideo = in_array(strtolower($extension), ['mp4', 'avi', 'mov', 'wmv']);
                        $isPdf = strtolower($extension) === 'pdf';
                        ?>
                        
                        <?php if ($isImage): ?>
                            <!-- Image Preview -->
                            <div class="relative">
                                <img src="<?= get_file_url($work['file_path']) ?>" 
                                     alt="<?= esc($work['title']) ?>"
                                     class="w-full rounded-xl shadow-lg cursor-pointer"
                                     @click="openLightbox('<?= get_file_url($work['file_path']) ?>')">
                                <div class="absolute top-4 right-4">
                                    <button @click="openLightbox('<?= get_file_url($work['file_path']) ?>')"
                                            class="bg-black bg-opacity-50 text-white p-2 rounded-lg hover:bg-opacity-70 transition-colors">
                                        <i class="fas fa-expand"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Lightbox Modal -->
                            <div x-show="lightboxOpen" 
                                 x-cloak
                                 @click="closeLightbox()"
                                 class="fixed inset-0 bg-black bg-opacity-90 z-50 flex items-center justify-center p-4">
                                <img :src="lightboxImage" 
                                     class="max-w-full max-h-full object-contain"
                                     @click.stop>
                                <button @click="closeLightbox()"
                                        class="absolute top-4 right-4 text-white text-2xl hover:text-gray-300">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            
                        <?php elseif ($isVideo): ?>
                            <!-- Video Preview -->
                            <div class="relative bg-black rounded-xl overflow-hidden">
                                <video controls class="w-full">
                                    <source src="<?= get_file_url($work['file_path']) ?>" type="video/<?= $extension ?>">
                                    Browser Anda tidak mendukung tag video.
                                </video>
                            </div>
                            
                        <?php elseif ($isPdf): ?>
                            <!-- PDF Preview -->
                            <div class="bg-gray-100 dark:bg-gray-800 rounded-xl p-6">
                                <div class="text-center mb-4">
                                    <i class="fas fa-file-pdf text-6xl text-red-500 mb-4"></i>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                                        Dokumen PDF
                                    </h3>
                                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                                        Ukuran: <?= format_bytes($work['file_size']) ?>
                                    </p>
                                </div>
                                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                                    <a href="<?= get_file_url($work['file_path']) ?>" 
                                       target="_blank"
                                       class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors inline-flex items-center justify-center">
                                        <i class="fas fa-eye mr-2"></i>
                                        Lihat PDF
                                    </a>
                                    <a href="<?= get_file_url($work['file_path']) ?>" 
                                       download
                                       class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors inline-flex items-center justify-center">
                                        <i class="fas fa-download mr-2"></i>
                                        Download
                                    </a>
                                </div>
                            </div>
                            
                        <?php else: ?>
                            <!-- Other File Types -->
                            <?php 
                            // Get file type information
                            $fileInfo = get_file_type_info($work['file_path']);
                            ?>
                            <div class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-700 rounded-xl p-8 text-center shadow-lg">
                                <div class="mb-6">
                                    <div class="inline-block bg-white dark:bg-gray-700 p-6 rounded-full shadow-md">
                                        <i class="fas <?= $fileInfo['icon'] ?> <?= $fileInfo['color'] ?> text-6xl"></i>
                                    </div>
                                </div>
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                                    File <?= $fileInfo['type'] ?>
                                </h3>
                                <p class="text-gray-600 dark:text-gray-400 mb-2">
                                    <?= strtoupper($extension) ?> • <?= format_bytes($work['file_size']) ?>
                                </p>
                                <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-inner mb-6 text-left">
                                    <div class="flex items-center text-sm font-mono overflow-hidden">
                                        <i class="fas fa-file-alt text-gray-400 mr-2"></i>
                                        <span class="text-gray-600 dark:text-gray-400 truncate">
                                            <?= esc($work['file_path']) ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                                    <?php if (in_array($extension, ['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'pdf', 'txt'])): ?>
                                    <a href="<?= get_file_url($work['file_path']) ?>" 
                                       target="_blank"
                                       class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors inline-flex items-center justify-center">
                                        <i class="fas fa-eye mr-2"></i>
                                        Lihat File
                                    </a>
                                    <?php endif; ?>
                                    <a href="<?= get_file_url($work['file_path']) ?>" 
                                       download
                                       class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors inline-flex items-center justify-center">
                                        <i class="fas fa-download mr-2"></i>
                                        Download File
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                    <?php elseif ($work['file_type'] === 'link' && $work['external_link']): ?>
                        <!-- External Link Preview -->
                        <div class="bg-gradient-to-br from-primary-50 to-primary-100 dark:from-primary-900 dark:to-primary-800 rounded-xl p-8 text-center">
                            <i class="fas fa-external-link-alt text-4xl text-primary-600 dark:text-primary-400 mb-4"></i>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                                Link Eksternal
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-6">
                                Karya ini tersedia melalui link eksternal
                            </p>
                            <a href="<?= esc($work['external_link']) ?>" 
                               target="_blank" 
                               rel="noopener noreferrer"
                               class="bg-primary-600 hover:bg-primary-700 text-white px-8 py-3 rounded-lg font-semibold transition-colors inline-flex items-center justify-center">
                                <i class="fas fa-external-link-alt mr-2"></i>
                                Buka Link
                            </a>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Work Description -->
                <div class="prose prose-lg dark:prose-invert max-w-none">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Deskripsi</h2>
                    <div class="text-gray-700 dark:text-gray-300 leading-relaxed">
                        <?= nl2br(esc($work['description'])) ?>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Author Info -->
                <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Pencipta Karya</h3>
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-12 h-12 bg-primary-600 rounded-full flex items-center justify-center">
                            <span class="text-white text-lg font-semibold">
                                <?= strtoupper(substr($work['user_name'], 0, 1)) ?>
                            </span>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white">
                                <?= esc($work['user_name']) ?>
                            </h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Mahasiswa PTI
                            </p>
                        </div>
                    </div>
                    
                    <!-- Work Actions (if owner) -->
                    <?php if (session()->get('user_id') == $work['user_id']): ?>
                        <div class="flex space-x-2 pt-4 border-t border-gray-200 dark:border-gray-700">
                            <a href="<?= site_url('/karya/edit/' . $work['id']) ?>" 
                               class="flex-1 bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg font-medium transition-colors text-center">
                                <i class="fas fa-edit mr-1"></i>Edit
                            </a>
                            <button onclick="deleteWork(<?= $work['id'] ?>)"
                                    class="flex-1 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                                <i class="fas fa-trash mr-1"></i>Hapus
                            </button>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Work Details -->
                <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Detail Karya</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Kategori:</span>
                            <a href="<?= site_url('/kategori/' . $work['category_slug']) ?>" 
                               class="text-primary-600 dark:text-primary-400 hover:underline font-medium">
                                <?= esc($work['category_name']) ?>
                            </a>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Tahun:</span>
                            <span class="font-medium text-gray-900 dark:text-white"><?= $work['year'] ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Dilihat:</span>
                            <span class="font-medium text-gray-900 dark:text-white"><?= number_format($work['views']) ?> kali</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Diunggah:</span>
                            <span class="font-medium text-gray-900 dark:text-white">
                                <?= date('d M Y', strtotime($work['created_at'])) ?>
                            </span>
                        </div>
                        <?php if ($work['file_size']): ?>
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Ukuran File:</span>
                                <span class="font-medium text-gray-900 dark:text-white"><?= format_bytes($work['file_size']) ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Share -->
                <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Bagikan</h3>
                    <div class="flex space-x-3">
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(current_url()) ?>" 
                           target="_blank"
                           class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-lg text-center transition-colors">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url=<?= urlencode(current_url()) ?>&text=<?= urlencode($work['title']) ?>" 
                           target="_blank"
                           class="flex-1 bg-sky-500 hover:bg-sky-600 text-white px-3 py-2 rounded-lg text-center transition-colors">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="https://wa.me/?text=<?= urlencode($work['title'] . ' - ' . current_url()) ?>" 
                           target="_blank"
                           class="flex-1 bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-lg text-center transition-colors">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <button onclick="copyToClipboard('<?= current_url() ?>')"
                                class="flex-1 bg-gray-600 hover:bg-gray-700 text-white px-3 py-2 rounded-lg transition-colors">
                            <i class="fas fa-copy"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Works -->
        <?php if (!empty($relatedWorks)): ?>
            <div class="mt-12 pt-8 border-t border-gray-200 dark:border-gray-700">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Karya Terkait</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <?php foreach ($relatedWorks as $relatedWork): ?>
                        <div class="group bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                            <div class="relative h-32 overflow-hidden">
                                <?php if ($relatedWork['file_type'] === 'link' && strpos($relatedWork['external_link'], 'youtube.com') !== false): ?>
                                    <?php
                                    $videoId = '';
                                    parse_str(parse_url($relatedWork['external_link'], PHP_URL_QUERY), $params);
                                    if (isset($params['v'])) {
                                        $videoId = $params['v'];
                                    }
                                    ?>
                                    <div class="embed-responsive-item">
                                        <img src="https://img.youtube.com/vi/<?= $videoId ?>/mqdefault.jpg"
                                             alt="<?= esc($relatedWork['title']) ?>"
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                        <div class="absolute inset-0 flex items-center justify-center">
                                            <div class="bg-red-600 text-white rounded-full p-3 opacity-90">
                                                <i class="fab fa-youtube text-xl"></i>
                                            </div>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <img src="<?= get_thumbnail_url($relatedWork['thumbnail']) ?>"
                                         alt="<?= esc($relatedWork['title']) ?>"
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                <?php endif; ?>
                                
                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-all duration-300 flex items-center justify-center">
                                    <a href="<?= site_url('/karya/' . $relatedWork['slug']) ?>" 
                                       class="bg-white text-gray-900 px-3 py-1 rounded font-medium opacity-0 group-hover:opacity-100 transform translate-y-2 group-hover:translate-y-0 transition-all duration-300 text-sm">
                                        Lihat
                                    </a>
                                </div>
                            </div>
                            
                            <div class="p-3">
                                <h3 class="font-semibold text-gray-900 dark:text-white text-sm mb-1 line-clamp-2">
                                    <?= esc($relatedWork['title']) ?>
                                </h3>
                                <p class="text-xs text-gray-600 dark:text-gray-400">
                                    <?= esc($relatedWork['user_name']) ?> • <?= $relatedWork['year'] ?>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
function workPreview() {
    return {
        lightboxOpen: false,
        lightboxImage: '',
        
        openLightbox(imageSrc) {
            this.lightboxImage = imageSrc;
            this.lightboxOpen = true;
            document.body.style.overflow = 'hidden';
        },
        
        closeLightbox() {
            this.lightboxOpen = false;
            document.body.style.overflow = 'auto';
        }
    }
}

function deleteWork(workId) {
    if (confirm('Apakah Anda yakin ingin menghapus karya ini? Tindakan ini tidak dapat dibatalkan.')) {
        fetch(`<?= site_url('/karya/delete/') ?>${workId}`, {
            method: 'DELETE',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Karya berhasil dihapus');
                window.location.href = '<?= site_url('/karya-saya') ?>';
            } else {
                alert('Gagal menghapus karya: ' + (data.error || 'Terjadi kesalahan'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menghapus karya');
        });
    }
}

function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        alert('Link berhasil disalin ke clipboard!');
    }).catch(function(err) {
        console.error('Error copying text: ', err);
        alert('Gagal menyalin link');
    });
}
</script>
<?= $this->endSection() ?>