<section class="py-4 py-md-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3 mb-md-4">
            <h2 class="h4 fw-bold mb-0">En Çok Favorilenenler</h2>
            <a href="<?php echo BASE_URL; ?>books" class="d-inline-flex align-items-center gap-2 text-dark text-decoration-none small fw-semibold" aria-label="Tüm kitapları gör">
                <span>Tümü<span class="d-none d-sm-inline">nü gör</span></span>
                <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-dark text-white p-2 lh-1">
                    <i class="bi bi-arrow-right"></i>
                </span>
            </a>
        </div>
        <?php if (!empty($favoritesBooks)): ?>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-3 g-md-4">
                <?php foreach ($favoritesBooks as $book): ?>
                    <div class="col">
                        <div class="card border-0 rounded-4 overflow-hidden shadow-sm position-relative text-white" style="min-height: 300px;">
                            <img src="<?php echo BASE_URL . "images/" . htmlspecialchars($book->image_name); ?>" class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover" alt="<?php echo htmlspecialchars($book->title); ?>">
                            <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(180deg, rgba(0,0,0,.15), rgba(8,20,28,.95));">
                            </div>
                            <div class="card-body position-relative d-flex flex-column justify-content-between p-3" style="min-height: 300px;">                                
                                <div class="d-flex justify-content-between align-items-center gap-2">
                                    <span class="badge bg-white text-dark rounded-pill px-3 py-2">
                                        <?php echo htmlspecialchars($book->category_name); ?>
                                    </span>
                                    <span class="badge bg-dark bg-opacity-75 text-white rounded-pill px-3 py-2">
                                        <i class="bi bi-heart-fill text-danger me-1"></i>
                                        <?php echo (int) $book->fav_count; ?>
                                    </span>
                                </div>
                                <div>
                                    <h3 class="h5 fw-bold text-white mb-2 text-capitalize">
                                        <?php echo htmlspecialchars($book->title); ?>
                                    </h3>
                                    <p class="small text-white mb-2">
                                        <i class="bi bi-person me-2"></i>
                                        <?php echo htmlspecialchars($book->author); ?>
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="small text-white">
                                            <i class="bi bi-book me-2"></i>
                                            <?php echo htmlspecialchars($book->pages); ?> sayfa
                                        </span>
                                        <a href="<?php echo BASE_URL; ?>books/<?php echo htmlspecialchars($book->slug) . "/" . htmlspecialchars($book->book_id); ?>" class="btn btn-light rounded-circle d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;" aria-label="<?php echo htmlspecialchars($book->title); ?> kitabını incele">
                                            <i class="bi bi-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-muted text-center py-4 mb-0">
                <i class="bi bi-heart me-2"></i>
                Henüz favorilere eklenen kitap bulunmuyor.
            </p>
        <?php endif; ?>
    </div>
</section>
