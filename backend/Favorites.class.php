<?php

    class Favorites extends Database {

        // Favori kontrolü
        public function checkFavorite(int $user_id, int $book_id) {
            $sql = "SELECT * FROM favorites WHERE user_id = :user_id AND book_id = :book_id LIMIT 1";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([
                "user_id" => $user_id,
                "book_id" => $book_id,
            ]);

            return (bool) $stmt->fetch();
        }

        // Favorilere ekle
        public function createFavorite(int $user_id, int $book_id) : array {

            if ($this->checkFavorite($user_id, $book_id)) {
                return [
                    "status" => "danger",
                    "message" => "Bu kitap zaten favorilerinizde."
                ];
            }

            $sql = "INSERT INTO favorites (user_id, book_id) VALUES (:user_id, :book_id)";
            $stmt = $this->connect()->prepare($sql);
            $result = $stmt->execute([
                "user_id" => $user_id,
                "book_id" => $book_id
            ]);

            if ($result) {
                return [
                    "status" => "success",
                    "message" => "Kitap favorilerinize eklendi."
                ];
            }
            else {
                return [
                    "status" => "danger",
                    "message" => "Sistemde yaşanan bir hatadan dolayı işlem gerçekleştirilemedi, daha sonra tekrar deneyiniz..."
                ];
            }

        }

        // Favorilerden kaldır
        public function deleteFavorite(int $user_id, int $book_id) : array {

            if (!$this->checkFavorite($user_id, $book_id)) {
                return [
                    "status" => "danger",
                    "message" => "Bu kitap zaten favorinizde değil."
                ];
            }

            $sql = "DELETE FROM favorites WHERE user_id = :user_id AND book_id = :book_id";
            $stmt = $this->connect()->prepare($sql);
            $result = $stmt->execute([
                "user_id" => $user_id,
                "book_id" => $book_id
            ]);

            if ($result) {
                return [
                    "status" => "success",
                    "message" => "Kitap favorilerinizden silindi."
                ];
            }
            else {
                return [
                    "status" => "danger",
                    "message" => "Sistemde yaşanan bir hatadan dolayı işlem gerçekleştirilemedi, daha sonra tekrar deneyiniz..."
                ];
            }

        }

        // Kullanıcının favori sayısı
        public function getFavoriteCount(int $user_id) {
            $sql = "SELECT COUNT(*) AS totalFavorite FROM favorites WHERE user_id = :user_id";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([
                'user_id' => $user_id
            ]);

            return $stmt->fetch();
        }

        // Favorileri sayfalama ile getirme
        public function getFavoriteByUser(int $user_id, int $page) {
            $limit = 10;
            $offset = ($page - 1) * $limit;

            $sql = "SELECT f.id AS favorite_id, b.*, b.id AS book_id, b.slug AS slug, c.name AS category_name FROM favorites f inner join books b on f.book_id = b.id inner join categories c on b.category_id = c.id WHERE f.user_id = :user_id ORDER BY f.id DESC LIMIT :limit OFFSET :offset";
            $stmt = $this->connect()->prepare($sql);

            $stmt->bindValue("limit", $limit, PDO::PARAM_INT);
            $stmt->bindValue("offset", $offset, PDO::PARAM_INT);
            $stmt->bindValue("user_id", $user_id, PDO::PARAM_INT);

            $stmt->execute();
            $favorites = $stmt->fetchAll();

            $totalFavorite = (int) $this->getFavoriteCount($user_id)->totalFavorite;
            $pageCount = (int) ceil($totalFavorite / $limit);

            return [
                "totalFavorite" => $totalFavorite,
                "totalPages" => $pageCount,
                "start" => $totalFavorite > 0 ? $offset + 1 : 0,
                "end" => min($offset + $limit, $totalFavorite),
                "favorites" => $favorites
            ];
        }

        // Favorilerden Kaldır - Profil
        public function deleteFavoriteByProfil(int $id) : array {
            $sql = "DELETE FROM favorites WHERE id = :id";
            $stmt = $this->connect()->prepare($sql);
            $result = $stmt->execute([
                "id" => $id
            ]);

            if ($result) {
                return [
                    "status" => "success",
                    "message" => "Kitap favorilerinizden silindi."
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