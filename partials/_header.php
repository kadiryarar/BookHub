<?php include_once "libs/variables.php"; ?>
<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $title; ?> | BookHub</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex flex-column min-vh-100">
    <header class="bg-white border-bottom shadow-sm sticky-top rounded-bottom-4">
        <div class="container d-flex align-items-center gap-2 gap-lg-3 py-3">

            <button class="btn btn-dark rounded-3 shadow-sm p-2 lh-1 d-lg-none" data-bs-toggle="offcanvas" data-bs-target="#sideMenu" aria-label="Menüyü aç"><i class="bi bi-text-left fs-4 text-warning"></i></button>
            <a href="<?php echo BASE_URL; ?>" class="fs-5 fw-bold text-dark text-decoration-none">
                <i class="bi bi-book-half text-warning me-1"></i>
                BookHub
            </a>

            <ul class="nav d-none d-lg-flex flex-nowrap ms-2">
                <li class="nav-item">
                    <a class="nav-link link-secondary py-1 text-nowrap" href="<?php echo BASE_URL; ?>">
                        <i class="bi bi-house-door me-1"></i>
                        Anasayfa
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link link-secondary py-1 text-nowrap" href="<?php echo BASE_URL; ?>books">
                        <i class="bi bi-book me-1"></i>
                        Kitaplar
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link link-secondary py-1 text-nowrap" href="<?php echo BASE_URL; ?>categories">
                        <i class="bi bi-tags me-1"></i>
                        Kategoriler
                    </a>
                </li>
            </ul>

            <form id="searchForm" class="d-none d-md-block col-md-4 col-xl-3 ms-auto" action="<?php echo BASE_URL; ?>books" method="get">
                <div class="input-group input-group-sm">
                    <input class="form-control bg-light border-0 rounded-start-pill ps-3" name="keyword" placeholder="Kitap veya yazar ara">
                    <button class="btn btn-dark rounded-end-pill px-3">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
            <?php if (!isloggedIn()): ?>
            <div class="guest-only ms-auto ms-md-0 d-flex gap-2">
                <a href="<?php echo BASE_URL; ?>login" class="btn btn-sm btn-outline-dark rounded-pill px-3">Giriş Yap</a>
                <a href="<?php echo BASE_URL; ?>register" class="btn btn-sm btn-warning rounded-pill px-3 d-none d-sm-inline-block">Kayıt Ol</a>
            </div>
            <?php else: ?>
                <div class="user-only admin-only ms-auto ms-md-0 dropdown mx-1">
                    <a href="" class="text-decoration-none text-warning fs-3 lh-1 d-block" data-bs-toggle="dropdown" aria-expanded="false" title="Hesabım">
                        <i class="bi bi-person-circle"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow rounded-4 p-2">
                        <li class="px-2 py-2 d-flex align-items-center gap-2">
                        <i class="bi bi-person-circle text-warning fs-1 lh-1"></i>
                        <div>
                            <div class="fw-semibold text-nowrap">
                                <?php echo $_SESSION["name"] . " " . $_SESSION["surname"]; ?>
                            </div>
                            <span class="badge text-bg-<?php echo ($_SESSION["user_type"] === "admin") ? "danger" : "warning"; ?> admin-only"><?php echo ($_SESSION["user_type"] === "admin") ? "Yönetici" : "Üye"; ?></span>
                        </div>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item rounded-3 text-nowrap" href="<?php echo BASE_URL; ?><?php echo $_SESSION["username"]; ?>/books">
                                <i class="bi bi-person me-2"></i>
                                Profilim
                            </a>
                        </li>
                        <?php if (isAdmin()): ?>
                            <li class="admin-only">
                                <hr class="dropdown-divider">
                            </li>
                            <li class="admin-only">
                                <a class="dropdown-item rounded-3 text-nowrap text-danger" href="<?php echo BASE_URL; ?>admin/dashboard">
                                    <i class="bi bi-shield-lock me-2"></i>
                                    Yönetim Paneli
                                </a>
                            </li>
                        <?php endif; ?>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item rounded-3 text-danger" href="<?php echo BASE_URL; ?>logout">
                                <i class="bi bi-box-arrow-right me-2"></i>
                                Çıkış Yap
                            </a>
                        </li>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </header>