<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="bg-white dark:bg-gray-900 min-h-screen">
    <!-- Header -->
    <div class="bg-gradient-to-r from-primary-600 to-primary-800 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl md:text-4xl font-bold mb-4">Galeri Karya</h1>
            <p class="text-xl text-primary-100">
                Jelajahi koleksi lengkap karya mahasiswa Program Studi Pendidikan Teknologi Informasi
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
                    <!-- <button @click="resetFilters()" 
                            class="text-sm text-primary-600 dark:text-primary-400 hover:text-primary-800 dark:hover:text-primary-300 font-medium">
                        <i class="fas fa-undo mr-1"></i>Reset Filter
                    </button> -->
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
        renderWorkThumbnailJS(work) {
    // Jika file upload langsung dan tipe file adalah image (jpg, png, dll)
    if (work.file_type === 'file' && work.file_path) {
        const extension = work.file_path.split('.').pop().toLowerCase();
        const imageExts = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp'];
        const videoExts = ['mp4', 'avi', 'mov', 'wmv', 'webm', 'flv', 'mkv'];
        
        // Untuk gambar (poster, foto), tampilkan gambar asli
        if (imageExts.includes(extension)) {
            return `<img src="<?= base_url('uploads/') ?>${work.file_path}" 
                         alt="${work.title}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                         loading="lazy">`;
        }
        
        // Untuk video, tampilkan poster frame
        if (videoExts.includes(extension)) {
            return `<div class="w-full h-full bg-gray-900 flex items-center justify-center relative">
                        <video class="w-full h-full object-cover" preload="metadata" muted>
                            <source src="<?= base_url('uploads/') ?>${work.file_path}#t=1">
                        </video>
                        <div class="absolute inset-0 bg-black bg-opacity-20 flex items-center justify-center">
                            <i class="fas fa-play-circle text-white text-3xl opacity-80"></i>
                        </div>
                    </div>`;
        }
        
        // PDF preview
        if (extension === 'pdf') {
            return `<div class="w-full h-full flex items-center justify-center">
                        <img src="<?= base_url('assets/images/pdf-preview.jpg') ?>" 
                             alt="${work.title}"
                             class="w-full h-full object-cover"
                             loading="lazy">
                    </div>`;
        }
        
        // Document previews
        if (['doc', 'docx'].includes(extension)) {
            return `<div class="w-full h-full flex items-center justify-center">
                        <img src="<?= base_url('assets/images/doc-preview.jpg') ?>" 
                             alt="${work.title}"
                             class="w-full h-full object-cover"
                             loading="lazy">
                    </div>`;
        }
        
        if (['xls', 'xlsx'].includes(extension)) {
            return `<div class="w-full h-full flex items-center justify-center">
                        <img src="<?= base_url('assets/images/excel-preview.jpg') ?>" 
                             alt="${work.title}"
                             class="w-full h-full object-cover"
                             loading="lazy">
                    </div>`;
        }
        
        if (['ppt', 'pptx'].includes(extension)) {
            return `<div class="w-full h-full flex items-center justify-center">
                        <img src="<?= base_url('assets/images/ppt-preview.jpg') ?>" 
                             alt="${work.title}"
                             class="w-full h-full object-cover"
                             loading="lazy">
                    </div>`;
        }
    }
    
    // Jika ada thumbnail dan bukan file gambar, gunakan thumbnail
    if (work.thumbnail) {
        const imageExts = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp'];
        const hasImageFile = work.file_type === 'file' && work.file_path && imageExts.includes(work.file_path.split('.').pop().toLowerCase());
        
        // Jika bukan file gambar, gunakan thumbnail
        if (!hasImageFile) {
            return `<img src="<?= base_url('uploads/thumbnails/') ?>${work.thumbnail}" 
                         alt="${work.title}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                         loading="lazy">`;
        }
    }
    
    // Jika link eksternal
    if (work.file_type === 'link' && work.external_link) {
        return this.getLinkPreviewJS(work);
    }
    
    // Default placeholder
    return this.getWorkPlaceholderJS(work);
},

getWorkPlaceholderJS(work) {
    const categoryName = work.category_name.toLowerCase();
    const gradients = {
        'poster': 'from-purple-400 to-purple-600',
        'video': 'from-red-400 to-red-600',
        'pdf': 'from-red-500 to-red-700',
        'web': 'from-blue-400 to-blue-600',
        'foto': 'from-green-400 to-green-600',
        'aplikasi': 'from-indigo-400 to-indigo-600'
    };
    
    const icons = {
        'poster': 'fas fa-image',
        'video': 'fas fa-video',
        'pdf': 'fas fa-file-pdf',
        'web': 'fas fa-globe',
        'foto': 'fas fa-camera',
        'aplikasi': 'fas fa-mobile-alt'
    };
    
    const gradient = gradients[categoryName] || 'from-primary-400 to-primary-600';
    const icon = icons[categoryName] || 'fas fa-folder';
    
    return `<div class="w-full h-full bg-gradient-to-br ${gradient} flex flex-col items-center justify-center text-white">
                <i class="${icon} text-3xl mb-1"></i>
                <span class="text-xs font-medium text-center px-2 leading-tight">${work.category_name}</span>
            </div>`;
},

getLinkPreviewJS(work) {
    const url = work.external_link;
    
    if (url.includes('github.com')) {
        return `<div class="w-full h-full bg-gray-900 flex flex-col items-center justify-center text-white">
                    <i class="fab fa-github text-4xl mb-2"></i>
                    <span class="text-xs font-medium">GitHub</span>
                </div>`;
    }
    
    if (url.includes('youtube.com') || url.includes('youtu.be')) {
        const videoIdMatch = url.match(/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/);
        if (videoIdMatch) {
            const videoId = videoIdMatch[1];
            return `<div class="w-full h-full relative">
                        <img src="https://img.youtube.com/vi/${videoId}/maxresdefault.jpg" 
                             alt="${work.title}"
                             class="w-full h-full object-cover"
                             loading="lazy">
                        <div class="absolute inset-0 bg-black bg-opacity-20 flex items-center justify-center">
                            <i class="fab fa-youtube text-red-500 text-3xl"></i>
                        </div>
                    </div>`;
        }
    }
    
    if (url.includes('drive.google.com')) {
        return `<div class="w-full h-full bg-blue-500 flex flex-col items-center justify-center text-white">
                    <i class="fab fa-google-drive text-4xl mb-2"></i>
                    <span class="text-xs font-medium">Drive</span>
                </div>`;
    }
    
    const domain = new URL(url).hostname;
    return `<div class="w-full h-full bg-gradient-to-br from-blue-400 to-blue-600 flex flex-col items-center justify-center text-white">
                <i class="fas fa-external-link-alt text-3xl mb-1"></i>
                <span class="text-xs font-medium text-center px-2 leading-tight">${domain}</span>
            </div>`;
},
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
                console.log('Filter response data:', data);
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
            return `
                <div class="group bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    <div class="relative h-48 overflow-hidden">
                        ${this.renderWorkThumbnailJS(work)}
                        
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