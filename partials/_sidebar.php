<aside class="offcanvas offcanvas-start text-bg-dark w-75 d-lg-none" tabindex="-1" id="sideMenu">
  <div class="offcanvas-header py-2">
    <span class="fs-5 fw-bold"><i class="bi bi-book-half me-1 text-warning"></i>BookHub</span>
    <button class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Kapat"></button>
  </div>

  <div class="offcanvas-body d-flex flex-column pt-0">

    <?php if (!isloggedIn()): ?>
      <div class="bg-black bg-opacity-25 rounded-4 p-3 mb-3 guest-only">
        <div class="fw-semibold mb-1">Hoş geldin!</div>
        <div class="small text-white-50 mb-3">Kitap eklemek, favorilemek ve takas yapmak için giriş yap.</div>
        <div class="d-grid gap-2">
          <a href="<?php echo BASE_URL; ?>login" class="btn btn-warning btn-sm">Giriş Yap</a>
          <a href="<?php echo BASE_URL; ?>register" class="btn btn-outline-light btn-sm">Kayıt Ol</a>
        </div>
      </div>
    <?php endif; ?>
    
    <?php if (isloggedIn()): ?>
      <a href="/profil" class="bg-black bg-opacity-25 rounded-4 p-3 mb-3 d-flex align-items-center gap-3 text-decoration-none text-white user-only admin-only">
        <i class="bi bi-person-circle text-warning fs-1 lh-1"></i>
        <div>
          <div class="fw-semibold"><?php echo $_SESSION["name"] . " " . $_SESSION["surname"]; ?></div>
          <span class="badge text-bg-<?php echo ($_SESSION["user_type"] === "admin") ? "danger" : "warning"; ?> admin-only"><?php echo ($_SESSION["user_type"] === "admin") ? "Yönetici" : "Üye"; ?></span>  
        </div>
      </a>
    <?php endif; ?>

    <nav class="nav flex-column mb-3">
      <a class="nav-link text-white" href="<?php echo BASE_URL; ?>">
        <i class="bi bi-house-door text-warning me-2"></i>
        Anasayfa
      </a>
      <a class="nav-link text-white" href="<?php echo BASE_URL; ?>books">
        <i class="bi bi-book-half text-warning me-2"></i>
        Kitaplar
      </a>
      <a class="nav-link text-white" href="<?php echo BASE_URL; ?>categories">
          <i class="bi bi-tags text-warning me-2"></i>
          Kategoriler
      </a>
      <?php if (isloggedIn()): ?>
        <div class="text-white-50 small px-3 pt-3 pb-1 user-only admin-only">
          Benim alanım
        </div>
        <a class="nav-link text-white user-only admin-only px-4" href="<?php echo BASE_URL . $_SESSION["username"] ?>/books">
          <i class="bi bi-plus-circle text-warning me-2"></i>
          Kitaplarım
        </a>
        <a class="nav-link text-white user-only admin-only px-4" href="<?php echo BASE_URL . $_SESSION["username"] ?>/favorites">
          <i class="bi bi-heart text-warning me-2"></i>
          Favorilerim
        </a>
        <a class="nav-link text-white user-only admin-only px-4" href="<?php echo BASE_URL . $_SESSION["username"] ?>/trades">
          <i class="bi bi-arrow-left-right text-warning me-2"></i>
          Takaslarım
        </a>
        <a class="nav-link text-white user-only admin-only px-4" href="<?php echo BASE_URL . $_SESSION["username"] ?>/trades">
          <i class="bi bi-arrow-left-right text-warning me-2"></i>
          Takaslarım
        </a>
      <?php endif; ?>
      
      <?php if (isAdmin()): ?>
        <div class="text-white-50 small px-3 pt-3 pb-1 admin-only">
          Yönetim
        </div>
        <a class="nav-link text-white admin-only px-4" href="<?php echo BASE_URL; ?>admin/dashboard">
          <i class="bi bi-grid-1x2-fill text-warning me-2"></i>
          Genel Bakış
        </a>
        <a class="nav-link text-white admin-only px-4" href="<?php echo BASE_URL; ?>admin/users">
          <i class="bi bi-people text-warning me-2"></i>
          Kullanıcılar
        </a>
        <a class="nav-link text-white admin-only px-4" href="<?php echo BASE_URL; ?>admin/categories">
          <i class="bi bi-tags text-warning me-2"></i>
          Kategoriler
        </a>
        <a class="nav-link text-white admin-only px-4" href="<?php echo BASE_URL; ?>admin/pending">
          <i class="bi bi-hourglass-split text-warning me-2"></i>
          Onay Bekleyenler
        </a>
      <?php endif; ?>
    </nav>
    <?php if (isloggedIn()): ?>
      <a href="<?php echo BASE_URL ?>logout" class="btn btn-outline-danger btn-sm mt-auto user-only admin-only"><i class="bi bi-box-arrow-right me-2"></i>Çıkış Yap</a>
    <?php endif; ?>
  </div>
</aside>