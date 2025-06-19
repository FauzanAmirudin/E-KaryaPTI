<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="bg-white dark:bg-gray-900 min-h-screen">
    <!-- Header -->
    <div class="bg-gradient-to-r from-primary-600 to-primary-800 text-white py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl md:text-4xl font-bold mb-4">Edit Karya</h1>
            <p class="text-xl text-primary-100">
                Perbarui informasi karya "<?= esc($work['title']) ?>"
            </p>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <form action="<?= site_url('/karya/update/' . $work['id']) ?>" method="POST" enctype="multipart/form-data" 
              class="space-y-8" x-data="editForm()" @submit="handleSubmit">
            <?= csrf_field() ?>
            <!-- Hidden field for file_type -->
            <input type="hidden" name="file_type" value="<?= $work['file_type'] ?>">
            
            <!-- Basic Information -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">
                    <i class="fas fa-info-circle mr-2 text-primary-600"></i>
                    Informasi Dasar
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Title -->
                    <div class="md:col-span-2">
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Judul Karya <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="title" 
                               name="title" 
                               value="<?= esc($work['title']) ?>"
                               x-model="form.title"
                               required
                               maxlength="255"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <div class="flex justify-between mt-1">
                            <span class="text-xs text-gray-500 dark:text-gray-400">Minimal 5 karakter</span>
                            <span class="text-xs text-gray-500 dark:text-gray-400" x-text="form.title.length + '/255'"></span>
                        </div>
                    </div>

                    <!-- Category -->
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Kategori <span class="text-red-500">*</span>
                        </label>
                        <select id="category_id" 
                                name="category_id" 
                                x-model="form.category_id"
                                required
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            <option value="">Pilih Kategori</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= $category['id'] ?>" <?= $work['category_id'] == $category['id'] ? 'selected' : '' ?>>
                                    <?= esc($category['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Year -->
                    <div>
                        <label for="year" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Tahun Pembuatan <span class="text-red-500">*</span>
                        </label>
                        <select id="year" 
                                name="year" 
                                x-model="form.year"
                                required
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            <option value="">Pilih Tahun</option>
                            <?php foreach ($years as $year): ?>
                                <option value="<?= $year ?>" <?= $work['year'] == $year ? 'selected' : '' ?>>
                                    <?= $year ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Deskripsi <span class="text-red-500">*</span>
                        </label>
                        <textarea id="description" 
                                  name="description" 
                                  x-model="form.description"
                                  required
                                  rows="6"
                                  class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white resize-none"><?= esc($work['description']) ?></textarea>
                        <div class="flex justify-between mt-1">
                            <span class="text-xs text-gray-500 dark:text-gray-400">Minimal 10 karakter</span>
                            <span class="text-xs text-gray-500 dark:text-gray-400" x-text="form.description.length"></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Current Work Preview -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">
                    <i class="fas fa-eye mr-2 text-primary-600"></i>
                    Preview Karya Saat Ini
                </h2>

                <?php if ($work['file_type'] === 'file' && $work['file_path']): ?>
                    <?php 
                    $extension = pathinfo($work['file_path'], PATHINFO_EXTENSION);
                    $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                    ?>
                    
                    <div class="mb-4">
                        <?php if ($isImage && $work['thumbnail']): ?>
                            <img src="<?= site_url('uploads/thumbnails/' . $work['thumbnail']) ?>" 
                                 alt="<?= esc($work['title']) ?>"
                                 class="max-w-xs rounded-lg shadow-lg">
                        <?php else: ?>
                            <div class="flex items-center space-x-3 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg max-w-xs">
                                <i class="fas fa-file text-2xl text-gray-400"></i>
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white">File saat ini</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400"><?= strtoupper($extension) ?></p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                        <i class="fas fa-info-circle mr-1"></i>
                        Upload file baru jika ingin mengganti file yang ada
                    </p>

                <?php elseif ($work['file_type'] === 'link' && $work['external_link']): ?>
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 mb-4">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-external-link-alt text-primary-600 dark:text-primary-400"></i>
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">Link saat ini:</p>
                                <a href="<?= esc($work['external_link']) ?>" 
                                   target="_blank" 
                                   class="text-primary-600 dark:text-primary-400 hover:underline break-all">
                                    <?= esc($work['external_link']) ?>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Update Files -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">
                    <i class="fas fa-sync-alt mr-2 text-primary-600"></i>
                    Perbarui File/Link (Opsional)
                </h2>

                <?php if ($work['file_type'] === 'file'): ?>
                    <!-- File Upload -->
                    <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-8" 
                         x-data="fileUpload()">
                        <div class="text-center" x-show="!selectedFile">
                            <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-4"></i>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                                Upload File Baru (Opsional)
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-4">
                                Biarkan kosong jika tidak ingin mengubah file
                            </p>
                            <input type="file" 
                                   id="file" 
                                   name="file" 
                                   @change="handleFileSelect($event)"
                                   accept=".jpg,.jpeg,.png,.gif,.webp,.mp4,.avi,.mov,.pdf,.zip,.rar"
                                   class="hidden">
                            <label for="file" 
                                   class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-lg font-semibold cursor-pointer inline-block transition-colors">
                                Pilih File Baru
                            </label>
                        </div>

                        <!-- New File Preview -->
                        <div x-show="selectedFile" x-cloak class="text-center">
                            <div class="mb-4">
                                <div x-show="filePreview.type === 'image'">
                                    <img :src="filePreview.url" class="mx-auto max-h-48 rounded-lg shadow-lg">
                                </div>
                                <div x-show="filePreview.type === 'other'" class="text-center">
                                    <i :class="filePreview.icon" class="text-6xl text-gray-400 mb-4"></i>
                                </div>
                            </div>
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2" x-text="selectedFile.name"></h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4" x-text="formatFileSize(selectedFile.size)"></p>
                            <button type="button" 
                                    @click="removeFile()"
                                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                                <i class="fas fa-trash mr-2"></i>Hapus File
                            </button>
                        </div>
                    </div>

                <?php else: ?>
                    <!-- External Link Update -->
                    <div>
                        <label for="external_link" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Update URL Link (Opsional)
                        </label>
                        <input type="url" 
                               id="external_link" 
                               name="external_link" 
                               value="<?= esc($work['external_link']) ?>"
                               x-model="form.external_link"
                               placeholder="Masukkan URL baru atau biarkan kosong"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            Biarkan kosong jika tidak ingin mengubah link
                        </p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end space-x-4">
                <a href="<?= site_url('/karya/' . $work['slug']) ?>" 
                   class="px-6 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg font-semibold hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    Batal
                </a>
                <button type="submit" 
                        :disabled="!isFormValid() || isSubmitting"
                        :class="{ 'opacity-50 cursor-not-allowed': !isFormValid() || isSubmitting }"
                        class="px-8 py-3 bg-primary-600 hover:bg-primary-700 text-white rounded-lg font-semibold transition-colors inline-flex items-center">
                    <span x-show="!isSubmitting">
                        <i class="fas fa-save mr-2"></i>
                        Simpan Perubahan
                    </span>
                    <span x-show="isSubmitting" x-cloak>
                        <i class="fas fa-spinner fa-spin mr-2"></i>
                        Menyimpan...
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
function editForm() {
    return {
        form: {
            title: '<?= esc($work['title']) ?>',
            description: `<?= esc($work['description']) ?>`,
            category_id: '<?= $work['category_id'] ?>',
            year: '<?= $work['year'] ?>',
            external_link: '<?= esc($work['external_link'] ?? '') ?>'
        },
        isSubmitting: false,
        
        isFormValid() {
            return this.form.title.length >= 5 && 
                   this.form.description.length >= 10 && 
                   this.form.category_id && 
                   this.form.year;
        },
        
        handleSubmit(event) {
            if (!this.isFormValid()) {
                event.preventDefault();
                alert('Mohon lengkapi semua field yang diperlukan');
                return;
            }
            this.isSubmitting = true;
        }
    }
}

function fileUpload() {
    return {
        selectedFile: null,
        filePreview: {
            type: null,
            url: null,
            icon: null
        },
        
        handleFileSelect(event) {
            const files = event.target.files;
            if (files.length > 0) {
                this.processFile(files[0]);
            }
        },
        
        processFile(file) {
            if (file.size > 10 * 1024 * 1024) {
                alert('Ukuran file terlalu besar. Maksimal 10MB.');
                return;
            }
            
            this.selectedFile = file;
            this.generatePreview(file);
        },
        
        generatePreview(file) {
            const fileType = file.type;
            
            if (fileType.startsWith('image/')) {
                this.filePreview.type = 'image';
                this.filePreview.url = URL.createObjectURL(file);
            } else {
                this.filePreview.type = 'other';
                this.filePreview.icon = this.getFileIcon(file.name);
            }
        },
        
        getFileIcon(filename) {
            const extension = filename.split('.').pop().toLowerCase();
            const icons = {
                pdf: 'fas fa-file-pdf text-red-500',
                mp4: 'fas fa-file-video text-blue-500',
                avi: 'fas fa-file-video text-blue-500',
                mov: 'fas fa-file-video text-blue-500',
                zip: 'fas fa-file-archive text-yellow-500',
                rar: 'fas fa-file-archive text-yellow-500'
            };
            return icons[extension] || 'fas fa-file text-gray-500';
        },
        
        removeFile() {
            this.selectedFile = null;
            this.filePreview = { type: null, url: null, icon: null };
            document.getElementById('file').value = '';
            if (this.filePreview.url) {
                URL.revokeObjectURL(this.filePreview.url);
            }
        },
        
        formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }
    }
}
</script>
<?= $this->endSection() ?>