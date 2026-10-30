<?php

    $page = max(1, (int) ($_GET["p"] ?? 1));

    $result = $books->getBooksByUser($_SESSION["id"], $page);
    $userBooks = $result["userBooks"];
    $pageCount = $result["pageCount"];
    $totalItems = $result["totalBooks"];
    $recordStart = $result["start"];
    $recordEnd = $result["end"];

    $start = max(2, $page - 1);
    $end = min($pageCount - 1, $page + 1);

    $statuses = [
        0 => ["danger", "Pasif"],
        1 => ["success", "Aktif"],
        2 => ["warning", "Takasta"]
    ];

?>
<div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 pb-3 mb-4 border-bottom">
    <div>
        <h2 class="h5 fw-bold mb-1 d-flex align-items-center gap-2">
            <i class="bi bi-book text-warning"></i>
            <span>
                Kitaplarım
            </span>
        </h2>
        <p class="text-muted small mb-0">
            Sisteme eklediğin ve paylaşmaya hazır kitaplar.
        </p>
    </div>
    <button class="btn btn-warning btn-sm rounded-pill px-3 fw-semibold d-flex align-items-center gap-1 align-self-start align-self-sm-center" data-bs-toggle="modal" data-bs-target="#newBookModal">
        <i class="bi bi-plus-circle"></i>
        Kitap Ekle
    </button>
</div>

<?php if (empty($userBooks)): ?>
    <div class="border rounded-4 px-3 py-2 d-flex align-items-center gap-2 text-muted small">
        <i class="bi bi-book text-warning fs-5"></i>
        <span>
            <strong class="text-dark">
                Henüz kitap yok.
            </strong>
            Sisteme eklediğin bir kitap bulunmuyor.
        </span>
        <button class="btn btn-sm btn-warning rounded-pill px-3 ms-auto flex-shrink-0" data-bs-toggle="modal" data-bs-target="#newBookModal">
            Kitap Ekle
        </button>
    </div>
<?php else: ?>
    <div class="row g-3">
        <?php foreach ($userBooks as $book): ?>
            <?php $status = $statuses[$book->is_verified] ?? ["secondary", "Bilinmiyor"]; ?>
            <div class="col-12 col-md-6">
                <div class="border rounded-4 p-3 h-100 bg-white">
                    <div class="d-flex gap-3">
                        <div class="bg-light rounded-3 d-flex align-items-center justify-content-center flex-shrink-0 overflow-hidden" style="width: 115px; height: 120px;">
                            <img src="<?php echo BASE_URL . "images/" . htmlspecialchars($book->image_name); ?>" class="w-100 h-100 img-fluid" />
                        </div>
                        <div class="flex-grow-1 overflow-hidden position-relative">
                            <div class="d-flex justify-content-between align-items-start gap-2">
                                <h3 class="h6 fw-bold mb-1 text-truncate">
                                    <?php echo ucfirst(htmlspecialchars($book->title)); ?>
                                </h3>
                                <span class="badge bg-<?php echo $status[0]; ?> rounded-pill px-2 py-1 small flex-shrink-0">
                                    <?php echo $status[1]; ?>
                                </span>
                            </div>
                            <p class="text-muted small mb-2 text-truncate text-capitalize">
                                <?php echo htmlspecialchars($book->author); ?>
                            </p>
                            <div class="mb-3">
                                <span class="badge bg-light text-dark border rounded-2 px-2 py-1 small text-capitalize">
                                    <?php echo htmlspecialchars($book->category_name); ?>
                                </span>
                            </div>
                            <div class="d-flex gap-2">
                                <button class="btn btn-sm btn-outline-dark rounded-pill px-3 py-1 small d-flex align-items-center gap-1" data-book-id="<?php echo (int) $book->id; ?>" data-book-title="<?php echo htmlspecialchars($book->title); ?>" data-book-description="<?php echo htmlspecialchars($book->description); ?>" data-book-author="<?php echo htmlspecialchars($book->author); ?>" data-book-image_name="<?php echo htmlspecialchars($book->image_name); ?>" data-book-pages="<?php echo (int) $book->pages; ?>" data-book-category_id="<?php echo (int) $book->category_id; ?>" data-bs-toggle="modal" data-bs-target="#bookEditModal">
                                    <i class="bi bi-pencil"></i>
                                    <span class="d-none d-sm-inline">
                                        Düzenle
                                    </span>
                                </button>
                                <button class="btn btn-sm btn-outline-danger rounded-pill px-3 py-1 small d-flex align-items-center gap-1" data-book-id="<?php echo (int) $book->id; ?>" data-book-title="<?php echo htmlspecialchars($book->title); ?>" data-bs-toggle="modal" data-bs-target="#bookDeleteModal">
                                    <i class="bi bi-trash"></i>
                                    <span class="d-none d-sm-inline">
                                        Sil
                                    </span>
                                </button>
                                <a href="<?php echo BASE_URL; ?>books/<?php echo htmlspecialchars($book->slug) . "/" . htmlspecialchars($book->book_id); ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3 py-1 small d-flex align-items-center gap-1">
                                    <i class="bi bi-eye"></i>
                                    <span class="d-none d-sm-inline">
                                        İncele
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php include_once __DIR__ . "/../partials/_pagination.php"; ?>
<?php include_once __DIR__ . "/../models/_book-add-modal.php"; ?>
<?php include_once __DIR__ . "/../models/_book-edit-modal.php"; ?>
<?php include_once __DIR__ . "/../models/_book-delete-modal.php"; ?>