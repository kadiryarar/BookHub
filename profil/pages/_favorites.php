<?php

    $page = isset($_GET["p"]) ? $_GET["p"] : 1;
    $result = $favorite->getFavoriteByUser($_SESSION["id"], $page);
    $getFavorites = $result["favorites"];
    $totalItems = $result["totalFavorite"];
    $pageCount = $result["totalPages"];
    $recordStart = $result["start"];
    $recordEnd = $result["end"];

    $start = max(2, $page - 1);
    $end = min($pageCount - 1, $page + 1);

?>

<div class="d-flex justify-content-between align-items-start mb-3 pb-3 border-bottom">
    <div>
        <h2 class="h5 fw-bold mb-1"><i class="bi bi-heart text-danger me-2"></i>Favorilerim</h2>
        <p class="text-muted small mb-0">Daha sonra tekrar görmek istediğin kitaplar.</p>
    </div>
</div>
<?php if (empty($getFavorites)): ?>
    <div class="border rounded-4 px-3 py-2 d-flex align-items-center gap-2 text-muted small">
        <i class="bi bi-heart text-danger fs-5"></i>
        <span><strong class="text-dark">Favori yok.</strong> Henüz favorilerine eklediğin bir kitap bulunmuyor.</span>
    </div>
<?php else: ?>
    <div class="row g-3">
        <?php foreach ($getFavorites as $fav): ?>
            <div class="col-12 col-md-6">
                <div class="border rounded-4 p-3 d-flex align-items-center gap-3">
                    <div class="rounded-3 overflow-hidden flex-shrink-0 bg-danger-subtle d-flex align-items-center justify-content-center position-relative" style="width: 120px; height: 80px;">
                        <img src="<?php echo BASE_URL . "images/" . $fav->image_name ?>" class="w-100 h-100 object-fit-cover position-absolute top-0 start-0" onerror="this.remove()">
                        <i class="bi bi-book text-danger fs-3"></i>
                    </div>

                    <div class="flex-grow-1 overflow-hidden">
                        <h3 class="h6 fw-bold mb-0 text-truncate"><?php echo htmlspecialchars($fav->title); ?></h3>
                        <p class="text-muted small mb-1 text-truncate"><?php echo htmlspecialchars($fav->author); ?></p>
                        <span class="badge bg-light text-dark border"><?php echo htmlspecialchars($fav->category_name); ?></span>
                    </div>

                    <form method="post">
                        <input type="hidden" name="favorite_id" value="<?php echo htmlspecialchars($fav->favorite_id); ?>">
                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle flex-shrink-0" title="Favorilerden Sil" name="deleteFavorite">
                            <i class="bi bi-trash"></i>
                        </button>
                        <a href="<?php echo BASE_URL; ?>books/<?php echo htmlspecialchars($fav->slug) . "/" . htmlspecialchars($fav->book_id); ?>" class="btn btn-sm btn-outline-primary rounded-circle flex-shrink-0" title="İncele">
                            <i class="bi bi-eye"></i>
                        </a>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php include_once __DIR__ . "/../partials/_pagination.php"; ?>