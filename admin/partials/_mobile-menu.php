<div class="offcanvas offcanvas-start text-bg-dark" tabindex="-1" id="sideMenu">
  <div class="offcanvas-header border-bottom border-secondary-subtle border-opacity-25">
    <h5 class="offcanvas-title fw-bold">
      <i class="bi bi-book-half me-2 text-warning"></i>Book<span class="text-warning">Hub</span>
    </h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Kapat"></button>
  </div>
  <div class="offcanvas-body d-flex flex-column">
    <div class="text-secondary small fw-semibold mb-2">
      Yönetim
    </div>
    <div class="list-group gap-1 mx-2" data-bs-theme="dark">
      <a href="<?php echo BASE_URL; ?>admin/dashboard" class="list-group-item list-group-item-action border-0 rounded-3 d-flex align-items-center gap-3 py-2 small text-nowrap <?php echo ($page === 'dashboard') ? 'active bg-warning text-dark fw-semibold' : ''; ?>" aria-current="page">
        <i class="bi bi-grid-1x2-fill"></i>
        <span>
          Genel Bakış
        </span>
      </a>
      <a href="<?php echo BASE_URL; ?>admin/users" class="list-group-item list-group-item-action border-0 rounded-3 d-flex align-items-center gap-3 py-2 small text-nowrap <?php echo ($page === 'users') ? 'active bg-warning text-dark fw-semibold' : ''; ?>">
        <i class="bi bi-people"></i>
        <span>
          Kullanıcılar
        </span>
      </a>
      <a href="<?php echo BASE_URL; ?>admin/categories" class="list-group-item list-group-item-action border-0 rounded-3 d-flex align-items-center gap-3 py-2 small text-nowrap <?php echo ($page === 'categories') ? 'active bg-warning text-dark fw-semibold' : ''; ?>">
        <i class="bi bi-tags"></i>
        <span>
          Kategoriler
        </span>
      </a>
      <a href="<?php echo BASE_URL; ?>admin/pending" class="list-group-item list-group-item-action border-0 rounded-3 d-flex align-items-center gap-3 py-2 small text-nowrap <?php echo ($page === 'pending') ? 'active bg-warning text-dark fw-semibold' : ''; ?>">
        <i class="bi bi-hourglass-split"></i>
        <span>
          Onay Bekleyenler
        </span>
        <span class="badge rounded-circle bg-danger px-2 py-0 ms-auto lh-lg">
          <?php echo $notIsVerified; ?>
        </span>
      </a>
    </div>
    <div class="p-3 border-top border-secondary-subtle border-opacity-25 mt-auto">
      <div class="dropdown dropup">
        <button class="btn btn-dark w-100 border-0 p-2 d-flex align-items-center text-start" data-bs-toggle="dropdown" aria-expanded="false">
          <span class="bg-warning text-dark rounded-circle d-flex p-2 lh-1 flex-shrink-0 fs-5">
            <i class="bi bi-person-fill"></i>
          </span>
          <span class="ms-3 flex-grow-1 fw-semibold text-white text-truncate">
            <?php echo $_SESSION["name"] . " " . $_SESSION["surname"]; ?>
          </span>
          <i class="bi bi-chevron-expand text-secondary"></i>
        </button>
        <ul class="dropdown-menu dropdown-menu-dark w-100 shadow">
          <li>
            <a class="dropdown-item py-2" href="<?php echo BASE_URL; ?>">
              <i class="bi bi-house me-2"></i>
              Siteye Dön
            </a>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>
          <li>
            <a class="dropdown-item py-2 text-danger" href="<?php echo BASE_URL; ?>logout">
              <i class="bi bi-box-arrow-right me-2"></i>
              Çıkış Yap
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>