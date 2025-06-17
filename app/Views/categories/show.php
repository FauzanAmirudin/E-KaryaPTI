<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="bg-white dark:bg-gray-900 min-h-screen">
    <!-- Breadcrumb -->
    <div class="bg-gray-50 dark:bg-gray-800 border-b dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <nav class="flex items-center space-x-2 text-sm">
                <a href="<?= base_url('/') ?>" class="text-gray-500 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400">
                    Beranda
                </a>
                <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                <a href="<?= base_url('/kategori') ?>" class="text-gray-500 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400">
                    Kategori
                </a>
                <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                <span class="text-gray-900 dark:text-white font-medium">
                    <?= esc($category['name']) ?>
                </span>
            </nav>
        </div>
    </div>

    <!-- Category Header -->
    <div class="bg-gradient-to-r from-primary-600 to-primary-800 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center space-y-6 md:space-y-0 md:space-x-8">
                <div class="w-24 h-24 bg-white bg-opacity-20 rounded-2xl flex items-center justify-center">
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
                    <i class="<?= $icon ?> text-4xl text-white"></i>
                </div>
                <div class="text-center md:text-left flex-1">
                    <h1 class="text-4xl md:text-5xl font-bold mb-4">
                        Kategori <?= esc($category['name']) ?>
                    </h1>
                    <p class="text-xl text-primary-100 mb-4">
                        <?= esc($category['description'] ?? 'Koleksi karya ' . strtolower($category['name']) . ' dari mahasiswa PTI') ?>
                    </p>
                    <div class="flex flex-col sm:flex-row items-center space-y-2 sm:space-y-0 sm:space-x-6 text-primary-200">
                        <span class="flex items-center">
                            <i class="fas fa-folder-open mr-2"></i>
                            <?= count($works) ?> Karya Ditampilkan
                        </span>
                        <span class="flex items-center">
                            <i class="fas fa-users mr-2"></i>
                            Dari Mahasiswa PTI
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-gray-50 dark:bg-gray-800 border-b dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col md:flex-row gap-4" x-data="categoryFilters()">
                <!-- Search -->
                <div class="flex-1">
                    <div class="relative">
                        <input type="text" 
                               x-model="filters.search"
                               @input.debounce.500ms="applyFilters()"
                               placeholder="Cari dalam kategori <?= esc($category['name']) ?>..."
                               class="w-full pl-10 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <i class="fas fa-search absolute left-3 top-4 text-gray-400"></i>
                    </div>
                </div>

                <!-- Year Filter -->
                <div class="w-full md:w-48">
                    <select x-model="filters.year" 
                            @change="applyFilters()"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <option value="">Semua Tahun</option>
                        <?php foreach ($years as $year): ?>
                            <option value="<?= $year ?>" <?= $filters['year'] == $year ? 'selected' : '' ?>>
                                <?= $year ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Sort -->
                <div class="w-full md:w-48">
                    <select x-model="filters.order_by" 
                            @change="applyFilters()"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <option value="created_at">Terbaru</option>
                        <option value="title">Judul A-Z</option>
                        <option value="views">Paling Dilihat</option>
                        <option value="year">Tahun</option>
                    </select>
                </div>

                <!-- Reset -->
                <button @click="resetFilters()" 
                        class="px-6 py-3 text-primary-600 dark:text-primary-400 hover:text-primary-800 dark:hover:text-primary-300 font-medium whitespace-nowrap">
                    <i class="fas fa-undo mr-2"></i>Reset
                </button>
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

    <!-- Related Categories -->
    <div class="bg-gray-50 dark:bg-gray-800 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-8 text-center">
                Kategori Lainnya
            </h2>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                <?php 
                // Get other categories (this would need to be passed from controller)
                $otherCategories = array_filter($categories ?? [], function($cat) use ($category) {
                    return $cat['id'] !== $category['id'];
                });
                ?>
                <?php foreach (array_slice($otherCategories, 0, 6) as $otherCategory): ?>
                    <a href="<?= base_url('/kategori/' . $otherCategory['slug']) ?>" 
                       class="group bg-white dark:bg-gray-900 rounded-lg p-4 text-center hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                        <div class="w-12 h-12 bg-primary-100 dark:bg-primary-900 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:bg-primary-200 dark:group-hover:bg-primary-800 transition-colors">
                            <?php
                            $icon = $icons[strtolower($otherCategory['name'])] ?? 'fas fa-folder';
                            ?>
                            <i class="<?= $icon ?> text-primary-600 dark:text-primary-400"></i>
                        </div>
                        <h3 class="font-medium text-gray-900 dark:text-white text-sm mb-1">
                            <?= esc($otherCategory['name']) ?>
                        </h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            <?= $otherCategory['works_count'] ?> karya
                        </p>
                    </a>
                <?php endforeach; ?>
            </div>
            
            <div class="text-center mt-8">
                <a href="<?= base_url('/kategori') ?>" 
                   class="inline-flex items-center text-primary-600 dark:text-primary-400 hover:text-primary-800 dark:hover:text-primary-300 font-medium">
                    Lihat Semua Kategori
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
function categoryFilters() {
    return {
        filters: {
            search: '<?= $filters['search'] ?? '' ?>',
            year: '<?= $filters['year'] ?? '' ?>',
            order_by: '<?= $filters['order_by'] ?? 'created_at' ?>',
            order_dir: '<?= $filters['order_dir'] ?? 'DESC' ?>'
        },
        
        applyFilters() {
            this.showLoading();
            
            const params = new URLSearchParams();
            params.append('category', '<?= $category['slug'] ?>');
            Object.keys(this.filters).forEach(key => {
                if (this.filters[key]) {
                    params.append(key, this.filters[key]);
                }
            });
            
            fetch(`<?= base_url('/galeri/filter') ?>?${params.toString()}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('works-container').innerHTML = this.renderWorksGrid(data.works);
                document.getElementById('pagination-container').innerHTML = data.pagination || '';
                
                // Update URL
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
            const thumbnailUrl = work.thumbnail 
                ? `<?= base_url('uploads/thumbnails/') ?>${work.thumbnail}`
                : `<?= base_url('assets/images/no-image.jpg') ?>`;
                
            return `
                <div class="group bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    <div class="relative h-48 overflow-hidden">
                        <img src="${thumbnailUrl}" 
                             alt="${work.title}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                             onerror="this.src='<?= base_url('assets/images/no-image.jpg') ?>'">
                        
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-all duration-300 flex items-center justify-center">
                            <a href="<?= base_url('/karya/') ?>${work.slug}" 
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