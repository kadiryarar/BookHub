<?php 
    require_once __DIR__ . "/libs/functions.php";
    require_once __DIR__ . "/backend/Database.class.php";
    require_once __DIR__ . "/backend/Categories.class.php";

    $title = "Kategoriler";
    include_once __DIR__ . "/partials/_header.php";
    include_once __DIR__ . "/partials/_sidebar.php";

    $categories = new Categories();
    $category = $categories->getCategories();

?>
<main class="container py-5">

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-3 pb-4 mb-4 border-bottom">
        <div>
            <h2 class="fw-bold mb-1">
                Kitap Kategorileri
            </h2>
            <p class="text-secondary mb-0">
                İlgini çeken kategoriyi seç, kitapları keşfetmeye başla.
            </p>
        </div>
        <span class="badge rounded-pill text-bg-dark px-3 py-2 align-self-start align-self-md-auto">
            <i class="bi bi-tags me-1"></i>
            <?php echo $categories->getCategoryByActiveCount()->totalCategory; ?> kategori
        </span>
    </div>

    <?php if (!empty($category)): ?>
        <div class="row g-4">
            <?php foreach ($category as $cat): ?>
                <div class="col-12 col-sm-6 col-lg-4">
                    <a href="<?php echo BASE_URL; ?>books/category/<?php echo $cat->slug; ?>" class="card h-100 border-0 shadow-sm rounded-4 text-decoration-none text-dark">
                        <div class="card-body p-4 d-flex align-items-center gap-3">
                            <div class="rounded-circle bg-dark text-white d-flex align-items-center justify-content-center flex-shrink-0 fw-bold fs-5" style="width: 52px; height: 52px;">
                                <?php echo mb_strtoupper(mb_substr($cat->name, 0, 1)); ?>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="fw-semibold mb-1">
                                    <?php echo $cat->name; ?>
                                </h6>
                                <span class="text-secondary small">
                                    <i class="bi bi-book me-1"></i>
                                    <?php echo $cat->categoryByBooksCount; ?> kitap
                                </span>
                            </div>
                            <i class="bi bi-arrow-right text-secondary fs-5"></i>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="text-center py-5">
            <i class="bi bi-inbox display-4 text-secondary"></i>
            <h5 class="fw-semibold mt-3 mb-1">
                Henüz kategori yok
            </h5>
            <p class="text-secondary mb-0">
                Şu anda görüntülenecek bir kategori bulunmuyor.
            </p>
        </div>
    <?php endif; ?>

</main>
<?php include_once "partials/_footer.php"; ?>