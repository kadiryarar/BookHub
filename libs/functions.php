<?php

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    function safeHtml(string $text) : string {
        $text = trim($text);
        $text = htmlspecialchars($text);
        $text = stripslashes($text);
        
        return $text;
    }

    function createSlug(string $text) : string {
        $text = str_replace(['Ç', 'Ğ', 'I', 'Ö', 'Ş', 'Ü', 'ç', 'ğ', 'ı', 'ö', 'ş', 'ü'], ['c', 'g', 'i', 'o', 's', 'u', 'c', 'g', 'i', 'o', 's', 'u'], $text);
        $text = strtolower($text);
        $text = preg_replace('/[^a-z0-9]+/', "-", $text);
        $text = trim($text, "-");

        return $text;
    }

    function isloggedIn() : bool {
        return (isset($_SESSION["id"]) && $_SESSION["isLogged"] === true);
    }

    function isAdmin() : bool {
        return (isloggedIn() && isset($_SESSION["user_type"]) && $_SESSION["user_type"] === "admin");
    }

?>