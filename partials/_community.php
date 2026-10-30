<?php
    if (isloggedIn()) {
        return;
    }
?>
<section class="container pb-4 pb-lg-5">
    <div class="card bg-dark text-white border-0 border-top border-warning border-4 shadow rounded-4">
        <div class="card-body p-4 p-lg-5">
            <div class="row align-items-center g-4 g-lg-5">
                <div class="col-12 col-lg-7">
                    <span class="badge rounded-pill text-bg-warning px-3 py-2 mb-3">
                        <i class="bi bi-people-fill me-1"></i>
                        Kitapseverler Topluluğu
                    </span>
                    <h2 class="h2 fw-bold mb-3">
                        Topluluğa katıl, kitaplarını paylaş
                    </h2>
                    <p class="text-white-50 lh-lg mb-4">
                        Üye ol, kendi kitaplarını ekle, beğendiklerini favorilerine kaydet
                        ve diğer okurlarla takas teklifleri gönder.
                    </p>
                    <ul class="list-unstyled d-flex flex-column flex-sm-row flex-wrap gap-2 gap-sm-4 mb-0 small">
                        <li class="d-flex align-items-center gap-2">
                            <i class="bi bi-collection text-warning fs-5"></i>
                            Kitaplarını paylaş
                        </li>
                        <li class="d-flex align-items-center gap-2">
                            <i class="bi bi-heart text-warning fs-5"></i>
                            Favorilerine ekle
                        </li>
                        <li class="d-flex align-items-center gap-2">
                            <i class="bi bi-arrow-left-right text-warning fs-5"></i>
                            Takas teklifi gönder
                        </li>
                    </ul>
                </div>
                <div class="col-12 col-lg-5">
                    <div class="d-grid gap-2 ms-lg-auto col-lg-9">
                        <a href="<?php echo BASE_URL . "register"; ?>" class="btn btn-warning rounded-3 py-3 fw-semibold">
                            <i class="bi bi-person-plus-fill me-2"></i>
                            Hemen Üye Ol
                        </a>
                        <a href="<?php echo BASE_URL . "login"; ?>" class="btn btn-outline-light rounded-3 py-3 fw-semibold">
                            <i class="bi bi-box-arrow-in-right me-2"></i>
                            Zaten üyeyim, giriş yap
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>