<section class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body d-flex align-items-center gap-2 gap-sm-3 px-2 px-sm-3">
                <div class="bg-warning-subtle rounded-3 p-2 lh-1">
                    <i class="bi bi-book fs-4 text-warning"></i>
                </div>
                <div>
                    <div class="h5 fw-bold mb-0"><?php echo $userBooksCount; ?></div>
                    <div class="small text-secondary text-nowrap">Kitabım</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body d-flex align-items-center gap-2 gap-sm-3 px-2 px-sm-3">
                <div class="bg-danger-subtle rounded-3 p-2 lh-1">
                    <i class="bi bi-heart fs-4 text-danger"></i>
                </div>
                <div>
                    <div class="h5 fw-bold mb-0"><?php echo $totalFavorite; ?></div>
                    <div class="small text-secondary text-nowrap">Favori</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body d-flex align-items-center gap-2 gap-sm-3 px-2 px-sm-3">
                <div class="bg-primary-subtle rounded-3 p-2 lh-1">
                    <i class="bi bi-arrow-left-right fs-4 text-primary"></i>
                </div>
                <div>
                    <div class="h5 fw-bold mb-0"><?php echo $totalTrades; ?></div>
                    <div class="small text-secondary text-nowrap">Aktif Takas</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body d-flex align-items-center gap-2 gap-sm-3 px-2 px-sm-3">
                <div class="bg-success-subtle rounded-3 p-2 lh-1">
                    <i class="bi bi-check2-circle fs-4 text-success"></i>
                </div>
                <div>
                    <div class="h5 fw-bold mb-0"><?php echo $totalCompletedTrades; ?></div>
                    <div class="small text-secondary text-nowrap">Tamamlanan</div>
                </div>
            </div>
        </div>
    </div>
</section>