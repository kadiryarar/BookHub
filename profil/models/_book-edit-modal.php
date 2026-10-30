<div class="modal fade" id="bookEditModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form method="post" enctype="multipart/form-data" class="modal-content border-0 shadow rounded-4">
            <input type="hidden" name="id" id="editBookId">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Kitabı Düzenle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
            </div>

            <div class="modal-body">
                <div class="row g-4">
                    <div class="col-md-7">
                        <div class="mb-3">
                            <label for="editBookTitle"
                                   class="form-label small fw-semibold">
                                Kitap Adı
                            </label>
                            <input type="text" class="form-control rounded-3" id="editBookTitle" name="title" placeholder="Örn: Nutuk">
                        </div>

                        <div class="mb-3">
                            <label for="editBookDescription"
                                   class="form-label small fw-semibold">
                                Açıklama
                            </label>
                            <textarea class="form-control rounded-3" id="editBookDescription" name="description" rows="5" placeholder="Kitap hakkında kısa bir not..."></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="editBookAuthor"
                                   class="form-label small fw-semibold">
                                Yazar
                            </label>
                            <input type="text" class="form-control rounded-3" id="editBookAuthor" name="author" placeholder="Yazar adı">
                        </div>

                        <div class="mb-3">
                            <label for="editBookPages"
                                   class="form-label small fw-semibold">
                                Sayfa Sayısı
                            </label>
                            <input type="number" class="form-control rounded-3" id="editBookPages" name="pages" placeholder="Örn: 592" min="1">
                        </div>

                    </div>

                    <div class="col-md-5">
                        <label class="form-label small fw-semibold">
                            Aktif Resim
                        </label>
                        <div class="border rounded-3 p-3 text-center mb-3 bg-light">
                            <img src="" id="editBookImagePreview" alt="Mevcut kitap resmi" class="img-fluid rounded-3" style="max-height: 190px; object-fit: contain;">
                            <div id="editBookNoImage"
                                 class="text-muted small py-4"
                                 style="display: none;">
                                <i class="bi bi-image fs-2 d-block mb-2"></i>
                                Resim bulunmuyor
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="editBookImage" class="form-label small fw-semibold">
                                Yeni Resim
                            </label>
                            <input type="file" class="form-control rounded-3" id="editBookImage" name="image" accept="image/jpeg,image/png">
                            <div class="form-text">
                                JPG veya PNG, en fazla 2 MB.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="editBookCategory" class="form-label small fw-semibold">
                                Kategori
                            </label>
                            <select class="form-select rounded-3" id="editBookCategory" name="category_id">
                                <?php foreach ($categories->getCategories() as $category): ?>
                                    <option value="<?php echo $category->id; ?>">
                                        <?php echo htmlspecialchars($category->name); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">
                    İptal
                </button>

                <button type="submit" class="btn btn-warning rounded-pill px-4" name="editBook">
                    <i class="bi bi-check-lg me-1"></i>
                    Değişiklikleri Kaydet
                </button>
            </div>

        </form>
    </div>
</div>
<script>
    const bookEditModal = document.getElementById("bookEditModal");

    bookEditModal.addEventListener("show.bs.modal", function(event) {

        const button = event.relatedTarget;

        const id = button.getAttribute("data-book-id");
        const title = button.getAttribute("data-book-title");
        const description = button.getAttribute("data-book-description");
        const author = button.getAttribute("data-book-author");
        const pages = button.getAttribute("data-book-pages");
        const category_id = button.getAttribute("data-book-category_id");
        const imageName = button.getAttribute("data-book-image_name");

        document.getElementById("editBookId").value = id;
        document.getElementById("editBookTitle").value = title;
        document.getElementById("editBookDescription").value = description;
        document.getElementById("editBookAuthor").value = author;
        document.getElementById("editBookPages").value = pages;
        document.getElementById("editBookCategory").value = category_id;

        const imagePreview = document.getElementById("editBookImagePreview");
        const editBookNoImage = document.getElementById("editBookNoImage");

        if (imageName) {
            imagePreview.src = "../images/" + encodeURIComponent(imageName);
            editBookNoImage.style.display = "none";
        } else {
            imagePreview.style.display = "none";
            editBookNoImage.style.display = "block";
        }
    });
</script>