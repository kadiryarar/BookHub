<footer class="bg-dark text-white mt-auto pt-5 pb-3 rounded-top-4">
  <div class="container">
    <div class="row g-4 pb-4">
      <div class="col-lg-4">
        <a href="<?php echo BASE_URL; ?>" class="fs-5 fw-bold text-white text-decoration-none">
          <i class="bi bi-book-half text-warning me-1"></i>
          BookHub
        </a>
        <p class="text-white-50 small mt-3 mb-3">
          Okuduğun kitapları kaydet, beğendiklerini favorile, yeni kitaplar için takas teklifi gönder. Kitapseverlerin buluşma noktası.
        </p>
      </div>
      <div class="col-6 col-md-4 col-lg-2 offset-lg-1">
        <h2 class="h6 fw-bold text-warning mb-3">
          Keşfet
        </h2>
        <ul class="list-unstyled small mb-0">
          <li class="mb-2">
            <a href="<?php echo BASE_URL; ?>" class="link-light link-opacity-75 link-opacity-100-hover text-decoration-none">
              <i class="bi bi-house-door text-warning me-2"></i>
              Anasayfa
            </a>
          </li>
          <li class="mb-2">
            <a href="<?php echo BASE_URL; ?>books" class="link-light link-opacity-75 link-opacity-100-hover text-decoration-none">
              <i class="bi bi-book-half text-warning me-2"></i>
              Kitaplar
            </a>
          </li>
          <li class="mb-2">
            <a href="<?php echo BASE_URL; ?>categories" class="link-light link-opacity-75 link-opacity-100-hover text-decoration-none">
              <i class="bi bi-tags text-warning me-2"></i>
              Kategoriler
            </a>
          </li>
          
        </ul>
      </div>
      <div class="col-6 col-md-4 col-lg-2">
        <h2 class="h6 fw-bold text-warning mb-3">
          Hesabım
        </h2>
        <ul class="list-unstyled small mb-0">
          <?php if (!isloggedIn()): ?>
            <li class="mb-2 guest-only">
              <a href="<?php echo BASE_URL; ?>login" class="link-light link-opacity-75 link-opacity-100-hover text-decoration-none">
                Giriş Yap
              </a>
            </li>
            <li class="guest-only">
              <a href="<?php echo BASE_URL; ?>register" class="link-light link-opacity-75 link-opacity-100-hover text-decoration-none">
                Kayıt Ol
              </a>
            </li>
          <?php else: ?>
            <li class="mb-2 user-only admin-only">
              <a href="<?php echo $_SESSION["username"]; ?>/books" class="link-light link-opacity-75 link-opacity-100-hover text-decoration-none">
                Profilim
              </a>
            </li>
            <li class="mb-2 user-only admin-only">
              <a href="<?php echo $_SESSION["username"]; ?>/favorites" class="link-light link-opacity-75 link-opacity-100-hover text-decoration-none">
                Favorilerim
              </a>
            </li>
            <li class="user-only admin-only">
              <a href="<?php echo $_SESSION["username"]; ?>/trades" class="link-light link-opacity-75 link-opacity-100-hover text-decoration-none">
                Takaslarım
              </a>
            </li>
          <?php endif; ?>
        </ul>
      </div>
      <div class="col-12 col-md-4 col-lg-3">
        <h2 class="h6 fw-bold text-warning mb-3">İletişim</h2>
        <ul class="list-unstyled small text-white-50 mb-0">
          <li class="mb-2"><i class="bi bi-envelope text-warning me-2"></i>destek@bookhub.com</li>
          <li class="mb-2"><i class="bi bi-geo-alt text-warning me-2"></i>Türkiye</li>
          <li><i class="bi bi-clock text-warning me-2"></i>Hafta içi 09:00 - 18:00</li>
        </ul>
      </div>
    </div>
    <div class="text-center border-top border-secondary pt-3 small text-white-50">
      <div>© 2026 BookHub. Tüm hakları saklıdır.</div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</footer>