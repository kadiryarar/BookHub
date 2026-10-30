<?php 
    require_once __DIR__ . "/../libs/variables.php";
    require_once __DIR__ . "/../libs/functions.php";
    require_once __DIR__ . "/../backend/Database.class.php";
    require_once __DIR__ . "/../backend/Users.class.php";
    require_once __DIR__ . "/../backend/Categories.class.php";
    require_once __DIR__ . "/../backend/Books.class.php";

    if (!isAdmin()) {
        header("Location: ../403");
        exit;
    }

    $categories = new Categories();
    $books = new Books();
    $users = new Users();
    $notIsVerified = $books->getBooksByNotIsVerifiedCount();
    $userCount = $users->getUsersCount()->totalUsers;
    $data = "";

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
        // Kategori ekle işlemleri
        if (isset($_POST["createCategory"])) {
            $name = safeHtml($_POST["name"] ?? "");
            $isActive = isset($_POST["status"]) && $_POST["status"] == "on" ? 1 : 0;
            $slug = createSlug($name);

            $data = $categories->createCategory($name, $slug, $isActive);
        }

        // Kategori düzenle işlemleri
        if (isset($_POST["editCategory"])) {
            $id = (int) $_POST["id"] ?? "";
            $name = (string) safeHtml($_POST["name"] ?? "");
            $isActive = isset($_POST["status"]) && $_POST["status"] == "on" ? 1 : 0;
            $slug = createSlug($name);

            $data = $categories->editCategory($id, $name, $slug, $isActive);
        }

        // Kategori sil işlemleri
        if (isset($_POST["deleteCategory"])) {
            $id = (int) $_POST["id"] ?? "";

            $data = $categories->deleteCategory($id);
        }

        // Kitap onayla işlemleri
        if (isset($_POST["bookIsVerified"])) {
            $id = (int) $_POST["id"] ?? "";

            $data = $books->editBookByIsVerified($id);
        }
        
        // Kitap onay kaldır işlemleri
        if (isset($_POST["bookNotIsVerified"])) {
            $id = (int) $_POST["id"] ?? "";

            $data = $books->deleteBookByIsVerified($id);
        }

        // Kullanıcı güncelleme işlemleri
        if (isset($_POST["editUser"])) {
            $id = (int) $_POST["id"];
            $name = (string) safeHtml($_POST["name"]);
            $surname = (string) safeHtml($_POST["surname"]);
            $username = (string) safeHtml($_POST["username"]);
            $email = (string) safeHtml($_POST["email"]);
            $user_type = (string) safeHtml($_POST["user_type"]);

            $data = $users->editUserByAdmin($id, $name, $surname, $username, $email, $user_type);
        }

        // Kullanıcı silme işlemleri 
        if (isset($_POST["deleteUser"])) {
            $id = (int) $_POST["id"];
            $session_id = (int) $_SESSION["id"];

            $data = $users->deleteUserByAdmin($id, $session_id);
        }

    }

    $page = $_GET["page"] ?? "dashboard";

    include_once __DIR__ . "/partials/_header.php"; 
    include_once __DIR__ . "/partials/_alert.php";
?>

<div class="container-fluid">
    <div class="row">

        <?php include_once __DIR__ . "/partials/_sidebar.php"; ?>
        <?php include_once __DIR__ . "/partials/_mobile-menu.php"; ?>

        <main class="col-lg-9 col-xl-10 p-0">

            <?php include_once __DIR__ . "/partials/_topbar.php"; ?>

            <div class="container-fluid px-3 px-lg-4 py-4">
                <?php

                    switch ($page) {
                        case 'users':
                            include_once "pages/_users.php";
                            break;
                        case 'categories':
                            include_once "pages/_categories.php";
                            break;
                        case 'pending':
                            include_once "pages/_pending.php";
                            break;
                        default:
                            include_once "pages/_dashboard.php";
                            break;
                    }

                ?>
            </div>

        </main>
    </div>
</div>

<?php include_once __DIR__ . "/partials/_footer.php"; ?>