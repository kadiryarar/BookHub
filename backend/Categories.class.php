<?php

    class Categories extends Database {
        // Kategori adı kontrolü - Dashboard/Categories
        private function checkCategory(string $name) {
            $sql = "SELECT * FROM categories WHERE name = :name LIMIT 1";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([
                'name' => $name
            ]);

            return $stmt->fetch();
        }

        // Id'ye göre kategori getirme - Dashboard/Categories
        private function getCategoryById(int $id) {
            $sql = "SELECT * FROM categories WHERE id = :id LIMIT 1";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([
                'id' => $id
            ]);

            return $stmt->fetch();
        }
        
        // Toplam kategori sayısı - Dashboard/Categories
        public function getCategoryCount() {
            $sql = "SELECT COUNT(*) AS totalCategory FROM categories";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();

            return $stmt->fetch();
        }

        // Aktif Kategori sayısı - Dashboard/Categories
        public function getCategoryByActiveCount() {
            $sql = "SELECT COUNT(*) AS totalCategory FROM categories WHERE is_verified = 1";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();

            return $stmt->fetch();
        }

        // Pasif kategori sayısı - Dashboard/Categories
        public function getCategoryByPassiveCount() {
            $sql = "SELECT COUNT(*) AS totalCategory FROM categories WHERE is_verified = 0";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();

            return $stmt->fetch();
        }

        // Kitapların toplam sayısı - Dashboard/Categories
        public function getCategoryByBooks() {
            $sql = "SELECT COUNT(*) AS totalBooks FROM books";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();

            return $stmt->fetch();
        }

        // Kategorilere göre kitap sayılarını getirme - Dashboard
        public function getCategoriesByBooksCount() {
            $sql = "SELECT c.*, COUNT(b.id) AS categoryByBooksCount FROM categories c LEFT JOIN books b ON c.id = b.category_id GROUP BY c.id;";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll();
        }

        // Sayfalama ile kategorileri getirme - Dashboard/Categories
        public function getCategoriesByPagination(int $page) {
            $limit = 8;
            $offset = ($page - 1) * $limit;
            $sql = "SELECT c.*, COUNT(b.id) AS categoryCountByBooks FROM categories c LEFT JOIN books b ON c.id = b.category_id GROUP BY c.id LIMIT :limit OFFSET :offset";
            $stmt = $this->connect()->prepare($sql);

            $stmt->bindValue("limit", $limit, PDO::PARAM_INT);
            $stmt->bindValue("offset", $offset, PDO::PARAM_INT);

            $stmt->execute();

            $pageCount = ceil($this->getCategoryCount()->totalCategory / $limit);

            return [
                "pageCount" => $pageCount,
                "categories" => $stmt->fetchAll()
            ];
        }

        // Onaylı kategorileri getirme - Profil + Filter
        public function getCategories() {
            $sql = "SELECT c.*, COUNT(b.id) AS categoryByBooksCount FROM categories c LEFT JOIN books b ON c.id = b.category_id AND b.is_verified = 1 WHERE c.is_verified = 1 GROUP BY c.id";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll();
        }

        // Kategori ekleme - Dashboard/Categories
        public function createCategory(string $name, string $slug, int $isActive) : array {

            if (empty($name)) {
                return [
                    "status" => "danger",
                    "message" => "Kategori adı boş bırakılamaz."
                ];
            }

            $category = $this->checkCategory($name);

            if ($category) {
                return $data = [
                    "status" => "danger",
                    "message" => "Bu kategori adı zaten kullanılıyor."
                ];
            }

            $sql = "INSERT INTO categories (name, slug, is_verified) VALUES (:name, :slug, :is_verified)";
            $stmt = $this->connect()->prepare($sql);
            $result = $stmt->execute([
                'name' => $name,
                'slug' => $slug,
                'is_verified' => $isActive
            ]);

            if ($result) {
                return [
                    "status" => "success",
                    "message" => "Kategori başarılı bir şekilde eklendi."
                ];
            }
            else {
                return [
                    "status" => "danger",
                    "message" => "Sistemde yaşanan bir hatadan dolayı işlem gerçekleştirilemedi, daha sonra tekrar deneyiniz..."
                ];
            }

        }

        // Kategori güncelleme - Dashboard/Categories
        public function editCategory(int $id, string $name, string $slug, int $isActive) : array {
            if (empty($name)) {
                return [
                    "status" => "danger",
                    "message" => "Kategori adı boş bırakılamaz."
                ];
            }

            $category = $this->getCategoryById($id);

            if (!$category) {
                return [
                    "status" => "danger",
                    "message" => "Kategori bulunamadı."
                ];
            }

            if ($category->is_verified == $isActive && $category->name == $name) {
                return [
                    "status" => "danger",
                    "message" => "Herhangi bir değişiklik yapılmadı."
                ];
            }

            $cat = $this->checkCategory($name);

            if ($cat && $cat->id != $id) {
                return [
                    "status" => "danger",
                    "message" => "Bu kategori adı zaten kullanılıyor."
                ];
            }

            $sql = "UPDATE categories SET name = :name, slug = :slug , is_verified = :is_verified WHERE id = :id";
            $stmt = $this->connect()->prepare($sql);
            $result = $stmt->execute([
                'name' => $name,
                'slug' => $slug,
                'is_verified' => $isActive,
                'id' => $id
            ]);

            if ($result) {
                return [
                    "status" => "success",
                    "message" => "Kategori başarılı bir şekilde güncellendi."
                ];
            }
            else {
                return [
                    "status" => "danger",
                    "message" => "Sistemde yaşanan bir hatadan dolayı işlem gerçekleştirilemedi, daha sonra tekrar deneyiniz..."
                ];
            }
        }

        // Kategori silme - Dashboard/Categories
        public function deleteCategory(int $id) : array {
            if (empty($id)) {
                return [
                    "status" => "danger",
                    "message" => "Kategori silinemedi."
                ];
            }

            $sql = "DELETE FROM categories WHERE id = :id";
            $stmt = $this->connect()->prepare($sql);
            $result = $stmt->execute([
                'id' => $id
            ]);

            if ($result) {
                return [
                    "status" => "success",
                    "message" => "Kategori başarılı bir şekilde silindi."
                ];
            }
            else {
                return [
                    "status" => "danger",
                    "message" => "Sistemde yaşanan bir hatadan dolayı işlem gerçekleştirilemedi, daha sonra tekrar deneyiniz..."
                ];
            }

        }

    }

?>