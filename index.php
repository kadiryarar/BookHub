<?php
    require_once __DIR__ . "/libs/functions.php";
    require_once __DIR__ . "/backend/Database.class.php";
    require_once __DIR__ . "/backend/Users.class.php";
    require_once __DIR__ . "/backend/Books.class.php";
    require_once __DIR__ . "/backend/Trades.class.php";

    $title = "Anasayfa";

    include_once __DIR__ . "/partials/_header.php";
    include_once __DIR__ . "/partials/_sidebar.php";

    $users = new Users();
    $books = new Books();
    $trades = new Trades();
    $totalTrades = $trades->getTotalTrades()->totalTrades;
    $latestBooks = $books->getLatestBooks();
    $favoritesBooks = $books->getFavorites();
    $bookCount = $books->getBookCountByIsVerified();

?>

<main class="container py-3 py-md-4">
    <?php 

        include_once __DIR__ . "/partials/_mobile-search.php";
        include_once __DIR__ . "/partials/_hero.php";
        include_once __DIR__ . "/partials/_latest.php";
        include_once __DIR__ . "/partials/_favorites.php";

    ?>
</main>

<?php include_once __DIR__ . "/partials/_community.php"; ?>
<?php include_once __DIR__ . "/partials/_footer.php"; ?>