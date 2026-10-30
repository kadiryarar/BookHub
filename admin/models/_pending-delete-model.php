<div class="modal fade" id="pendingRejectModal" tabindex="-1" aria-labelledby="pendingRejectModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form class="modal-content border-0 rounded-4 shadow" method="post">

      <div class="modal-header border-0 p-4 pb-2">
        <h5 class="modal-title fw-bold" id="pendingRejectModalTitle">Kitabı reddet</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
      </div>

      <div class="modal-body p-4 pt-2">
        <p class="text-body-secondary small mb-3">
          <strong id="rejectBookTitle"></strong> kitabı kalıcı olarak silinecek. Bu işlem geri alınamaz.
        </p>
        <input type="hidden" name="id" id="rejectBookId" value="">
      </div>

      <div class="modal-footer border-0 p-4 pt-2">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Vazgeç</button>
        <button type="submit" class="btn btn-danger fw-semibold" name="bookNotIsVerified"><i class="bi bi-x-lg me-2"></i>Reddet</button>
      </div>

    </form>
  </div>
</div>
<script>

  const rejectModal = document.getElementById("pendingRejectModal");

  rejectModal.addEventListener("show.bs.modal", function (event) {

    const button = event.relatedTarget;
    const id = button.getAttribute("data-book-id");
    const name = button.getAttribute("data-book-title");
    document.getElementById("rejectBookId").value = id;
    document.getElementById("rejectBookTitle").textContent = name;

  });

</script>