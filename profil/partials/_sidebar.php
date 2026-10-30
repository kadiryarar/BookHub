<aside class="col-12 col-lg-3 mb-2 mb-lg-0">
    <div class="card border-0 shadow-sm rounded-4 sticky-lg-top menu-card">
        <div class="list-group list-group-flush p-2 d-grid gap-2">
            <a href="<?php echo BASE_URL . $_SESSION["username"] . "/books"; ?>" class="list-group-item list-group-item-light list-group-item-action border-0 rounded-3 py-3 px-3 d-flex align-items-center justify-content-between <?php echo ($pageRoute === 'books') ? 'active' : ''; ?>">
                <span class="d-flex align-items-center gap-2">
                    <i class="bi bi-book fs-5"></i>
                    <span>Kitaplarım</span>
                </span>
                <span class="badge rounded-pill text-bg-warning"><?php echo $userBooksCount; ?></span>
            </a>
            <a href="<?php echo BASE_URL . $_SESSION["username"] . "/favorites"; ?>" class="list-group-item list-group-item-light list-group-item-action border-0 rounded-3 py-3 px-3 d-flex align-items-center justify-content-between <?php echo ($pageRoute === 'favorites') ? 'active' : ''; ?>">
                <span class="d-flex align-items-center gap-2">
                    <i class="bi bi-heart fs-5"></i>
                    <span>Favorilerim</span>
                </span>
                <span class="badge rounded-pill text-bg-warning"><?php echo $totalFavorite; ?></span>
            </a>
            <a href="<?php echo BASE_URL . $_SESSION["username"] . "/trades"; ?>" class="list-group-item list-group-item-light list-group-item-action border-0 rounded-3 py-3 px-3 d-flex align-items-center justify-content-between <?php echo ($pageRoute === 'trades') ? 'active' : ''; ?>">
                <span class="d-flex align-items-center gap-2">
                    <i class="bi bi-arrow-left-right fs-5"></i>
                    <span>Takaslarım</span>
                </span>
                <span class="badge rounded-pill text-bg-warning"><?php echo $totalTrades; ?></span>
            </a>
            <a href="<?php echo BASE_URL . $_SESSION["username"] . "/settings"; ?>" class="list-group-item list-group-item-light list-group-item-action border-0 rounded-3 py-3 px-3 d-flex align-items-center justify-content-between <?php echo ($pageRoute === 'settings') ? 'active' : ''; ?>">
                <span class="d-flex align-items-center gap-2">
                    <i class="bi bi-gear fs-5"></i>
                    <span>Ayarlarım</span>
                </span>
                <i class="bi bi-chevron-right small"></i>
            </a>
        </div>
    </div>
</aside>