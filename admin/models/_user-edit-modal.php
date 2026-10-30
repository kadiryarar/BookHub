<div class="modal fade" id="userEditModal" tabindex="-1" aria-labelledby="userEditModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form class="modal-content border-0 rounded-4 shadow" method="post">

      <div class="modal-header border-0 p-4 pb-2">
        <h5 class="modal-title fw-bold" id="userEditModalTitle">Kullanıcıyı düzenle</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
      </div>

      <div class="modal-body p-4 pt-2">
        <input type="hidden" name="id" id="editUserId">

        <div class="row g-3 mb-3">
          <div class="col-sm-6">
            <label for="editUserName" class="form-label fw-semibold small">Ad</label>
            <input type="text" class="form-control" id="editUserName" name="name">
          </div>
          <div class="col-sm-6">
            <label for="editUserSurname" class="form-label fw-semibold small">Soyad</label>
            <input type="text" class="form-control" id="editUserSurname" name="surname">
          </div>
        </div>

        <div class="mb-3">
          <label for="editUserUsername" class="form-label fw-semibold small">Kullanıcı adı</label>
          <input type="text" class="form-control" id="editUserUsername" name="username">
        </div>

        <div class="mb-3">
          <label for="editUserEmail" class="form-label fw-semibold small">E-posta</label>
          <input type="text" class="form-control" id="editUserEmail" name="email">
        </div>

        <div class="mb-3">
          <label for="editUserType" class="form-label fw-semibold small">Kullanıcı türü</label>
          <select class="form-select" id="editUserType" name="user_type">
            <option value="user">Üye</option>
            <option value="admin">Yönetici</option>
          </select>
        </div>
      </div>

      <div class="modal-footer border-0 p-4 pt-2">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">İptal</button>
        <button type="submit" class="btn btn-warning fw-semibold" name="editUser">
          <i class="bi bi-check-lg me-2"></i>
          Güncelle
        </button>
      </div>

    </form>
  </div>
</div>
<script>
  const userEditModal = document.getElementById("userEditModal");

  userEditModal.addEventListener("show.bs.modal", function(event) {

      const button = event.relatedTarget;

      const id = button.getAttribute("data-user-id");
      const name = button.getAttribute("data-user-name");
      const surname = button.getAttribute("data-user-surname");
      const username = button.getAttribute("data-user-username");
      const email = button.getAttribute("data-user-email");
      const role = button.getAttribute("data-user-role");

      document.getElementById("editUserId").value = id;
      document.getElementById("editUserName").value = name;
      document.getElementById("editUserSurname").value = surname;
      document.getElementById("editUserUsername").value = username;
      document.getElementById("editUserEmail").value = email;
      document.getElementById("editUserType").value = role;
  });
</script>