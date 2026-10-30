<?php

    class Users extends Database {
        // Kullanıcı adı / e-posta sorgulama - Register / Login
        private function checkUser(string $email) {
            $sql = "SELECT * FROM users WHERE email = :email OR username = :username LIMIT 1";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([
                'email' => $email,
                'username' => $email
            ]);

            return $stmt->fetch();
        }

        // Kullanıcı Id'sine göre image_name getir
        private function getImageNameById(int $id) {
            $sql = "SELECT b.image_name FROM users u inner join books b on u.id = b.user_id WHERE u.id = :id";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([
                "id" => $id
            ]);

            return $stmt->fetch()->image_name;
        }

        // Id'ye göre kullanıcı getirme - Users
        public function getUserById(int $id) {
            $sql = "SELECT * FROM users WHERE id = :id LIMIT 1";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([
                'id' => $id
            ]);

            return $stmt->fetch();
        }

        // Kullanıcı giriş kontrolü - Login
        public function checkLogin(string $email, string $password) : array {
            
            if (empty($email) || empty($password)) {
                return  [
                    "status" => "danger",
                    "message" => "Lütfen tüm alanları doldurunuz."
                ];
            }

            if (str_contains($email, "@")) {
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    return  [
                        "status" => "danger",
                        "message" => "E-Posta formata uygun değildir."
                    ];
                }
            }

            $user = $this->checkUser($email);

            if (!$user) {
                return  [
                    "status" => "danger",
                    "message" => "Kullanıcı Adı / E-posta adresi kayıtlı değil."
                ];
            }

            if (!password_verify($password, $user->password)) {
                return  [
                    "status" => "danger",
                    "message" => "Şifre yanlış."
                ];
            }
            else {
                return [
                    "status" => "success",
                    "id" => $user->id,
                    "name" => $user->name,
                    "surname" => $user->surname,
                    "username" => $user->username,
                    "email" => $user->email,
                    "user_type" => $user->user_type,
                    "created_at" => $user->created_at,
                    "message" => "Giriş başarılı, Anasayfaya yönlendiriliyorsunuz..."
                ];
            }
        }

        // Kullanıcı ekleme - Register
        public function createUser(string $name, string $surname, string $username, string $email, string $password, string $repassword) : array {
            if (empty($name) || empty($surname) || empty($username) || empty($email) || empty($password) || empty($repassword)) {
                return [
                    "status" => "danger",
                    "message" => "Lütfen tüm alanları doldurunuz."
                ];
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return [
                    "status" => "danger",
                    "message" => "E-Posta formata uygun değildir."
                ];
            }

            if (str_contains($username, " ")) {
                return [
                    "status" => "danger",
                    "message" => "Kullanıcı adında boşluk karakteri olamaz."
                ];
            }

            if (str_contains($username, "@")) {
                return [
                    "status" => "danger",
                    "message" => "Kullanıcı adı @ karakteri içeremez."
                ];
            }

            $user = $this->checkUser($username);

            if ($user) {
                return [
                    "status" => "danger",
                    "message" => "Bu kullanıcı adı zaten kullanılıyor."
                ];
            }

            if (strlen($password) < 8) {
                return [
                    "status" => "danger",
                    "message" => "Şifre en az 8 karakterden oluşmalıdır."
                ];
            }

            if (!preg_match('/[A-Z]/', $password)) {
                return [
                    "status" => "danger",
                    "message" => "Şifrede en az 1 tane büyük harf olmalıdır."
                ];
            } 

            if (!preg_match('/[a-z]/', $password)) {
                return [
                    "status" => "danger",
                    "message" => "Şifrede en az 1 tane küçük harf olmalıdır."
                ];
            } 

            if (!preg_match('/[0-9]/', $password)) {
                return [
                    "status" => "danger",
                    "message" => "Şifrede en az 1 tane rakam olmalıdır."
                ];
            }

            if (!preg_match('/[^A-Za-z0-9]/', $password)) {
                return [
                    "status" => "danger",
                    "message" => "Şifrede en az 1 tane özel karakter olmalıdır."
                ];
            }

            if ($password != $repassword) {
                return [
                    "status" => "danger",
                    "message" => "Şifreler uyuşmuyor."
                ];
            }

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO users (name, surname, username, email, password) VALUES (:name, :surname, :username, :email, :password)";
            $stmt = $this->connect()->prepare($sql);
            $result = $stmt->execute([
                'name' => ucfirst($name),
                'surname' => ucfirst($surname),
                'username' => $username,
                'email' => $email,
                'password' => $hashedPassword  
            ]);

            if ($result) {
                return [
                    "status" => "success",
                    "message" => "Hesabınız başarıyla oluşturuldu. Giriş sayfasına yönlendiriliyorsunuz..."
                ];
            }
            else {
                return [
                    "status" => "danger",
                    "message" => "Sistemde yaşanan bir hatadan dolayı işlem gerçekleştirilemedi, daha sonra tekrar deneyiniz..."
                ];
            }

        }

        // Toplam kullanıcı sayısı - Dashboard
        public function getUsersCount() {
            $sql = "SELECT COUNT(*) AS totalUsers FROM users";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();

            return $stmt->fetch();
        }

        // Toplam üye sayısı - Dashboard/Users
        public function getUsersByMemberCount() {
            $sql = "SELECT COUNT(*) AS totalMember FROM users WHERE user_type = 'user'";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();

            return $stmt->fetch();
        }

        // Toplam admin sayısı - Dashboard/Users
        public function getUsersByAdminCount() {
            $sql = "SELECT COUNT(*) AS totalAdmin FROM users WHERE user_type = 'admin'";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();

            return $stmt->fetch();
        }

        // Sayfalama ile kullanıcı getirme - Dashboard/Users
        public function getUsersByPagination(int $page) {
            $limit = 8;
            $offset = ($page - 1) * $limit;
            $sql = "SELECT u.*, COUNT(b.id) AS userCountByBooks FROM users u LEFT JOIN books b ON u.id = b.user_id AND b.is_verified = 1 GROUP BY u.id LIMIT :limit OFFSET :offset";
            $stmt = $this->connect()->prepare($sql);

            $stmt->bindValue("limit", $limit, PDO::PARAM_INT);
            $stmt->bindValue("offset", $offset, PDO::PARAM_INT);

            $stmt->execute();

            $pageCount = ceil($this->getUsersCount()->totalUsers / $limit);

            return [
                "pageCount" => $pageCount,
                "categories" => $stmt->fetchAll()
            ];
        }

        // Admin sayfası kullanıcı güncelleme - Dashboard/Users
        public function editUserByAdmin(int $id, string $name, string $surname, string $username, string $email, string $user_type) : array {
            if (empty($name) || empty($surname) || empty($username) || empty($email)) {
                return [
                    "status" => "danger",
                    "message" => "Lütfen tüm alanları doldurunuz."
                ];
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return [
                    "status" => "danger",
                    "message" => "E-Posta formata uygun değildir."
                ];
            }

            if (str_contains($username, " ")) {
                return [
                    "status" => "danger",
                    "message" => "Kullanıcı adında boşluk karakteri olamaz."
                ];
            }

            if (str_contains($username, "@")) {
                return [
                    "status" => "danger",
                    "message" => "Kullanıcı adı @ karakteri içeremez."
                ];
            }

            $user = $this->getUserById($id);

            if (!$user) {
                return [
                    "status" => "danger",
                    "message" => "Kullanıcı bulunamadı."
                ];
            }

            if ($user->name == $name && $user->surname == $surname && $user->username == $username && $user->email == $email && $user->user_type == $user_type) {
                return [
                    "status" => "danger",
                    "message" => "Herhangi bir değişiklik yapılmadı."
                ];
            }

            $u = $this->checkUser($username);

            if ($u && ($u->name == $name && $u->surname == $surname && $u->username == $username && $u->email == $email && $u->user_type == $user_type)) {
                return [
                    "status" => "danger",
                    "message" => "Bu kullanıcı adı zaten kullanılıyor."
                ];
            }

            $sql = "UPDATE users SET name = :name, surname = :surname, username = :username, email = :email, user_type = :user_type WHERE id = :id";
            $stmt = $this->connect()->prepare($sql);
            $result = $stmt->execute([
                "name" => $name,
                "surname" => $surname,
                "username" => $username,
                "email" => $email,
                "user_type" => $user_type,
                "id" => $id
            ]);

            if ($result) {
                return [
                    "status" => "success",
                    "message" => "Kullanıcı başarılı bir şekilde güncellendi."
                ];
            }
            else {
                return [
                    "status" => "danger",
                    "message" => "Sistemde yaşanan bir hatadan dolayı işlem gerçekleştirilemedi, daha sonra tekrar deneyiniz..."
                ];
            }

        }

        // Admin sayfası kullanıcı silme - Dashboard/Users
        public function deleteUserByAdmin(int $id, int $session_id) : array {
            $user = $this->getUserById($id);

            if (!$user) {
                return [
                    "status" => "danger",
                    "message" => "Kullanıcı bulunamadı."
                ];
            }
            
            if ($user->id == $session_id) {
                return [
                    "status" => "danger",
                    "message" => "Kendi hesabınızı silemezsiniz."
                ];
            }

            $imageName = $this->getImageNameById($id);
            $imagePath = "../images/" . $imageName;

            $sql = "DELETE FROM users WHERE id = :id";
            $stmt = $this->connect()->prepare($sql);
            $result = $stmt->execute([
                "id" => $id
            ]);

            if ($result && $stmt->rowCount() > 0) {

                if (!empty($imageName) && file_exists($imagePath)) {
                    unlink($imagePath);
                }

                return [
                    "status" => "success",
                    "message" => "Kullanıcı başarılı bir şekilde silindi."
                ];
            }
            else {
                return [
                    "status" => "danger",
                    "message" => "Sistemde yaşanan bir hatadan dolayı işlem gerçekleştirilemedi, daha sonra tekrar deneyiniz..."
                ];
            }

        }

        // Profil sayfası kullanıcı ve şifre güncelleme
        public function updateProfil(int $id, string $name, string $surname, string $email, string $username, string $old_password, string $new_password, string $new_password_again) : array {
            $user = $this->getUserById($id);

            if (empty($name) || empty($surname) || empty($email) || empty($username)) {
                return [
                    "status" => "danger",
                    "message" => "Lütfen kişisel bilgileri alanında tüm alanları doldurunuz."
                ];
            }

            if ($user->name == $name && $user->surname == $surname && $user->email == $email && $user->username == $username && empty($old_password) && empty($new_password) && empty($new_password_again)) {
                return [
                    "status" => "danger",
                    "message" => "Herhangi bir değişiklik yapılmadı."
                ];
            }

            if ($user && $user->username == $username && $user->email == $email && empty($old_password) && empty($new_password) && empty($new_password_again)) {
                return [
                    "status" => "danger",
                    "message" => "Bu kullanıcı adı zaten kullanılıyor."
                ];
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return [
                    "status" => "danger",
                    "message" => "E-Posta formata uygun değildir."
                ];
            }

            if (str_contains($username, " ")) {
                return [
                    "status" => "danger",
                    "message" => "Kullanıcı adında boşluk karakteri olamaz."
                ];
            }

            if (str_contains($username, "@")) {
                return [
                    "status" => "danger",
                    "message" => "Kullanıcı adı @ karakteri içeremez."
                ];
            }

            $params = [];
            $params["name"] = $name;
            $params["surname"] = $surname;
            $params["email"] = $email;
            $params["username"] = $username;

            $sql = "UPDATE users SET name = :name, surname = :surname, email = :email, username = :username";

            if (!empty($old_password) || !empty($new_password) || !empty($new_password_again)) {
                if (!password_verify($old_password, $user->password)) {
                    return [
                        "status" => "danger",
                        "message" => "Eski şifre yanlış."
                    ];
                }

                if ($new_password != $new_password_again) {
                    return [
                        "status" => "danger",
                        "message" => "Şifreler uyuşmuyor."
                    ];
                }

                 if (strlen($new_password) < 8) {
                    return [
                        "status" => "danger",
                        "message" => "Şifre en az 8 karakterden oluşmalıdır."
                    ];
                }

                if (!preg_match('/[A-Z]/', $new_password)) {
                    return [
                        "status" => "danger",
                        "message" => "Şifrede en az 1 tane büyük harf olmalıdır."
                    ];
                } 

                if (!preg_match('/[a-z]/', $new_password)) {
                    return [
                        "status" => "danger",
                        "message" => "Şifrede en az 1 tane küçük harf olmalıdır."
                    ];
                } 

                if (!preg_match('/[0-9]/', $new_password)) {
                    return [
                        "status" => "danger",
                        "message" => "Şifrede en az 1 tane rakam olmalıdır."
                    ];
                }

                if (!preg_match('/[^A-Za-z0-9]/', $new_password)) {
                    return [
                        "status" => "danger",
                        "message" => "Şifrede en az 1 tane özel karakter olmalıdır."
                    ];
                }

                $hashedPassword = password_hash($new_password, PASSWORD_DEFAULT);

                $sql .= " , password = :password";
                $params["password"] = $hashedPassword;
            }            

            $sql .= " WHERE id = :id";
            $stmt = $this->connect()->prepare($sql);

            foreach ($params as $key => $param) {
                $stmt->bindValue($key, $param, PDO::PARAM_STR);
            }

            $stmt->bindValue("id", $id, PDO::PARAM_INT);

            $result = $stmt->execute();

            if ($result) {
                return [
                    "status" => "success",
                    "message" => "Kullanıcı başarılı bir şekilde güncellendi."
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