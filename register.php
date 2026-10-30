<?php 

    require_once __DIR__ . "/backend/Database.class.php";
    require_once __DIR__ . "/backend/Users.class.php";
    require_once __DIR__ . "/libs/functions.php";

    if (isloggedIn()) {
      header("Location: home");
    }

    $message = "";
    $name = $surname = $username = $email = "";

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $name = (string) safeHtml($_POST["name"] ?? "");
        $surname = (string) safeHtml($_POST["surname"] ?? "");
        $username = (string) safeHtml($_POST["username"] ?? "");
        $email = (string) safeHtml($_POST["email"] ?? "");
        $password = (string) safeHtml($_POST["password"] ?? "");
        $repassword = (string) safeHtml($_POST["repassword"] ?? "");

        $user = new Users();
        $data = $user->createUser($name, $surname, $username, $email, $password, $repassword);

        $message = '<div class="alert alert-'. $data["status"] . ' alert-dismissible fade show border-0 rounded-3 small" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>' . $data["message"] . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Kapat"></button>
            </div>';  

        if ($data["status"] === "success") { 
          header("Refresh: 1; URL = login");
        }
        
    }

    $title = "Register";  
    include_once __DIR__ . "/partials/_header.php"; 
    include_once __DIR__ . "/partials/_sidebar.php"; 
    
?>

<main class="container flex-grow-1 d-flex align-items-center justify-content-center py-4">
  <section class="w-100">
    <div class="row justify-content-center">
      <div class="col-12 col-sm-10 col-md-7 col-lg-5 col-xl-4">
        <div class="card border-0 shadow-sm rounded-4 p-3 p-md-4">
          <div class="text-center mb-3">
            <i class="bi bi-person-plus text-warning display-3 lh-1"></i>
            <h1 class="h4 fw-bold mt-2 mb-1">Hesap oluştur</h1>
            <p class="text-muted small mb-0">Kitaplarını kaydet, favorilerini ekle, takas teklifleri gönder.</p>
          </div>
          <div id="alertAlani">
            <?php if (!empty($message)) echo $message; ?>
          </div>
          <form method="post">
            <div class="row g-3 mb-3">
              <div class="col-6">
                <label for="name" class="form-label small mb-1">Ad</label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-0"><i class="bi bi-person"></i></span>
                  <input type="text" class="form-control bg-light border-0" id="name" name="name" placeholder="Ad" value="<?php echo $name; ?>">
                </div>
              </div>
              <div class="col-6">
                <label for="surname" class="form-label small mb-1">Soyad</label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-0"><i class="bi bi-person"></i></span>
                  <input type="text" class="form-control bg-light border-0" id="surname" name="surname" placeholder="Soyad" value="<?php echo $surname; ?>">
                </div>
              </div>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label small mb-1">E-posta</label>
              <div class="input-group">
                <span class="input-group-text bg-light border-0"><i class="bi bi-envelope"></i></span>
                <input type="text" class="form-control bg-light border-0" id="email" name="email" placeholder="ornek@mail.com" value="<?php echo $email; ?>">
              </div>
            </div>
            <div class="mb-3">
              <label for="username" class="form-label small mb-1">Kullanıcı Adı</label>
              <div class="input-group">
                <span class="input-group-text bg-light border-0"><i class="bi bi-person"></i></span>
                <input type="text" class="form-control bg-light border-0" id="username" name="username" placeholder="Kullanıcı adı" value="<?php echo $username; ?>">
              </div>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label small mb-1">Şifre</label>
              <div class="input-group">
                <span class="input-group-text bg-light border-0"><i class="bi bi-lock"></i></span>
                <input type="password" class="form-control bg-light border-0" id="password" name="password" placeholder="Şifren">
              </div>
            </div>
            <div class="mb-3">
              <label for="repassword" class="form-label small mb-1">Şifre (tekrar)</label>
              <div class="input-group">
                <span class="input-group-text bg-light border-0"><i class="bi bi-shield-lock"></i></span>
                <input type="password" class="form-control bg-light border-0" id="repassword" name="repassword" placeholder="Şifreni tekrar gir">
              </div>
            </div>
            <button type="submit" class="btn btn-warning rounded-pill w-100 fw-semibold"><i class="bi bi-person-plus me-1"></i>Kayıt Ol</button>
          </form>
          <div class="text-center small text-muted mt-3">Zaten hesabın var mı? <a href="<?php echo BASE_URL; ?>login" class="fw-semibold link-dark">Giriş yap</a></div>
        </div>
      </div>
    </div>
  </section>
</main> 
<?php include_once "partials/_footer.php"; ?> 