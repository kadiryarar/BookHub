<?php

    $page = isset($_GET["p"]) ? $_GET["p"] : 1;
    $pageCount = $books->getBooksByPending($page)["pageCount"];
    $pendings = $books->getBooksByPending($page)["notIsVerified"];
    $start = max(2, $page - 1);
    $end = min($pageCount - 1, $page + 1);

?>
<div class="mb-4">
  <h4 class="fw-bold mb-1">Onay Bekleyenler</h4>
  <p class="mb-0 text-body-secondary">Kullanıcıların gönderdiği kitapları inceleyin, onaylayın veya reddedin.</p>
</div>

<div class="row g-3 mb-4">
  <div class="col-6 col-xl-3">
    <div class="card text-bg-dark border-0 rounded-4 h-100">
      <div class="card-body p-3">
        <div class="d-flex justify-content-between align-items-start mb-2">
          <span class="bg-warning text-dark rounded-3 d-flex p-2 fs-5 lh-1 flex-shrink-0">
            <i class="bi bi-hourglass-split"></i>
          </span>
        </div>
        <div class="fs-4 fw-bold lh-1 mb-1"><?php echo $notIsVerified; ?></div>
        <div class="text-white-50 small">Onay bekleyen</div>
      </div>
    </div>
  </div>
</div>

<div class="card border-0 shadow-sm rounded-4">
  <div class="card-header bg-white border-0 p-4 pb-2">
    <h6 class="mb-0 fw-bold">Bekleyen kitaplar</h6>
  </div>

  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead>
        <tr class="text-body-secondary small">
          <th class="ps-4 fw-semibold">Kitap</th>
          <th class="fw-semibold d-none d-md-table-cell">Kategori</th>
          <th class="fw-semibold d-none d-lg-table-cell">Gönderen</th>
          <th class="fw-semibold d-none d-lg-table-cell">Gönderim tarihi</th>
          <th class="fw-semibold text-end pe-4">İşlem</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($pendings)): ?>
          <tr>
            <td colspan="5">
                <div class="d-flex align-items-center justify-content-center gap-2 py-3 text-secondary">
                    <i class="bi bi-hourglass-split text-warning"></i>
                    <span class="small fw-medium">Bekleyen kitap onayı bulunamadı.</span>
                </div>
            </td>
          </tr>
        <?php else: ?>
            <?php foreach ($pendings as $pending): ?>
                <tr>
                    <td class="ps-4 py-3">
                        <div class="d-flex align-items-center gap-3">
                        <img src="<?php echo BASE_URL . 'images/' . $pending->image_name; ?>" alt="<?php echo $pending->title; ?>"
                            width="64" height="64" class="rounded-2 border shadow-sm object-fit-cover flex-shrink-0">
                        <div>
                            <div class="fw-semibold"><?php echo $pending->title; ?></div>
                            <small class="text-body-secondary"><?php echo $pending->author; ?></small>
                        </div>
                        </div>
                    </td>
                    <td class="d-none d-md-table-cell"><span class="badge text-bg-light border"><?php echo $pending->category_name; ?></span></td>
                    <td class="d-none d-lg-table-cell">
                        <div class="d-flex align-items-center gap-2">
                        <span class="bg-primary-subtle text-primary-emphasis rounded-circle d-flex p-2 lh-1 flex-shrink-0"><i class="bi bi-person-fill"></i></span>
                        <span><?php echo $pending->firstName . " " . $pending->lastName?> </span>
                        </div>
                    </td>
                    <td class="d-none d-lg-table-cell text-body-secondary"><?php echo date("d.m.Y", strtotime($pending->created_at)); ?></td>
                    <td class="text-end pe-4 text-nowrap">
                        <a href="<?php echo BASE_URL; ?>books/<?php echo htmlspecialchars($pending->slug) . "/" . htmlspecialchars($pending->book_id); ?>" class="btn btn-sm btn-outline-dark">
                            <i class="bi bi-eye"></i>
                        </a>
                        <button type="button" class="btn btn-sm btn-success" aria-label="Onayla" data-bs-toggle="modal" data-bs-target="#pendingApproveModal" data-book-id="<?php echo $pending->id; ?>" data-book-title="<?php echo $pending->title; ?>">
                            <i class="bi bi-check-lg"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-danger" aria-label="Reddet" data-bs-toggle="modal" data-bs-target="#pendingRejectModal" data-book-id="<?php echo $pending->id; ?>" data-book-title="<?php echo $pending->title; ?>">
                            <i class="bi bi-x-lg"></i>
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


<?php include_once __DIR__ . "/../models/_pending-update-model.php"; ?>
<?php include_once __DIR__ . "/../models/_pending-delete-model.php"; ?>