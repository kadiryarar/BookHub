<?php 

    require_once __DIR__ . "/backend/Database.class.php";
    require_once __DIR__ . "/backend/Users.class.php";
    require_once __DIR__ . "/libs/functions.php";

    if (isloggedIn()) {
      header("Location: home");
    }

    $message = "";
    $email = "";

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $email = (string) safeHtml($_POST["email"] ?? "");
        $password = (string) safeHtml($_POST["password"] ?? "");

        $user = new Users();
        $data = $user->checkLogin($email, $password);

        $message = '<div class="alert alert-'. $data["status"] . ' alert-dismissible fade show border-0 rounded-3 small" role="alert">';
        if ($data["status"] === "success") {
          $message .= '<i class="bi bi-check-circle-fill"></i> ';
        }
        else {
          $message .= '<i class="bi bi-exclamation-triangle-fill me-2"></i> ';
        }

        $message .= $data["message"] . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Kapat"></button></div>';  

        if ($data["status"] === "success") { 
          $_SESSION["id"] = $data["id"];
          $_SESSION["name"] = $data["name"];
          $_SESSION["surname"] = $data["surname"];
          $_SESSION["username"] = $data["username"];
          $_SESSION["email"] = $data["email"];
          $_SESSION["user_type"] = $data["user_type"];
          $_SESSION["created_at"] = $data["created_at"];
          $_SESSION["isLogged"] = true;

          header("Refresh: 1; URL = home");
        }
    }

    $title = "Login";  
    include_once __DIR__ . "/partials/_header.php"; 
    include_once __DIR__ . "/partials/_sidebar.php"; 
    
?>

<main class="container flex-grow-1 d-flex align-items-center justify-content-center py-4">
  <section class="w-100">
    <div class="row justify-content-center">
      <div class="col-12 col-sm-10 col-md-7 col-lg-5 col-xl-4">
        <div class="card border-0 shadow-sm rounded-4 p-3 p-md-4">
          <div class="text-center mb-3">
            <i class="bi bi-person-circle text-warning display-3 lh-1"></i>
            <h1 class="h4 fw-bold mt-2 mb-1">Tekrar hoş geldin</h1>
            <p class="text-muted small mb-0">Hesabına giriş yap, kitaplarını ve takaslarını yönet.</p>
          </div>
          <div id="alertAlani">
            <?php if (!empty($message)) echo $message; ?>
          </div>
          <form method="post">
            <div class="mb-3">
              <label for="email" class="form-label small mb-1">Kullanıcı Adı / E-posta</label>
              <div class="input-group">
                <span class="input-group-text bg-light border-0"><i class="bi bi-envelope"></i></span>
                <input type="text" class="form-control bg-light border-0" id="email" name="email" placeholder="Kullanıcı adı veya e-posta" value="<?php echo $email; ?>">
              </div>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label small mb-1">Şifre</label>
              <div class="input-group">
                <span class="input-group-text bg-light border-0"><i class="bi bi-lock"></i></span>
                <input type="password" class="form-control bg-light border-0" id="password" name="password" placeholder="Şifren">
              </div>
            </div>
            <button type="submit" class="btn btn-warning rounded-pill w-100 fw-semibold"><i class="bi bi-box-arrow-in-right me-1"></i>Giriş Yap</button>
          </form>
          <div class="text-center small text-muted mt-3">Hesabın yok mu? <a href="<?php echo BASE_URL; ?>register" class="fw-semibold link-dark">Kayıt ol</a></div>
        </div>
      </div>
    </div>
  </section>
</main> 
<?php include_once "partials/_footer.php"; ?> 