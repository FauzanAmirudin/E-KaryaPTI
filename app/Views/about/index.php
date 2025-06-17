<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="bg-white dark:bg-gray-900 min-h-screen">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-primary-600 to-primary-800 text-white py-20">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-6">
                Tentang eKarya PTI
            </h1>
            <p class="text-xl text-primary-100 leading-relaxed">
                Platform digital untuk mengapresiasi dan berbagi karya inovatif mahasiswa Program Teknologi Informasi
            </p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <!-- Vision & Mission -->
        <div class="mb-16">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                    Visi & Misi
                </h2>
                <div class="w-24 h-1 bg-primary-600 mx-auto"></div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Vision -->
                <div class="bg-gradient-to-br from-primary-50 to-primary-100 dark:from-primary-900 dark:to-primary-800 rounded-2xl p-8">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-primary-600 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-eye text-white text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Visi</h3>
                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                            Menjadi platform terdepan dalam mengapresiasi dan mempromosikan karya inovatif mahasiswa 
                            Program Teknologi Informasi untuk mendukung pengembangan talenta digital Indonesia.
                        </p>
                    </div>
                </div>

                <!-- Mission -->
                <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900 dark:to-green-800 rounded-2xl p-8">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-green-600 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-target text-white text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Misi</h3>
                        <ul class="text-gray-700 dark:text-gray-300 text-left space-y-2">
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-600 mt-1 mr-3"></i>
                                Menyediakan platform showcase karya mahasiswa PTI
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-600 mt-1 mr-3"></i>
                                Memfasilitasi kolaborasi dan pembelajaran
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-600 mt-1 mr-3"></i>
                                Mendorong inovasi teknologi informasi
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- About Platform -->
        <div class="mb-16">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-8 text-center">
                Tentang Platform
            </h2>
            
            <div class="prose prose-lg dark:prose-invert max-w-none">
                <p class="text-gray-700 dark:text-gray-300 leading-relaxed mb-6">
                    eKarya PTI adalah platform digital yang dikembangkan khusus untuk mahasiswa Program Teknologi Informasi 
                    sebagai wadah untuk memamerkan, berbagi, dan mengapresiasi karya-karya inovatif yang telah dibuat selama 
                    perjalanan akademik mereka.
                </p>
                
                <p class="text-gray-700 dark:text-gray-300 leading-relaxed mb-6">
                    Platform ini mendukung berbagai jenis karya mulai dari poster desain, video presentasi, dokumen penelitian, 
                    aplikasi web, aplikasi mobile, hingga karya fotografi. Setiap karya dapat diunggah dengan deskripsi lengkap 
                    dan dikategorikan untuk memudahkan pencarian dan eksplorasi.
                </p>

                <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                    Melalui eKarya PTI, mahasiswa dapat membangun portofolio digital, mendapatkan apresiasi dari komunitas, 
                    serta menginspirasi mahasiswa lainnya untuk terus berkarya dan berinovasi di bidang teknologi informasi.
                </p>
            </div>
        </div>

        <!-- Features -->
        <div class="mb-16">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-12 text-center">
                Fitur Platform
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="text-center p-6 bg-gray-50 dark:bg-gray-800 rounded-xl">
                    <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-upload text-blue-600 dark:text-blue-400 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Upload Mudah</h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        Upload karya dengan mudah, mendukung berbagai format file dan link eksternal
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="text-center p-6 bg-gray-50 dark:bg-gray-800 rounded-xl">
                    <div class="w-16 h-16 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-search text-green-600 dark:text-green-400 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Pencarian Canggih</h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        Cari karya berdasarkan kategori, tahun, atau kata kunci dengan sistem filter yang lengkap
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="text-center p-6 bg-gray-50 dark:bg-gray-800 rounded-xl">
                    <div class="w-16 h-16 bg-purple-100 dark:bg-purple-900 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-users text-purple-600 dark:text-purple-400 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Komunitas</h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        Bergabung dengan komunitas mahasiswa PTI dan saling menginspirasi
                    </p>
                </div>

                <!-- Feature 4 -->
                <div class="text-center p-6 bg-gray-50 dark:bg-gray-800 rounded-xl">
                    <div class="w-16 h-16 bg-red-100 dark:bg-red-900 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-chart-line text-red-600 dark:text-red-400 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Statistik</h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        Pantau performa karya dengan statistik views dan engagement
                    </p>
                </div>

                <!-- Feature 5 -->
                <div class="text-center p-6 bg-gray-50 dark:bg-gray-800 rounded-xl">
                    <div class="w-16 h-16 bg-yellow-100 dark:bg-yellow-900 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-mobile-alt text-yellow-600 dark:text-yellow-400 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Responsive</h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        Akses platform dari perangkat apapun dengan tampilan yang optimal
                    </p>
                </div>

                <!-- Feature 6 -->
                <div class="text-center p-6 bg-gray-50 dark:bg-gray-800 rounded-xl">
                    <div class="w-16 h-16 bg-indigo-100 dark:bg-indigo-900 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-shield-alt text-indigo-600 dark:text-indigo-400 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Aman</h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        Sistem keamanan yang terjamin untuk melindungi karya dan data pengguna
                    </p>
                </div>
            </div>
        </div>

        <!-- Development Goals -->
        <div class="mb-16">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-8 text-center">
                Tujuan Pengembangan
            </h2>
            
            <div class="bg-gradient-to-r from-primary-50 to-primary-100 dark:from-primary-900 dark:to-primary-800 rounded-2xl p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                            <i class="fas fa-lightbulb text-primary-600 mr-2"></i>
                            Mendorong Inovasi
                        </h3>
                        <p class="text-gray-700 dark:text-gray-300 mb-6">
                            Memberikan wadah bagi mahasiswa untuk mengekspresikan kreativitas dan inovasi 
                            dalam bidang teknologi informasi.
                        </p>
                        
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                            <i class="fas fa-handshake text-primary-600 mr-2"></i>
                            Membangun Kolaborasi
                        </h3>
                        <p class="text-gray-700 dark:text-gray-300">
                            Memfasilitasi kolaborasi antar mahasiswa melalui sharing karya dan ide-ide kreatif.
                        </p>
                    </div>
                    
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                            <i class="fas fa-graduation-cap text-primary-600 mr-2"></i>
                            Mendukung Pembelajaran
                        </h3>
                        <p class="text-gray-700 dark:text-gray-300 mb-6">
                            Menjadi sumber inspirasi dan pembelajaran bagi mahasiswa dari karya-karya yang telah dibuat.
                        </p>
                        
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                            <i class="fas fa-trophy text-primary-600 mr-2"></i>
                            Membangun Portofolio
                        </h3>
                        <p class="text-gray-700 dark:text-gray-300">
                            Membantu mahasiswa membangun portofolio digital yang dapat digunakan untuk karir masa depan.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="mb-16">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-12 text-center">
                Hubungi Kami
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Email -->
                <div class="text-center p-6 bg-white dark:bg-gray-800 rounded-xl shadow-lg">
                    <div class="w-16 h-16 bg-primary-100 dark:bg-primary-900 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-envelope text-primary-600 dark:text-primary-400 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Email</h3>
                    <a href="mailto:pti@university.ac.id" class="text-primary-600 dark:text-primary-400 hover:underline">
                        pti@university.ac.id
                    </a>
                </div>

                <!-- Phone -->
                <div class="text-center p-6 bg-white dark:bg-gray-800 rounded-xl shadow-lg">
                    <div class="w-16 h-16 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-phone text-green-600 dark:text-green-400 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Telepon</h3>
                    <p class="text-gray-600 dark:text-gray-400">+62 21 1234 5678</p>
                </div>

                <!-- Address -->
                <div class="text-center p-6 bg-white dark:bg-gray-800 rounded-xl shadow-lg">
                    <div class="w-16 h-16 bg-red-100 dark:bg-red-900 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-map-marker-alt text-red-600 dark:text-red-400 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Alamat</h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        Jl. Pendidikan No. 123<br>
                        Jakarta, Indonesia
                    </p>
                </div>
            </div>
        </div>

        <!-- Development Team -->
        <div class="text-center">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">
                Tim Pengembang
            </h2>
            
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-700 rounded-2xl p-8">
                <p class="text-gray-700 dark:text-gray-300 mb-6">
                    Platform eKarya PTI dikembangkan oleh mahasiswa Program Teknologi Informasi 
                    dengan dukungan dari dosen dan staff akademik.
                </p>
                
                <div class="flex flex-wrap justify-center gap-4">
                    <span class="bg-primary-100 dark:bg-primary-900 text-primary-800 dark:text-primary-200 px-4 py-2 rounded-full text-sm font-medium">
                        Web Development
                    </span>
                    <span class="bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 px-4 py-2 rounded-full text-sm font-medium">
                        UI/UX Design
                    </span>
                    <span class="bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 px-4 py-2 rounded-full text-sm font-medium">
                        Database Design
                    </span>
                    <span class="bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200 px-4 py-2 rounded-full text-sm font-medium">
                        System Analysis
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-primary-600 py-16">
        <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-white mb-4">
                Siap Bergabung dengan Komunitas?
            </h2>
            <p class="text-xl text-primary-100 mb-8">
                Mulai bagikan karya terbaik Anda dan bergabung dengan komunitas mahasiswa PTI
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <?php if (session()->get('is_logged_in')): ?>
                    <a href="<?= base_url('/unggah') ?>" 
                       class="bg-white text-primary-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors inline-flex items-center justify-center">
                        <i class="fas fa-plus mr-2"></i>
                        Unggah Karya Sekarang
                    </a>
                    <a href="<?= base_url('/galeri') ?>" 
                       class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-primary-600 transition-colors inline-flex items-center justify-center">
                        <i class="fas fa-images mr-2"></i>
                        Jelajahi Galeri
                    </a>
                <?php else: ?>
                    <a href="<?= base_url('/register') ?>" 
                       class="bg-white text-primary-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors inline-flex items-center justify-center">
                        <i class="fas fa-user-plus mr-2"></i>
                        Daftar Sekarang
                    </a>
                    <a href="<?= base_url('/galeri') ?>" 
                       class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-primary-600 transition-colors inline-flex items-center justify-center">
                        <i class="fas fa-images mr-2"></i>
                        Lihat Galeri
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>