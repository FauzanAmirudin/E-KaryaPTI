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
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6" id="works-grid">
            <?php foreach ($works as $work): ?>
                <div class="group bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1 work-card" 
                     data-date="<?= $work['created_at'] ?>" 
                     data-title="<?= esc($work['title']) ?>" 
                     data-views="<?= $work['views'] ?>">
                    <!-- Thumbnail -->
                    <div class="relative h-48 overflow-hidden">
                        <?= renderWorkThumbnail($work, 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-300') ?>
                        
                        <!-- Category Badge -->
                        <div class="absolute top-3 left-3">
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
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-2 line-clamp-2">
                            <?= esc($work['title']) ?>
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-3 line-clamp-2">
                            <?= esc(substr($work['description'], 0, 100)) ?>...
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
                        <div class="flex space-x-2">
                            <a href="<?= base_url('/karya/' . $work['slug']) ?>" 
                               class="flex-1 bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg font-medium transition-colors text-center text-sm">
                                <i class="fas fa-eye mr-1"></i>Lihat
                            </a>
                            <a href="<?= base_url('/karya/edit/' . $work['id']) ?>" 
                               class="flex-1 bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors text-center text-sm">
                                <i class="fas fa-edit mr-1"></i>Edit
                            </a>
                            <button onclick="confirmDelete(<?= $work['id'] ?>)"
                                    class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-lg font-medium transition-colors text-sm">
                                <i class="fas fa-trash"></i>
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
    // Get CSRF token from meta tag
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    const csrfHeader = document.querySelector('meta[name="csrf-header"]')?.getAttribute('content') || 'X-CSRF-TOKEN';
    
    fetch(`<?= site_url('/karya/delete/') ?>${workId}`, {
        method: 'DELETE',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Content-Type': 'application/json',
            [csrfHeader]: csrfToken
        }
    })
    .then(response => response.json())
    .then(data => {
        closeDeleteModal();
        if (data.success) {
            // Show success message
            showNotification('Karya berhasil dihapus', 'success');
            // Reload the page after a short delay
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        } else {
            // Show error message
            showNotification('Gagal menghapus karya: ' + (data.error || 'Terjadi kesalahan'), 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        closeDeleteModal();
        showNotification('Terjadi kesalahan saat menghapus karya', 'error');
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