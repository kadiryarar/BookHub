<?php 
    require_once __DIR__ . "/libs/functions.php";
    require_once __DIR__ . "/backend/Database.class.php";
    require_once __DIR__ . "/backend/Books.class.php";
    require_once __DIR__ . "/backend/Favorites.class.php";
    require_once __DIR__ . "/backend/Trades.class.php";

    if (!isset($_GET["slug"])) {
        header("Location: books");
    }

    if (!isset($_GET["id"])) {
        header("Location: books");
    }

    $slug = $_GET["slug"] ?? "";
    $id = $_GET["id"] ?? "";

    $favorites = new Favorites();
    $books = new Books();
    $trades = new Trades();
    $book = $books->getBookBySlug($slug, $id);
    if (isset($_SESSION["id"])) {
        $myBooks = $books->getBooksByUserActive($_SESSION["id"]);
    }

    $title = $book->title;
    include_once __DIR__ . "/partials/_header.php";
    include_once __DIR__ . "/partials/_sidebar.php";

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Favorilere ekle işlemleri
        if (isset($_POST["createFavorite"])) {
            $data = $favorites->createFavorite($_SESSION["id"], $book->book_id);
        }

        // Favorilerden sil işlemleri
        if (isset($_POST["deleteFavorite"])) {
            $data = $favorites->deleteFavorite($_SESSION["id"], $book->book_id);
        }

        // Takas isteği gönder
        if (isset($_POST["createTrade"])) {
            $senderBookId = (int) $_POST["senderBookId"];
            $senderUserId = (int) $_SESSION["id"];
            $recieverBookId = (int) $_POST["recieverBookId"];
            $recieverUserId = (int) $_POST["recieverUserId"];

            $data = $trades->createTrades($senderBookId, $senderUserId, $recieverBookId, $recieverUserId);
        }
    }

?>
<?php include_once __DIR__ . "/profil/partials/_alert.php"; ?>
<main class="container py-4 py-lg-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="list-unstyled d-flex d-md-inline-flex align-items-center flex-nowrap gap-1 gap-sm-2 mw-100 bg-body-tertiary border border-light-subtle rounded-pill ps-3 pe-4 py-2 mb-0 small">
            <li class="flex-shrink-0">
                <a href="<?php echo BASE_URL; ?>" class="d-inline-flex align-items-center gap-1 text-nowrap link-dark link-underline-opacity-0 link-underline-opacity-75-hover">
                    <i class="bi bi-house-door-fill text-warning"></i>Ana Sayfa
                </a>
            </li>
            <li class="flex-shrink-0 text-secondary opacity-50" aria-hidden="true">
                <i class="bi bi-chevron-right"></i>
            </li>
            <li class="flex-shrink-0">
                <a href="<?php echo BASE_URL; ?>books" class="d-inline-flex align-items-center gap-1 text-nowrap link-dark link-underline-opacity-0 link-underline-opacity-75-hover">
                    <i class="bi bi-book text-warning"></i>Kitaplar
                </a>
            </li>
            <li class="flex-shrink-0 text-secondary opacity-50" aria-hidden="true">
                <i class="bi bi-chevron-right"></i>
            </li>
            <li class="flex-shrink-0">
                <a href="<?php echo BASE_URL; ?>books/category/<?php echo htmlspecialchars($book->category_slug); ?>" class="d-inline-flex align-items-center gap-1 text-nowrap link-dark link-underline-opacity-0 link-underline-opacity-75-hover">
                    <i class="bi bi-tags text-warning"></i><?php echo htmlspecialchars($book->category_name); ?>
                </a>
            </li>
            <li class="flex-shrink-0 text-secondary opacity-50" aria-hidden="true">
                <i class="bi bi-chevron-right"></i>
            </li>
            <li class="text-truncate fw-semibold text-dark" aria-current="page">
                <?php echo htmlspecialchars($book->title); ?>
            </li>
        </ol>
    </nav>
    <div class="card border border-light-subtle border-top border-warning border-4 shadow rounded-4 mb-4">
        <div class="card-body p-3 p-md-4 p-lg-5">
            <div class="row g-4 g-lg-5">
                <div class="col-12 col-sm-5 col-lg-4">
                    <div class="rounded-4 shadow">
                        <div class="ratio rounded-3 overflow-hidden" style="--bs-aspect-ratio: 80%;">
                            <img src="<?php echo BASE_URL . "images/" . htmlspecialchars($book->image_name); ?>" alt="Kürk Mantolu Madonna kitap kapağı" class="w-100 h-100">
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-7 col-lg-5 d-flex flex-column">
                    <div class="mb-3">
                        <span class="badge rounded-pill text-bg-warning px-3 py-2">
                            <i class="bi bi-tags-fill text-dark me-1"></i>
                            <?php echo htmlspecialchars($book->category_name); ?>
                        </span>
                    </div>
                    <h1 class="h2 fw-bold text-dark mb-2 text-capitalize">
                        <?php echo htmlspecialchars($book->title); ?>
                    </h1>
                    <div class="d-flex align-items-center gap-2 mb-4 text-secondary fs-5">
                        <i class="bi bi-pencil-square text-warning-emphasis"></i>
                        <span><?php echo htmlspecialchars($book->author); ?></span>
                    </div>
                    <ul class="list-group list-group-flush border-top mt-auto">
                        <li class="list-group-item d-flex align-items-center gap-3 px-0 py-3">
                            <span class="rounded-circle bg-warning-subtle text-warning-emphasis d-flex align-items-center justify-content-center flex-shrink-0" style="width: 40px; height: 40px;">
                                <i class="bi bi-book"></i>
                            </span>
                            <span class="text-secondary">Sayfa Sayısı</span>
                            <span class="fw-semibold text-dark ms-auto"><?php echo htmlspecialchars($book->pages); ?> sayfa</span>
                        </li>
                        <li class="list-group-item d-flex align-items-center gap-3 px-0 py-3">
                            <span class="rounded-circle bg-warning-subtle text-warning-emphasis d-flex align-items-center justify-content-center flex-shrink-0" style="width: 40px; height: 40px;">
                                <i class="bi bi-calendar-check"></i>
                            </span>
                            <span class="text-secondary">Eklenme Tarihi</span>
                            <span class="fw-semibold text-dark ms-auto"><?php echo date("d.m.Y", strtotime(htmlspecialchars($book->created_at))); ?></span>
                        </li>
                    </ul>
                </div>
                <div class="col-12 col-lg-3">
                    <div class="card h-100 border border-light-subtle bg-body-tertiary rounded-4">
                        <div class="card-body d-flex flex-column p-3 p-lg-4">
                            <div class="text-uppercase fw-semibold text-secondary small mb-3">
                                İşlemler
                            </div>
                            <?php if (!isloggedIn()): ?>
                                <div class="text-center my-auto py-2">
                                    <div class="rounded-circle bg-body border d-inline-flex align-items-center justify-content-center mb-3"
                                         style="width: 56px; height: 56px;">
                                        <i class="bi bi-lock-fill fs-4 text-secondary"></i>
                                    </div>
                                    <p class="fw-semibold text-dark mb-1">Giriş yapmalısın</p>
                                    <p class="text-secondary small mb-4">
                                        Favorilere eklemek ve takas teklifi göndermek için hesabına giriş yap.
                                    </p>
                                    <a href="<?php echo BASE_URL . "login"; ?>" class="btn btn-warning w-100 rounded-3 py-2 fw-semibold">
                                        <i class="bi bi-box-arrow-in-right me-2"></i>
                                        Giriş Yap
                                    </a>
                                </div>
                            <?php else: ?>
                                <?php if ($book->bookIsVerified): ?>
                                    <div class="d-grid gap-3 my-auto">
                                        <div>
                                            <?php if ($book->book_user_id == $_SESSION["id"]): ?>
                                                <button type="button" class="btn btn-dark w-100 rounded-3 py-3 fw-semibold" disabled>
                                                    <i class="bi bi-person-check me-2"></i>
                                                    Bu kitap sana ait
                                                </button>
                                            <?php else: ?>
                                                <button type="button" class="btn btn-dark w-100 rounded-3 py-3 fw-semibold"
                                                        data-bs-toggle="modal" data-bs-target="#tradeModal">
                                                    <i class="bi bi-arrow-left-right me-2"></i>
                                                    Takas Teklifi Gönder
                                                </button>
                                                <div class="text-secondary small text-center mt-2">
                                                    Teklifin kitap sahibine iletilir.
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="d-flex align-items-center gap-2 text-secondary small">
                                            <hr class="flex-grow-1 m-0">
                                            <span>veya</span>
                                            <hr class="flex-grow-1 m-0">
                                        </div>
                                        <form method="post">
                                            <?php if (!$favorites->checkFavorite($_SESSION["id"], $book->book_id)): ?>
                                                <button type="submit" name="createFavorite" class="btn btn-outline-dark w-100 rounded-3 py-2 fw-semibold">
                                                    <i class="bi bi-heart me-2"></i>
                                                    Favorilere Ekle
                                                </button>
                                            <?php else: ?>
                                                <button type="submit" name="deleteFavorite" class="btn btn-outline-danger w-100 rounded-3 py-2 fw-semibold">
                                                    <i class="bi bi-heart-fill me-2"></i>
                                                    Favorilerden Kaldır
                                                </button>
                                            <?php endif; ?>
                                        </form>
                                    </div>
                                <?php else: ?>
                                    <div class="bg-warning-subtle text-warning-emphasis small text-center rounded-3 py-2">
                                        <i class="bi bi-hourglass-split me-1"></i>
                                        Bu kitap henüz onaylanmadı.
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="card border border-light-subtle shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <h2 class="h5 fw-bold text-dark border-start border-warning border-4 ps-3 mb-4">
                Kitap Hakkında
            </h2>
            <div class="row">
                <div class="col-12 col-lg-9">
                    <p class="text-secondary lh-lg mb-0">
                        <?php echo htmlspecialchars($book->description); ?>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="card border border-light-subtle shadow-sm rounded-4">
        <div class="card-body p-4">
            <h2 class="h5 fw-bold text-dark border-start border-warning border-4 ps-3 mb-4">
                Kitap Sahibi
            </h2>
            <div class="row align-items-center g-4">
                <div class="col-12 col-md-5">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-dark text-warning d-flex align-items-center justify-content-center flex-shrink-0" style="width: 68px; height: 68px;">
                            <i class="bi bi-person-fill fs-2"></i>
                        </div>
                        <div>
                            <h3 class="h6 fw-bold text-dark mb-1"><?php echo htmlspecialchars($book->name) . htmlspecialchars($book->surname); ?></h3>
                            <div class="text-secondary small">@<?php echo htmlspecialchars($book->username); ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="border-start border-warning border-3 ps-3">
                        <div class="text-secondary small mb-1">
                            <i class="bi bi-envelope me-2"></i>E-posta Adresi
                        </div>
                        <div class="fw-medium text-dark text-break"><?php echo htmlspecialchars($book->email); ?></div>
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <div class="bg-dark text-white rounded-3 p-3 d-flex align-items-center gap-3">
                        <i class="bi bi-collection text-warning fs-3"></i>
                        <div>
                            <div class="fs-4 fw-bold text-warning lh-1 mb-1"><?php echo htmlspecialchars($books->getBooksByUserCount($book->user_id)->totalBooks); ?></div>
                            <div class="text-white-50 small">Paylaşılan Kitap</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php if (isloggedIn()): ?>
<div class="modal fade" id="tradeModal" tabindex="-1" aria-labelledby="tradeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen-sm-down">
        <form method="post" class="modal-content border-0 rounded-4 shadow">

            <div class="modal-header border-bottom-0 pb-0 px-4 pt-4">
                <h2 class="modal-title h5 fw-bold text-dark border-start border-warning border-4 ps-3" id="tradeModalLabel">
                    Takas Teklifi Gönder
                </h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
            </div>

            <div class="modal-body px-4 py-4">

                <div class="text-uppercase fw-semibold text-secondary small mb-2">İstediğin kitap</div>
                <div class="d-flex align-items-center gap-3 bg-body-tertiary border border-light-subtle rounded-3 p-3 mb-4">
                    <span class="rounded-circle bg-warning-subtle text-warning-emphasis d-flex align-items-center justify-content-center flex-shrink-0"
                          style="width: 40px; height: 40px;">
                        <i class="bi bi-book"></i>
                    </span>
                    <div class="min-w-0">
                        <div class="fw-semibold text-dark text-truncate"><?php echo htmlspecialchars($book->title); ?></div>
                        <div class="text-secondary small text-truncate">
                            <?php echo htmlspecialchars($book->author); ?> · @<?php echo htmlspecialchars($book->username); ?>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="offeredBookId" class="form-label fw-semibold text-dark">
                        <i class="bi bi-arrow-left-right text-warning me-1"></i>
                        Karşılığında vereceğin kitap
                    </label>

                    <?php if (!empty($myBooks)): ?>
                        <div class="input-group">
                            <span class="input-group-text bg-body-tertiary text-warning-emphasis">
                                <i class="bi bi-book"></i>
                            </span>
                            <select class="form-select" id="offeredBookId" name="recieverBookId" aria-describedby="offeredBookHelp" required>
                                <option value="" selected disabled>Bir kitap seç</option>
                                <?php foreach ($myBooks as $myBook): ?>
                                    <option value="<?php echo htmlspecialchars($myBook->id); ?>">
                                        <?php
                                            echo htmlspecialchars($myBook->title);
                                            if (!empty($myBook->author)) {
                                                echo " — " . htmlspecialchars($myBook->author);
                                            }
                                        ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning d-flex align-items-center gap-2 rounded-3 mb-0" role="alert">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                            <div class="small">Takas teklifi göndermek için önce kendi kitabını eklemelisin.</div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="modal-footer border-top-0 px-4 pb-4 pt-0 gap-2">
                <button type="button" class="btn btn-outline-secondary rounded-3 px-4 py-2" data-bs-dismiss="modal">
                    Vazgeç
                </button>
                <input type="hidden" name="senderBookId" value="<?php echo $book->book_id; ?>">
                <input type="hidden" name="recieverUserId" value="<?php echo $book->book_user_id; ?>">
                <button type="submit" name="createTrade" class="btn btn-warning rounded-3 px-4 py-2 fw-semibold" <?php echo empty($myBooks) ? "disabled" : ""; ?>>
                    <i class="bi bi-send me-2"></i>
                    Teklifi Gönder
                </button>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>
<?php include_once "partials/_footer.php"; ?>