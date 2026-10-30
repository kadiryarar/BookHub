<div class="modal fade" id="userDeleteModal" tabindex="-1" aria-labelledby="userDeleteModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form class="modal-content border-0 rounded-4 shadow" method="post">

      <div class="modal-body p-4 text-center">
        <span class="bg-danger-subtle text-danger-emphasis rounded-circle d-inline-flex p-3 fs-3 lh-1 mb-3">
          <i class="bi bi-trash"></i>
        </span>
        <h5 class="fw-bold mb-2" id="userDeleteModalTitle">Kullanıcıyı sil</h5>
        <p class="text-body-secondary mb-0">
          <strong id="deleteUserName"></strong> kalıcı olarak silinecek.
          Bu işlem geri alınamaz.
        </p>
        <input type="hidden" name="id" id="deleteUserId">
      </div>

      <div class="modal-footer border-0 justify-content-center p-4 pt-0">
        <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Vazgeç</button>
        <button type="submit" class="btn btn-danger px-4" name="deleteUser">Evet, sil</button>
      </div>

    </form>
  </div>
</div>
<script>

  const userDeleteModal = document.getElementById("userDeleteModal");

  userDeleteModal.addEventListener("show.bs.modal", function (event) {

    const button = event.relatedTarget;
    const id = button.getAttribute("data-user-id");
    const name = button.getAttribute("data-user-name");
    const surname = button.getAttribute("data-user-surname");

    document.getElementById("deleteUserId").value = id;
    document.getElementById("deleteUserName").textContent = name + " " + surname;

  });

</script>