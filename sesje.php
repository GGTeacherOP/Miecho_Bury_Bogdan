<?php
session_start();

// Funkcja sprawdzająca czy użytkownik jest zalogowany
function czyZalogowany()
{
    return isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] === true;
}

// Funkcja sprawdzająca rolę użytkownika
function sprawdzRole($wymaganaRola)
{
    if (!czyZalogowany() || $_SESSION['rola'] !== $wymaganaRola) {
        header("Location: brak_dostepu.php");
        exit();
    }
}

// Funkcja sprawdzająca stanowisko pracownika (tylko dla pracowników)
function sprawdzStanowisko($wymaganeStanowiska)
{
    if (
        !czyZalogowany() || $_SESSION['rola'] !== 'pracownik' ||
        !in_array($_SESSION['stanowisko'], (array)$wymaganeStanowiska)
    ) {
        header("Location: brak_dostepu.php");
        exit();
    }
}

// Funkcja zwracająca typ konta klienta (tylko dla klientów)
function typKontaKlienta()
{
    if (czyZalogowany() && $_SESSION['rola'] === 'klient') {
        return $_SESSION['typ_konta'];
    }
    return null;
}

// Funkcja wylogowująca
function wyloguj()
{
    $_SESSION = array();

    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }

    session_destroy();
    header("Location: logowanie.php");
    exit();
}

// Automatyczne przekierowanie niezalogowanych
if (!czyZalogowany() && basename($_SERVER['PHP_SELF']) !== 'logowanie.php') {
    header("Location: logowanie.php");
    exit();
}

// Obsługa wylogowania
if (isset($_GET['wyloguj'])) {
    wyloguj();
}
