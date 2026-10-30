<?php

    $user = $users->getUserById($_SESSION["id"]);

?>
<div class="mb-3 pb-3 border-bottom">
    <h2 class="h5 fw-bold mb-1"><i class="bi bi-gear text-dark me-2"></i>Profil Ayarları</h2>
    <p class="text-muted small mb-0">Hesap bilgilerini ve şifreni buradan güncelle.</p>
</div>

<form method="post" style="max-width: 760px;">
    <div class="border rounded-4 p-3 p-md-4 mb-3">
        <div class="d-flex align-items-center gap-2 mb-3">
            <i class="bi bi-person-circle text-primary fs-5"></i>
            <h3 class="h6 fw-bold mb-0">Kişisel bilgiler</h3>
        </div>

        <div class="row g-3">
            <div class="col-md-6">
                <div class="form-floating">
                    <input type="text" class="form-control rounded-3" id="profileName" name="name" value="<?php echo $user->name; ?>" placeholder="Ad">
                    <label for="profileName">Ad</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating">
                    <input type="text" class="form-control rounded-3" id="profileSurname" name="surname" value="<?php echo $user->surname; ?>" placeholder="Soyad">
                    <label for="profileSurname">Soyad</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-body-tertiary rounded-start-3"><i class="bi bi-envelope"></i></span>
                    <div class="form-floating">
                        <input type="email" class="form-control rounded-end-3" id="profileEmail" name="email" value="<?php echo $user->email; ?>" placeholder="E-posta">
                        <label for="profileEmail">E-posta</label>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-body-tertiary rounded-start-3"><i class="bi bi-person"></i></span>
                    <div class="form-floating">
                        <input type="text" class="form-control rounded-end-3" id="profileUsername" name="username" value="<?php echo $user->username; ?>" placeholder="Kullanıcı Adı">
                        <label for="profileEmail">Kullanıcı Adı</label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="border rounded-4 p-3 p-md-4 mb-3">
        <div class="d-flex align-items-center gap-2 mb-1">
            <i class="bi bi-shield-lock text-primary fs-5"></i>
            <h3 class="h6 fw-bold mb-0">Şifre</h3>
        </div>
        <p class="text-muted small mb-3">Şifreni değiştirmek istemiyorsan bu alanları boş bırak.</p>

        <div class="row g-3">
            <div class="col-12">
                <div class="form-floating">
                    <input type="password" class="form-control rounded-3" id="oldPassword" name="old_password" placeholder="Eski Şifre" autocomplete="current-password">
                    <label for="oldPassword">Eski Şifre</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating">
                    <input type="password" class="form-control rounded-3" id="newPassword" name="new_password" placeholder="Yeni Şifre" autocomplete="new-password">
                    <label for="newPassword">Yeni Şifre</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating">
                    <input type="password" class="form-control rounded-3" id="newPasswordAgain" name="new_password_again" placeholder="Şifre Tekrar" autocomplete="new-password">
                    <label for="newPasswordAgain">Şifre Tekrar</label>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column-reverse flex-sm-row justify-content-sm-end gap-2">
        <a href="" class="btn btn-outline-secondary rounded-pill px-4">Vazgeç</a>
        <button type="submit" class="btn btn-dark rounded-pill px-4" name="updateProfil"><i class="bi bi-check-lg me-1"></i>Kaydet</button>
    </div>
</form>