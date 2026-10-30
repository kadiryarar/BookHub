<section class="bg-dark text-white rounded-4 p-4 mb-4">
    <div class="row align-items-center g-3">
      <div class="col-lg-8">
        <h1 class="h2 fw-bold mb-2">Okuduğun kitap, başkasının yeni favorisi olabilir.</h1>
        <p class="mb-3 text-white-50">Kitaplarını kaydet, beğendiklerini favorile, bir daha okumayacaklarını takasla.</p>
        <div class="d-flex gap-2">
          <a href="<?php echo BASE_URL; ?>books" class="btn btn-warning btn-sm rounded-pill px-3">Kitaplara göz at</a>
          <?php if (!isloggedIn()): ?>
            <a href="<?php echo BASE_URL; ?>login" class="btn btn-outline-light btn-sm rounded-pill px-3 guest-only">Giriş yap</a>
          <?php endif; ?>
        </div>
      </div>
      <div class="col-lg-4 d-none d-lg-flex gap-2 justify-content-end">
        <div class="bg-white bg-opacity-10 rounded-3 px-3 py-2 text-center">
          <div class="fs-4 fw-bold">
            <?php echo $bookCount; ?>
          </div>
          <small class="text-white-50">Kitap</small>
        </div>
        <div class="bg-white bg-opacity-10 rounded-3 px-3 py-2 text-center">
          <div class="fs-4 fw-bold">
            <?php echo $users->getUsersCount()->totalUsers; ?>
          </div>
          <small class="text-white-50">Üye</small>
        </div>
        <div class="bg-white bg-opacity-10 rounded-3 px-3 py-2 text-center">
          <div class="fs-4 fw-bold">
            <?php echo $totalTrades; ?>
          </div>
          <small class="text-white-50">Takas</small>
        </div>
      </div>
    </div>
</section>