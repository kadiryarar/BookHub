<?php

    class Trades extends Database {
        // Takas kontrolü
        private function checkTrades(int $senderBookId, int $senderUserId, int $receiverBookId, int $receiverUserId) {
            $sql = "SELECT * FROM trades WHERE sender_id = :sender_id AND receiver_id = :receiver_id AND sender_book_id = :sender_book_id AND receiver_book_id = :receiver_book_id LIMIT 1";
            $stmt = $this->connect()->prepare($sql);

            $stmt->bindValue("sender_id", $senderUserId, PDO::PARAM_INT);
            $stmt->bindValue("receiver_id", $receiverUserId, PDO::PARAM_INT);
            $stmt->bindValue("sender_book_id", $senderBookId, PDO::PARAM_INT);
            $stmt->bindValue("receiver_book_id", $receiverBookId, PDO::PARAM_INT);

            $stmt->execute();

            return (bool) $stmt->fetch();
        }

        // Kullanıcının takas sayısı
        public function getTradesCount(int $user_id) {
            $sql = "SELECT COUNT(*) AS totalTrades FROM trades WHERE sender_id = :sender_user_id OR receiver_id = :receiver_user_id";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([
                'sender_user_id' => $user_id,
                'receiver_user_id' => $user_id
            ]);

            return $stmt->fetch();
        }

        // Toplam takas sayısı
        public function getTotalTrades() {
            $sql = "SELECT COUNT(*) AS totalTrades FROM trades";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();

            return $stmt->fetch();
        }

        // Kullanıcının tamamlanan takas sayısı
        public function getCompletedTradesCount() {
            $sql = "SELECT COUNT(*) AS totalCompletedTrades FROM trades WHERE status = 'completed'";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();

            return $stmt->fetch();
        }

        // Takas isteği oluştur
        public function createTrades(int $senderBookId, int $senderUserId, int $receiverBookId, int $receiverUserId) : array {
            if ($this->checkTrades($senderBookId, $senderUserId, $receiverBookId, $receiverUserId)) {
                return [
                    "status" => "danger",
                    "message" => "Bu kitap için zaten bir takas teklifin bulunuyor."
                ];
            }
        
            $sql = "INSERT INTO trades (sender_id, receiver_id, sender_book_id, receiver_book_id) VALUES (:sender_id, :receiver_id, :sender_book_id, :receiver_book_id)";
            $stmt = $this->connect()->prepare($sql);

            $stmt->bindValue("sender_id", $senderUserId, PDO::PARAM_INT);
            $stmt->bindValue("receiver_id", $receiverUserId, PDO::PARAM_INT);
            $stmt->bindValue("sender_book_id", $senderBookId, PDO::PARAM_INT);
            $stmt->bindValue("receiver_book_id", $receiverBookId, PDO::PARAM_INT);

            $result = $stmt->execute();            

            if ($result) {
                return [
                    "status" => "success",
                    "message" => "Takas isteği gönderildi."
                ];
            }
            else {
                return [
                    "status" => "danger",
                    "message" => "Sistemde yaşanan bir hatadan dolayı işlem gerçekleştirilemedi, daha sonra tekrar deneyiniz..."
                ];
            }
        }

        // Takas isteğini reddet
        public function tradesRejected(int $id) : array {
            $sql = "UPDATE trades SET status = 'rejected' WHERE id = :id";
            $stmt = $this->connect()->prepare($sql);
            $result = $stmt->execute([
                "id" => $id
            ]);

            if ($result) {
                return [
                    "status" => "success",
                    "message" => "Takas isteği reddedildi."
                ];
            }
            else {
                return [
                    "status" => "danger",
                    "message" => "Sistemde yaşanan bir hatadan dolayı işlem gerçekleştirilemedi, daha sonra tekrar deneyiniz..."
                ];
            }
        }

        // Takas isteğini iptal et
        public function tradesCancelled(int $id) : array {
            $sql = "UPDATE trades SET status = 'cancelled' WHERE id = :id";
            $stmt = $this->connect()->prepare($sql);
            $result = $stmt->execute([
                "id" => $id
            ]);

            if ($result) {
                return [
                    "status" => "success",
                    "message" => "Takas isteği iptal edildi."
                ];
            }
            else {
                return [
                    "status" => "danger",
                    "message" => "Sistemde yaşanan bir hatadan dolayı işlem gerçekleştirilemedi, daha sonra tekrar deneyiniz..."
                ];
            }
        }

        // Takas isteğini kabul et
        public function tradesCompleted(int $id, int $sender, int $receiver, int $book_sender, int $book_receiver) : array {
            $conn = $this->connect();

            try {
                $conn->beginTransaction();

                $sql = "UPDATE trades SET status = 'completed' WHERE id = :id";
                $stmtTradesStatus = $conn->prepare($sql);
                $stmtTradesStatus->bindValue("id", $id, PDO::PARAM_INT);
                $stmtTradesStatus->execute();

                $sql = "UPDATE books SET user_id = :user_sender_id WHERE id = :book_sender_id";
                $stmtUpdateBook_1 = $conn->prepare($sql);
                $stmtUpdateBook_1->bindValue("book_sender_id", $book_sender, PDO::PARAM_INT);
                $stmtUpdateBook_1->bindValue("user_sender_id", $sender, PDO::PARAM_INT);
                $stmtUpdateBook_1->execute();

                $sql = "UPDATE books SET user_id = :user_receiver_id WHERE id = :book_receiver_id";
                $stmtUpdateBook_2 = $conn->prepare($sql);
                $stmtUpdateBook_2->bindValue("book_receiver_id", $book_receiver, PDO::PARAM_INT);
                $stmtUpdateBook_2->bindValue("user_receiver_id", $receiver, PDO::PARAM_INT);
                $stmtUpdateBook_2->execute();

                $conn->commit();

                return [
                    "status" => "success",
                    "message" => "Takas tamamlandı."
                ];

            } catch (PDOException $err) {
                if ($conn->inTransaction()) {
                    $conn->rollBack();
                }

                die($err->getMessage());

                return [
                    "status" => "danger",
                    "message" => "İşlem başarısız."
                ];
            } 
        }

        // Takasları sayfalama ile getirme
        public function getTradesByUser(int $user_id, int $page) {
            $limit = 10;
            $offset = ($page - 1) * $limit;

            $countSql = "SELECT COUNT(*) FROM trades WHERE sender_id = :sender_user_id OR receiver_id = :receiver_user_id";
            $countStmt = $this->connect()->prepare($countSql);
            $countStmt->bindValue("sender_user_id", $user_id, PDO::PARAM_INT);
            $countStmt->bindValue("receiver_user_id", $user_id, PDO::PARAM_INT);
            $countStmt->execute();
            $totalTrades = (int) $countStmt->fetchColumn();
            $pageCount = (int) ceil($totalTrades / $limit);

            $sql = "SELECT t.id AS tradesId, t.status AS tradesStatus, t.created_at AS tradesCreatedAt, 
                    user_receiver.name AS receiver_name, user_receiver.surname AS receiver_surname, 
                    user_receiver.id AS receiver_user_id, user_sender.name AS sender_name, 
                    user_sender.surname AS sender_surname, user_sender.id AS sender_user_id, 
                    book_sender.title AS book_sender_title, book_sender.author AS book_sender_author, 
                    book_receiver.title AS book_receiver_title, book_receiver.author AS book_receiver_author, 
                    book_sender.slug AS book_sender_slug, book_sender.id AS book_sender_id, book_receiver.id AS book_receiver_id 
                    FROM trades t 
                    inner join users user_sender on t.sender_id = user_sender.id 
                    inner join users user_receiver on t.receiver_id = user_receiver.id 
                    inner join books book_sender on t.sender_book_id = book_sender.id 
                    inner join books book_receiver on t.receiver_book_id = book_receiver.id 
                    WHERE t.sender_id = :session_sender_id OR t.receiver_id = :session_receiver_id 
                    ORDER BY t.created_at DESC LIMIT :limit OFFSET :offset";
            
            $stmt = $this->connect()->prepare($sql);

            $stmt->bindValue("session_sender_id", $user_id, PDO::PARAM_INT);
            $stmt->bindValue("session_receiver_id", $user_id, PDO::PARAM_INT);
            $stmt->bindValue("limit", $limit, PDO::PARAM_INT);
            $stmt->bindValue("offset", $offset, PDO::PARAM_INT);
            
            $stmt->execute();
            $trades = $stmt->fetchAll();

            return [
                "totalTrades" => $totalTrades,
                "totalPages" => $pageCount,
                "start" => $totalTrades > 0 ? $offset + 1 : 0,
                "end" => min($offset + $limit, $totalTrades),
                "trades" => $trades
            ];
        }
    }

?>  