<?php $pager->setSurroundCount(2) ?>

<nav aria-label="<?= lang('Pager.pageNavigation') ?>">
    <ul class="flex items-center justify-center space-x-1">
        <?php if ($pager->hasPrevious()) : ?>
            <li>
                <a href="<?= $pager->getFirst() ?>" 
                   class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                    <i class="fas fa-angle-double-left"></i>
                </a>
            </li>
            <li>
                <a href="<?= $pager->getPrevious() ?>" 
                   class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                    <i class="fas fa-angle-left"></i>
                </a>
            </li>
        <?php endif ?>

        <?php foreach ($pager->links() as $link) : ?>
            <li>
                <?php if ($link['active']) : ?>
                    <span class="px-3 py-2 text-sm font-medium text-primary-600 bg-primary-50 border border-primary-300 dark:bg-primary-900 dark:border-primary-700 dark:text-primary-300">
                        <?= $link['title'] ?>
                    </span>
                <?php else : ?>
                    <a href="<?= $link['uri'] ?>" 
                       class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        <?= $link['title'] ?>
                    </a>
                <?php endif ?>
            </li>
        <?php endforeach ?>

        <?php if ($pager->hasNext()) : ?>
            <li>
                <a href="<?= $pager->getNext() ?>" 
                   class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                    <i class="fas fa-angle-right"></i>
                </a>
            </li>
            <li>
                <a href="<?= $pager->getLast() ?>" 
                   class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                    <i class="fas fa-angle-double-right"></i>
                </a>
            </li>
        <?php endif ?>
    </ul>
    
    <div class="text-center mt-4">
        <?php
        // Get current page from URI segment
        $uri = service('uri');
        $segment = $pager->segment ?? 0;
        $currentPage = $segment ? $uri->getSegment($segment) : 1;
        if (!is_numeric($currentPage) || $currentPage < 1) {
            $currentPage = 1;
        }
        
        // Calculate other pagination values
        $perPage = $pager->getPerPage();
        $total = $pager->getTotal();
        $startRow = (($currentPage - 1) * $perPage) + 1;
        $endRow = min($startRow + $perPage - 1, $total);
        
        // If no results, show 0
        if ($total === 0) {
            $startRow = 0;
            $endRow = 0;
        }
        ?>
        <span class="text-sm text-gray-700 dark:text-gray-400">
            Menampilkan 
            <span class="font-semibold text-gray-900 dark:text-white"><?= $startRow ?></span>
            sampai 
            <span class="font-semibold text-gray-900 dark:text-white"><?= $endRow ?></span>
            dari 
            <span class="font-semibold text-gray-900 dark:text-white"><?= $total ?></span>
            hasil
        </span>
    </div>
</nav>