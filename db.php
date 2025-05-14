<?php
$serwer = "localhost";
$uzytkownik = "root";
$haslo = ""; // Domyślne hasło w XAMPP jest puste
$baza = "meatmasters";

try {
    $conn = new mysqli($serwer, $uzytkownik, $haslo, $baza);

    // Sprawdź połączenie
    if ($conn->connect_error) {
        throw new Exception("Połączenie nieudane: " . $conn->connect_error);
    }

    $conn->set_charset("utf8");
} catch (Exception $e) {
    die("Błąd bazy danych: " . $e->getMessage());
}
