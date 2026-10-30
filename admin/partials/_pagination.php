<?php if ($pageCount > 1): ?>
    <nav class="items-list d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 p-4" aria-label="Kategori sayfalama">
        <span class="small text-muted">
        Sayfa <?php echo $page; ?> / <?php echo $pageCount; ?> • Toplam <?php echo $categories->getCategoryCount()->totalCategory; ?> kategori
        </span>

        <ul class="pagination pagination-sm gap-1 flex-wrap mb-0">
            <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                <a class="page-link border-0 rounded-3 ms-0 px-3 py-2 d-flex align-items-center justify-content-center bg-light text-secondary"
                href="<?php echo ($page <= 1) ? '' : BASE_URL . 'admin/' . $_GET["page"] . '/' . ($page - 1); ?>"
                <?php echo ($page <= 1) ? 'tabindex="-1" aria-disabled="true"' : ''; ?>
                aria-label="Önceki">
                <i class="bi bi-chevron-left"></i>
                </a>
            </li>

            <li class="page-item <?php echo (1 == $page) ? 'active' : ''; ?>" <?php echo (1 == $page) ? 'aria-current="page"' : ''; ?>>
                <a class="page-link border-0 rounded-3 ms-0 px-3 py-2 d-flex align-items-center justify-content-center <?php echo (1 == $page) ? 'bg-warning text-dark fw-semibold' : 'bg-light text-dark'; ?>" href="<?php echo BASE_URL; ?>admin/<?php echo $_GET["page"]; ?>/1">
                    1
                </a>
            </li>

            <?php if ($start > 2): ?>
                <li class="page-item">
                    <span class="page-link border-0 rounded-3 ms-0 px-3 py-2 d-flex align-items-center justify-content-center bg-light text-dark">
                        ...
                    </span>
                </li>
            <?php endif; ?>

            <?php for ($i = $start; $i <= $end; $i++): ?>
                <?php $isActive = ($page == $i); ?>
                <li class="page-item <?php echo $isActive ? 'active' : ''; ?>" <?php echo $isActive ? 'aria-current="page"' : ''; ?>>
                    <a class="page-link border-0 rounded-3 ms-0 px-3 py-2 d-flex align-items-center justify-content-center <?php echo $isActive ? 'bg-warning text-dark fw-semibold' : 'bg-light text-dark'; ?>" href="<?php echo BASE_URL . 'admin/' . $_GET["page"] . '/' . $i; ?>">
                        <?php echo $i; ?>
                    </a>
                </li>
            <?php endfor; ?>

            <?php if ($end < $pageCount - 1): ?>
                <li class="page-item">
                    <span class="border-0 rounded-3 ms-0 px-3 py-2 d-flex align-items-center justify-content-center bg-light text-dark">
                        ...
                    </span>
                </li>
            <?php endif; ?>

            <li class="page-item <?php echo ($pageCount == $page) ? 'active' : ''; ?>" <?php echo ($pageCount == $page) ? 'aria-current="page"' : ''; ?>>
                <a class="page-link border-0 rounded-3 ms-0 px-3 py-2 d-flex align-items-center justify-content-center <?php echo ($pageCount == $page) ? 'bg-warning text-dark fw-semibold' : 'bg-light text-dark'; ?>" href="<?php echo BASE_URL . 'admin/' . $_GET["page"] . '/' .$pageCount; ?>">
                    <?php echo $pageCount; ?>
                </a>
            </li>

            <li class="page-item <?php echo ($page >= $pageCount) ? 'disabled' : ''; ?>">
                <a class="page-link border-0 rounded-3 ms-0 px-3 py-2 d-flex align-items-center justify-content-center bg-light <?php echo ($page >= $pageCount) ? 'text-secondary' : 'text-dark'; ?>" href="<?php echo ($page >= $pageCount) ? '#' : BASE_URL . 'admin/' . $_GET["page"] . '/' . ($page + 1); ?>" <?php echo ($page >= $pageCount) ? 'tabindex="-1" aria-disabled="true"' : ''; ?> aria-label="Sonraki">
                    <i class="bi bi-chevron-right"></i>
                </a>
            </li>
        </ul>
    </nav>
<?php endif; ?>