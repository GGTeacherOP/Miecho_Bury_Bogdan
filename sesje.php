<?php
session_start();

if (!isset($_SESSION['zalogowany']) || $_SESSION['zalogowany'] !== true) {
    // Jeśli użytkownik nie jest zalogowany, przekieruj go na stronę logowania
    header("Location: login.php");
    exit();
}

// Opcjonalnie: możesz ustawić zmienne lokalne dla wygody
$rola = $_SESSION['rola']; // 'klient' lub 'pracownik'
$user_id = $_SESSION['user_id'];
$email = $_SESSION['user_email'];
$imie = $_SESSION['imie'];
$nazwisko = $_SESSION['nazwisko'];
