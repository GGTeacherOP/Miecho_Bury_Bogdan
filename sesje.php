<?php
// Rozpoczęcie sesji - musi być na początku przed jakimkolwiek outputem
session_start();

/**
 * Sprawdza czy użytkownik jest zalogowany
 * @return bool True jeśli zalogowany, false w przeciwnym wypadku
 */
function czyZalogowany()
{
    // Sprawdza czy flaga 'zalogowany' w sesji jest ustawiona na true
    return isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] === true;
}

/**
 * Sprawdza czy użytkownik ma wymaganą rolę
 * @param string $wymaganaRola Wymagana rola (np. 'admin', 'pracownik')
 */
function sprawdzRole($wymaganaRola)
{
    // Jeśli użytkownik nie jest zalogowany lub nie ma wymaganej roli
    if (!czyZalogowany() || $_SESSION['rola'] !== $wymaganaRola) {
        // Przekieruj na stronę braku dostępu
        header("Location: brak_dostepu.php");
        exit(); // Zakończ wykonanie skryptu
    }
}

/**
 * Sprawdza czy pracownik ma wymagane stanowisko
 * @param array|string $wymaganeStanowiska Tablica lub string z wymaganymi stanowiskami
 */
function sprawdzStanowisko($wymaganeStanowiska)
{
    // Jeśli użytkownik nie jest zalogowany, nie jest pracownikiem lub nie ma wymaganego stanowiska
    if (
        !czyZalogowany() || $_SESSION['rola'] !== 'pracownik' ||
        !in_array($_SESSION['stanowisko'], (array)$wymaganeStanowiska)
    ) {
        header("Location: brak_dostepu.php");
        exit();
    }
}

/**
 * Pobiera typ konta klienta (tylko dla roli 'klient')
 * @return string|null Typ konta klienta lub null jeśli nie dotyczy
 */
function typKontaKlienta()
{
    // Jeśli użytkownik jest zalogowany jako klient
    if (czyZalogowany() && $_SESSION['rola'] === 'klient') {
        return $_SESSION['typ_konta']; // Zwróć jego typ konta
    }
    return null; // W przeciwnym wypadku zwróć null
}

/**
 * Wylogowuje użytkownika i niszczy sesję
 */
function wyloguj()
{
    // Wyczyszczenie wszystkich danych sesji
    $_SESSION = array();

    // Jeśli używane są ciasteczka sesji, usuń je
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(), // Nazwa ciasteczka sesji
            '', // Wartość pusta
            time() - 42000, // Czas w przeszłości (wygaśnięcie)
            $params["path"], // Ścieżka
            $params["domain"], // Domena
            $params["secure"], // Flaga secure
            $params["httponly"] // Flaga httponly
        );
    }

    // Zniszcz sesję
    session_destroy();
    
    // Przekieruj na stronę logowania
    header("Location: logowanie.php");
    exit(); // Zakończ wykonanie skryptu
}

// Automatyczne przekierowanie niezalogowanych użytkowników
// (z wyjątkiem strony logowania)
if (!czyZalogowany() && basename($_SERVER['PHP_SELF']) !== 'logowanie.php') {
    header("Location: logowanie.php");
    exit();
}

// Obsługa żądania wylogowania
if (isset($_GET['wyloguj'])) {
    wyloguj(); // Wywołaj funkcję wylogowania
}