<?php

  $page = isset($_GET["p"]) ? $_GET["p"] : 1;
  $pageCount = $categories->getCategoriesByPagination($page)["pageCount"];
  $cat = $categories->getCategoriesByPagination($page)["categories"];
  $start = max(2, $page - 1);
  $end = min($pageCount - 1, $page + 1);

?>
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
  <div>
    <h4 class="fw-bold mb-1">Kategoriler</h4>
    <p class="mb-0 text-body-secondary">Kitap kategorilerini ekleyin, düzenleyin veya silin.</p>
  </div>
  <form method="post">
      <button type="button" class="btn btn-warning fw-semibold" data-bs-toggle="modal" data-bs-target="#categoryModal">
        <i class="bi bi-plus-lg me-2"></i>Kategori ekle
      </button>
  </form>
</div>

<div class="row g-3 mb-4">
  <div class="col-6 col-xl-3">
    <div class="card text-bg-dark border-0 rounded-4 h-100">
      <div class="card-body p-3">
        <div class="d-flex justify-content-between align-items-start mb-2">
          <span class="bg-warning text-dark rounded-3 d-flex p-2 fs-5 lh-1 flex-shrink-0"><i class="bi bi-tags"></i></span>
        </div>
        <div class="fs-4 fw-bold lh-1 mb-1"><?php echo $categories->getCategoryCount()->totalCategory; ?></div>
        <div class="text-white-50 small">Toplam kategori</div>
      </div>
    </div>
  </div>
  <div class="col-6 col-xl-3">
    <div class="card border-0 shadow-sm rounded-4 h-100">
      <div class="card-body p-3">
        <div class="d-flex justify-content-between align-items-start mb-2">
          <span class="bg-success-subtle text-success-emphasis rounded-3 d-flex p-2 fs-5 lh-1 flex-shrink-0"><i class="bi bi-check-circle"></i></span>
        </div>
        <div class="fs-4 fw-bold lh-1 mb-1"><?php echo $categories->getCategoryByActiveCount()->totalCategory; ?></div>
        <div class="text-body-secondary small">Aktif kategori</div>
      </div>
    </div>
  </div>
  <div class="col-6 col-xl-3">
    <div class="card border-0 shadow-sm rounded-4 h-100">
      <div class="card-body p-3">
        <div class="d-flex justify-content-between align-items-start mb-2">
          <span class="bg-secondary-subtle text-secondary-emphasis rounded-3 d-flex p-2 fs-5 lh-1 flex-shrink-0"><i class="bi bi-slash-circle"></i></span>
        </div>
        <div class="fs-4 fw-bold lh-1 mb-1"><?php echo $categories->getCategoryByPassiveCount()->totalCategory; ?></div>
        <div class="text-body-secondary small">Pasif kategori</div>
      </div>
    </div>
  </div>
  <div class="col-6 col-xl-3">
    <div class="card border-0 shadow-sm rounded-4 h-100">
      <div class="card-body p-3">
        <div class="d-flex justify-content-between align-items-start mb-2">
          <span class="bg-primary-subtle text-primary-emphasis rounded-3 d-flex p-2 fs-5 lh-1 flex-shrink-0"><i class="bi bi-book"></i></span>
        </div>
        <div class="fs-4 fw-bold lh-1 mb-1"><?php echo $categories->getCategoryByBooks()->totalBooks; ?></div>
        <div class="text-body-secondary small">Kategorilere bağlı kitap</div>
      </div>
    </div>
  </div>
</div>

<div class="card border-0 shadow-sm rounded-4">
  <div class="card-header bg-white border-0 d-flex align-items-center justify-content-between p-4 pb-2">
    <h6 class="mb-0 fw-bold">Kategori listesi</h6>
    <small class="text-body-secondary">Toplam <?php echo $categories->getCategoryCount()->totalCategory; ?> kayıt</small>
  </div>

  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead>
        <tr class="text-body-secondary small">
          <th class="ps-4 fw-semibold">Kategori</th>
          <th class="fw-semibold d-none d-md-table-cell">Kitap sayısı</th>
          <th class="fw-semibold">Durum</th>
          <th class="fw-semibold d-none d-lg-table-cell">Oluşturulma</th>
          <th class="fw-semibold text-end pe-4">İşlem</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($cat)): ?>
          <tr>
            <td colspan="5">
                <div class="d-flex align-items-center justify-content-center gap-2 py-3 text-secondary">
                    <i class="bi bi-tags text-warning"></i>
                    <span class="small fw-medium">Gösterilecek kategori bulunamadı.</span>
                </div>
            </td>
          </tr>
        <?php else: ?>
          <?php foreach ($cat as $category): ?>
              <tr>
                <td class="ps-4 py-3">
                    <div class="d-flex align-items-center gap-3">
                        <div>
                            <div class="fw-semibold text-capitalize"><?php echo $category->name; ?></div>
                            <small class="text-body-secondary"><?php echo $category->slug; ?></small>
                        </div>
                    </div>
                </td>
                <td class="d-none d-md-table-cell">
                    <?php echo $category->categoryCountByBooks; ?>
                </td>
                <td>
                    <?php if ($category->is_verified): ?>
                        <span class="badge text-bg-success-subtle bg-success-subtle text-success-emphasis">
                            Aktif
                        </span>
                    <?php else: ?>
                        <span class="badge text-bg-danger-subtle bg-danger-subtle text-danger-emphasis">
                            Pasif
                        </span>
                    <?php endif; ?>
                </td>
                <td class="d-none d-lg-table-cell text-body-secondary">
                    <?php echo date("d.m.Y", strtotime($category->created_at)); ?>
                </td>
                <td class="text-end pe-4 text-nowrap">
                    <button type="button" class="btn btn-sm btn-outline-dark" aria-label="Düzenle" data-bs-toggle="modal" data-bs-target="#categoryEditModal" data-category-id="<?php echo $category->id; ?>" data-category-name="<?php echo $category->name; ?>" data-category-status="<?php echo $category->is_verified; ?>">
                        <i class="bi bi-pencil-square"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-danger" aria-label="Sil" data-bs-toggle="modal" data-bs-target="#deleteModal" data-category-id="<?php echo $category->id; ?>" data-category-name="<?php echo $category->name; ?>">
                            <i class="bi bi-trash"></i>
                    </button>
                </td>
              </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
  <?php include_once __DIR__ . "/../partials/_pagination.php"; ?>
</div>

<?php include_once __DIR__ . "/../models/_category-add-modal.php"; ?>
<?php include_once __DIR__ . "/../models/_category-edit-modal.php"; ?>
<?php include_once __DIR__ . "/../models/_category-delete-modal.php"; ?>