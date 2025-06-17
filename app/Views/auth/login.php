<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <!-- Logo -->
        <div class="flex justify-center">
            <div class="w-16 h-16 bg-primary-600 rounded-xl flex items-center justify-center mb-6">
                <i class="fas fa-graduation-cap text-white text-2xl"></i>
            </div>
        </div>
        <h2 class="text-center text-3xl font-bold text-gray-900 dark:text-white">
            Masuk ke eKarya PTI
        </h2>
        <p class="mt-2 text-center text-sm text-gray-600 dark:text-gray-400">
            Atau
            <a href="<?= site_url('/register') ?>" class="font-medium text-primary-600 hover:text-primary-500 dark:text-primary-400">
                daftar akun baru
            </a>
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white dark:bg-gray-800 py-8 px-4 shadow-xl rounded-xl sm:px-10">
            <form class="space-y-6" action="<?= site_url('/login') ?>" method="POST" x-data="loginForm()">
                <?= csrf_field() ?>
                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Email
                    </label>
                    <div class="mt-1 relative">
                        <input id="email" 
                               name="email" 
                               type="email" 
                               autocomplete="email" 
                               required
                               x-model="form.email"
                               @input="validateEmail()"
                               value="<?= old('email') ?>"
                               class="appearance-none block w-full px-3 py-2 pl-10 border border-gray-300 dark:border-gray-600 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-primary-500 focus:border-primary-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                               placeholder="Masukkan email Anda">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                    </div>
                    <p x-show="emailError" x-text="emailError" class="mt-1 text-sm text-red-600 dark:text-red-400" x-cloak></p>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Password
                    </label>
                    <div class="mt-1 relative">
                        <input id="password" 
                               name="password" 
                               :type="showPassword ? 'text' : 'password'" 
                               autocomplete="current-password" 
                               required
                               x-model="form.password"
                               @input="validatePassword()"
                               class="appearance-none block w-full px-3 py-2 pl-10 pr-10 border border-gray-300 dark:border-gray-600 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-primary-500 focus:border-primary-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                               placeholder="Masukkan password Anda">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <button type="button" @click="showPassword = !showPassword" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                <i :class="showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                            </button>
                        </div>
                    </div>
                    <p x-show="passwordError" x-text="passwordError" class="mt-1 text-sm text-red-600 dark:text-red-400" x-cloak></p>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember-me" 
                               name="remember-me" 
                               type="checkbox" 
                               class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700">
                        <label for="remember-me" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">
                            Ingat saya
                        </label>
                    </div>

                    <div class="text-sm">
                        <a href="#" class="font-medium text-primary-600 hover:text-primary-500 dark:text-primary-400">
                            Lupa password?
                        </a>
                    </div>
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" 
                            :disabled="!isFormValid() || isSubmitting"
                            :class="{ 'opacity-50 cursor-not-allowed': !isFormValid() || isSubmitting }"
                            class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors">
                        <span x-show="!isSubmitting" class="flex items-center">
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            Masuk
                        </span>
                        <span x-show="isSubmitting" x-cloak class="flex items-center">
                            <i class="fas fa-spinner fa-spin mr-2"></i>
                            Memproses...
                        </span>
                    </button>
                </div>

                <!-- Divider -->
                <div class="mt-6">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300 dark:border-gray-600"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-400">
                                Belum punya akun?
                            </span>
                        </div>
                    </div>

                    <div class="mt-6">
                        <a href="<?= site_url('/register') ?>"
                           class="w-full flex justify-center py-2 px-4 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors">
                            <i class="fas fa-user-plus mr-2"></i>
                            Daftar Sekarang
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
function loginForm() {
    return {
        form: {
            email: '<?= old('email') ?>',
            password: ''
        },
        showPassword: false,
        isSubmitting: false,
        emailError: '',
        passwordError: '',
        
        validateEmail() {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!this.form.email) {
                this.emailError = 'Email wajib diisi';
            } else if (!emailRegex.test(this.form.email)) {
                this.emailError = 'Format email tidak valid';
            } else {
                this.emailError = '';
            }
        },
        
        validatePassword() {
            if (!this.form.password) {
                this.passwordError = 'Password wajib diisi';
            } else if (this.form.password.length < 6) {
                this.passwordError = 'Password minimal 6 karakter';
            } else {
                this.passwordError = '';
            }
        },
        
        isFormValid() {
            return this.form.email && 
                   this.form.password && 
                   !this.emailError && 
                   !this.passwordError;
        },
        
        init() {
            // Validate on load if there's old input
            if (this.form.email) {
                this.validateEmail();
            }
        }
    }
}
</script>
<?= $this->endSection() ?>