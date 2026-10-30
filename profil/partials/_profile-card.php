<section class="card border-0 shadow-sm rounded-4 position-relative mb-4">
    <div class="bg-dark rounded-top-4" style="height: 110px;"></div>

    <div class="card-body px-3 px-md-4 pb-4">
        <div class="d-flex flex-column flex-md-row align-items-md-end gap-3" style="margin-top: -55px;">

            <div class="bg-white rounded-circle p-1 shadow-sm align-self-start z-1">
                <div class="rounded-circle bg-warning-subtle d-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                    <i class="bi bi-person-fill text-warning" style="font-size: 3.5rem;"></i>
                </div>
            </div>

            <div class="flex-grow-1">
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <h1 class="h4 fw-bold mb-0"><?php echo $_SESSION["name"] . " " . $_SESSION["surname"]; ?></h1>
                    <span class="badge text-bg-<?php echo ($_SESSION["user_type"] === "admin") ? "danger" : "warning"; ?>"><?php echo ($_SESSION["user_type"] === "admin") ? "Yönetici" : "Üye"; ?></span>
                </div>
                <div class="text-secondary small mt-1">
                    <span class="d-block d-sm-inline"><i class="bi bi-envelope me-1"></i><?php echo $_SESSION["email"]; ?></span>
                    <span class="mx-2 d-none d-sm-inline">•</span>
                    <span class="d-block d-sm-inline"><i class="bi bi-calendar3 me-1"></i><?php echo date("d.m.Y", strtotime($_SESSION["created_at"])); ?>'dan beri üye</span>
                </div>
            </div>

            <div class="dropdown align-self-start align-self-md-end z-3">
                <button class="btn btn-sm btn-outline-dark rounded-pill px-3 dropdown-toggle d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-gear"></i>
                    <span>Hesap İşlemleri</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-4 p-2 mt-2" style="min-width: 230px;">
                    <li class="px-2 py-2 d-flex align-items-center gap-2">
                        <i class="bi bi-person-circle text-warning fs-1 lh-1"></i>
                        <div class="overflow-hidden">
                            <div class="fw-semibold text-nowrap"><?php echo $_SESSION["name"] . " " . $_SESSION["surname"]; ?></div>
                            <div class="small text-secondary text-nowrap"><?php echo $_SESSION["email"]; ?></div>
                        </div>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item rounded-3 py-2 d-flex align-items-center gap-2" href="<?php echo BASE_URL; ?>">
                            <i class="bi bi-arrow-left text-secondary"></i>Siteye Dön
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item rounded-3 py-2 d-flex align-items-center gap-2 text-danger" href="<?php echo BASE_URL; ?>logout">
                            <i class="bi bi-box-arrow-right"></i>Çıkış Yap
                        </a>
                    </li>
                </ul>
            </div>

        </div>
    </div>
</section>