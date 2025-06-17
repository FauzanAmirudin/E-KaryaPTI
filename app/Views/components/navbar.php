<nav class="bg-white dark:bg-gray-800 shadow-lg sticky top-0 z-50 transition-colors duration-300" x-data="{ mobileMenuOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="<?= base_url('/') ?>" class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-primary-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-graduation-cap text-white text-sm"></i>
                    </div>
                    <span class="text-xl font-bold text-gray-900 dark:text-white">eKarya PTI</span>
                </a>
            </div>
            
            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="<?= base_url('/') ?>" class="text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors <?= uri_string() === '' ? 'text-primary-600 dark:text-primary-400 font-semibold' : '' ?>">
                    Beranda
                </a>
                <a href="<?= base_url('/galeri') ?>" class="text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors <?= str_starts_with(uri_string(), 'galeri') ? 'text-primary-600 dark:text-primary-400 font-semibold' : '' ?>">
                    Galeri
                </a>
                <a href="<?= base_url('/kategori') ?>" class="text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors <?= str_starts_with(uri_string(), 'kategori') ? 'text-primary-600 dark:text-primary-400 font-semibold' : '' ?>">
                    Kategori
                </a>
                <a href="<?= base_url('/tentang') ?>" class="text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors <?= uri_string() === 'tentang' ? 'text-primary-600 dark:text-primary-400 font-semibold' : '' ?>">
                    Tentang
                </a>
            </div>
            
            <!-- Right Side Menu -->
            <div class="hidden md:flex items-center space-x-4">
                <!-- Dark Mode Toggle -->
                <button onclick="toggleDarkMode()" class="p-2 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition-colors">
                    <i class="fas fa-moon dark:hidden"></i>
                    <i class="fas fa-sun hidden dark:inline"></i>
                </button>
                
                <?php if (session()->get('is_logged_in')): ?>
                    <!-- User Menu -->
                    <div class="relative" x-data="{ userMenuOpen: false }">
                        <button @click="userMenuOpen = !userMenuOpen" class="flex items-center space-x-2 text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
                            <div class="w-8 h-8 bg-primary-600 rounded-full flex items-center justify-center">
                                <span class="text-white text-sm font-medium">
                                    <?= strtoupper(substr(session()->get('user_name'), 0, 1)) ?>
                                </span>
                            </div>
                            <span><?= session()->get('user_name') ?></span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        
                        <div x-show="userMenuOpen" @click.away="userMenuOpen = false" x-cloak
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg py-1 z-50 border dark:border-gray-700">
                            <a href="<?= base_url('/karya-saya') ?>" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                <i class="fas fa-folder-open mr-2"></i>Karya Saya
                            </a>
                            <a href="<?= base_url('/unggah') ?>" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                <i class="fas fa-plus mr-2"></i>Unggah Karya
                            </a>
                            <a href="<?= base_url('/profil') ?>" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                <i class="fas fa-user mr-2"></i>Profil
                            </a>
                            <hr class="my-1 border-gray-200 dark:border-gray-600">
                            <a href="<?= base_url('/logout') ?>" class="block px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                                <i class="fas fa-sign-out-alt mr-2"></i>Logout
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- User is NOT logged in -->
                    <div class="hidden sm:flex items-center space-x-4">
                        <a href="<?= site_url('/login') ?>" class="text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
                            <span>Masuk</span>
                        </a>
                        <a href="<?= site_url('/register') ?>" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg transition-colors">
                            <span>Daftar</span>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Mobile Menu Button -->
            <div class="md:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400">
                    <i class="fas fa-bars" x-show="!mobileMenuOpen"></i>
                    <i class="fas fa-times" x-show="mobileMenuOpen" x-cloak></i>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Mobile Menu -->
    <div x-show="mobileMenuOpen" x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-1"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-1"
         class="md:hidden bg-white dark:bg-gray-800 border-t dark:border-gray-700">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <a href="<?= base_url('/') ?>" class="block px-3 py-2 text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors">
                Beranda
            </a>
            <a href="<?= base_url('/galeri') ?>" class="block px-3 py-2 text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors">
                Galeri
            </a>
            <a href="<?= base_url('/kategori') ?>" class="block px-3 py-2 text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors">
                Kategori
            </a>
            <a href="<?= base_url('/tentang') ?>" class="block px-3 py-2 text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors">
                Tentang
            </a>
            
            <?php if (session()->get('is_logged_in')): ?>
                <hr class="my-2 border-gray-200 dark:border-gray-600">
                <div class="px-3 py-2">
                    <div class="flex items-center space-x-2 mb-2">
                        <div class="w-8 h-8 bg-primary-600 rounded-full flex items-center justify-center">
                            <span class="text-white text-sm font-medium">
                                <?= strtoupper(substr(session()->get('user_name'), 0, 1)) ?>
                            </span>
                        </div>
                        <span class="text-gray-900 dark:text-white font-medium"><?= session()->get('user_name') ?></span>
                    </div>
                </div>
                <a href="<?= base_url('/karya-saya') ?>" class="block px-3 py-2 text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors">
                    <i class="fas fa-folder-open mr-2"></i>Karya Saya
                </a>
                <a href="<?= base_url('/unggah') ?>" class="block px-3 py-2 text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors">
                    <i class="fas fa-plus mr-2"></i>Unggah Karya
                </a>
                <a href="<?= base_url('/profil') ?>" class="block px-3 py-2 text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors">
                    <i class="fas fa-user mr-2"></i>Profil
                </a>
                <a href="<?= base_url('/logout') ?>" class="block px-3 py-2 text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors">
                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                </a>
            <?php else: ?>
                <hr class="my-2 border-gray-200 dark:border-gray-600">
                <a href="<?= site_url('/login') ?>" class="block px-3 py-2 text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors">
                    Masuk
                </a>
                <a href="<?= site_url('/register') ?>" class="block px-3 py-2 text-center bg-primary-600 hover:bg-primary-700 text-white rounded-md transition-colors mx-3 mt-2">
                    Daftar
                </a>
            <?php endif; ?>
            
            <!-- Dark Mode Toggle Mobile -->
            <div class="px-3 py-2">
                <button onclick="toggleDarkMode()" class="flex items-center space-x-2 text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
                    <i class="fas fa-moon dark:hidden"></i>
                    <i class="fas fa-sun hidden dark:inline"></i>
                    <span class="dark:hidden">Mode Gelap</span>
                    <span class="hidden dark:inline">Mode Terang</span>
                </button>
            </div>
        </div>
    </div>
</nav>