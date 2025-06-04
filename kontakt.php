<?php

/***********************************************
 * SEKCJA 1: INICJALIZACJA 
 ***********************************************/

// Włączamy sesję - potrzebna do sprawdzenia czy użytkownik jest zalogowany
session_start();

// Łączymy się z bazą danych MySQL
// Parametry: serwer, login, hasło, nazwa bazy
$db = new mysqli('localhost', 'root', '', 'meatmasters');


/***********************************************
 * SEKCJA 2: POBRANIE DANYCH UŻYTKOWNIKA 
 * (tylko dla zalogowanych)
 ***********************************************/

// Domyślne puste wartości dla formularza
$dane_user = [
    'imie' => '',   // Imię i nazwisko
    'email' => ''    // Adres email
];

// Sprawdzamy czy użytkownik jest zalogowany
if (isset($_SESSION['zalogowany'])) {
    // Pobieramy dane użytkownika z bazy
    $result = $db->query("SELECT imie, nazwisko, email FROM klienci WHERE id = {$_SESSION['user_id']}");

    // Jeśli znaleziono użytkownika, aktualizujemy dane
    if ($row = $result->fetch_assoc()) {
        $dane_user['imie'] = $row['imie'] . ' ' . $row['nazwisko'];
        $dane_user['email'] = $row['email'];
    }
}


/***********************************************
 * SEKCJA 3: OBSŁUGA FORMULARZA 
 * (gdy użytkownik kliknie "Wyślij")
 ***********************************************/

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Zabezpieczamy dane przed SQL Injection
    $imie = $db->real_escape_string($_POST['imie'] ?? '');
    $email = $db->real_escape_string($_POST['email'] ?? '');
    $wiadomosc = $db->real_escape_string($_POST['wiadomosc'] ?? '');

    // Sprawdzamy czy wymagane pola są wypełnione
    if (!empty($imie) && !empty($email) && !empty($wiadomosc)) {
        // Ustalamy ID użytkownika (NULL dla niezalogowanych)
        $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'NULL';

        // Wstawiamy wiadomość do bazy danych
        $db->query("INSERT INTO kontakty (klient_id, imie, email, wiadomosc) 
                   VALUES ($user_id, '$imie', '$email', '$wiadomosc')");

        // Ustawiamy komunikat w sesji
        $_SESSION['komunikat'] = $db->error ? 'Błąd wysyłania!' : 'Wysłano!';
    } else {
        $_SESSION['komunikat'] = 'Wypełnij wszystkie pola!';
    }

    // Przekierowujemy z powrotem do formularza
    header('Location: kontakt.php');
    exit;
}


/***********************************************
 * SEKCJA 4: WYŚWIETLANIE KOMUNIKATÓW 
 * (jeśli istnieją w sesji)
 ***********************************************/

if (isset($_SESSION['komunikat'])) {
    echo '<div class="komunikat">' . $_SESSION['komunikat'] . '</div>';
    unset($_SESSION['komunikat']); // Usuwamy komunikat po wyświetleniu
}
?>
<!-- 
 * SEKCJA HTML - INTERFEJS UŻYTKOWNIKA
 * ----------------------------------
 -->
<!DOCTYPE html>
<html lang="pl">

<head>
    <!-- 
        SEKCJA METADANYCH 
        - Informacje techniczne o stronie
    -->
    <meta charset="UTF-8"> <!-- Kodowanie znaków (obsługa polskich znaków) -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Responsywność na urządzeniach mobilnych -->
    <title>Kontakt - MeatMaster</title> <!-- Tytuł strony (widoczny w zakładce przeglądarki) -->

    <!-- 
        ARKUSZE STYLÓW 
        - Podłączanie zewnętrznych zasobów CSS
    -->
    <link rel="stylesheet" href="style.css"> <!-- Główny arkusz stylów strony -->
    <link rel="icon" type="image/png" href="icon.png"> <!-- Favicon (ikona strony) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"> <!-- Biblioteka ikon FontAwesome -->

    <!-- 
        STYLE WEWNĘTRZNE 
        - CSS specyficzny tylko dla tej strony
    -->
    <style>
        /* 
            SEKCJA KOMUNIKATÓW 
            - Style dla powiadomień systemowych
        */
        .komunikat-sukces {
            background-color: #d4edda;
            /* Zielone tło dla sukcesu */
            color: #155724;
            /* Ciemnozielony tekst */
            padding: 10px;
            margin: 15px 0;
            border-radius: 5px;
            border: 1px solid #c3e6cb;
            /* Subtelna obramówka */
        }

        .komunikat-blad {
            background-color: #f8d7da;
            /* Czerwone tło dla błędów */
            color: #721c24;
            /* Ciemnoczerwony tekst */
            padding: 10px;
            margin: 15px 0;
            border-radius: 5px;
            border: 1px solid #f5c6cb;
        }

        /* 
            SEKCJA FORMULARZA 
            - Style dla elementów formularza
        */
        .kontakt-formularz {
            max-width: 600px;
            /* Maksymalna szerokość formularza */
            margin: 0 auto;
            /* Wyśrodkowanie */
            padding: 20px;
            background: #f9f9f9;
            /* Jasne tło */
            border-radius: 8px;
            /* Zaokrąglone rogi */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            /* Subtelny cień */
        }

        /* Grupa pól formularza */
        .form-group {
            margin-bottom: 15px;
            /* Odstęp między grupami */
        }

        /* Etykiety pól */
        .form-group label {
            display: block;
            /* Etykieta nad polem */
            margin-bottom: 5px;
            font-weight: bold;
            /* Pogrubienie tekstu */
        }

        /* Wspólne style dla input/select/textarea */
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            /* Pełna szerokość kontenera */
            padding: 8px;
            border: 1px solid #ddd;
            /* Szara obramówka */
            border-radius: 4px;
            /* Lekko zaokrąglone rogi */
            box-sizing: border-box;
            /* Prawidłowe obliczanie szerokości */
        }

        /* Specyficzny styl dla pola tekstowego */
        .form-group textarea {
            min-height: 150px;
            /* Minimalna wysokość */
            resize: vertical;
            /* Zezwól tylko na pionową zmianę rozmiaru */
        }

        /* Przycisk wysyłania */
        .przycisk-wyslij {
            background-color: #c00;
            /* Czerwony kolor MeatMaster */
            color: white;
            padding: 10px 15px;
            border: none;
            /* Brak obramowania */
            border-radius: 4px;
            cursor: pointer;
            /* Kursor wskazujący */
            transition: background 0.3s;
            /* Animacja hover */
        }

        /* Efekt hover dla przycisku */
        .przycisk-wyslij:hover {
            background-color: #a00;
            /* Ciemniejszy czerwony */
        }
    </style>
</head>

<body>
    <!-- 
        NAGŁÓWEK STRONY 
        - Logo i menu nawigacyjne
    -->
    <header>
        <div class="kontener naglowek-kontener">
            <!-- Logo firmy -->
            <div class="logo">
                <img src="Logo.png" alt="MeatMaster Logo">
            </div>

            <!-- Główne menu -->
            <nav>
                <ul>
                    <li><a href="Strona_glowna.php">Strona główna</a></li>
                    <li><a href="Oferta.php">Oferta</a></li>
                    <li><a href="sklep.php">Sklep</a></li>
                    <li><a href="o_nas.php">O nas</a></li>
                    <li><a href="kontakt.php">Kontakt</a></li>
                    <li><a href="faq.php">FAQ</a></li>
                    <li><a href="aktualnosci.php">Aktualności</a></li>
                    <li><a href="opinie.php">Opinie</a></li>

                    <!-- Link do profilu/logowania (warunkowy) -->
                    <?php if (isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] === true): ?>
                        <li><a href="profil.php"><i class="fas fa-user"></i> Profil</a></li>
                    <?php else: ?>
                        <li><a href="logowanie.php"><i class="fas fa-user"></i> Logowanie</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <!-- 
        GŁÓWNA ZAWARTOŚĆ 
        - Sekcja z formularzem kontaktowym
    -->
    <main>
        <section class="sekcja-o-nas">
            <div class="kontener">
                <h2 class="tytul-sekcji">Nasz zespół kontaktowy</h2>

                <!-- Wyświetlenie komunikatu (jeśli istnieje) -->
                <?php if (isset($komunikat)) echo $komunikat; ?>

                <!-- Karty kontaktowe pracowników -->
                <div class="siatka-opinii">
                    <!-- Karta 1 -->
                    <div class="karta-opinii">
                        <div class="kontakt-osoba">
                            <div class="kontakt-avatar">DB</div> <!-- Inicjały -->
                            <h3>Dominik Bogdan</h3>
                            <p class="kontakt-dane"><i class="fas fa-briefcase"></i> Kierownik Działu Sprzedaży</p>
                            <p class="kontakt-dane"><i class="fas fa-phone"></i> +48 123 456 700</p>
                            <p class="kontakt-dane"><i class="fas fa-envelope"></i> dominik.bogdan@meatmaster.pl</p>
                            <p class="kontakt-dane"><i class="fas fa-clock"></i> Pon-Pt: 7:00-15:00</p>
                        </div>
                    </div>

                    <!-- Karta 2 -->
                    <div class="karta-opinii">
                        <div class="kontakt-osoba">
                            <div class="kontakt-avatar">KB</div>
                            <h3>Kacper Bury</h3>
                            <p class="kontakt-dane"><i class="fas fa-briefcase"></i> Specjalista ds. Klienta</p>
                            <p class="kontakt-dane"><i class="fas fa-phone"></i> +48 123 456 701</p>
                            <p class="kontakt-dane"><i class="fas fa-envelope"></i> kacper.bury@meatmaster.pl</p>
                            <p class="kontakt-dane"><i class="fas fa-clock"></i> Pon-Pt: 9:00-17:00</p>
                        </div>
                    </div>

                    <!-- Karta 3 (Dział Obsługi Klienta) -->
                    <div class="karta-opinii">
                        <div class="kontakt-osoba">
                            <div class="kontakt-avatar"><i class="fas fa-headset kontakt-ikona"></i></div>
                            <h3>Dział Obsługi Klienta</h3>
                            <p class="kontakt-dane"><i class="fas fa-phone"></i> +48 123 456 789</p>
                            <p class="kontakt-dane"><i class="fas fa-envelope"></i> kontakt@meatmaster.pl</p>
                            <p class="kontakt-dane"><i class="fas fa-clock"></i> Pon-Pt: 6:00-18:00</p>
                        </div>
                    </div>
                </div>

                <!-- Formularz kontaktowy -->
                <div class="kontakt-formularz">
                    <h3><i class="fas fa-envelope"></i> Formularz kontaktowy</h3>
                    <form method="POST" class="contact-form">
                        <!-- Ukryte pola z danymi użytkownika (dla zalogowanych) -->
                        <<input type="hidden" name="imie" value="<?= htmlspecialchars($dane_user['imie']) ?>">
                            <input type="hidden" name="email" value="<?= htmlspecialchars($dane_user['email']) ?>">
                            <input type="hidden" name="telefon" value="<?= htmlspecialchars($dane_user['telefon'] ?? '') ?>">

                            <!-- Pole wyboru tematu -->
                            <div class="form-group">
                                <label for="temat">Temat wiadomości</label>
                                <select id="temat" name="temat" required>
                                    <option value="">-- Wybierz temat --</option>
                                    <option value="zamowienie">Zamówienie</option>
                                    <option value="reklamacja">Reklamacja</option>
                                    <option value="wspolpraca">Współpraca</option>
                                    <option value="inne">Inne</option>
                                </select>
                            </div>

                            <!-- Pole tekstowe wiadomości -->
                            <div class="form-group">
                                <label for="wiadomosc">Treść wiadomości</label>
                                <textarea id="wiadomosc" name="wiadomosc" rows="5" required></textarea>
                            </div>

                            <!-- Przycisk wysyłania -->
                            <button type="submit" class="przycisk-wyslij">
                                <i class="fas fa-paper-plane"></i> Wyślij wiadomość
                            </button>
                    </form>
                </div>
            </div>
        </section>
    </main>

    <!-- 
        STOPKA STRONY 
        - Informacje kontaktowe i prawa autorskie
    -->
    <footer>
        <div class="kontener">
            <div class="zawartosc-stopki">
                <!-- Sekcja kontaktowa -->
                <div class="kolumna-stopki">
                    <h3>Kontakt</h3>
                    <p><i class="fas fa-map-marker-alt"></i> ul. Mięsna 14, 69-420 Radomyśl Wielki</p>
                    <p><i class="fas fa-phone"></i> +48 694 202 137</p>
                    <p><i class="fas fa-envelope"></i> kontakt@meatmaster.pl</p>
                </div>

                <!-- Godziny otwarcia -->
                <div class="kolumna-stopki">
                    <h3>Godziny otwarcia</h3>
                    <p>Pon-Pt: 6:00 - 22:00</p>
                    <p>Sob: 7:00 - 14:00</p>
                    <p>Niedz: Zamknięte</p>
                </div>

                <!-- Media społecznościowe -->
                <div class="kolumna-stopki">
                    <h3>Śledź nas</h3>
                    <div class="linki-spolecznosciowe">
                        <a href="#" aria-label="Twitter" class="x-icon">X</a>
                        <a href="#" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
                        <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>

            <!-- Prawa autorskie -->
            <div class="prawa-autorskie">
                <p>&copy; 2025 MeatMaster - Hurtownia Mięsa. Wszelkie prawa zastrzeżone.</p>
            </div>
        </div>
    </footer>
</body>

</html>