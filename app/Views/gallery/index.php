<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="bg-white dark:bg-gray-900 min-h-screen">
    <!-- Header -->
    <div class="bg-gradient-to-r from-primary-600 to-primary-800 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl md:text-4xl font-bold mb-4">Galeri Karya</h1>
            <p class="text-xl text-primary-100">
                Jelajahi koleksi lengkap karya mahasiswa Program Teknologi Informasi
            </p>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="bg-gray-50 dark:bg-gray-800 border-b dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4" x-data="galleryFilters()">
                <!-- Search -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Cari Karya
                    </label>
                    <div class="relative">
                        <input type="text" 
                               x-model="filters.search"
                               @input.debounce.500ms="applyFilters()"
                               placeholder="Cari judul atau nama pencipta..."
                               class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                </div>

                <!-- Category Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Kategori
                    </label>
                    <select x-model="filters.category" 
                            @change="applyFilters()"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <option value="">Semua Kategori</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['slug'] ?>" <?= $filters['category'] === $category['slug'] ? 'selected' : '' ?>>
                                <?= esc($category['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Year Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Tahun
                    </label>
                    <select x-model="filters.year" 
                            @change="applyFilters()"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <option value="">Semua Tahun</option>
                        <?php foreach ($years as $year): ?>
                            <option value="<?= $year ?>" <?= $filters['year'] == $year ? 'selected' : '' ?>>
                                <?= $year ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- Sort & View Options -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-2">
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Urutkan:</label>
                        <select x-model="filters.order_by" 
                                @change="applyFilters()"
                                class="px-3 py-1 border border-gray-300 dark:border-gray-600 rounded focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm">
                            <option value="created_at">Terbaru</option>
                            <option value="title">Judul A-Z</option>
                            <option value="views">Paling Dilihat</option>
                            <option value="year">Tahun</option>
                        </select>
                    </div>
                    <button @click="resetFilters()" 
                            class="text-sm text-primary-600 dark:text-primary-400 hover:text-primary-800 dark:hover:text-primary-300 font-medium">
                        <i class="fas fa-undo mr-1"></i>Reset Filter
                    </button>
                </div>
                
                <div class="flex items-center space-x-2 mt-4 sm:mt-0">
                    <span class="text-sm text-gray-600 dark:text-gray-400" id="results-count">
                        Menampilkan <?= count($works) ?> karya
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Works Grid -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div id="works-container">
            <?= $this->include('gallery/works_grid', ['works' => $works]) ?>
        </div>

        <!-- Loading State -->
        <div id="loading-state" class="hidden text-center py-8">
            <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-primary-600"></div>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Memuat karya...</p>
        </div>

        <!-- Pagination -->
        <div id="pagination-container" class="mt-8">
            <?= $pager->links('default', 'default_full') ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
function galleryFilters() {
    return {
        filters: {
            search: '<?= $filters['search'] ?? '' ?>',
            category: '<?= $filters['category'] ?? '' ?>',
            year: '<?= $filters['year'] ?? '' ?>',
            order_by: '<?= $filters['order_by'] ?? 'created_at' ?>',
            order_dir: '<?= $filters['order_dir'] ?? 'DESC' ?>'
        },
        
        applyFilters() {
            this.showLoading();
            
            const params = new URLSearchParams();
            Object.keys(this.filters).forEach(key => {
                if (this.filters[key]) {
                    params.append(key, this.filters[key]);
                }
            });
            
            fetch(`<?= site_url('/galeri/filter') ?>?${params.toString()}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('works-container').innerHTML = this.renderWorksGrid(data.works);
                document.getElementById('pagination-container').innerHTML = data.pagination || '';
                document.getElementById('results-count').textContent = `Menampilkan ${data.works.length} dari ${data.total} karya`;
                
                // Update URL without page reload
                const url = new URL(window.location);
                Object.keys(this.filters).forEach(key => {
                    if (this.filters[key]) {
                        url.searchParams.set(key, this.filters[key]);
                    } else {
                        url.searchParams.delete(key);
                    }
                });
                window.history.pushState({}, '', url);
            })
            .catch(error => {
                console.error('Error:', error);
            })
            .finally(() => {
                this.hideLoading();
            });
        },
        
        resetFilters() {
            this.filters = {
                search: '',
                category: '',
                year: '',
                order_by: 'created_at',
                order_dir: 'DESC'
            };
            this.applyFilters();
        },
        
        showLoading() {
            document.getElementById('loading-state').classList.remove('hidden');
            document.getElementById('works-container').style.opacity = '0.5';
        },
        
        hideLoading() {
            document.getElementById('loading-state').classList.add('hidden');
            document.getElementById('works-container').style.opacity = '1';
        },
        
        renderWorksGrid(works) {
            if (works.length === 0) {
                return `
                    <div class="text-center py-12">
                        <i class="fas fa-search text-6xl text-gray-300 dark:text-gray-600 mb-4"></i>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Tidak ada karya ditemukan</h3>
                        <p class="text-gray-600 dark:text-gray-400">Coba ubah filter pencarian Anda</p>
                    </div>
                `;
            }
            
            return `
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    ${works.map(work => this.renderWorkCard(work)).join('')}
                </div>
            `;
        },
        
        renderWorkCard(work) {
            // Handle thumbnail display
            let thumbnailUrl = work.thumbnail
                ? `<?= site_url('uploads/thumbnails/') ?>${work.thumbnail}`
                : '<?= site_url('assets/images/no-image.jpg') ?>';
            
            // If YouTube link, use YouTube thumbnail
            if (work.external_link && work.external_link.includes('youtube.com')) {
                const params = new URLSearchParams(new URL(work.external_link).search);
                const videoId = params.get('v');
                if (videoId) {
                    thumbnailUrl = `https://img.youtube.com/vi/${videoId}/mqdefault.jpg`;
                }
            }

            return `
                <div class="group bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    <div class="relative h-48 overflow-hidden">
                        <img src="${thumbnailUrl}" 
                             alt="${work.title}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                             onerror="this.src='<?= site_url('assets/images/no-image.jpg') ?>'">
                        
                        <div class="absolute top-3 left-3">
                            <span class="bg-black bg-opacity-70 text-white px-2 py-1 rounded text-xs font-medium">
                                ${work.category_name}
                            </span>
                        </div>
                        
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-all duration-300 flex items-center justify-center">
                            <a href="<?= site_url('karya/') ?>${work.slug}" 
                               class="bg-white text-gray-900 px-4 py-2 rounded-lg font-semibold opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0 transition-all duration-300">
                                <i class="fas fa-eye mr-2"></i>Lihat Detail
                            </a>
                        </div>
                    </div>
                    
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-2 line-clamp-2">
                            ${work.title}
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-3 line-clamp-2">
                            ${work.description.substring(0, 100)}...
                        </p>
                        
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <div class="w-6 h-6 bg-primary-600 rounded-full flex items-center justify-center">
                                    <span class="text-white text-xs font-medium">
                                        ${work.user_name.charAt(0).toUpperCase()}
                                    </span>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-900 dark:text-white">
                                        ${work.user_name}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        ${work.year}
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center text-gray-500 dark:text-gray-400 text-xs">
                                <i class="fas fa-eye mr-1"></i>
                                ${work.views.toLocaleString()}
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }
    }
}
</script>
<?= $this->endSection() ?>