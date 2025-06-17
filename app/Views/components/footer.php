<footer class="bg-gray-900 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Logo & Description -->
            <div class="col-span-1 md:col-span-2">
                <div class="flex items-center space-x-2 mb-4">
                    <div class="w-8 h-8 bg-primary-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-graduation-cap text-white text-sm"></i>
                    </div>
                    <span class="text-xl font-bold">eKarya PTI</span>
                </div>
                <p class="text-gray-300 mb-4 max-w-md">
                    Platform galeri karya mahasiswa Program Teknologi Informasi. 
                    Tempat berbagi dan mengapresiasi karya-karya inovatif mahasiswa PTI.
                </p>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fab fa-facebook text-xl"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fab fa-instagram text-xl"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fab fa-twitter text-xl"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fab fa-youtube text-xl"></i>
                    </a>
                </div>
            </div>
            
            <!-- Quick Links -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Menu Utama</h3>
                <ul class="space-y-2">
                    <li><a href="<?= base_url('/') ?>" class="text-gray-300 hover:text-white transition-colors">Beranda</a></li>
                    <li><a href="<?= base_url('/galeri') ?>" class="text-gray-300 hover:text-white transition-colors">Galeri</a></li>
                    <li><a href="<?= base_url('/kategori') ?>" class="text-gray-300 hover:text-white transition-colors">Kategori</a></li>
                    <li><a href="<?= base_url('/tentang') ?>" class="text-gray-300 hover:text-white transition-colors">Tentang</a></li>
                </ul>
            </div>
            
            <!-- Contact Info -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Kontak</h3>
                <ul class="space-y-2 text-gray-300">
                    <li class="flex items-center">
                        <i class="fas fa-envelope mr-2"></i>
                        <a href="mailto:pti@university.ac.id" class="hover:text-white transition-colors">pti@university.ac.id</a>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-phone mr-2"></i>
                        <span>+62 21 1234 5678</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-map-marker-alt mr-2 mt-1"></i>
                        <span>Jl. Pendidikan No. 123<br>Jakarta, Indonesia</span>
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Bottom Bar -->
        <div class="border-t border-gray-800 mt-8 pt-8 flex flex-col md:flex-row justify-between items-center">
            <p class="text-gray-400 text-sm">
                © <?= date('Y') ?> eKarya PTI. Semua hak dilindungi.
            </p>
            <div class="flex space-x-6 mt-4 md:mt-0">
                <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">Kebijakan Privasi</a>
                <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">Syarat & Ketentuan</a>
            </div>
        </div>
    </div>
</footer>