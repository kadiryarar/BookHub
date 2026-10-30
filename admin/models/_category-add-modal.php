<div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form class="modal-content border-0 rounded-4 shadow" id="categoryForm" method="post">
      <div class="modal-header border-0 p-4 pb-2">
        <h5 class="modal-title fw-bold" id="categoryModalTitle">Kategori ekle</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
      </div>

      <div class="modal-body p-4 pt-2">
        <div class="mb-3">
          <label for="categoryName" class="form-label fw-semibold small">Kategori adı</label>
          <input type="text" class="form-control" id="categoryName" name="name" placeholder="Örn. Roman">
        </div>

        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" role="switch" id="categoryStatus" name="status">
          <label class="form-check-label small" for="categoryStatus">Kategori aktif</label>
        </div>
      </div>

      <div class="modal-footer border-0 p-4 pt-2">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">İptal</button>
        <button type="submit" class="btn btn-warning fw-semibold" name="createCategory">
          <i class="bi bi-check-lg me-2"></i><span>Kaydet</span>
        </button>
      </div>

    </form>
  </div>
</div>