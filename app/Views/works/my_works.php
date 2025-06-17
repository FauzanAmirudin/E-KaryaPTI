<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="bg-white dark:bg-gray-900 min-h-screen">
    <!-- Header -->
    <div class="bg-gradient-to-r from-primary-600 to-primary-800 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row justify-between items-center mb-8 gap-4">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                    Karya Saya
                </h1>
                
                <a href="<?= site_url('/unggah') ?>"
                   class="bg-primary-600 text-white px-6 py-3 rounded-lg inline-flex items-center hover:bg-primary-700 transition-colors">
                    <i class="fas fa-plus mr-2"></i>
                    Unggah Karya
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="bg-gray-50 dark:bg-gray-800 border-b dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Total Works -->
                <div class="bg-white dark:bg-gray-900 rounded-xl p-6 shadow-lg">
                    <div class="flex items-center">
                        <div class="p-3 bg-primary-100 dark:bg-primary-900 rounded-full">
                            <i class="fas fa-folder-open text-2xl text-primary-600 dark:text-primary-400"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                                <?= $stats['total_works'] ?>
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400">Total Karya</p>
                        </div>
                    </div>
                </div>

                <!-- Total Views -->
                <div class="bg-white dark:bg-gray-900 rounded-xl p-6 shadow-lg">
                    <div class="flex items-center">
                        <div class="p-3 bg-green-100 dark:bg-green-900 rounded-full">
                            <i class="fas fa-eye text-2xl text-green-600 dark:text-green-400"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                                <?= number_format($stats['total_views']) ?>
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400">Total Views</p>
                        </div>
                    </div>
                </div>

                <!-- Categories -->
                <div class="bg-white dark:bg-gray-900 rounded-xl p-6 shadow-lg">
                    <div class="flex items-center">
                        <div class="p-3 bg-yellow-100 dark:bg-yellow-900 rounded-full">
                            <i class="fas fa-tags text-2xl text-yellow-600 dark:text-yellow-400"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                                <?= count($stats['works_by_category']) ?>
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400">Kategori</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Category Breakdown -->
            <?php if (!empty($stats['works_by_category'])): ?>
                <div class="mt-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Karya per Kategori</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-3">
                        <?php foreach ($stats['works_by_category'] as $category): ?>
                            <div class="bg-white dark:bg-gray-900 rounded-lg p-3 text-center shadow">
                                <p class="font-semibold text-gray-900 dark:text-white"><?= $category['total_works'] ?></p>
                                <p class="text-xs text-gray-600 dark:text-gray-400"><?= esc($category['category_name']) ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Works List -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <?php if (empty($works)): ?>
            <!-- Empty State -->
            <div class="text-center py-16 px-6 bg-white dark:bg-gray-800 rounded-xl shadow-sm">
                <div class="max-w-md mx-auto">
                    <img src="<?= site_url('assets/images/empty-works.svg') ?>" alt="No works" class="w-64 h-64 mx-auto mb-6 opacity-80">
                    
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                        Belum Ada Karya
                    </h3>
                    
                    <p class="text-gray-600 dark:text-gray-400 mb-8">
                        Anda belum memiliki karya yang diunggah. Mulai bagikan karya Anda dengan komunitas PTI sekarang!
                    </p>
                    
                    <a href="<?= site_url('/unggah') ?>"
                       class="bg-primary-600 text-white px-6 py-3 rounded-lg inline-flex items-center hover:bg-primary-700 transition-colors">
                        <i class="fas fa-cloud-upload-alt mr-2"></i>
                        Unggah Karya Pertama
                    </a>
                </div>
            </div>
        <?php else: ?>
            <!-- Works Grid -->
            <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 sm:mb-0">
                    Daftar Karya (<?= count($works) ?>)
                </h2>
                <div class="flex space-x-3">
                    <select onchange="sortWorks(this.value)" 
                            class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm">
                        <option value="newest">Terbaru</option>
                        <option value="oldest">Terlama</option>
                        <option value="title">Judul A-Z</option>
                        <option value="views">Paling Dilihat</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="works-grid">
                <?php foreach ($works as $work): ?>
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 work-card" 
                         data-date="<?= $work['created_at'] ?>" 
                         data-title="<?= esc($work['title']) ?>" 
                         data-views="<?= $work['views'] ?>">
                        <!-- Card Content -->
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden flex flex-col h-full">
                            <!-- Thumbnail -->
                            <div class="aspect-video overflow-hidden">
                                <?php if ($work['file_type'] === 'link' && strpos($work['external_link'], 'youtube.com') !== false): ?>
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
                                    // Get file type info using helper function
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
                                            class="w-full h-full object-cover <?= (empty($work['thumbnail']) && !$isImage) ? 'opacity-0' : '' ?>"
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
                            </div>

                            <!-- Category Badge -->
                            <div class="absolute top-3 right-3">
                                <span class="bg-black bg-opacity-70 text-white px-2 py-1 rounded text-xs font-medium">
                                    <?= esc($work['category_name']) ?>
                                </span>
                            </div>

                            <!-- Status Badge -->
                            <div class="absolute top-3 right-3">
                                <?php if ($work['status'] === 'published'): ?>
                                    <span class="bg-green-500 text-white px-2 py-1 rounded text-xs font-medium">
                                        <i class="fas fa-check mr-1"></i>Published
                                    </span>
                                <?php elseif ($work['status'] === 'draft'): ?>
                                    <span class="bg-yellow-500 text-white px-2 py-1 rounded text-xs font-medium">
                                        <i class="fas fa-edit mr-1"></i>Draft
                                    </span>
                                <?php else: ?>
                                    <span class="bg-gray-500 text-white px-2 py-1 rounded text-xs font-medium">
                                        <i class="fas fa-archive mr-1"></i>Archived
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-6">
                            <h3 class="font-bold text-lg text-gray-900 dark:text-white mb-2 line-clamp-2">
                                <?= esc($work['title']) ?>
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 line-clamp-3">
                                <?= esc(substr($work['description'], 0, 120)) ?>...
                            </p>

                            <!-- Stats -->
                            <div class="flex items-center justify-between mb-4 text-sm text-gray-500 dark:text-gray-400">
                                <div class="flex items-center space-x-4">
                                    <span class="flex items-center">
                                        <i class="fas fa-eye mr-1"></i>
                                        <?= number_format($work['views']) ?>
                                    </span>
                                    <span class="flex items-center">
                                        <i class="fas fa-calendar mr-1"></i>
                                        <?= $work['year'] ?>
                                    </span>
                                </div>
                                <span class="text-xs">
                                    <?= date('d M Y', strtotime($work['created_at'])) ?>
                                </span>
                            </div>

                            <!-- Actions -->
                            <div class="mt-4 flex justify-end space-x-2">
                                <a href="<?= site_url('/karya/' . $work['slug']) ?>" 
                                   class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition-colors">
                                    <i class="fas fa-eye mr-1.5"></i>
                                    Lihat
                                </a>
                                <a href="<?= site_url('/karya/edit/' . $work['id']) ?>" 
                                   class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition-colors">
                                    <i class="fas fa-edit mr-1.5"></i>
                                    Edit
                                </a>
                                <button onclick="confirmDelete(<?= $work['id'] ?>)"
                                        class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors">
                                    <i class="fas fa-trash mr-1.5"></i>
                                    Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Pagination -->
            <?= $pager->links('default', 'default_full') ?>
        <?php endif; ?>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full p-6">
        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">
            Konfirmasi Hapus
        </h3>
        <p class="text-gray-600 dark:text-gray-400 mb-6">
            Apakah Anda yakin ingin menghapus karya ini? Tindakan ini tidak dapat dibatalkan.
        </p>
        <div class="flex justify-end space-x-3">
            <button type="button" onclick="closeDeleteModal()"
                    class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg">
                Batal
            </button>
            <button id="confirmDeleteBtn" type="button"
                    class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg">
                Hapus Karya
            </button>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
let workToDelete = null;
const deleteModal = document.getElementById('deleteModal');

function confirmDelete(id) {
    workToDelete = id;
    deleteModal.classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
}

function closeDeleteModal() {
    deleteModal.classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
    workToDelete = null;
}

document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
    if (workToDelete) {
        deleteWork(workToDelete);
    }
});

function deleteWork(workId) {
    fetch(`<?= site_url('/karya/delete/') ?>${workId}`, {
        method: 'DELETE',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        closeDeleteModal();
        if (data.success) {
            // Show success message
            alert('Karya berhasil dihapus');
            // Reload the page
            window.location.reload();
        } else {
            // Show error message
            alert('Gagal menghapus karya: ' + (data.error || 'Terjadi kesalahan'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        closeDeleteModal();
        alert('Terjadi kesalahan saat menghapus karya');
    });
}

function sortWorks(sortBy) {
    const grid = document.getElementById('works-grid');
    const cards = Array.from(grid.querySelectorAll('.work-card'));
    
    cards.sort((a, b) => {
        switch(sortBy) {
            case 'newest':
                return new Date(b.dataset.date) - new Date(a.dataset.date);
            case 'oldest':
                return new Date(a.dataset.date) - new Date(b.dataset.date);
            case 'title':
                return a.dataset.title.localeCompare(b.dataset.title);
            case 'views':
                return parseInt(b.dataset.views) - parseInt(a.dataset.views);
            default:
                return 0;
        }
    });
    
    // Animate and reorder
    cards.forEach((card, index) => {
        card.style.order = index;
        card.style.animation = 'fadeIn 0.3s ease';
    });
}

function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `fixed top-20 right-4 z-50 px-4 py-3 rounded-lg shadow-lg max-w-md ${
        type === 'success' ? 'bg-green-100 border border-green-400 text-green-700' : 'bg-red-100 border border-red-400 text-red-700'
    }`;
    notification.innerHTML = `
        <div class="flex items-center">
            <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} mr-2"></i>
            <span>${message}</span>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-auto text-current hover:opacity-75">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.transition = 'opacity 0.5s';
        notification.style.opacity = '0';
        setTimeout(() => notification.remove(), 500);
    }, 5000);
}

// Close modal when clicking outside
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});

// CSS for animations
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
`;
document.head.appendChild(style);
</script>
<?= $this->endSection() ?>