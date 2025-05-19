<?php
/**
 * PLIK: zarzadzanie_pracownikami.php
 * AUTOR: [Twój Nick]
 * DATA: [Data]
 * 
 * Skrypt do zarządzania pracownikami w systemie MeatMaster
 * Wymaga uprawnień Kierownika
 */

// 1. ŁADOWANIE WYMAGANYCH PLIKÓW
require_once "sesje.php"; // Plik z funkcjami do obsługi sesji
require_once "db.php";    // Plik z połączeniem do bazy danych

// 2. SPRAWDZENIE UPRAWNIEŃ
sprawdzStanowisko(['Kierownik']); // Tylko kierownik ma dostęp

// 3. OBSŁUGA DODAWANIA PRACOWNIKA
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['dodaj'])) {
    $imie = $_POST['imie'];
    $nazwisko = $_POST['nazwisko'];
    $email = $_POST['email'];
    $haslo = password_hash($_POST['haslo'], PASSWORD_DEFAULT); // Bezpieczne hashowanie
    $telefon = $_POST['telefon'];
    $stanowisko = $_POST['stanowisko'];
    $data_zatrudnienia = $_POST['data_zatrudnienia'];
    $wynagrodzenie = $_POST['wynagrodzenie'];

    // 3.1. PRZYGOTOWANIE ZAPYTANIA SQL
    $insert_query = "INSERT INTO pracownicy (imie, nazwisko, email, haslo, telefon, stanowisko, data_zatrudnienia, wynagrodzenie) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    // 3.2. WYKONANIE ZAPYTANIA Z ZABEZPIECZENIEM PRZED SQL INJECTION
    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param("sssssssd", $imie, $nazwisko, $email, $haslo, $telefon, $stanowisko, $data_zatrudnienia, $wynagrodzenie);

    if ($stmt->execute()) {
        $success = "Pracownik został dodany!";
    } else {
        $error = "Błąd podczas dodawania pracownika: " . $conn->error;
    }
}

// 4. OBSŁUGA EDYCJI PRACOWNIKA
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edytuj'])) {
    $id = $_POST['id'];
    $imie = $_POST['imie'];
    $nazwisko = $_POST['nazwisko'];
    $email = $_POST['email'];
    $telefon = $_POST['telefon'];
    $stanowisko = $_POST['stanowisko'];
    $data_zatrudnienia = $_POST['data_zatrudnienia'];
    $wynagrodzenie = $_POST['wynagrodzenie'];

    // 4.1. PRZYGOTOWANIE ZAPYTANIA SQL
    $update_query = "UPDATE pracownicy SET 
                    imie = ?,
                    nazwisko = ?,
                    email = ?,
                    telefon = ?,
                    stanowisko = ?,
                    data_zatrudnienia = ?,
                    wynagrodzenie = ?
                    WHERE id = ?";

    // 4.2. WYKONANIE ZAPYTANIA
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("ssssssdi", $imie, $nazwisko, $email, $telefon, $stanowisko, $data_zatrudnienia, $wynagrodzenie, $id);

    if ($stmt->execute()) {
        $success = "Dane pracownika zostały zaktualizowane!";
    } else {
        $error = "Błąd podczas aktualizacji danych pracownika: " . $conn->error;
    }
}

// 5. OBSŁUGA USUWANIA PRACOWNIKA
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['usun'])) {
    $id = $_POST['id'];

    // 5.1. PRZYGOTOWANIE ZAPYTANIA SQL
    $delete_query = "DELETE FROM pracownicy WHERE id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $success = "Pracownik został usunięty!";
    } else {
        $error = "Błąd podczas usuwania pracownika: " . $conn->error;
    }
}

// 6. POBRANIE LISTY PRACOWNIKÓW
$query = "SELECT * FROM pracownicy_widok";
$result = $conn->query($query);
$pracownicy = $result->fetch_all(MYSQLI_ASSOC);

// 7. LISTA DOSTĘPNYCH STANOWISK
$stanowiska = ['Kierownik', 'Programista', 'Pracownik linii pakowania', 'Magazynier', 'Księgowy', 'Specjalista HR', 'Logistyk'];
?>

<!-- 8. STRUKTURA HTML -->
<!DOCTYPE html>
<html lang="pl">
<head>
    <!-- 8.1. METADANE -->
    <meta charset="UTF-8"> <!-- Kodowanie znaków UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Responsywność -->
    <title>MeatMaster - Zarządzanie pracownikami</title> <!-- Tytuł strony -->
    
    <!-- 8.2. LINKI DO ZASOBÓW -->
    <link rel="stylesheet" href="style.css"> <!-- Główny arkusz stylów -->
    <link rel="icon" type="image/png" href="icon.png"> <!-- Ikona strony -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"> <!-- Ikony FontAwesome -->
    
    <!-- 8.3. STYLE WEWNĘTRZNE -->
    <style>
        /* 8.3.1. SEKCJA PRACOWNIKÓW */
        .sekcja-pracownicy {
            padding: 80px 0; /* Wewnętrzny odstęp góra-dół */
            background: #f5f5f5; /* Kolor tła */
            min-height: calc(100vh - 300px); /* Minimalna wysokość */
        }

        /* 8.3.2. KONTENER GŁÓWNY */
        .kontener-pracownicy {
            max-width: 1200px; /* Maksymalna szerokość */
            margin: 0 auto; /* Wyśrodkowanie */
            background: #fff; /* Kolor tła */
            padding: 40px; /* Wewnętrzny odstęp */
            border-radius: 8px; /* Zaokrąglone rogi */
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1); /* Cień */
        }

        /* 8.3.3. NAGŁÓWKI */
        h2 {
            color: #c00; /* Kolor tekstu */
            margin-bottom: 30px; /* Odstęp od dołu */
            text-align: center; /* Wyśrodkowanie */
        }

        /* 8.3.4. TABELA */
        table {
            width: 100%; /* Pełna szerokość */
            border-collapse: collapse; /* Łączenie obramowań */
            margin-bottom: 30px; /* Odstęp od dołu */
        }

        /* 8.3.5. KOMÓRKI TABELI */
        th, td {
            padding: 12px 15px; /* Wewnętrzny odstęp */
            text-align: left; /* Wyrównanie tekstu */
            border-bottom: 1px solid #ddd; /* Linia oddzielająca */
        }

        /* 8.3.6. NAGŁÓWKI TABELI */
        th {
            background-color: #c00; /* Kolor tła */
            color: white; /* Kolor tekstu */
        }

        /* 8.3.7. EFEKT HOVER NA WIERSZACH */
        tr:hover {
            background-color: #f5f5f5; /* Kolor tła po najechaniu */
        }

        /* 8.3.8. FORMULARZE */
        .formularz {
            background: #f9f9f9; /* Kolor tła */
            padding: 20px; /* Wewnętrzny odstęp */
            border-radius: 8px; /* Zaokrąglone rogi */
            margin-top: 20px; /* Odstęp od góry */
        }

        /* 8.3.9. GRUPY FORMULARZA */
        .formularz-grupa {
            margin-bottom: 15px; /* Odstęp od dołu */
            display: flex; /* Układ flex */
            flex-wrap: wrap; /* Zawijanie wierszy */
            gap: 15px; /* Odstęp między elementami */
        }

        /* 8.3.10. ELEMENTY FORMULARZA */
        .formularz-grupa > div {
            flex: 1; /* Rozciąganie do dostępnej przestrzeni */
            min-width: 200px; /* Minimalna szerokość */
        }

        /* 8.3.11. ETYKIETY FORMULARZA */
        .formularz-grupa label {
            display: block; /* Element blokowy */
            margin-bottom: 5px; /* Odstęp od dołu */
            font-weight: bold; /* Pogrubienie tekstu */
        }

        /* 8.3.12. POLA FORMULARZA */
        .formularz-grupa input,
        .formularz-grupa select {
            width: 100%; /* Pełna szerokość */
            padding: 8px; /* Wewnętrzny odstęp */
            border: 1px solid #ddd; /* Obramowanie */
            border-radius: 4px; /* Zaokrąglone rogi */
        }

        /* 8.3.13. PRZYCISKI */
        .przycisk {
            padding: 10px 15px; /* Wewnętrzny odstęp */
            color: white; /* Kolor tekstu */
            border: none; /* Brak obramowania */
            border-radius: 4px; /* Zaokrąglone rogi */
            cursor: pointer; /* Kursor wskazujący */
            text-align: center; /* Wyśrodkowanie tekstu */
            text-decoration: none; /* Brak podkreślenia */
        }

        /* 8.3.14. KOLORY PRZYCISKÓW */
        .przycisk-dodaj { background: #4CAF50; } /* Zielony */
        .przycisk-edytuj { background: #2196F3; } /* Niebieski */
        .przycisk-usun { background: #f44336; } /* Czerwony */
        .przycisk-anuluj { background: #9E9E9E; } /* Szary */

        /* 8.3.15. EFEKT HOVER NA PRZYCISKACH */
        .przycisk:hover {
            opacity: 0.8; /* Lekkie przyciemnienie */
        }

        /* 8.3.16. KOMUNIKATY */
        .alert {
            padding: 15px; /* Wewnętrzny odstęp */
            margin-bottom: 20px; /* Odstęp od dołu */
            border-radius: 4px; /* Zaokrąglone rogi */
        }

        /* 8.3.17. KOMUNIKAT SUKCESU */
        .alert-success {
            background-color: #dff0d8; /* Kolor tła */
            color: #3c763d; /* Kolor tekstu */
        }

        /* 8.3.18. KOMUNIKAT BŁĘDU */
        .alert-error {
            background-color: #f2dede; /* Kolor tła */
            color: #a94442; /* Kolor tekstu */
        }

        /* 8.3.19. PRZYCISK NOWEGO PRACOWNIKA */
        .przycisk-nowy {
            display: inline-block; /* Element liniowo-blokowy */
            padding: 10px 15px; /* Wewnętrzny odstęp */
            background: #4CAF50; /* Kolor tła */
            color: white; /* Kolor tekstu */
            border: none; /* Brak obramowania */
            border-radius: 4px; /* Zaokrąglone rogi */
            cursor: pointer; /* Kursor wskazujący */
            margin-bottom: 20px; /* Odstęp od dołu */
        }

        /* 8.3.20. EFEKT HOVER NA PRZYCISKU NOWEGO */
        .przycisk-nowy:hover {
            opacity: 0.8; /* Lekkie przyciemnienie */
        }
    </style>
</head>
<body>
    <!-- 9. NAGŁÓWEK STRONY -->
    <header>
        <div class="kontener naglowek-kontener">
            <!-- 9.1. LOGO FIRMY -->
            <div class="logo">
                <img src="Logo.png" alt="MeatMaster Logo">
            </div>
            
            <!-- 9.2. NAWIGACJA GŁÓWNA -->
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

    <!-- 10. GŁÓWNA ZAWARTOŚĆ -->
    <section class="sekcja-pracownicy">
        <div class="kontener-pracownicy">
            <h2>Zarządzanie pracownikami</h2>

            <!-- 10.1. KOMUNIKATY SYSTEMOWE -->
            <?php if (isset($success)): ?>
                <div class="alert alert-success"><?= $success ?></div>
            <?php endif; ?>

            <?php if (isset($error)): ?>
                <div class="alert alert-error"><?= $error ?></div>
            <?php endif; ?>

            <!-- 10.2. PRZYCISK DODAWANIA NOWEGO PRACOWNIKA -->
            <button class="przycisk-nowy" onclick="pokazFormularzDodawania()">Dodaj nowego pracownika</button>

            <!-- 10.3. TABELA Z LISTĄ PRACOWNIKÓW -->
            <table>
                <!-- 
                  NAGŁÓWKI TABELI 
                  - Definicja kolumn
                -->
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Imię</th>
                        <th>Nazwisko</th>
                        <th>Email</th>
                        <th>Telefon</th>
                        <th>Stanowisko</th>
                        <th>Zatrudniony</th>
                        <th>Wynagrodzenie</th>
                        <th>Akcje</th>
                    </tr>
                </thead>
                <!-- 
                  CIAŁO TABELI 
                  - Dane wyświetlane w pętli PHP
                -->
                <tbody>
                    <?php foreach ($pracownicy as $pracownik): ?>
                    <tr>
                        <!-- ID PRACOWNIKA -->
                        <td><?= $pracownik['id'] ?></td>
                        
                        <!-- IMIĘ PRACOWNIKA (z zabezpieczeniem XSS) -->
                        <td><?= htmlspecialchars($pracownik['imie']) ?></td>
                        
                        <!-- NAZWISKO PRACOWNIKA (z zabezpieczeniem XSS) -->
                        <td><?= htmlspecialchars($pracownik['nazwisko']) ?></td>
                        
                        <!-- EMAIL PRACOWNIKA (z zabezpieczeniem XSS) -->
                        <td><?= htmlspecialchars($pracownik['email']) ?></td>
                        
                        <!-- TELEFON PRACOWNIKA (z zabezpieczeniem XSS) -->
                        <td><?= htmlspecialchars($pracownik['telefon'] ?? '-') ?></td>
                        
                        <!-- STANOWISKO PRACOWNIKA (z zabezpieczeniem XSS) -->
                        <td><?= htmlspecialchars($pracownik['stanowisko']) ?></td>
                        
                        <!-- DATA ZATRUDNIENIA (sformatowana) -->
                        <td><?= date('d.m.Y', strtotime($pracownik['data_zatrudnienia'])) ?></td>
                        
                        <!-- WYNAGRODZENIE (sformatowane) -->
                        <td><?= number_format($pracownik['wynagrodzenie'], 2) ?> zł</td>
                        
                        <!-- PRZYCISKI AKCJI -->
                        <td>
                            <!-- 
                              PRZYCISK EDYCJI 
                              - Wywołuje funkcję JS z parametrami pracownika
                            -->
                            <button onclick="pokazFormularzEdycji(
                                '<?= $pracownik['id'] ?>',
                                '<?= htmlspecialchars($pracownik['imie'], ENT_QUOTES) ?>',
                                '<?= htmlspecialchars($pracownik['nazwisko'], ENT_QUOTES) ?>',
                                '<?= htmlspecialchars($pracownik['email'], ENT_QUOTES) ?>',
                                '<?= htmlspecialchars($pracownik['telefon'], ENT_QUOTES) ?>',
                                '<?= htmlspecialchars($pracownik['stanowisko'], ENT_QUOTES) ?>',
                                '<?= $pracownik['data_zatrudnienia'] ?>',
                                '<?= $pracownik['wynagrodzenie'] ?>'
                            )">Edytuj</button>
                            
                            <!-- 
                              PRZYCISK USUWANIA 
                              - Wywołuje funkcję JS z ID pracownika
                            -->
                            <button onclick="potwierdzUsuniecie(<?= $pracownik['id'] ?>)">Usuń</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- 
              FORMULARZ DODAWANIA PRACOWNIKA 
              - Domyślnie ukryty (display: none)
            -->
            <div id="formularz-dodawania" class="formularz" style="display: none;">
                <h3>Dodaj nowego pracownika</h3>
                <form method="POST">
                    <!-- GRUPA PÓL: IMIĘ I NAZWISKO -->
                    <div class="formularz-grupa">
                        <div>
                            <label for="imie">Imię:</label>
                            <input type="text" id="imie" name="imie" required>
                        </div>
                        <div>
                            <label for="nazwisko">Nazwisko:</label>
                            <input type="text" id="nazwisko" name="nazwisko" required>
                        </div>
                    </div>

                    <!-- GRUPA PÓL: EMAIL I HASŁO -->
                    <div class="formularz-grupa">
                        <div>
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div>
                            <label for="haslo">Hasło:</label>
                            <input type="password" id="haslo" name="haslo" required>
                        </div>
                    </div>

                    <!-- GRUPA PÓL: TELEFON I STANOWISKO -->
                    <div class="formularz-grupa">
                        <div>
                            <label for="telefon">Telefon:</label>
                            <input type="text" id="telefon" name="telefon">
                        </div>
                        <div>
                            <label for="stanowisko">Stanowisko:</label>
                            <select id="stanowisko" name="stanowisko" required>
                                <?php foreach ($stanowiska as $stanowisko): ?>
                                    <option value="<?= $stanowisko ?>"><?= $stanowisko ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <!-- GRUPA PÓL: DATA ZATRUDNIENIA I WYNAGRODZENIE -->
                    <div class="formularz-grupa">
                        <div>
                            <label for="data_zatrudnienia">Data zatrudnienia:</label>
                            <input type="date" id="data_zatrudnienia" name="data_zatrudnienia" required>
                        </div>
                        <div>
                            <label for="wynagrodzenie">Wynagrodzenie (zł):</label>
                            <input type="number" step="0.01" id="wynagrodzenie" name="wynagrodzenie" required>
                        </div>
                    </div>

                    <!-- PRZYCISKI FORMULARZA -->
                    <div class="przyciski-formularza">
                        <button type="submit" name="dodaj" class="przycisk przycisk-dodaj">Dodaj</button>
                        <button type="button" onclick="ukryjFormularz('formularz-dodawania')" class="przycisk przycisk-anuluj">Anuluj</button>
                    </div>
                </form>
            </div>

            <!-- 
              FORMULARZ EDYCJI PRACOWNIKA 
              - Domyślnie ukryty (display: none)
              - Wypełniany danymi przez JavaScript
            -->
            <div id="formularz-edycji" class="formularz" style="display: none;">
                <h3>Edytuj pracownika</h3>
                <form method="POST">
                    <!-- UKRYTE POLE Z ID PRACOWNIKA -->
                    <input type="hidden" name="id" id="edit-id">

                    <!-- GRUPA PÓL: IMIĘ I NAZWISKO -->
                    <div class="formularz-grupa">
                        <div>
                            <label for="edit-imie">Imię:</label>
                            <input type="text" id="edit-imie" name="imie" required>
                        </div>
                        <div>
                            <label for="edit-nazwisko">Nazwisko:</label>
                            <input type="text" id="edit-nazwisko" name="nazwisko" required>
                        </div>
                    </div>

                    <!-- GRUPA PÓL: EMAIL I TELEFON -->
                    <div class="formularz-grupa">
                        <div>
                            <label for="edit-email">Email:</label>
                            <input type="email" id="edit-email" name="email" required>
                        </div>
                        <div>
                            <label for="edit-telefon">Telefon:</label>
                            <input type="text" id="edit-telefon" name="telefon">
                        </div>
                    </div>

                    <!-- GRUPA PÓL: STANOWISKO I DATA ZATRUDNIENIA -->
                    <div class="formularz-grupa">
                        <div>
                            <label for="edit-stanowisko">Stanowisko:</label>
                            <select id="edit-stanowisko" name="stanowisko" required>
                                <?php foreach ($stanowiska as $stanowisko): ?>
                                    <option value="<?= $stanowisko ?>"><?= $stanowisko ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label for="edit-data_zatrudnienia">Data zatrudnienia:</label>
                            <input type="date" id="edit-data_zatrudnienia" name="data_zatrudnienia" required>
                        </div>
                    </div>

                    <!-- GRUPA PÓL: WYNAGRODZENIE -->
                    <div class="formularz-grupa">
                        <div>
                            <label for="edit-wynagrodzenie">Wynagrodzenie (zł):</label>
                            <input type="number" step="0.01" id="edit-wynagrodzenie" name="wynagrodzenie" required>
                        </div>
                    </div>

                    <!-- PRZYCISKI FORMULARZA -->
                    <div class="przyciski-formularza">
                        <button type="submit" name="edytuj" class="przycisk przycisk-edytuj">Zapisz zmiany</button>
                        <button type="button" onclick="ukryjFormularz('formularz-edycji')" class="przycisk przycisk-anuluj">Anuluj</button>
                    </div>
                </form>
            </div>

            <!-- 
              FORMULARZ POTWIERDZENIA USUNIĘCIA 
              - Domyślnie ukryty (display: none)
            -->
            <div id="formularz-usuwania" class="formularz" style="display: none;">
                <h3>Czy na pewno chcesz usunąć tego pracownika?</h3>
                <form method="POST">
                    <!-- UKRYTE POLE Z ID PRACOWNIKA -->
                    <input type="hidden" name="id" id="delete-id">
                    <p>Ta operacja jest nieodwracalna!</p>

                    <!-- PRZYCISKI FORMULARZA -->
                    <div class="przyciski-formularza">
                        <button type="submit" name="usun" class="przycisk przycisk-usun">Usuń</button>
                        <button type="button" onclick="ukryjFormularz('formularz-usuwania')" class="przycisk przycisk-anuluj">Anuluj</button>
                    </div>
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
            <!-- TRZY KOLUMNY Z INFORMACJAMI -->
            <div class="zawartosc-stopki">
                <!-- KOLUMNA 1: DANE KONTAKTOWE -->
                <div class="kolumna-stopki">
                    <h3>Kontakt</h3>
                    <p><i class="fas fa-map-marker-alt"></i> ul. Mięsna 14, 69-420 Radomyśl Wielki</p>
                    <p><i class="fas fa-phone"></i> +48 694 202 137</p>
                    <p><i class="fas fa-envelope"></i> kontakt@meatmaster.pl</p>
                </div>
                
                <!-- KOLUMNA 2: GODZINY OTWARCIA -->
                <div class="kolumna-stopki">
                    <h3>Godziny otwarcia</h3>
                    <p>Pon-Pt: 6:00 - 22:00</p>
                    <p>Sob: 7:00 - 14:00</p>
                    <p>Niedz: Zamknięte</p>
                </div>
                
                <!-- KOLUMNA 3: LINKI DO SOCIAL MEDIA -->
                <div class="kolumna-stopki">
                    <h3>Śledź nas</h3>
                    <div class="linki-spolecznosciowe">
                        <a href="#" aria-label="Twitter" class="x-icon">X</a>
                        <a href="#" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
                        <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            
            <!-- INFORMACJA O PRAWACH AUTORSKICH -->
            <div class="prawa-autorskie">
                <p>&copy; 2025 MeatMaster - Hurtownia Mięsa. Wszelkie prawa zastrzeżone.</p>
            </div>
        </div>
    </footer>


    <!-- 12. SKRYPT JAVASCRIPT -->
    <script>
        /**
         * 12.1. POKAZYWANIE FORMULARZA DODAWANIA
         * - Ukrywa inne formularze
         * - Pokazuje formularz dodawania
         * - Przewija do formularza
         */
        function pokazFormularzDodawania() {
            ukryjFormularz('formularz-edycji');
            ukryjFormularz('formularz-usuwania');
            document.getElementById('formularz-dodawania').style.display = 'block';
            window.scrollTo({
                top: document.getElementById('formularz-dodawania').offsetTop,
                behavior: 'smooth'
            });
        }

        /**
         * 12.2. POKAZYWANIE FORMULARZA EDYCJI
         * - Wypełnia formularz danymi pracownika
         * - Pokazuje formularz edycji
         * - Przewija do formularza
         */
        function pokazFormularzEdycji(id, imie, nazwisko, email, telefon, stanowisko, data_zatrudnienia, wynagrodzenie) {
            ukryjFormularz('formularz-dodawania');
            ukryjFormularz('formularz-usuwania');

            document.getElementById('edit-id').value = id;
            document.getElementById('edit-imie').value = imie;
            document.getElementById('edit-nazwisko').value = nazwisko;
            document.getElementById('edit-email').value = email;
            document.getElementById('edit-telefon').value = telefon;
            document.getElementById('edit-stanowisko').value = stanowisko;
            document.getElementById('edit-data_zatrudnienia').value = data_zatrudnienia;
            document.getElementById('edit-wynagrodzenie').value = wynagrodzenie;

            document.getElementById('formularz-edycji').style.display = 'block';
            window.scrollTo({
                top: document.getElementById('formularz-edycji').offsetTop,
                behavior: 'smooth'
            });
        }

        /**
         * 12.3. POTWIERDZENIE USUNIĘCIA
         * - Ustawia ID pracownika do usunięcia
         * - Pokazuje formularz potwierdzenia
         * - Przewija do formularza
         */
        function potwierdzUsuniecie(id) {
            ukryjFormularz('formularz-dodawania');
            ukryjFormularz('formularz-edycji');

            document.getElementById('delete-id').value = id;
            document.getElementById('formularz-usuwania').style.display = 'block';
            window.scrollTo({
                top: document.getElementById('formularz-usuwania').offsetTop,
                behavior: 'smooth'
            });
        }

        /**
         * 12.4. UKRYWANIE FORMULARZA
         * @param {string} idFormularza - ID formularza do ukrycia
         */
        function ukryjFormularz(idFormularza) {
            document.getElementById(idFormularza).style.display = 'none';
        }
    </script>
</body>
</html>