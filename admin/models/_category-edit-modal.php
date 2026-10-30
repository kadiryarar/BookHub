<div class="modal fade" id="categoryEditModal" tabindex="-1" aria-labelledby="categoryEditModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form class="modal-content border-0 rounded-4 shadow" method="post">
      <div class="modal-header border-0 p-4 pb-2">
        <h5 class="modal-title fw-bold" id="categoryEditModalTitle">Kategoriyi düzenle</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
      </div>

      <div class="modal-body p-4 pt-2">
        <input type="hidden" name="id" id="editCategoryId">

        <div class="mb-3">
          <label for="editCategoryName" class="form-label fw-semibold small">Kategori adı</label>
          <input type="text" class="form-control" id="editCategoryName" name="name">
        </div>

        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" role="switch" id="editCategoryStatus" name="status">
          <label class="form-check-label small" for="editCategoryStatus">Kategori aktif</label>
        </div>
      </div>

      <div class="modal-footer border-0 p-4 pt-2">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">İptal</button>
        <button type="submit" class="btn btn-warning fw-semibold" name="editCategory"><i class="bi bi-check-lg me-2"></i>Güncelle</button>
      </div>

    </form>
  </div>
</div>
<script>
  const categoryEditModal = document.getElementById("categoryEditModal");

  categoryEditModal.addEventListener("show.bs.modal", function(event) {

      const button = event.relatedTarget;

      const id = button.getAttribute("data-category-id");
      const name = button.getAttribute("data-category-name");
      const status = button.getAttribute("data-category-status");

      document.getElementById("editCategoryId").value = id;
      document.getElementById("editCategoryName").value = name;

      const statusInput = document.getElementById("editCategoryStatus");

      if (status == "1") {
          statusInput.checked = true;
      } else {
          statusInput.checked = false;
      }
  });
</script>