<?php 
    require_once __DIR__ . "/libs/functions.php";
    require_once __DIR__ . "/backend/Database.class.php";
    require_once __DIR__ . "/backend/Books.class.php";
    require_once __DIR__ . "/backend/Categories.class.php";

    $title = "Kitaplar";
    include_once __DIR__ . "/partials/_header.php";
    include_once __DIR__ . "/partials/_sidebar.php";

    $cat = trim(isset($_GET["category"]) ? $_GET["category"] : "");
    $keyword = trim(isset($_GET["keyword"]) ? $_GET["keyword"] : "");
    $keyword = urldecode($keyword);
    $page = isset($_GET["page"]) ? $_GET["page"] : 1;

    $categories = new Categories();
    $books = new Books();

    $result = $books->getBooksByFilters($cat, $keyword, $page);
    $totalBooks = $result["totalBooks"];
    $getBooks = $result["books"];
    $totalPages = $result["totalPages"];
    $start = $result["start"];
    $end = $result["end"];

    if ($keyword !== '') {
        $baseUrl = BASE_URL . 'books/search/' . rawurlencode($keyword) . '/';
    } elseif ($cat !== '') {
        $baseUrl = BASE_URL . 'books/' . $cat . '/';
    } else {
        $baseUrl = BASE_URL . 'books/page/';
    }

    $pageUrl = function (int $p) use ($baseUrl) {
        return $baseUrl . $p;
    };

?>
<main class="container py-4 py-lg-5">
    <div class="d-flex justify-content-between align-items-center gap-2 mb-4">
        <h1 class="h5 fw-bold text-dark mb-0 text-nowrap">
            <i class="bi bi-book-half me-2" style="color: #1e293b;"></i>BookHub
            <span class="fw-normal">Kütüphanesi</span>
        </h1>
        <span class="badge bg-light text-dark border rounded-pill px-3 py-2 fw-medium flex-shrink-0">
            <i class="bi bi-book-half me-1"></i>
            <?php echo $totalBooks; ?> Kitap
        </span>
    </div>

    <div class="mb-2">
        <h2 class="h6 fw-bold text-dark mb-3">
            <i class="bi bi-sliders me-2" style="color: #1e293b;"></i>
            Kategoriye Göre Filtrele
        </h2>
        <div class="d-flex flex-nowrap gap-2 overflow-x-auto pb-2">
            <a href="<?php echo BASE_URL; ?>books" class="<?php echo !isset($_GET["category"]) ? 'btn btn-dark' : 'btn btn-light'; ?> border rounded-pill px-4 py-2 flex-shrink-0">
                Tümü
            </a>
            <?php foreach ($categories->getCategories() as $category): ?>
                <a href="<?php echo BASE_URL; ?>books/category/<?php echo $category->slug; ?>" class="<?php echo (isset($_GET["category"]) && $_GET["category"] == $category->slug) ? 'btn btn-dark' : 'btn btn-light'; ?> border rounded-pill px-4 py-2 flex-shrink-0">
                    <?php echo $category->name; ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

    <?php include_once __DIR__ . "/partials/_mobile-search.php"; ?>

    <?php if (!empty($cat) || !empty($keyword)): ?>
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 bg-light rounded-4 p-3 mb-4">
            <div class="d-flex flex-wrap align-items-center gap-2">
                <span class="small text-dark">
                    <i class="bi bi-funnel me-2"></i>
                    Uygulanan Filtreler:
                </span>
                
                <?php if (!empty($cat)): ?>
                    <span class="badge bg-white text-dark border rounded-pill px-3 py-2">
                        Kategori: <?php echo htmlspecialchars($cat); ?>
                        <a href="<?php echo BASE_URL; ?><?php echo !empty($keyword) ? 'books/search/' . urlencode($keyword) : 'books'; ?>" class="text-dark text-decoration-none ms-2" aria-label="Kategoriyi kaldır">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    </span>
                <?php endif; ?>

                <?php if (!empty($keyword)): ?>
                    <span class="badge bg-white text-dark border rounded-pill px-3 py-2">
                        Arama: <?php echo htmlspecialchars($keyword); ?>
                        <a href="<?php echo BASE_URL; ?><?php echo !empty($cat) ? 'books/category/' . urlencode($cat) : 'books'; ?>" class="text-dark text-decoration-none ms-2" aria-label="Aranan kelimeyi kaldır">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    </span>
                <?php endif; ?>
            </div>
            
            <a href="<?php echo BASE_URL; ?>books" class="text-danger text-decoration-none small">
                <i class="bi bi-arrow-counterclockwise me-1"></i>
                Filtreleri Temizle
            </a>
        </div>
    <?php endif; ?>

    <?php if (empty($getBooks)): ?>
        <div class="text-center bg-light rounded-4 p-4 p-md-5">
            <i class="bi bi-inbox text-secondary display-4"></i>
            <h3 class="h5 fw-bold text-dark mt-3 mb-2">
                Gösterilecek içerik bulunamadı
            </h3>
            <p class="text-secondary mb-0">
                Şu anda görüntülenecek herhangi bir içerik bulunmuyor.
            </p>
        </div>
    <?php else: ?>
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 g-3">
            <?php foreach ($getBooks as $book): ?>
                <div class="col">
                    <div class="card border-0 rounded-4 overflow-hidden shadow-sm position-relative text-white" style="min-height: 300px;">
                        <img src="<?php echo BASE_URL . "images/" . htmlspecialchars($book->image_name); ?>" class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover" alt="Kürk Mantolu Madonna">
                        <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(180deg, rgba(0,0,0,.15), rgba(8,20,28,.95));"></div>
                        <div class="card-body position-relative d-flex flex-column justify-content-between p-3" style="min-height: 300px;">
                            <div>
                                <span class="badge bg-white text-dark rounded-pill px-3 py-2">
                                    <?php echo htmlspecialchars($book->name); ?>
                                </span>
                            </div>
                            <div>
                                <h2 class="h5 fw-bold text-white mb-2 text-capitalize">
                                    <?php echo htmlspecialchars($book->title); ?>
                                </h2>
                                <p class="small text-white mb-2">
                                    <i class="bi bi-person me-2"></i>
                                    <?php echo htmlspecialchars($book->author); ?>
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="small text-white">
                                        <i class="bi bi-book me-2"></i>
                                        <?php echo htmlspecialchars($book->pages); ?> sayfa
                                    </span>
                                    <a href="<?php echo BASE_URL; ?>books/<?php echo htmlspecialchars($book->slug) . "/" . htmlspecialchars($book->book_id); ?>" class="btn btn-light rounded-circle d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;" aria-label="Kürk Mantolu Madonna kitabını incele">
                                        <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if ($totalPages > 1): ?>
        <?php
            $startPage = max(1, $page - 2);
            $endPage   = min($totalPages, $page + 2);
        ?>
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 border-top pt-4 mt-4">
            <span class="small text-secondary">
                <?php echo $totalBooks; ?> kitaptan <?php echo $start; ?> – <?php echo $end; ?> arası gösteriliyor
            </span>
            <nav aria-label="Kitap sayfaları">
                <ul class="pagination align-items-center gap-2 mb-0">
                    <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                        <a class="page-link border rounded-circle text-dark d-flex align-items-center justify-content-center" href="<?php echo $pageUrl($page - 1); ?>" aria-label="Önceki sayfa" style="width: 40px; height: 40px;">
                            <i class="bi bi-chevron-left"></i>
                        </a>
                    </li>
                    <?php if ($startPage > 1): ?>
                        <li class="page-item">
                            <a class="page-link border rounded-circle text-dark d-flex align-items-center justify-content-center" href="<?php echo $pageUrl(1); ?>" style="width: 40px; height: 40px;">
                                1
                            </a>
                        </li>
                        <?php if ($startPage > 2): ?>
                            <li class="page-item disabled">
                                <span class="page-link border-0 bg-transparent">...</span>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                        <?php $isActive = ($page == $i); ?>
                        <li class="page-item <?php echo $isActive ? 'active' : ''; ?>">
                            <a class="page-link border rounded-circle d-flex align-items-center justify-content-center <?php echo $isActive ? 'bg-dark border-dark text-white' : 'text-dark'; ?>" href="<?php echo $pageUrl($i); ?>" style="width: 40px; height: 40px;">
                                <?php echo $i; ?>
                            </a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($endPage < $totalPages): ?>
                        <?php if ($endPage < $totalPages - 1): ?>
                            <li class="page-item disabled">
                                <span class="page-link border-0 bg-transparent">...</span>
                            </li>
                        <?php endif; ?>
                        <li class="page-item">
                            <a class="page-link border rounded-circle text-dark d-flex align-items-center justify-content-center" href="<?php echo $pageUrl($totalPages); ?>" style="width: 40px; height: 40px;">
                                <?php echo $totalPages; ?>
                            </a>
                        </li>
                    <?php endif; ?>

                    <li class="page-item <?php echo ($page >= $totalPages) ? 'disabled' : ''; ?>">
                        <a class="page-link border rounded-circle text-dark d-flex align-items-center justify-content-center" href="<?php echo $pageUrl($page + 1); ?>" aria-label="Sonraki sayfa" style="width: 40px; height: 40px;">
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    <?php endif; ?>

</main>
<?php include_once "partials/_footer.php"; ?>