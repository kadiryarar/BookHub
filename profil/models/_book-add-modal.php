<div class="modal fade" id="newBookModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form method="post" enctype="multipart/form-data" class="modal-content border-0 shadow rounded-4">

            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Yeni Kitap Ekle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
            </div>

            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label small fw-semibold" for="bookTitle">Kitap Adı</label>
                        <input type="text" class="form-control rounded-3" id="bookTitle" name="title" placeholder="Örn: Nutuk" value="<?php echo $title; ?>">
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-semibold" for="bookAuthor">Yazar</label>
                        <input type="text" class="form-control rounded-3" id="bookAuthor" name="author" placeholder="Örn: Mustafa Kemal Atatürk" <?php echo $author; ?>>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold" for="bookCategory">Kategori</label>
                        <select class="form-select rounded-3" id="bookCategory" name="category_id">
                            <option selected disabled>Seçiniz...</option>
                            <?php foreach ($categories->getCategories() as $category): ?>
                                <option value="<?php echo $category->id; ?>" <?php echo ($category->id === $category_id) ? "selected" : ""; ?>><?php echo $category->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold" for="bookPages">Sayfa Sayısı</label>
                        <input type="number" class="form-control rounded-3" id="bookPages" name="pages" placeholder="Örn: 592" <?php echo $pages; ?>>
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-semibold" for="bookImage">Kitap Resmi</label>
                        <input type="file" class="form-control rounded-3" id="bookImage" name="image" accept="image/jpeg,image/png">
                        <div class="form-text">JPG veya PNG, en fazla 2 MB.</div>
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-semibold" for="bookDesc">Açıklama</label>
                        <textarea class="form-control rounded-3" id="bookDesc" name="description" rows="3" placeholder="Kitap hakkında kısa bir not..."><?php echo $description; ?></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">İptal</button>
                <button type="submit" class="btn btn-warning rounded-pill px-4" name="createBook">Ekle</button>
            </div>
        </form>
    </div>
</div>