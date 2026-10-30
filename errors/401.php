<?php include_once __DIR__ . "/../libs/variables.php"; ?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>401 - Kimlik Doğrulama Gerekli | BookHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-body-tertiary">
    <main class="container min-vh-100 d-flex flex-column justify-content-center align-items-center py-5">
        <a href="<?php echo BASE_URL; ?>" class="text-dark text-decoration-none d-flex align-items-center gap-2 mb-4">
            <span class="bg-dark text-warning rounded-3 p-2 d-flex fs-5 lh-1">
                <i class="bi bi-book-half"></i>
            </span>
            <span class="fs-4 fw-bold">Book<span class="text-warning">Hub</span></span>
        </a>
        <div class="card text-bg-dark border-0 shadow rounded-4 w-100" style="max-width: 560px;">
            <div class="card-body p-4 p-md-5 text-center">
                <span class="bg-warning text-dark rounded-4 d-inline-flex p-3 fs-1 lh-1 mb-4">
                    <i class="bi bi-person-lock"></i>
                </span>
                <div class="display-1 fw-bold text-warning lh-1 mb-3">401</div>
                <h1 class="h4 fw-bold mb-3">Önce giriş yapmalısın</h1>
                <p class="text-white-50 mb-4">
                    Bu sayfayı görüntülemek için oturum açman gerekiyor.
                    BookHub hesabınla giriş yaparak kaldığın yerden devam edebilirsin.
                </p>
                <div class="d-grid d-sm-flex justify-content-center gap-2">
                    <a href="<?php echo BASE_URL; ?>login" class="btn btn-warning fw-semibold px-4">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Giriş Yap
                    </a>
                    <a href="<?php echo BASE_URL; ?>" class="btn btn-outline-light px-4">
                        <i class="bi bi-house me-2"></i>Siteye Dön
                    </a>
                </div>
            </div>
            <div class="card-footer border-secondary-subtle border-opacity-25 bg-transparent text-center text-white-50 small py-3">
                <i class="bi bi-person-plus me-1"></i>
                Henüz hesabın yok mu?
                <a href="<?php echo BASE_URL; ?>register" class="link-warning fw-semibold text-decoration-none ms-1">
                    Kayıt Ol
                </a>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>