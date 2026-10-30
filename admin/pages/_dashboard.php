<div class="mb-4">
  <h4 class="fw-bold mb-1">Hoş geldin, <?php echo $_SESSION["name"] . " " . $_SESSION["surname"]; ?></h4>
  <p class="mb-0 text-body-secondary"><?php echo $notIsVerified; ?> kitap onayını bekliyor.</p>
</div>

<div class="row g-3 mb-4">
  <div class="col-6 col-xl-3">
    <div class="card text-bg-dark border-0 rounded-4 h-100">
      <div class="card-body p-3">
        <div class="d-flex justify-content-between align-items-start mb-2">
          <span class="bg-warning text-dark rounded-3 d-flex p-2 fs-5 lh-1 flex-shrink-0"><i class="bi bi-book"></i></span>
        </div>
        <div class="fs-4 fw-bold lh-1 mb-1"><?php echo $books->getBookCount(); ?></div>
        <div class="text-white-50 small">Toplam kitap</div>
      </div>
    </div>
  </div>
  <div class="col-6 col-xl-3">
    <div class="card border-0 shadow-sm rounded-4 h-100">
      <div class="card-body p-3">
        <div class="d-flex justify-content-between align-items-start mb-2">
          <span class="bg-primary-subtle text-primary-emphasis rounded-3 d-flex p-2 fs-5 lh-1 flex-shrink-0"><i class="bi bi-people"></i></span>
        </div>
        <div class="fs-4 fw-bold lh-1 mb-1"><?php echo $userCount; ?></div>
        <div class="text-body-secondary small">Toplam kullanıcı</div>
      </div>
    </div>
  </div>
  <div class="col-6 col-xl-3">
    <div class="card border-0 shadow-sm rounded-4 h-100">
      <div class="card-body p-3">
        <div class="d-flex justify-content-between align-items-start mb-2">
          <span class="bg-warning-subtle text-warning-emphasis rounded-3 d-flex p-2 fs-5 lh-1 flex-shrink-0"><i class="bi bi-hourglass-split"></i></span>
        </div>
        <div class="fs-4 fw-bold lh-1 mb-1"><?php echo $notIsVerified; ?></div>
        <div class="text-body-secondary small">Onay bekleyen</div>
      </div>
    </div>
  </div>
  <div class="col-6 col-xl-3">
    <div class="card border-0 shadow-sm rounded-4 h-100">
      <div class="card-body p-3">
        <div class="d-flex justify-content-between align-items-start mb-2">
          <span class="bg-success-subtle text-success-emphasis rounded-3 d-flex p-2 fs-5 lh-1 flex-shrink-0"><i class="bi bi-tags"></i></span>
        </div>
        <div class="fs-4 fw-bold lh-1 mb-1"><?php echo $categories->getCategoryCount()->totalCategory; ?></div>
        <div class="text-body-secondary small">Toplam kategori</div>
      </div>
    </div>
  </div>
</div>

<div class="row g-3">

  <div class="col-xl-8">
    <div class="card border-0 shadow-sm h-100">
        <div class="card-header bg-white border-0 d-flex align-items-center justify-content-between p-4 pb-2">
            <div>
                <h6 class="mb-0 fw-bold">Kategoriye göre kitap dağılımı</h6>
                <small class="text-body-secondary">Toplam <?php echo $books->getBookCount(); ?> kitap</small>
            </div>
            <a href="<?php echo BASE_URL ?>admin/categories" class="btn btn-sm btn-outline-dark">Kategoriler</a>
        </div>

        <div class="card-body px-4 pb-4 d-flex flex-column gap-4">
            <?php foreach ($categories->getCategoriesByBooksCount() as $category): ?>
                <?php
                    $totalBooks = $books->getBookCount();

                    $categoryCount = $category->categoryByBooksCount;

                    $percentage = $totalBooks > 0
                        ? ($categoryCount / $totalBooks) * 100
                        : 0;
                ?>
                <?php $isActive = (int) $category->is_verified === 1; ?>
                <div>
                    <div class="d-flex justify-content-between align-items-center small mb-2">
                        <span class="fw-semibold d-flex align-items-center gap-2">
                            <?php echo htmlspecialchars($category->name); ?>
                            <?php if ($isActive): ?>
                                <span class="badge text-bg-dark fw-normal">Aktif</span>
                            <?php else: ?>
                                <span class="badge text-bg-light border fw-normal">Pasif</span>
                            <?php endif; ?>
                        </span>
                        <span class="text-body-secondary">
                            <span class="text-body fw-semibold"><?php echo $category->categoryByBooksCount; ?></span> · %<?php echo (number_format($percentage, 0)); ?>
                        </span>
                    </div>
                    <div class="progress" style="height: 6px" role="progressbar"
                        aria-label="<?php echo htmlspecialchars($category->name); ?>, <?php echo $category->categoryByBooksCount; ?> kitap"
                        aria-valuenow="<?php echo $percentage; ?>" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar bg-dark" style="width: <?php echo $percentage; ?>%"></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
  </div>

  <div class="col-xl-4">
    <div class="card border-0 shadow-sm rounded-4 h-100">
      <div class="card-header bg-white border-0 p-4 pb-2">
        <h6 class="mb-0 fw-bold">Hızlı menü</h6>
      </div>
      <div class="list-group list-group-flush rounded-bottom-4">

        <a href="<?php echo BASE_URL; ?>admin/categories" class="list-group-item list-group-item-action d-flex align-items-center gap-3 px-4 py-3">
          <span class="bg-success-subtle text-success-emphasis rounded-3 d-flex p-2 lh-1 flex-shrink-0"><i class="bi bi-tags"></i></span>
          <div class="flex-grow-1">
            <div class="fw-semibold">Kategoriler</div>
            <small class="text-body-secondary">Ekle, düzenle ve sil</small>
          </div>
          <i class="bi bi-chevron-right text-body-secondary"></i>
        </a>

        <a href="<?php echo BASE_URL; ?>admin/pending" class="list-group-item list-group-item-action d-flex align-items-center gap-3 px-4 py-3">
          <span class="bg-warning-subtle text-warning-emphasis rounded-3 d-flex p-2 lh-1 flex-shrink-0"><i class="bi bi-hourglass-split"></i></span>
          <div class="flex-grow-1">
            <div class="fw-semibold">Onay bekleyenler</div>
            <small class="text-body-secondary">Gönderilen kitapları incele</small>
          </div>
          <span class="badge rounded-circle text-bg-warning px-2 py-0 lh-lg"><?php echo $notIsVerified; ?></span>
        </a>

        <a href="<?php echo BASE_URL; ?>admin/users" class="list-group-item list-group-item-action d-flex align-items-center gap-3 px-4 py-3">
          <span class="bg-primary-subtle text-primary-emphasis rounded-3 d-flex p-2 lh-1 flex-shrink-0"><i class="bi bi-people"></i></span>
          <div class="flex-grow-1">
            <div class="fw-semibold">Kullanıcılar</div>
            <small class="text-body-secondary">Kullanıcıları görüntüle</small>
          </div>
          <i class="bi bi-chevron-right text-body-secondary"></i>
        </a>

        <a href="<?php echo BASE_URL; ?>admin/books" class="list-group-item list-group-item-action d-flex align-items-center gap-3 px-4 py-3">
          <span class="bg-info-subtle text-info-emphasis rounded-3 d-flex p-2 lh-1 flex-shrink-0"><i class="bi bi-book"></i></span>
          <div class="flex-grow-1">
            <div class="fw-semibold">Kitaplar</div>
            <small class="text-body-secondary">Tüm kitapları yönet</small>
          </div>
          <i class="bi bi-chevron-right text-body-secondary"></i>
        </a>

        <a href="<?php echo BASE_URL; ?>" class="list-group-item list-group-item-action d-flex align-items-center gap-3 px-4 py-3">
          <span class="bg-secondary-subtle text-secondary-emphasis rounded-3 d-flex p-2 lh-1 flex-shrink-0"><i class="bi bi-house"></i></span>
          <div class="flex-grow-1">
            <div class="fw-semibold">Siteye dön</div>
            <small class="text-body-secondary">Kullanıcı tarafını aç</small>
          </div>
          <i class="bi bi-box-arrow-up-right text-body-secondary"></i>
        </a>

      </div>
    </div>
  </div>

</div>