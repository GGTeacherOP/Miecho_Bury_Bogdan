<?php
/*
 * KONTAKTY_P.PHP - PANEL OBSŁUGI ZGŁOSZEŃ KONTAKTOWYCH
 * Skrypt dla pracowników do przeglądania i aktualizacji statusów zgłoszeń
 */

/******************************************************
 * 1. INICJALIZACJA I AUTORYZACJA
 ******************************************************/

// Dołączenie plików konfiguracyjnych
require_once "sesje.php";  // Plik z funkcjami sesyjnymi
require_once "db.php";     // Plik z połączeniem do bazy danych

// Sprawdzenie czy użytkownik ma wymagane uprawnienia
// Dopuszczalne stanowiska: Kierownik, Specjalista HR, Logistyk, Księgowy
sprawdzStanowisko(['Kierownik', 'Specjalista HR', 'Logistyk', 'Księgowy']);

/******************************************************
 * 2. POBRANIE ZGŁOSZEŃ Z BAZY DANYCH
 ******************************************************/

// Zapytanie SQL pobierające:
// - wszystkie pola z tabeli kontakty (k.*)
// - imię i nazwisko pracownika przypisanego do zgłoszenia
// Wyniki sortowane od najnowszych zgłoszeń
$kontakty = $conn->query("
    SELECT k.*, 
           CONCAT(p.imie, ' ', p.nazwisko) as pracownik,
           CASE 
               WHEN LENGTH(k.wiadomosc) > 50 THEN CONCAT(SUBSTRING(k.wiadomosc, 1, 50), '...')
               ELSE k.wiadomosc
           END as wiadomosc_przycieta
    FROM kontakty k
    LEFT JOIN pracownicy p ON k.pracownik_id = p.id
    ORDER BY k.data_zgloszenia DESC
")->fetch_all(MYSQLI_ASSOC); // Pobranie wszystkich wyników jako tablicy asocjacyjnej

/******************************************************
 * 3. OBSŁUGA ZMIANY STATUSU ZGŁOSZENIA
 ******************************************************/

// Sprawdzenie czy formularz został wysłany (metoda POST)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['zmien_status'])) {
    // Zabezpieczenie danych wejściowych:
    $id = $conn->real_escape_string($_POST['id']);
    $status = $conn->real_escape_string($_POST['status']); 
    
    // Budowanie zapytania SQL
    $data_zakonczenia = ($status == 'zamknieta') ? "NOW()" : "NULL";
    $sql = "UPDATE kontakty SET 
            status = '$status',
            pracownik_id = '{$_SESSION['user_id']}',
            data_zakonczenia = $data_zakonczenia
            WHERE id = $id";
    
    // Wykonanie zapytania
    $conn->query($sql);

    // Przekierowanie z powrotem z komunikatem o sukcesie
    header("Location: kontakty_p.php?updated=1");
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <!-- 
        SEKCJA METADANYCH
        - Podstawowe informacje o stronie 
    -->
    <meta charset="UTF-8"> <!-- Kodowanie znaków (obsługa polskich liter) -->
    <title>Zgłoszenia kontaktowe</title> <!-- Tytuł strony (widoczny w zakładce przeglądarki) -->

    <!-- 
        PODŁĄCZENIE ZASOBÓW ZEWNĘTRZNYCH
    -->
    <link rel="stylesheet" href="style.css"> <!-- Główny arkusz stylów strony -->
    <link rel="icon" type="image/png" href="icon.png"> <!-- Ikona strony (favicon) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"> <!-- Biblioteka ikon FontAwesome -->

    <!-- 
        STYLE WEWNĘTRZNE
        - CSS specyficzny dla tej strony
    -->
    <style>
        /* 
            GŁÓWNA SEKCJA ZAWARTOŚCI
            - Stylizacja kontenera i tła
        */
        .sekcja-zamowienia {

            padding: 80px 0; /* Wewnętrzny odstęp góra-dół */
            background: #f5f5f5; /* Kolor tła */
            min-height: calc(100vh - 300px); /* Minimalna wysokość (strona - header - footer) */
        }

        .kontener-zamowienia {
            max-width: 1200px; /* Maksymalna szerokość zawartości */
            margin: 0 auto; /* Wyśrodkowanie */
            background: #fff; /* Białe tło */
            padding: 40px; /* Wewnętrzny odstęp */
            border-radius: 8px; /* Zaokrąglone rogi */
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1); /* Subtelny cień */

        }

        /* 
            TYPOGRAFIA
            - Style tekstowe
        */
        h2 {

            color: #c00; /* Czerwony kolor MeatMaster */
            margin-bottom: 30px; /* Odstęp od dołu */
            text-align: center; /* Wyśrodkowanie */

        }

        /* 
            TABELA ZGŁOSZEŃ
            - Stylizacja tabeli i jej elementów
        */
        table {

            width: 100%; /* Pełna szerokość kontenera */
            border-collapse: collapse; /* Łączenie obramowań */
            margin-bottom: 30px; /* Odstęp od dołu */
        }

        th, td {
            padding: 12px 15px; /* Wewnętrzny odstęp */
            text-align: left; /* Wyrównanie tekstu do lewej */
            border-bottom: 1px solid #ddd; /* Linia oddzielająca wiersze */
        }

        th {
            background-color: #c00; /* Czerwone tło nagłówków */
            color: white; /* Biały tekst */
        }

        tr:hover {
            background-color: #f5f5f5; /* Podświetlenie wiersza przy najechaniu */

        }

        /* 
            FORULARZ ZMIANY STATUSU
            - Stylizacja formularza edycji
        */
        .formularz-edycji {

            background: #f9f9f9; /* Jasne tło */
            padding: 20px; /* Wewnętrzny odstęp */
            border-radius: 8px; /* Zaokrąglone rogi */
            margin-top: 20px; /* Odstęp od góry */
        }

        .formularz-grupa {
            margin-bottom: 15px; /* Odstęp między grupami formularza */
        }

        .formularz-grupa label {
            display: block; /* Etykieta w nowej linii */
            margin-bottom: 5px; /* Odstęp od pola */
            font-weight: bold; /* Pogrubiona etykieta */
        }

        .formularz-grupa select {
            width: 100%; /* Pełna szerokość */
            padding: 8px; /* Wewnętrzny odstęp */
            border: 1px solid #ddd; /* Szara obramówka */
            border-radius: 4px; /* Lekko zaokrąglone rogi */
        }

        .przycisk-edycji {
            padding: 10px 15px; /* Wewnętrzny odstęp */
            background: #c00; /* Czerwony MeatMaster */
            color: white; /* Biały tekst */
            border: none; /* Brak obramowania */
            border-radius: 4px; /* Zaokrąglone rogi */
            cursor: pointer; /* Kursor wskazujący */
        }

        .przycisk-edycji:hover {
            background: #a00; /* Ciemniejszy czerwony przy najechaniu */

        }

        /* 
            KOMUNIKATY SYSTEMOWE
            - Style dla powiadomień
        */
        .alert {

            padding: 15px; /* Wewnętrzny odstęp */
            margin-bottom: 20px; /* Odstęp od dołu */
            border-radius: 4px; /* Zaokrąglone rogi */
        }

        .alert-success {
            background-color: #dff0d8; /* Jasnozielone tło */
            color: #3c763d; /* Ciemnozielony tekst */
        }

        .alert-error {
            background-color: #f2dede; /* Jasnoczerwone tło */
            color: #a94442; /* Ciemnoczerwony tekst */

        }

        /* 
            STATUSY ZGŁOSZEŃ
            - Kolorystyka dla różnych statusów
        */
        .status-nowa {

            color: #ff9800; /* Pomarańczowy */
            font-weight: bold; /* Pogrubienie */
        }

        .status-w_trakcie {
            color: #2196f3; /* Niebieski */

            font-weight: bold;
        }

        .status-zamknieta {

            color: #4caf50; /* Zielony */

            font-weight: bold;
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

            <!-- Główne menu nawigacyjne -->
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
                    <li><a href="profil.php" id="profile-link"><i class="fas fa-user"></i> Profil</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- 
        GŁÓWNA ZAWARTOŚĆ STRONY
        - Panel zgłoszeń kontaktowych
    -->
    <section class="sekcja-zamowienia">
        <div class="kontener-zamowienia">
            <!-- Nagłówek sekcji -->
            <h2>Zgłoszenia kontaktowe</h2>

            <!-- Komunikat o aktualizacji statusu -->
            <?php if (isset($_GET['updated'])): ?>
                <div class="alert alert-success">Status zgłoszenia został zaktualizowany!</div>
            <?php endif; ?>

            <!-- Tabela ze zgłoszeniami -->
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Data</th>
                        <th>Nadawca</th>
                        <th>Temat</th>
                        <th>Wiadomość</th>
                        <th>Status</th>
                        <th>Pracownik</th>
                        <th>Akcje</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Pętla przez wszystkie zgłoszenia -->
                    <?php foreach ($kontakty as $k): ?>

                    <tr>
                        <td><?= $k['id'] ?></td> <!-- ID zgłoszenia -->
                        <td><?= date('d.m.Y H:i', strtotime($k['data_zgloszenia'])) ?></td> <!-- Data w formacie dzień.miesiąc.rok godzina:minuta -->
                        <td><?= htmlspecialchars($k['imie']) ?></td> <!-- Nazwa nadawcy (zabezpieczona przed XSS) -->
                        <td><?= htmlspecialchars($k['temat']) ?></td> <!-- Temat zgłoszenia -->
                        <td class="wiadomosc-kontener">  <!-- Kontener dla całej wiadomości -->
                            <!-- Pełna wiadomość (pokazywana po najechaniu/kliknięciu) -->
                            <div class="wiadomosc-pełna">
                            <?= nl2br(htmlspecialchars($k['wiadomosc'])) ?>
                            </div>
                        </td>
                       
                        <td class="status-<?= str_replace(' ', '', $k['status']) ?>"> <!-- Klasa CSS w zależności od statusu -->
                            <?= $k['status'] ?> <!-- Wyświetlenie statusu -->
                        </td>
                        <td><?= htmlspecialchars($k['pracownik'] ?? 'Brak') ?></td> <!-- Pracownik przypisany (lub "Brak") -->
                        <td>
                            <!-- Przycisk zmiany statusu -->
                            <button onclick="pokazFormularz(<?= $k['id'] ?>, '<?= $k['status'] ?>')">
                                Zmień status
                            </button>
                        </td>
                    </tr>

                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Formularz zmiany statusu (początkowo ukryty) -->
            <div id="formularz-edycji" class="formularz-edycji" style="display: none;">
                <h3>Zmiana statusu zgłoszenia</h3>
                <form method="post">
                    <!-- Pola ukryte -->
                    <input type="hidden" name="id" id="edit-id"> <!-- ID zgłoszenia do aktualizacji -->
                    <input type="hidden" name="zmien_status" value="1"> <!-- Flaga zmiany statusu -->

                    <!-- Lista rozwijana statusów -->
                    <div class="formularz-grupa">
                        <label for="status">Status:</label>
                        <select name="status" id="edit-status" required>
                            <option value="nowa">Nowa</option>
                            <option value="w_trakcie">W trakcie</option>
                            <option value="zamknieta">Zamknięta</option>
                        </select>
                    </div>

                    <!-- Przycisk zapisu -->
                    <button type="submit" class="przycisk-edycji">Zapisz zmiany</button>
                </form>
            </div>
        </div>
    </section>

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

    <!-- 
        SKRYPT JAVASCRIPT
        - Obsługa formularza zmiany statusu
    -->
    <script>
        // Funkcja pokazująca formularz zmiany statusu
        function pokazFormularz(id, status) {
            // Ustawienie wartości w formularzu
            document.getElementById('edit-id').value = id;
            document.getElementById('edit-status').value = status;

            // Pokazanie formularza
            document.getElementById('formularz-edycji').style.display = 'block';

            // Płynne przewinięcie do formularza
            window.scrollTo({
                top: document.getElementById('formularz-edycji').offsetTop,
                behavior: 'smooth'
            });
        }
    </script>
</body>

</html>