<header class="bg-white border-bottom sticky-top">
  <div class="container-fluid px-3 px-lg-4 py-3">
    <div class="d-flex align-items-center justify-content-between gap-3">

      <div class="d-flex align-items-center gap-3">
        <button class="btn btn-dark rounded-3 shadow-sm p-2 lh-1 d-lg-none" data-bs-toggle="offcanvas" data-bs-target="#sideMenu" aria-label="Menüyü aç"><i class="bi bi-text-left fs-4 text-warning"></i></button>
        <div>
          <h6 class="mb-0 fw-bold"><?php echo ucfirst($page); ?></h6>
        </div>
      </div>

      <div class="d-flex align-items-center gap-2">
        <a href="<?php echo BASE_URL; ?>admin/pending" class="btn btn-light position-relative" aria-label="Bildirimler">
          <i class="bi bi-bell fs-5"></i>
          <span class="position-absolute top-0 start-100 translate-middle badge rounded-circle bg-danger px-2 py-0 lh-lg z-1">
            <?php echo $notIsVerified; ?>
          </span>
        </a>
        <div class="dropdown">
          <button class="btn btn-light border-0 d-flex align-items-center" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="bg-dark text-white rounded-circle d-flex p-2 lh-1 flex-shrink-0">
              <i class="bi bi-person"></i>
            </span>
            <span class="d-none d-md-block ms-2 fw-semibold">
              <?php echo $_SESSION["name"] . " " . $_SESSION["surname"]; ?>
            </span>
          </button>
          <ul class="dropdown-menu dropdown-menu-end shadow">
            <li class="d-md-none">
              <span class="dropdown-item-text fw-semibold">
                <?php echo $_SESSION["name"] . " " . $_SESSION["surname"]; ?>
              </span>
            </li>
            <li class="d-md-none">
              <hr class="dropdown-divider">
            </li>
            <li>
              <a class="dropdown-item" href="<?php echo BASE_URL ?>">
                <i class="bi bi-house me-2"></i>
                Siteye Dön
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <a class="dropdown-item text-danger" href="<?php echo BASE_URL ?>logout">
                <i class="bi bi-box-arrow-right me-2"></i>
                Çıkış Yap
              </a>
            </li>
          </ul>
        </div>
      </div>

    </div>
  </div>
</header>