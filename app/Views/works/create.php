<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="bg-white dark:bg-gray-900 min-h-screen">
    <!-- Header -->
    <div class="bg-gradient-to-r from-primary-600 to-primary-800 text-white py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl md:text-4xl font-bold mb-4">Unggah Karya Baru</h1>
            <p class="text-xl text-primary-100">
                Bagikan karya terbaik Anda dengan komunitas mahasiswa PTI
            </p>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <form action="<?= site_url('/karya/store') ?>" method="POST" enctype="multipart/form-data" 
              class="space-y-8" x-data="uploadForm()" @submit="handleSubmit">
            <?= csrf_field() ?>
            
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
                               x-model="form.title"
                               @input="updateCharCount('title')"
                               required
                               maxlength="255"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                               placeholder="Masukkan judul karya yang menarik...">
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
                                <option value="<?= $category['id'] ?>"><?= esc($category['name']) ?></option>
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
                                <option value="<?= $year ?>"><?= $year ?></option>
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
                                  @input="updateCharCount('description')"
                                  required
                                  rows="6"
                                  class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white resize-none"
                                  placeholder="Jelaskan karya Anda secara detail. Ceritakan tentang tujuan, proses pembuatan, teknologi yang digunakan, dll..."></textarea>
                        <div class="flex justify-between mt-1">
                            <span class="text-xs text-gray-500 dark:text-gray-400">Minimal 10 karakter</span>
                            <span class="text-xs text-gray-500 dark:text-gray-400" x-text="form.description.length"></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- File Upload Method -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">
                    <i class="fas fa-upload mr-2 text-primary-600"></i>
                    Metode Upload
                </h2>

                <div class="mb-4 p-4 bg-yellow-50 border-l-4 border-yellow-400 text-yellow-800">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm">
                                <strong>Petunjuk Upload:</strong> Anda dapat memilih untuk mengunggah file langsung atau menggunakan link eksternal. 
                                Untuk file video, disarankan menggunakan link eksternal (YouTube, Google Drive, dll) karena ukuran file biasanya besar.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Upload Type Selection -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <label class="relative cursor-pointer">
                        <input type="radio" 
                               name="file_type" 
                               value="file" 
                               x-model="form.file_type"
                               class="sr-only peer">
                        <div class="p-6 border-2 border-gray-300 dark:border-gray-600 rounded-xl peer-checked:border-primary-500 peer-checked:bg-primary-50 dark:peer-checked:bg-primary-900 transition-all">
                            <div class="text-center">
                                <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 peer-checked:text-primary-600 mb-3"></i>
                                <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Unggah File</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    Upload file dari komputer Anda (gambar, video, PDF, dll)
                                </p>
                            </div>
                        </div>
                    </label>

                    <label class="relative cursor-pointer">
                        <input type="radio" 
                               name="file_type" 
                               value="link" 
                               x-model="form.file_type"
                               class="sr-only peer">
                        <div class="p-6 border-2 border-gray-300 dark:border-gray-600 rounded-xl peer-checked:border-primary-500 peer-checked:bg-primary-50 dark:peer-checked:bg-primary-900 transition-all">
                            <div class="text-center">
                                <i class="fas fa-external-link-alt text-3xl text-gray-400 peer-checked:text-primary-600 mb-3"></i>
                                <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Link Eksternal</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    Masukkan link ke GitHub, demo website, YouTube, dll
                                </p>
                            </div>
                        </div>
                    </label>
                </div>

                <!-- File Upload Section -->
                <div x-show="form.file_type === 'file'" x-cloak>
                    <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-8" 
                         x-data="fileUpload()"
                         @drop.prevent="handleDrop($event)"
                         @dragover.prevent
                         @dragenter.prevent
                         :class="{ 'border-primary-500 bg-primary-50 dark:bg-primary-900': isDragging }"
                         @dragenter="isDragging = true"
                         @dragleave="isDragging = false"
                         @drop="isDragging = false">
                        
                        <div class="text-center" x-show="!selectedFile">
                            <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-4"></i>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                                Drag & Drop File atau Klik untuk Browse
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-4">
                                Mendukung: JPG, PNG, PDF, MP4, ZIP (Maksimal 10MB)
                            </p>
                            <input type="file" 
                                   id="file" 
                                   name="file" 
                                   @change="handleFileSelect($event)"
                                   accept=".jpg,.jpeg,.png,.gif,.webp,.mp4,.avi,.mov,.pdf,.zip,.rar"
                                   class="hidden">
                            <label for="file" 
                                   class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-lg font-semibold cursor-pointer inline-block transition-colors">
                                Pilih File
                            </label>
                        </div>

                        <!-- File Preview -->
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

                        <!-- Upload Progress -->
                        <div x-show="uploadProgress > 0 && uploadProgress < 100" x-cloak class="mt-4">
                            <div class="bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                <div class="bg-primary-600 h-2 rounded-full transition-all duration-300" 
                                     :style="`width: ${uploadProgress}%`"></div>
                            </div>
                            <p class="text-center text-sm text-gray-600 dark:text-gray-400 mt-2" x-text="`Uploading... ${uploadProgress}%`"></p>
                        </div>
                    </div>
                </div>

                <!-- External Link Section -->
                <div x-show="form.file_type === 'link'" x-cloak>
                    <div class="space-y-4">
                        <div>
                            <label for="external_link" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                URL Link <span class="text-red-500">*</span>
                            </label>
                            <input type="url" 
                                   id="external_link" 
                                   name="external_link" 
                                   x-model="form.external_link"
                                   placeholder="https://github.com/username/project atau https://demo.website.com"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        </div>
                        
                        <!-- Link Preview -->
                        <div x-show="form.external_link && isValidUrl(form.external_link)" x-cloak 
                             class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <div class="flex items-center space-x-3">
                                <i class="fas fa-external-link-alt text-primary-600 dark:text-primary-400"></i>
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white">Link Preview</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 break-all" x-text="form.external_link"></p>
                                </div>
                            </div>
                        </div>

                        <!-- Common Link Types -->
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                            <button type="button" 
                                    @click="setLinkTemplate('github')"
                                    class="p-3 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors text-center">
                                <i class="fab fa-github text-xl mb-1"></i>
                                <p class="text-xs text-gray-600 dark:text-gray-400">GitHub</p>
                            </button>
                            <button type="button" 
                                    @click="setLinkTemplate('demo')"
                                    class="p-3 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors text-center">
                                <i class="fas fa-globe text-xl mb-1"></i>
                                <p class="text-xs text-gray-600 dark:text-gray-400">Demo Web</p>
                            </button>
                            <button type="button" 
                                    @click="setLinkTemplate('youtube')"
                                    class="p-3 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors text-center">
                                <i class="fab fa-youtube text-xl mb-1 text-red-500"></i>
                                <p class="text-xs text-gray-600 dark:text-gray-400">YouTube</p>
                            </button>
                            <button type="button" 
                                    @click="setLinkTemplate('drive')"
                                    class="p-3 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors text-center">
                                <i class="fab fa-google-drive text-xl mb-1 text-blue-500"></i>
                                <p class="text-xs text-gray-600 dark:text-gray-400">G-Drive</p>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex flex-wrap gap-3 justify-end">
                <a href="<?= site_url('/galeri') ?>"
                   class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg transition-colors">
                    Batal
                </a>
                <button type="submit"
                        class="px-6 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition-colors">
                    <i class="fas fa-save mr-2"></i>Simpan Karya
                </button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
function uploadForm() {
    return {
        form: {
            title: '',
            description: '',
            category_id: '',
            year: '',
            file_type: 'file',
            external_link: ''
        },
        isSubmitting: false,
        
        updateCharCount(field) {
            // Character count is handled by x-text in template
        },
        
        isFormValid() {
            const basic = this.form.title.length >= 5 && 
                         this.form.description.length >= 10 && 
                         this.form.category_id && 
                         this.form.year;
            
            if (this.form.file_type === 'file') {
                // Jika external link diisi, tidak perlu file
                if (this.form.external_link && this.isValidUrl(this.form.external_link)) {
                    return basic;
                }
                // Jika tidak ada external link, perlu file
                return basic && document.getElementById('file').files.length > 0;
            } else {
                // Jika tipe file link, perlu external_link
                return basic && this.form.external_link && this.isValidUrl(this.form.external_link);
            }
        },
        
        isValidUrl(string) {
            try {
                new URL(string);
                return true;
            } catch (_) {
                return false;
            }
        },
        
        setLinkTemplate(type) {
            const templates = {
                github: 'https://github.com/username/repository',
                demo: 'https://your-demo-website.com',
                youtube: 'https://www.youtube.com/watch?v=VIDEO_ID',
                drive: 'https://drive.google.com/file/d/FILE_ID/view'
            };
            this.form.external_link = templates[type] || '';
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
        isDragging: false,
        uploadProgress: 0,
        
        handleDrop(event) {
            const files = event.dataTransfer.files;
            if (files.length > 0) {
                this.processFile(files[0]);
            }
        },
        
        handleFileSelect(event) {
            const files = event.target.files;
            if (files.length > 0) {
                this.processFile(files[0]);
            }
        },
        
        processFile(file) {
            // Validate file size (10MB)
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