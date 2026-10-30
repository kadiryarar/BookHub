<div class="modal fade" id="pendingApproveModal" tabindex="-1" aria-labelledby="pendingApproveModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form class="modal-content border-0 rounded-4 shadow" method="post">

      <div class="modal-body p-4 text-center">
        <span class="bg-success-subtle text-success-emphasis rounded-circle d-inline-flex p-3 fs-3 lh-1 mb-3">
          <i class="bi bi-check-lg"></i>
        </span>
        <h5 class="fw-bold mb-2" id="pendingApproveModalTitle">Kitabı onayla</h5>
        <p class="text-body-secondary mb-0">
          <strong id="approveBookTitle"></strong> kitabı yayına alınacak. Onaylamak istediğinize emin misiniz?
        </p>
        <input type="hidden" name="id" id="approveBookId" value="">
      </div>

      <div class="modal-footer border-0 justify-content-center p-4 pt-0">
        <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Vazgeç</button>
        <button type="submit" class="btn btn-success px-4" name="bookIsVerified">Evet, onayla</button>
      </div>

    </form>
  </div>
</div>
<script>

  const updateModal = document.getElementById("pendingApproveModal");

  updateModal.addEventListener("show.bs.modal", function (event) {

    const button = event.relatedTarget;
    const id = button.getAttribute("data-book-id");
    const name = button.getAttribute("data-book-title");
    document.getElementById("approveBookId").value = id;
    document.getElementById("approveBookTitle").textContent = name;

  });

</script>