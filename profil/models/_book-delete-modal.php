
<div class="modal fade" id="bookDeleteModal" tabindex="-1" aria-labelledby="deleteModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content border-0 rounded-4 shadow" id="deleteForm" method="post">

            <div class="modal-body p-4 text-center">
                <span class="bg-danger-subtle text-danger-emphasis rounded-circle d-inline-flex p-3 fs-3 lh-1 mb-3">
                    <i class="bi bi-trash"></i>
                </span>

                <h5 class="fw-bold mb-2" id="deleteModalTitle">
                    Kitabı sil
                </h5>

                <p class="text-body-secondary mb-0">
                    <strong id="deleteBookName"></strong> kitabını silmek istediğinize emin misiniz?
                    Bu işlem geri alınamaz.
                </p>

                <input type="hidden" name="id" id="deleteBookId">
            </div>

            <div class="modal-footer border-0 justify-content-center p-4 pt-0">
                <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">
                    Vazgeç
                </button>

                <button type="submit" class="btn btn-danger px-4" name="deleteBook">
                    Evet, sil
                </button>
            </div>

        </form>
    </div>
</div>

<script>
    const bookDeleteModal = document.getElementById("bookDeleteModal");

    bookDeleteModal.addEventListener("show.bs.modal", function(event) {

        const button = event.relatedTarget;

        const id = button.getAttribute("data-book-id");
        const title = button.getAttribute("data-book-title");

        document.getElementById("deleteBookId").value = id;
        document.getElementById("deleteBookName").textContent = title;

    });
</script>