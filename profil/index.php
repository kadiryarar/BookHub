<?php 
    require_once __DIR__ . "/../libs/variables.php";
    require_once __DIR__ . "/../libs/functions.php";
    require_once __DIR__ . "/../backend/Database.class.php";
    require_once __DIR__ . "/../backend/Categories.class.php";
    require_once __DIR__ . "/../backend/Users.class.php";
    require_once __DIR__ . "/../backend/Books.class.php";
    require_once __DIR__ . "/../backend/Favorites.class.php";
    require_once __DIR__ . "/../backend/Trades.class.php";

    if (!isloggedIn()) {
        header("Location: ../401");
        exit;
    }

    $categories = new Categories();
    $books = new Books();
    $users = new Users();
    $favorite = new Favorites();
    $trades = new Trades();
    $userBooksCount = $books->getBooksByUserCount($_SESSION["id"])->totalBooks;
    $totalFavorite = $favorite->getFavoriteCount($_SESSION["id"])->totalFavorite;
    $totalTrades = $trades->getTradesCount($_SESSION["id"])->totalTrades;
    $totalCompletedTrades = $trades->getCompletedTradesCount()->totalCompletedTrades;
    $data = "";

    $title = "";
    $author = "";
    $description = "";
    $category_id = "";
    $pages = "";

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        // Kitap ekleme işlemleri
        if (isset($_POST["createBook"])) {
            $title = (string) safeHtml($_POST["title"] ?? "");
            $slug = (string) createSlug($title);
            $author = (string) safeHtml($_POST["author"] ?? "");
            $description = (string) safeHtml($_POST["description"] ?? "");
            $category_id = isset($_POST["category_id"]) ? (int) $_POST["category_id"] : 0;
            $pages = (int) $_POST["pages"] ?? "";
            $image = $_FILES["image"];

            $data = $books->createBook($_SESSION["id"], $title, $slug, $author, $category_id, $pages, $image, $description);
        }

        // Kitap düzenleme işlemleri
        if (isset($_POST["editBook"])) {
            $id = (int) $_POST["id"]; 
            $title = (string) safeHtml($_POST["title"] ?? "");
            $slug = (string) createSlug($title);
            $author = (string) safeHtml($_POST["author"] ?? "");
            $description = (string) safeHtml($_POST["description"] ?? "");
            $category_id = isset($_POST["category_id"]) ? (int) $_POST["category_id"] : 0;
            $is_verified = isset($_POST["is_verified"]) ? 1 : 0;
            $pages = (int) $_POST["pages"] ?? "";
            $image = $_FILES["image"];

            $data = $books->editBook($id, $title, $slug, $author, $category_id, $pages, $image, $description);
        }

        // Kitap silme işlemleri
        if (isset($_POST["deleteBook"])) {
            $id = (int) $_POST["id"];

            $data = $books->deleteBook($id);
        }

        // Kitabı favoriden kaldırma
        if (isset($_POST["deleteFavorite"])) {
            $id = (int) $_POST["favorite_id"];

            $data = $favorite->deleteFavoriteByProfil($id);
        }

        // Takas isteğini reddet
        if (isset($_POST["tradesRejected"])) {
            $id = (int) $_POST["tradesId"];

            $data = $trades->tradesRejected($id);
        }

        // Takas isteğini kabul et
        if (isset($_POST["tradesCompleted"])) {
            $id = (int) $_POST["tradesId"];
            $receiver_user_id = (int) $_POST["receiver_user_id"];
            $sender_user_id = (int) $_POST["sender_user_id"];
            $book_sender_id = (int) $_POST["book_sender_id"];
            $book_receiver_id = (int) $_POST["book_receiver_id"];

            $data = $trades->tradesCompleted($id, $sender_user_id, $receiver_user_id, $book_sender_id, $book_receiver_id);
        }

        // Takas isteğini iptal et
        if (isset($_POST["tradesCancelled"])) {
            $id = (int) $_POST["tradesId"];

            $data = $trades->tradesCancelled($id);  
        } 

        // Settings 
        if (isset($_POST["updateProfil"])) {
            $id = (int) $_SESSION["id"];
            $name = (string) $_POST["name"];
            $surname = (string) $_POST["surname"];
            $email = (string) $_POST["email"];
            $username = (string) $_POST["username"];
            $old_password = (string) $_POST["old_password"];
            $new_password = (string) $_POST["new_password"];
            $new_password_again = (string) $_POST["new_password_again"];

            $data = $users->updateProfil($id, $name, $surname, $email, $username, $old_password, $new_password, $new_password_again);
        }

    }

    $pageRoute = $_GET["page"] ?? "books";

    include_once __DIR__ . "/partials/_header.php"; 
    include_once __DIR__ . "/partials/_alert.php";
?>

<div class="container py-4 py-lg-5">

    <?php include_once __DIR__ . "/partials/_profile-card.php"; ?>
    <?php include_once __DIR__ . "/partials/_stats.php"; ?>

    <div class="row g-4">

        <?php include_once __DIR__ . "/partials/_sidebar.php"; ?>

        <main class="col-12 col-lg-9">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-3 p-md-4">
                    <?php

                        switch ($pageRoute) {
                            case 'favorites':
                                include_once "pages/_favorites.php";
                                break;
                            case 'trades':
                                include_once "pages/_trades.php";
                                break;
                            case 'settings':
                                include_once "pages/_settings.php";
                                break;
                            default:
                                include_once "pages/_books.php";
                                break;
                        }

                    ?>
                </div>
            </div>
        </main>

    </div>

</div>

<?php include_once __DIR__ . "/partials/_footer.php"; ?>