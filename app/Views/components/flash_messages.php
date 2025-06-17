<?php if (session()->getFlashdata('success')): ?>
    <div class="alert-auto-hide fixed top-20 right-4 z-50 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow-lg max-w-md" role="alert">
        <div class="flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            <span><?= session()->getFlashdata('success') ?></span>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-auto text-green-700 hover:text-green-900">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert-auto-hide fixed top-20 right-4 z-50 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow-lg max-w-md" role="alert">
        <div class="flex items-center">
            <i class="fas fa-exclamation-circle mr-2"></i>
            <span><?= session()->getFlashdata('error') ?></span>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-auto text-red-700 hover:text-red-900">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('errors')): ?>
    <div class="alert-auto-hide fixed top-20 right-4 z-50 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow-lg max-w-md" role="alert">
        <div class="flex items-start">
            <i class="fas fa-exclamation-triangle mr-2 mt-1"></i>
            <div class="flex-1">
                <p class="font-semibold mb-1">Terjadi kesalahan:</p>
                <ul class="text-sm space-y-1">
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <li>• <?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-2 text-red-700 hover:text-red-900">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
<?php endif; ?>