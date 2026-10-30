<?php

    $baseLink = BASE_URL . $_SESSION["username"] . "/" . htmlspecialchars($pageRoute) . "/";

    $labels = [
        "favorites" => "Favoriden",
        "trades" => "Takastan",
        "books" => "Kitaptan"
    ];

    $label = $labels[$pageRoute] ?? "";

?>
<?php if ($pageCount > 1): ?>
    <nav class="items-list d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 p-4" aria-label="Sayfa numaraları">
        <span class="small text-muted">
            <?php echo $totalItems; ?>
            <?php echo $label; ?>
            <?php echo $recordStart; ?> - <?php echo $recordEnd; ?> arası gösteriliyor
        </span>
        <ul class="pagination pagination-sm gap-1 flex-wrap mb-0">
            <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                <a class="page-link border-0 rounded-3 px-3 py-2 bg-light text-secondary" href="<?php echo ($page <= 1) ? '#' : $baseLink . ($page - 1); ?>" aria-label="Önceki" <?php echo ($page <= 1) ? 'tabindex="-1" aria-disabled="true"' : ''; ?>>
                    <i class="bi bi-chevron-left"></i>
                </a>
            </li>

            <li class="page-item <?php echo ($page == 1) ? 'active' : ''; ?>">
                <a class="page-link border-0 rounded-3 px-3 py-2 <?php echo ($page == 1) ? 'bg-warning text-dark fw-semibold' : 'bg-light text-dark'; ?>" href="<?php echo $baseLink . '1'; ?>">
                    1
                </a>
            </li>

            <?php if ($recordStart > 2): ?>
                <li class="page-item disabled">
                    <span class="page-link border-0 bg-light text-dark px-3 py-2">
                        ...
                    </span>
                </li>
            <?php endif; ?>

            <?php for ($i = $start; $i <= $end; $i++): ?>
                <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                    <a class="page-link border-0 rounded-3 px-3 py-2 <?php echo ($page == $i) ? 'bg-warning text-dark fw-semibold' : 'bg-light text-dark'; ?>" href="<?php echo $baseLink . $i; ?>">
                        <?php echo $i; ?>
                    </a>
                </li>
            <?php endfor; ?>

            <?php if ($recordEnd < $pageCount - 1): ?>
                <li class="page-item disabled">
                    <span class="page-link border-0 bg-light text-dark px-3 py-2">
                        ...
                    </span>
                </li>
            <?php endif; ?>

            <li class="page-item <?php echo ($page == $pageCount) ? 'active' : ''; ?>">
                <a class="page-link border-0 rounded-3 px-3 py-2 <?php echo ($page == $pageCount) ? 'bg-warning text-dark fw-semibold' : 'bg-light text-dark'; ?>" href="<?php echo $baseLink . $pageCount; ?>">
                    <?php echo $pageCount; ?>
                </a>
            </li>

            <li class="page-item <?php echo ($page >= $pageCount) ? 'disabled' : ''; ?>">
                <a class="page-link border-0 rounded-3 px-3 py-2 bg-light text-dark" href="<?php echo ($page >= $pageCount) ? '#' : $baseLink . ($page + 1); ?>" aria-label="Sonraki" <?php echo ($page >= $pageCount) ? 'tabindex="-1" aria-disabled="true"' : ''; ?>>
                    <i class="bi bi-chevron-right"></i>
                </a>
            </li>
        </ul>
    </nav>
<?php endif; ?>