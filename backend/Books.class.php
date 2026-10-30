<?php

    class Books extends Database {
        // Resim yükleme 
        private function uploadImage(string $path, string $tmpName) : bool {
            return move_uploaded_file($tmpName, $path);
        }

        // Id'ye göre kitap getir
        private function getBookById(int $id) {
            $sql = "SELECT b.*, c.* FROM books b inner join categories c on b.category_id = c.id WHERE b.id = :id";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([
                "id" => $id
            ]);

            return $stmt->fetch();
        }

        // Kullanıcıya ait toplam kitap sayısı - Profil 
        public function getBooksByUserCount(int $user_id) {
            $sql = "SELECT COUNT(*) AS totalBooks FROM books WHERE user_id = :user_id";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([
                "user_id" => $user_id
            ]);

            return $stmt->fetch();
        }
        
        // Kitap ekleme - Profil
        public function createBook(int $user_id, string $title, string $slug, string $author, int $category_id, int $pages, array $image, string $description) : array {
            $allowed = ["jpg", "png"];
            $extension = strtolower(pathinfo($image["name"], PATHINFO_EXTENSION));
            $tmpName = $image["tmp_name"];
            $uploads = "../images/";
            $imageName = $slug . uniqid() . "." . $extension;
            $fulPath = $uploads . $imageName;

            if (empty($title) || empty($author) || $category_id == 0 || empty($pages) || empty($description)) {
                return [
                    "status" => "danger",
                    "message" => "Lütfen tüm alanları doldurunuz."
                ];
            }

            if (!is_numeric($pages)) {
                return [
                    "status" => "danger",
                    "message" => "Sayfa sayısı sayısal olmalıdır."
                ]; 
            }

            if ($pages < 1 || $pages > 1000) {
                return [
                    "status" => "danger",
                    "message" => "Sayfa sayısı çok fazla."
                ]; 
            }

            if ($image["error"] === UPLOAD_ERR_NO_FILE) {
                return [
                    "status" => "danger",
                    "message" => "Lütfen kitap resmi seçiniz."
                ];
            }

            if ($image["error"] !== UPLOAD_ERR_OK) {
                return [
                    "status" => "danger",
                    "message" => "Resim yüklenirken bir hata oluştu."
                ];
            }

            if ($image["size"] > 1024 * 1024 * 2) {
                return [
                    "status" => "danger",
                    "message" => "Kitap resmi 2 MB olabilir."
                ];
            }

            if (!in_array($extension, $allowed)) {
                return [
                    "status" => "danger",
                    "message" => "Geçersiz dosya uzantısı."
                ];
            }

            $uploadImage = $this->uploadImage($fulPath, $tmpName);

            if (!$uploadImage) {
                return [
                    "status" => "danger",
                    "message" => "Resim yüklenemedi, daha sonra tekrar deneyiniz."
                ];
            }

            $conn = $this->connect();

            try {
                $conn->beginTransaction();

                $sql = "INSERT INTO books (user_id, category_id, title, slug, description, author, image_name, pages) VALUES (:user_id, :category_id, :title, :slug, :description, :author, :image_name, :pages)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([
                    "user_id" => $user_id, 
                    "category_id" => $category_id, 
                    "title" => $title, 
                    "slug" => $slug, 
                    "description" => $description, 
                    "author" => $author, 
                    "image_name" => $imageName, 
                    "pages" => $pages
                ]);

                $conn->commit();

                return [
                    "status" => "success",
                    "message" => "Kitap başarılı bir şekilde eklendi."
                ];

            } catch (PDOException $err) {

                if ($conn->inTransaction()) {
                    $conn->rollBack();
                }

                if (file_exists($fulPath)) {
                    unlink($fulPath);
                }

                return [
                    "status" => "danger",
                    "message" => "İşlem başarısız."
                ];

            }
        }

        // Kitap düzenleme - Profil
        public function editBook(int $id, string $title, string $slug, string $author, int $category_id, int $pages, array $image, string $description) : array {
            $allowed = ["jpg", "png"];

            if (empty($title) || empty($author) || empty($pages) || empty($description)) {
                return [
                    "status" => "danger",
                    "message" => "Lütfen tüm alanları doldurunuz."
                ];
            }

            if (!is_numeric($pages)) {
                return [
                    "status" => "danger",
                    "message" => "Sayfa sayısı sayısal olmalıdır."
                ]; 
            }

            if ($pages < 1 || $pages > 1000) {
                return [
                    "status" => "danger",
                    "message" => "Sayfa sayısı çok fazla."
                ]; 
            }

            $book = $this->getBookById($id);

            if (!$book) {
                return [
                    "status" => "danger",
                    "message" => "Kitap bulunamadı."
                ];
            }

            $oldImage = $book->image_name;
            $imageName = $oldImage;

            if (isset($image["error"]) && $image["error"] === UPLOAD_ERR_OK) {
                $extension = strtolower(pathinfo($image["name"], PATHINFO_EXTENSION));
                $tmpName = $image["tmp_name"];
                $uploads = "../images/";
                $imageName = $slug . uniqid() . "." . $extension;
                $fulPath = $uploads . $imageName;

                if ($image["size"] > 1024 * 1024 * 2) {
                    return [
                        "status" => "danger",
                        "message" => "Kitap resmi 2 MB olabilir."
                    ];
                }

                if (!in_array($extension, $allowed)) {
                    return [
                        "status" => "danger",
                        "message" => "Geçersiz dosya uzantısı."
                    ];
                }

                $uploadImage = $this->uploadImage($fulPath, $tmpName);

                if (!$uploadImage) {
                    return [
                        "status" => "danger",
                        "message" => "Resim yüklenemedi, daha sonra tekrar deneyiniz."
                    ];
                }
            }

            if ($book->title == $title && $book->author == $author && $book->category_id == $category_id && $book->pages == $pages && $book->description == $description && $book->image_name == $imageName) {
                return [
                    "status" => "danger",
                    "message" => "Herhangi bir değişiklik yapılmadı."
                ];
            }

            $sql = "UPDATE books SET category_id = :category_id, title = :title, slug = :slug, description = :description, author = :author, image_name = :image_name, pages = :pages WHERE id = :id";
            $stmt = $this->connect()->prepare($sql);
            $result = $stmt->execute([
                "category_id" => $category_id,
                "title" => $title,
                "slug" => $slug,
                "description" => $description,
                "author" => $author,
                "image_name" => $imageName,
                "pages" => $pages,
                "id" => $id
            ]);

            if ($result) {

                if ($imageName != $oldImage) {
                    if (file_exists("../images/" . $oldImage)) {
                        unlink("../images/" . $oldImage);
                    }
                }

                return [
                    "status" => "success",
                    "message" => "Kitap başarılı bir şekilde güncellendi."
                ];
            }
            else {
                if ($imageName != $oldImage) {
                    if (file_exists("../images/" . $imageName)) {
                        unlink("../images/" . $imageName);
                    }
                }

                return [
                    "status" => "danger",
                    "message" => "Sistemde yaşanan bir hatadan dolayı işlem gerçekleştirilemedi, daha sonra tekrar deneyiniz..."
                ];
            }
            
        }

        // Kitap silme - Profil
        public function deleteBook(int $id) : array {
            $book = $this->getBookById($id);

            if (!$book) {
                return [
                    "status" => "danger",
                    "message" => "Kitap bulunamadı."
                ];
            }

            $uploads = "../images/";
            $imageName = $book->image_name;
            $fulPath = $uploads . $imageName;

            $conn = $this->connect();

            try {
                $conn->beginTransaction();

                $sql = "DELETE FROM books WHERE id = :id";
                $stmt = $conn->prepare($sql);
                $result = $stmt->execute([
                    "id" => $id
                ]);

                if ($result) {
                    if (file_exists($fulPath) && !empty($imageName)) {
                        if (unlink($fulPath)) {
                            $conn->commit();
    
                            return [
                                "status" => "success",
                                "message" => "Kitap başarılı bir şekilde silindi."
                            ];
                        }
                        else {
                            if ($conn->inTransaction()) {
                                $conn->rollBack();
                            }
        
                            return [
                                "status" => "danger",
                                "message" => "Kitap resmi silinemedi."
                            ];
                        }
                    }
                    else {
                        if ($conn->inTransaction()) {
                            $conn->rollBack();
                        }

                        return [
                            "status" => "danger",
                            "message" => "Kitap resmi bulunamadı."
                        ];
                    }
                }
                else {
                    return [
                        "status" => "danger",
                        "message" => "Sistemde yaşanan bir hatadan dolayı işlem gerçekleştirilemedi, daha sonra tekrar deneyiniz..."
                    ];
                }

            } catch (PDOException $err) {  
                if ($conn->inTransaction()) {
                    $conn->rollBack();
                }

                return [
                    "status" => "danger",
                    "message" => "İşlem başarısız."
                ];
            }
        }

        // Kullanıcıya ait kitapları sayfalama ile getirme - Profil
        public function getBooksByUser(int $user_id, int $page) {
            $limit = 10;
            $offset = ($page - 1) * $limit;

            $sql = "SELECT b.*, c.name AS category_name, b.slug AS slug, b.id AS book_id FROM books b inner join categories c ON b.category_id = c.id WHERE b.user_id = :user_id ORDER BY b.id DESC LIMIT :limit OFFSET :offset";
            $stmt = $this->connect()->prepare($sql);

            $stmt->bindValue("limit", $limit, PDO::PARAM_INT);
            $stmt->bindValue("offset", $offset, PDO::PARAM_INT);
            $stmt->bindValue("user_id", $user_id, PDO::PARAM_INT);

            $stmt->execute();

            $totalBooks = (int) $this->getBooksByUserCount($user_id)->totalBooks;
            $pageCount = (int) ceil($totalBooks / $limit);

            return [
                "totalBooks" => $totalBooks,
                "pageCount" => $pageCount,
                "start" => $totalBooks > 0 ? $offset + 1 : 0,
                "end" => min($offset + $limit, $totalBooks),
                "userBooks" => $stmt->fetchAll()
            ];
        }

        // Onay bekleyen toplam kitap sayısı - Dashboard/Pending
        public function getBooksByNotIsVerifiedCount() {
            $sql = "SELECT COUNT(*) AS is_verified FROM books WHERE is_verified = 0";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();

            return $stmt->fetch()->is_verified;
        }

        // Onay bekleyen kitapları sayfalama ile getirme - Dashboard/Pending
        public function getBooksByPending(int $page) {
            $limit = 8;
            $offset = ($page - 1) * $limit;

            $sql = "SELECT b.*, c.name AS category_name, u.name AS firstName, u.surname AS lastName, b.slug AS slug, b.id AS book_id FROM books b inner join categories c on b.category_id = c.id inner join users u on b.user_id = u.id  WHERE b.is_verified = 0 LIMIT :limit OFFSET :offset";
            $stmt = $this->connect()->prepare($sql);

            $stmt->bindValue("limit", $limit, PDO::PARAM_INT);
            $stmt->bindValue("offset", $offset, PDO::PARAM_INT);

            $stmt->execute();

            $pageCount = ceil($this->getBooksByNotIsVerifiedCount() / $limit);

            return [
                "pageCount" => $pageCount,
                "notIsVerified" => $stmt->fetchAll()
            ];
        }

        // Onaylı toplam kitap sayısı - Home
        public function getBookCountByIsVerified() {
            $sql = "SELECT COUNT(*) AS totalBook FROM books WHERE is_verified = 1";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();

            return $stmt->fetch()->totalBook;
        }

        // Toplam kitap sayısı - Dashboard
        public function getBookCount() {
            $sql = "SELECT COUNT(*) AS totalBook FROM books";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();

            return $stmt->fetch()->totalBook;
        }

        // Kitap onayla - Dashboard/Pending
        public function editBookByIsVerified(int $id) {
            $sql = "UPDATE books SET is_verified = 1 WHERE id = :id";
            $stmt = $this->connect()->prepare($sql);
            $result = $stmt->execute([
                "id" => $id
            ]);

            if ($result) {
                return [
                    "status" => "success",
                    "message" => "Kitap doğrulandı."
                ];
            }
            else {
                return [
                    "status" => "danger",
                    "message" => "Sistemde yaşanan bir hatadan dolayı işlem gerçekleştirilemedi, daha sonra tekrar deneyiniz..."
                ];
            }
        }

        // Kitap sil - Dashboard/Pending
        public function deleteBookByIsVerified(int $id) {
            $book = $this->getBookById($id);

            if (!$book) {
                return [
                    "status" => "danger",
                    "message" => "Kitap bulunamadı."
                ];
            }

            $sql = "DELETE FROM books WHERE id = :id";
            $stmt = $this->connect()->prepare($sql);
            $result = $stmt->execute([
                "id" => $id
            ]);

            if ($result && $stmt->rowCount() > 0) {
                $imagePath = "../images/" . $book->image_name;

                if (!empty($book->image_name) && file_exists($imagePath)) {
                    unlink($imagePath);
                }

                return [
                    "status" => "success",
                    "message" => "Kitap doğrulaması kaldırıldı."
                ];
            }
            else {
                return [
                    "status" => "danger",
                    "message" => "Sistemde yaşanan bir hatadan dolayı işlem gerçekleştirilemedi, daha sonra tekrar deneyiniz..."
                ];
            }
        }

        // Kitapları filtreye göre getir
        public function getBooksByFilters(string $category, string $keyword, int $page) : array {
            $sql = " FROM books b INNER JOIN categories c ON b.category_id = c.id AND c.is_verified = 1 WHERE b.is_verified = 1";
            $params = [];
            $limit = 12;
            $page = max(1, $page);
            $offset = ($page - 1) * $limit;

            if (!empty($category)) {
                $sql .= " AND c.slug = :category";
                $params["category"] = $category;
            }

            if (!empty($keyword)) {
                $sql .= " AND (b.title LIKE :title OR b.author LIKE :author)";
                $params["title"] = "%" . $keyword . "%";
                $params["author"] = "%" . $keyword . "%";
            }

            $queryCount = "SELECT COUNT(*)" . $sql;
            $stmtCount = $this->connect()->prepare($queryCount);
            $stmtCount->execute($params);

            $totalBooks = (int) $stmtCount->fetchColumn();
            $totalPages = (int) ceil($totalBooks / $limit);

            $queryBooks = "SELECT b.*, b.id AS book_id, c.id, c.name" . $sql . " LIMIT :limit OFFSET :offset";
            $stmt = $this->connect()->prepare($queryBooks);

            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value, PDO::PARAM_STR);
            }

            $stmt->bindValue(":limit", $limit, PDO::PARAM_INT);
            $stmt->bindValue(":offset", $offset, PDO::PARAM_INT);
            $stmt->execute();

            return [
                "totalBooks" => $totalBooks,
                "totalPages" => $totalPages,
                "start" => $totalBooks > 0 ? $offset + 1 : 0,
                "end" => min($offset + $limit, $totalBooks),
                "books" => $stmt->fetchAll()
            ];
        }

        // Slug'a göre kitap getir
        public function getBookBySlug(string $slug, int $id) {
            $sql = "SELECT b.*, b.id AS book_id, b.user_id AS book_user_id, c.name AS category_name, c.slug AS category_slug, u.*, u.id AS user_id, b.is_verified AS bookIsVerified FROM books b inner join categories c on b.category_id = c.id inner join users u on b.user_id = u.id WHERE b.slug = :slug AND b.id = :id";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([
                ":slug" => $slug,
                ":id" => $id
            ]);

            return $stmt->fetch();
        }   

        // Kullanıcının aktif kitaplarını getirir. 
        public function getBooksByUserActive(int $user_id) {
            $sql = "SELECT * FROM books WHERE user_id = :user_id";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([
                "user_id" => $user_id
            ]);

            return $stmt->fetchAll();
        }

        // Son eklenen 4 kitap
        public function getLatestBooks() {
            $sql = "SELECT b.*, b.id AS book_id, b.slug AS slug, c.name FROM books b JOIN categories c ON c.id = b.category_id WHERE b.is_verified = 1 ORDER BY b.created_at DESC LIMIT 4";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll();
        }

        // Favorisi en çok olan kitaplar
        public function getFavorites() {
            $sql = "SELECT COUNT(f.id) AS fav_count, b.*, b.slug AS slug, b.id AS book_id, c.name AS category_name FROM favorites f inner join books b on f.book_id = b.id inner join users u on f.user_id = u.id inner join categories c on b.category_id = c.id WHERE b.is_verified = 1 GROUP BY b.id ORDER BY fav_count DESC LIMIT 8";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll();
        }
    }

?>