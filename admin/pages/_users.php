<?php

    $page = isset($_GET["p"]) ? $_GET["p"] : 1;
    $pageCount = $users->getUsersByPagination($page)["pageCount"];
    $user = $users->getUsersByPagination($page)["categories"];
    $start = max(2, $page - 1);
    $end = min($pageCount - 1, $page + 1);

?>
<div class="mb-4">
  <h4 class="fw-bold mb-1">Kullanıcılar</h4>
  <p class="mb-0 text-body-secondary">Kullanıcıların bilgilerini ve rollerini yönetin.</p>
</div>

<div class="row g-3 mb-4">
  <div class="col-6 col-xl-3">
    <div class="card text-bg-dark border-0 rounded-4 h-100">
      <div class="card-body p-3">
        <div class="d-flex justify-content-between align-items-start mb-2">
            <span class="bg-warning text-dark rounded-3 d-flex p-2 fs-5 lh-1 flex-shrink-0">
                <i class="bi bi-people"></i>
            </span>
        </div>
        <div class="fs-4 fw-bold lh-1 mb-1"><?php echo $users->getUsersCount()->totalUsers; ?></div>
        <div class="text-white-50 small">Toplam kullanıcı</div>
      </div>
    </div>
  </div>
  <div class="col-6 col-xl-3">
    <div class="card border-0 shadow-sm rounded-4 h-100">
      <div class="card-body p-3">
        <div class="d-flex justify-content-between align-items-start mb-2">
          <span class="bg-success-subtle text-success-emphasis rounded-3 d-flex p-2 fs-5 lh-1 flex-shrink-0"><i class="bi bi-person"></i></span>
        </div>
        <div class="fs-4 fw-bold lh-1 mb-1"><?php echo $users->getUsersByMemberCount()->totalMember; ?></div>
        <div class="text-body-secondary small">Kullanıcı</div>
      </div>
    </div>
  </div>
  <div class="col-6 col-xl-3">
    <div class="card border-0 shadow-sm rounded-4 h-100">
      <div class="card-body p-3">
        <div class="d-flex justify-content-between align-items-start mb-2">
          <span class="bg-primary-subtle text-primary-emphasis rounded-3 d-flex p-2 fs-5 lh-1 flex-shrink-0"><i class="bi bi-shield-check"></i></span>
        </div>
        <div class="fs-4 fw-bold lh-1 mb-1"><?php echo $users->getUsersByAdminCount()->totalAdmin; ?></div>
        <div class="text-body-secondary small">Yönetici</div>
      </div>
    </div>
  </div>
</div>

<div class="card border-0 shadow-sm rounded-4">
  <div class="card-header bg-white border-0 d-flex align-items-center justify-content-between p-4 pb-2">
    <h6 class="mb-0 fw-bold">Kullanıcı listesi</h6>
    <small class="text-body-secondary">Toplam <?php echo $users->getUsersCount()->totalUsers; ?> kayıt</small>
  </div>

  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead>
        <tr class="text-body-secondary small">
          <th class="ps-4 fw-semibold">Kullanıcı</th>
          <th class="fw-semibold d-none d-md-table-cell">Rol</th>
          <th class="fw-semibold d-none d-md-table-cell">Kitap sayısı</th>
          <th class="fw-semibold d-none d-lg-table-cell">Kayıt tarihi</th>
          <th class="fw-semibold text-end pe-4">İşlem</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($user)): ?>
          <tr>
            <td colspan="5">
                <div class="d-flex align-items-center justify-content-center gap-2 py-3 text-secondary">
                    <i class="bi bi-people text-warning"></i>
                    <span class="small fw-medium">Gösterilecek kullanıcı bulunamadı.</span>
                </div>
            </td>
          </tr>
        <?php else: ?>
            <?php foreach ($user as $u): ?>
                <tr>
                    <td class="ps-4 py-3">
                        <div class="d-flex align-items-center gap-3">
                          <div class="rounded-circle border bg-light text-secondary d-flex align-items-center justify-content-center flex-shrink-0 fw-semibold" style="width: 40px; height: 40px;">
                              <?php echo strtoupper(substr($u->name, 0, 1) . substr($u->surname, 0, 1)); ?>
                          </div>
                          <div>
                              <div class="fw-semibold">
                                  <?php echo $u->name . " " . $u->surname; ?>
                              </div>
                              <small class="text-body-secondary">
                                  <?php echo $u->email; ?>
                              </small>
                          </div>
                        </div>
                    </td>
                    <td class="d-none d-md-table-cell">
                        <span class="badge text-bg-light border fw-normal">
                            <?php echo ($u->user_type == "admin") ? "Yönetici" : "Üye" ; ?>
                        </span>
                    </td>
                    <td class="d-none d-md-table-cell">
                        <?php echo $u->userCountByBooks; ?>
                    </td>
                    <td class="d-none d-lg-table-cell text-body-secondary"><?php echo date("d.m.Y", strtotime($u->created_at)); ?></td>
                    <td class="text-end pe-4 text-nowrap">
                        <button type="button" class="btn btn-sm btn-outline-dark" aria-label="Düzenle" data-bs-toggle="modal" data-bs-target="#userEditModal" data-user-id="<?php echo $u->id; ?>" data-user-name="<?php echo $u->name; ?>" data-user-surname="<?php echo $u->surname; ?>" data-user-username="<?php echo $u->username; ?>" data-user-email="<?php echo $u->email; ?>" data-user-role="<?php echo $u->user_type; ?>">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-danger" aria-label="Sil" data-bs-toggle="modal" data-bs-target="#userDeleteModal" data-user-id="<?php echo $u->id; ?>" data-user-name="<?php echo $u->name; ?>" data-user-surname="<?php echo $u->surname; ?>">
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

<?php include_once __DIR__ . "/../models/_user-edit-modal.php"; ?>
<?php include_once __DIR__ . "/../models/_user-delete-modal.php"; ?>