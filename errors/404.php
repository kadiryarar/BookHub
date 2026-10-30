<?php include_once "../libs/variables.php"; ?>
<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>404 - Sayfa Bulunamadı | BookHub</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-body-tertiary">

  <main class="container min-vh-100 d-flex flex-column justify-content-center align-items-center py-5">

    <a href="<?php echo BASE_URL; ?>" class="text-dark text-decoration-none d-flex align-items-center gap-2 mb-4">
      <span class="bg-dark text-warning rounded-3 p-2 d-flex fs-5 lh-1"><i class="bi bi-book-half"></i></span>
      <span class="fs-4 fw-bold">Book<span class="text-warning">Hub</span></span>
    </a>

    <div class="card text-bg-dark border-0 shadow rounded-4 w-100" style="max-width: 560px;">
      <div class="card-body p-4 p-md-5 text-center">

        <span class="bg-warning text-dark rounded-4 d-inline-flex p-3 fs-1 lh-1 mb-4">
          <i class="bi bi-search"></i>
        </span>

        <div class="display-1 fw-bold text-warning lh-1 mb-3">404</div>
        <h1 class="h4 fw-bold mb-3">Aradığın kitap rafta yok</h1>
        <p class="text-white-50 mb-4">
          Bu adreste bir sayfa bulamadık. Sayfa taşınmış ya da silinmiş olabilir,
          adresi yanlış yazmış da olabilirsin.
        </p>

        <div class="d-grid d-sm-flex justify-content-center gap-2">
          <a href="<?php echo BASE_URL; ?>" class="btn btn-warning fw-semibold px-4">
            <i class="bi bi-house me-2"></i>Siteye Dön
          </a>
          <button type="button" class="btn btn-outline-light px-4" onclick="history.back()">
            <i class="bi bi-arrow-left me-2"></i>Geri Git
          </button>
        </div>
      </div>
    </div>

  </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>