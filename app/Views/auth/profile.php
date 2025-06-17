<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="bg-white dark:bg-gray-900 min-h-screen">
    <!-- Header -->
    <div class="bg-gradient-to-r from-primary-600 to-primary-800 text-white py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center space-x-4">
                <div class="w-20 h-20 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                    <span class="text-3xl font-bold">
                        <?= strtoupper(substr($user['name'], 0, 1)) ?>
                    </span>
                </div>
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold mb-2"><?= esc($user['name']) ?></h1>
                    <p class="text-xl text-primary-100"><?= esc($user['email']) ?></p>
                    <p class="text-primary-200">
                        <i class="fas fa-calendar mr-1"></i>
                        Bergabung <?= date('F Y', strtotime($user['created_at'])) ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Tabs -->
        <div class="border-b border-gray-200 dark:border-gray-700 mb-8" x-data="{ activeTab: 'profile' }">
            <nav class="-mb-px flex space-x-8">
                <button @click="activeTab = 'profile'" 
                        :class="{ 'border-primary-500 text-primary-600 dark:text-primary-400': activeTab === 'profile', 'border-transparent text-gray-500 dark:text-gray-400': activeTab !== 'profile' }"
                        class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors">
                    <i class="fas fa-user mr-2"></i>
                    Informasi Profil
                </button>
                <button @click="activeTab = 'password'" 
                        :class="{ 'border-primary-500 text-primary-600 dark:text-primary-400': activeTab === 'password', 'border-transparent text-gray-500 dark:text-gray-400': activeTab !== 'password' }"
                        class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors">
                    <i class="fas fa-lock mr-2"></i>
                    Ubah Password
                </button>
                <button @click="activeTab = 'stats'" 
                        :class="{ 'border-primary-500 text-primary-600 dark:text-primary-400': activeTab === 'stats', 'border-transparent text-gray-500 dark:text-gray-400': activeTab !== 'stats' }"
                        class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors">
                    <i class="fas fa-chart-bar mr-2"></i>
                    Statistik
                </button>
            </nav>

            <!-- Profile Tab -->
            <div x-show="activeTab === 'profile'" x-cloak class="mt-8">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">
                        Informasi Profil
                    </h2>
                    
                    <form action="<?= base_url('/profil/update') ?>" method="POST" x-data="profileForm()">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Nama Lengkap
                                </label>
                                <input type="text" 
                                       id="name" 
                                       name="name" 
                                       value="<?= esc($user['name']) ?>"
                                       x-model="form.name"
                                       required
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Email
                                </label>
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       value="<?= esc($user['email']) ?>"
                                       x-model="form.email"
                                       required
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button type="submit" 
                                    :disabled="!hasChanges() || isSubmitting"
                                    :class="{ 'opacity-50 cursor-not-allowed': !hasChanges() || isSubmitting }"
                                    class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors inline-flex items-center">
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

            <!-- Password Tab -->
            <div x-show="activeTab === 'password'" x-cloak class="mt-8">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">
                        Ubah Password
                    </h2>
                    
                    <form action="<?= base_url('/profil/password') ?>" method="POST" x-data="passwordForm()">
                        <div class="space-y-6">
                            <!-- Current Password -->
                            <div>
                                <label for="current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Password Saat Ini
                                </label>
                                <div class="relative">
                                    <input type="password" 
                                           id="current_password" 
                                           name="current_password" 
                                           x-model="form.currentPassword"
                                           required
                                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                </div>
                            </div>

                            <!-- New Password -->
                            <div>
                                <label for="new_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Password Baru
                                </label>
                                <div class="relative">
                                    <input type="password" 
                                           id="new_password" 
                                           name="new_password" 
                                           x-model="form.newPassword"
                                           @input="validateNewPassword()"
                                           required
                                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                </div>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Minimal 6 karakter</p>
                            </div>

                            <!-- Confirm New Password -->
                            <div>
                                <label for="confirm_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Konfirmasi Password Baru
                                </label>
                                <div class="relative">
                                    <input type="password" 
                                           id="confirm_password" 
                                           name="confirm_password" 
                                           x-model="form.confirmPassword"
                                           @input="validateConfirmPassword()"
                                           required
                                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                </div>
                                <p x-show="confirmPasswordError" x-text="confirmPasswordError" class="mt-1 text-sm text-red-600 dark:text-red-400" x-cloak></p>
                                <p x-show="form.confirmPassword && !confirmPasswordError" class="mt-1 text-sm text-green-600 dark:text-green-400" x-cloak>
                                    <i class="fas fa-check mr-1"></i>Password cocok
                                </p>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button type="submit" 
                                    :disabled="!isPasswordFormValid() || isSubmitting"
                                    :class="{ 'opacity-50 cursor-not-allowed': !isPasswordFormValid() || isSubmitting }"
                                    class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors inline-flex items-center">
                                <span x-show="!isSubmitting">
                                    <i class="fas fa-key mr-2"></i>
                                    Ubah Password
                                </span>
                                <span x-show="isSubmitting" x-cloak>
                                    <i class="fas fa-spinner fa-spin mr-2"></i>
                                    Mengubah...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Statistics Tab -->
            <div x-show="activeTab === 'stats'" x-cloak class="mt-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <!-- Total Works -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
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
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
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

                    <!-- Average Views -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                        <div class="flex items-center">
                            <div class="p-3 bg-yellow-100 dark:bg-yellow-900 rounded-full">
                                <i class="fas fa-chart-line text-2xl text-yellow-600 dark:text-yellow-400"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                                    <?= $stats['total_works'] > 0 ? number_format($stats['total_views'] / $stats['total_works'], 1) : 0 ?>
                                </h3>
                                <p class="text-gray-600 dark:text-gray-400">Rata-rata Views</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Works by Category -->
                <?php if (!empty($stats['works_by_category'])): ?>
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">
                            Karya per Kategori
                        </h3>
                        <div class="space-y-4">
                            <?php foreach ($stats['works_by_category'] as $category): ?>
                                <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <div>
                                        <h4 class="font-medium text-gray-900 dark:text-white">
                                            <?= esc($category['category_name']) ?>
                                        </h4>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            <?= $category['total_works'] ?> karya
                                        </p>
                                    </div>
                                    <div class="flex-1 mx-4">
                                        <div class="bg-gray-200 dark:bg-gray-600 rounded-full h-2">
                                            <div class="bg-primary-600 h-2 rounded-full" 
                                                 style="width: <?= ($category['total_works'] / $stats['total_works']) * 100 ?>%"></div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-sm font-medium text-gray-900 dark:text-white">
                                            <?= number_format(($category['total_works'] / $stats['total_works']) * 100, 1) ?>%
                                        </span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
function profileForm() {
    return {
        form: {
            name: '<?= esc($user['name']) ?>',
            email: '<?= esc($user['email']) ?>'
        },
        originalForm: {
            name: '<?= esc($user['name']) ?>',
            email: '<?= esc($user['email']) ?>'
        },
        isSubmitting: false,
        
        hasChanges() {
            return this.form.name !== this.originalForm.name || 
                   this.form.email !== this.originalForm.email;
        }
    }
}

function passwordForm() {
    return {
        form: {
            currentPassword: '',
            newPassword: '',
            confirmPassword: ''
        },
        isSubmitting: false,
        confirmPasswordError: '',
        
        validateNewPassword() {
            if (this.form.confirmPassword) {
                this.validateConfirmPassword();
            }
        },
        
        validateConfirmPassword() {
            if (!this.form.confirmPassword) {
                this.confirmPasswordError = '';
            } else if (this.form.newPassword !== this.form.confirmPassword) {
                this.confirmPasswordError = 'Konfirmasi password tidak cocok';
            } else {
                this.confirmPasswordError = '';
            }
        },
        
        isPasswordFormValid() {
            return this.form.currentPassword && 
                   this.form.newPassword && 
                   this.form.confirmPassword &&
                   this.form.newPassword.length >= 6 &&
                   !this.confirmPasswordError;
        }
    }
}
</script>
<?= $this->endSection() ?>