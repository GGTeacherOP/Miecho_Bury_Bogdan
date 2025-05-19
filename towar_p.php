<?php

/**
 * PLIK: towary_p.php
 * PRZEZNACZENIE: Panel zarządzania asortymentem mięsnym (tylko dla kierownika)
 * DOSTĘP: Tylko dla użytkowników z rolą 'Kierownik'
 * BEZPIECZEŃSTWO: Weryfikacja sesji, ochrona przed SQL injection
 */

// =============================================================================
// SEKCJA 1: INICJALIZACJA I KONTROLA DOSTĘPU
// =============================================================================

// Załączenie mechanizmu sesji i kontroli dostępu
require_once "sesje.php";

// Weryfikacja czy użytkownik ma uprawnienia kierownika
// Funkcja automatycznie przekieruje na stronę logowania jeśli brak dostępu
sprawdzStanowisko(['Kierownik']);

// Załączenie konfiguracji połączenia z bazą danych MySQL
require_once "db.php";

// =============================================================================
// SEKCJA 2: OPERACJE NA BAZIE DANYCH
// =============================================================================

/**
 * Pobranie pełnej listy towarów z widoku bazy danych
 * Widok 'towary_widok' łączy dane z różnych tabel dla wygody prezentacji
 */
$query = "SELECT * FROM towary_widok";
$result = $conn->query($query);
$towary = $result->fetch_all(MYSQLI_ASSOC); // Konwersja wyników na tablicę asocjacyjną

/**
 * Obsługa żądania aktualizacji danych towaru
 * Zabezpieczenia:
 * - Weryfikacja metody POST
 * - Sprawdzenie czy wysłano formularz edycji
 * - Prepared statements chroniące przed SQL injection
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edytuj'])) {
    // Pobranie i sanityzacja danych z formularza
    $id = $_POST['id']; // ID towaru do aktualizacji
    $nazwa = $_POST['nazwa']; // Nowa nazwa produktu
    $cena = $_POST['cena']; // Zaktualizowana cena
    $kategoria = $_POST['kategoria']; // Kategoria produktu
    $dostepnosc = $_POST['dostepnosc']; // Status dostępności

    // Przygotowanie zapytania SQL z parametrami
    $update_query = "UPDATE towary SET 
                    nazwa = ?,          -- Parametr 1: Nazwa towaru
                    cena_zl_kg = ?,     -- Parametr 2: Cena za kg
                    kategoria = ?,      -- Parametr 3: Kategoria
                    dostepnosc = ?      -- Parametr 4: Status dostępności
                    WHERE id = ?";

    // Inicjalizacja prepared statement
    $stmt = $conn->prepare($update_query);

    // Powiązanie parametrów (typów):
    // s - string (nazwa)
    // d - double (cena)
    // s - string (kategoria)
    // s - string (dostepnosc)
    // i - integer (id)
    $stmt->bind_param("sdssi", $nazwa, $cena, $kategoria, $dostepnosc, $id);

    // Wykonanie zapytania
    $stmt->execute();

    // Obsługa rezultatów operacji
    if ($stmt->affected_rows > 0) {
        // Sukces - odświeżenie danych
        $success = "Dane towaru zostały zaktualizowane!";
        $result = $conn->query($query);
        $towary = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        // Błąd aktualizacji
        $error = "Operacja aktualizacji nie powiodła się!";
    }
}
?>

<!-- ========================================================================== -->
<!-- SEKCJA HTML: INTERFEJS UŻYTKOWNIKA -->
<!-- ========================================================================== -->
<!DOCTYPE html>
<html lang="pl">

<head>
    <!-- Meta dane -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Informacje nagłówkowe -->
    <title>MeatMaster | Panel zarządzania towarami</title>

    <!-- Załączenie arkuszy stylów -->
    <link rel="stylesheet" href="style.css"> <!-- Główny arkusz stylów -->
    <link rel="icon" type="image/png" href="icon.png"> <!-- Favicon -->

    <!-- Biblioteka ikon Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Style wewnętrzne specyficzne dla tej strony -->
    <style>
        /* Główny kontener sekcji */
        .sekcja-towary {
            padding: 80px 0;
            /* Wewnętrzny odstęp */
            background: #f5f5f5;
            /* Kolor tła */
            min-height: calc(100vh - 300px);
            /* Minimalna wysokość */
        }

        /* Kontener z zawartością */
        .kontener-towary {
            max-width: 1000px;
            /* Maksymalna szerokość */
            margin: 0 auto;
            /* Wyśrodkowanie */
            background: #fff;
            /* Białe tło */
            padding: 40px;
            /* Wewnętrzne odstępy */
            border-radius: 8px;
            /* Zaokrąglone rogi */
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            /* Cień */
        }

        /* Tabela z towarami */
        table {
            width: 100%;
            /* Pełna szerokość */
            border-collapse: collapse;
            /* Usunięcie podwójnych obramowań */
            margin-bottom: 30px;
            /* Odstęp od dołu */
        }

        /* Nagłówki tabeli */
        th {
            background-color: #c00;
            /* Czerwone tło */
            color: white;
            /* Biały tekst */
        }

        /* Komórki tabeli */
        th,
        td {
            padding: 12px 15px;
            /* Wewnętrzne odstępy */
            text-align: left;
            /* Wyrównanie tekstu */
            border-bottom: 1px solid #ddd;
            /* Linia oddzielająca */
        }

        /* Efekt hover na wierszach */
        tr:hover {
            background-color: #f5f5f5;
            /* Jasnoszare tło */
        }

        /* Formularz edycji */
        .formularz-edycji {
            background: #f9f9f9;
            /* Jasne tło */
            padding: 20px;
            /* Wewnętrzne odstępy */
            border-radius: 8px;
            /* Zaokrąglone rogi */
            margin-top: 20px;
            /* Odstęp od góry */
        }

        /* Grupy pól formularza */
        .formularz-grupa {
            margin-bottom: 15px;
            /* Odstęp między grupami */
        }

        /* Przyciski */
        .przycisk-edycji {
            background: #c00;
            /* Czerwony kolor */
            color: white;
            /* Biały tekst */
            transition: background 0.3s;
            /* Efekt przejścia */
        }

        .przycisk-edycji:hover {
            background: #a00;
            /* Ciemniejszy czerwony */
        }
    </style>
</head>

<!-- ========================================================================== -->
<!-- SEKCJA BODY: ZAWARTOŚĆ STRONY -->
<!-- ========================================================================== -->

<body>
    <!-- Nagłówek strony -->
    <header>
        <div class="kontener naglowek-kontener">
            <!-- Logo firmy -->
            <div class="logo">
                <img src="Logo.png" alt="Logo MeatMaster">
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
                    <li><a href="profil.php"><i class="fas fa-user"></i> Profil</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Główna sekcja zarządzania towarami -->
    <section class="sekcja-towary">
        <div class="kontener-towary">
            <!-- Nagłówek sekcji -->
            <h2>Zarządzanie asortymentem</h2>

            <!-- Komunikaty systemowe -->
            <?php if (isset($success)): ?>
                <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>

            <?php if (isset($error)): ?>
                <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <!-- Tabela z listą towarów -->
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nazwa produktu</th>
                        <th>Cena (zł/kg)</th>
                        <th>Kategoria</th>
                        <th>Dostępność</th>
                        <th>Akcje</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($towary as $towar): ?>
                        <tr>
                            <td><?= htmlspecialchars($towar['id']) ?></td>
                            <td><?= htmlspecialchars($towar['nazwa']) ?></td>
                            <td><?= number_format($towar['cena_zl_kg'], 2) ?></td>
                            <td><?= htmlspecialchars($towar['kategoria']) ?></td>
                            <td><?= htmlspecialchars($towar['dostepnosc']) ?></td>
                            <td>
                                <button onclick="pokazFormularzEdycji(
                                    '<?= $towar['id'] ?>',
                                    '<?= htmlspecialchars($towar['nazwa'], ENT_QUOTES) ?>',
                                    '<?= $towar['cena_zl_kg'] ?>',
                                    '<?= $towar['kategoria'] ?>',
                                    '<?= $towar['dostepnosc'] ?>'
                                )">Edytuj</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Formularz edycji (początkowo ukryty) -->
            <div id="formularz-edycji" class="formularz-edycji" style="display: none;">
                <h3>Edytuj produkt</h3>
                <form method="POST">
                    <!-- Pole ukryte z ID towaru -->
                    <input type="hidden" name="id" id="edit-id">

                    <!-- Pole nazwy produktu -->
                    <div class="formularz-grupa">
                        <label for="nazwa">Nazwa produktu:</label>
                        <input type="text" name="nazwa" id="edit-nazwa" required>
                    </div>

                    <!-- Pole ceny -->
                    <div class="formularz-grupa">
                        <label for="cena">Cena (zł/kg):</label>
                        <input type="number" step="0.01" name="cena" id="edit-cena" required>
                    </div>

                    <!-- Wybór kategorii -->
                    <div class="formularz-grupa">
                        <label for="kategoria">Kategoria:</label>
                        <select name="kategoria" id="edit-kategoria" required>
                            <option value="wołowina">Wołowina</option>
                            <option value="wieprzowina">Wieprzowina</option>
                            <option value="drób">Drób</option>
                            <option value="mieszanka">Mieszanka</option>
                        </select>
                    </div>

                    <!-- Status dostępności -->
                    <div class="formularz-grupa">
                        <label for="dostepnosc">Dostępność:</label>
                        <select name="dostepnosc" id="edit-dostepnosc" required>
                            <option value="dostępny">Dostępny</option>
                            <option value="na zamówienie">Na zamówienie</option>
                            <option value="zapytaj">Zapytaj</option>
                        </select>
                    </div>

                    <!-- Przycisk zapisu -->
                    <button type="submit" name="edytuj" class="przycisk-edycji">Zapisz zmiany</button>
                </form>
            </div>
        </div>
    </section>
    </footer>
    <!-- Skrypt JavaScript -->
    <script>
        /**
         * Funkcja pokazująca formularz edycji i wypełniająca go danymi
         * @param {number} id - ID towaru
         * @param {string} nazwa - Nazwa produktu
         * @param {number} cena - Cena za kg
         * @param {string} kategoria - Kategoria produktu
         * @param {string} dostepnosc - Status dostępności
         */
        function pokazFormularzEdycji(id, nazwa, cena, kategoria, dostepnosc) {
            // Wypełnienie formularza danymi
            document.getElementById('edit-id').value = id;
            document.getElementById('edit-nazwa').value = nazwa;
            document.getElementById('edit-cena').value = cena;
            document.getElementById('edit-kategoria').value = kategoria;
            document.getElementById('edit-dostepnosc').value = dostepnosc;

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