<?php
// Ustawienia połączenia z bazą danych
$host = "localhost";     // adres serwera bazy danych
$user = "root";          // użytkownik bazy danych
$password = "";          // hasło (domyślnie puste w XAMPP)
$database = "meatmasters";     // nazwa bazy danych

// Tworzenie połączenia z bazą danych
$conn = mysqli_connect($host, $user, $password, $database);

// Sprawdzenie, czy połączenie się udało
if (!$conn) {
    die("Błąd połączenia z bazą danych: " . mysqli_connect_error());
}
$conn->set_charset("utf8");
?>
