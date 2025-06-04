<?php
require_once "sesje.php";
// Sprawdzenie czy użytkownik ma odpowiednie uprawnienia - dodajemy właściciela
if (!czyWlasciciel() && !in_array($_SESSION['stanowisko'], ['Pracownik linii pakowania', 'Magazynier', 'Księgowy', 'Specjalista HR', 'Logistyk'])) {
    header("Location: brak_dostepu.php");
    exit();
}

require_once "db.php";

// 2. POBRANIE REKLAMACJI Z BAZY
$query = "SELECT * FROM reklamacje_widok"; // Widok z danymi reklamacji
$result = $conn->query($query);
$reklamacje = $result->fetch_all(MYSQLI_ASSOC); // Pobierz wszystkie rekordy jako tablicę asocjacyjną

// 3. OBSŁUGA AKTUALIZACJI REKLAMACJI
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edytuj'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];
    $decyzja = $_POST['decyzja'];

    // Przygotowane zapytanie SQL dla bezpieczeństwa
    $update_query = "UPDATE reklamacje SET 
                    status = ?,
                    decyzja = ?,
                    data_rozpatrzenia = NOW(),
                    pracownik_id = ?
                    WHERE id = ?";

    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("ssii", $status, $decyzja, $_SESSION['user_id'], $id);
    $stmt->execute();

    // Komunikat o sukcesie lub błędzie
    if ($stmt->affected_rows > 0) {
        $success = "Status reklamacji został zaktualizowany!";
        // Odśwież dane
        $result = $conn->query($query);
        $reklamacje = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        $error = "Błąd podczas aktualizacji statusu reklamacji!";
    }
}
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <!-- Podstawowe meta tagi -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MeatMaster - Przegląd reklamacji</title>

    <!-- Podpięcie zewnętrznych zasobów -->
    <link rel="stylesheet" href="style.css"> <!-- Główny arkusz stylów -->
    <link rel="icon" type="image/png" href="icon.png"> <!-- Favicon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"> <!-- Ikony FontAwesome -->

    <!-- Style wewnętrzne SPECYFICZNE dla tej strony -->
    <style>
        /* Główna sekcja strony */
        .sekcja-reklamacje {
            padding: 80px 0;
            background: #f5f5f5;
            min-height: calc(100vh - 300px);
            /* Minimalna wysokość */
        }

        /* Kontener główny */
        .kontener-reklamacje {
            max-width: 1200px;
            /* Maksymalna szerokość */
            margin: 0 auto;
            /* Wyśrodkowanie */
            background: #fff;
            /* Białe tło */
            padding: 40px;
            /* Wewnętrzny odstęp */
            border-radius: 8px;
            /* Zaokrąglone rogi */
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            /* Subtelny cień */
        }

        /* Nagłówek strony */
        h2 {
            color: #c00;
            /* Czerwony kolor */
            margin-bottom: 30px;
            text-align: center;
        }

        /* Tabela z reklamacjami */
        table {
            width: 100%;
            border-collapse: collapse;
            /* Usunięcie podwójnych obramowań */
            margin-bottom: 30px;
        }

        /* Komórki tabeli */
        th,
        td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            /* Szara linia oddzielająca */
        }

        /* Nagłówki kolumn */
        th {
            background-color: #c00;
            /* Czerwone tło */
            color: white;
            /* Biały tekst */
        }

        /* Efekt hover na wierszach */
        tr:hover {
            background-color: #f5f5f5;
            /* Jasnoszare tło */
        }

        /* Formularz edycji */
        .formularz-edycji {
            background: #f9f9f9;
            /* Bardzo jasne szare tło */
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
        }

        /* Grupa pól formularza */
        .formularz-grupa {
            margin-bottom: 15px;
        }

        /* Etykiety formularza */
        .formularz-grupa label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        /* Pola formularza */
        .formularz-grupa select,
        .formularz-grupa textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        /* Textarea - większa wysokość */
        .formularz-grupa textarea {
            min-height: 100px;
            resize: vertical;
            /* Zezwól tylko na pionowy resize */
        }

        /* Przycisk zapisu */
        .przycisk-edycji {
            padding: 10px 15px;
            background: #c00;
            /* Czerwony kolor */
            color: white;
            /* Biały tekst */
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        /* Efekt hover na przycisku */
        .przycisk-edycji:hover {
            background: #a00;
            /* Ciemniejszy czerwony */
        }

        /* Komunikaty systemowe */
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        /* Komunikat sukcesu */
        .alert-success {
            background-color: #dff0d8;
            /* Jasnozielone tło */
            color: #3c763d;
            /* Ciemnozielony tekst */
        }

        /* Komunikat błędu */
        .alert-error {
            background-color: #f2dede;
            /* Jasnoczerwone tło */
            color: #a94442;
            /* Ciemnoczerwony tekst */
        }

        /* Kolory statusów reklamacji */
        .status-otwarta {
            color: #ff9800;
            /* Pomarańczowy */
            font-weight: bold;
        }

        .status-w_trakcie {
            color: #2196f3;
            /* Niebieski */
            font-weight: bold;
        }

        .status-rozpatrzona {
            color: #4caf50;
            /* Zielony */
            font-weight: bold;
        }

        .status-odrzucona {
            color: #f44336;
            /* Czerwony */
            font-weight: bold;
        }
    </style>
</head>

<body>
    <!-- Nagłówek strony (menu nawigacyjne) -->
    <header>
        <div class="kontener naglowek-kontener">
            <div class="logo">
                <img src="Logo.png" alt="MeatMaster Logo">
            </div>
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

    <!-- Główna sekcja z reklamacjami -->
    <section class="sekcja-reklamacje">
        <div class="kontener-reklamacje">
            <h2>Przegląd reklamacji</h2>

            <!-- Wyświetlanie komunikatu sukcesu -->
            <?php if (isset($success)): ?>
                <div class="alert alert-success"><?= $success ?></div>
            <?php endif; ?>

            <!-- Wyświetlanie komunikatu błędu -->
            <?php if (isset($error)): ?>
                <div class="alert alert-error"><?= $error ?></div>
            <?php endif; ?>

            <!-- Tabela z listą reklamacji -->
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Data zgłoszenia</th>
                        <th>Klient</th>
                        <th>ID Zamówienia</th>
                        <th>Treść</th>
                        <th>Status</th>
                        <th>Decyzja</th>
                        <th>Data rozpatrzenia</th>
                        <th>Akcje</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Pętla przez wszystkie reklamacje -->
                    <?php foreach ($reklamacje as $reklamacja): ?>
                        <tr>
                            <td><?= $reklamacja['id_reklamacji'] ?></td>
                            <td><?= date('d.m.Y H:i', strtotime($reklamacja['data_zgloszenia'])) ?></td>
                            <td><?= htmlspecialchars($reklamacja['klient']) ?></td>
                            <td><?= $reklamacja['id_zamowienia'] ?></td>
                            <td><?= htmlspecialchars(substr($reklamacja['tresc'], 0, 50)) ?>...</td>
                            <!-- Status z odpowiednim kolorem -->
                            <td class="status-<?= str_replace(' ', '', $reklamacja['status']) ?>">
                                <?= $reklamacja['status'] ?>
                            </td>
                            <td><?= $reklamacja['decyzja'] ? htmlspecialchars(substr($reklamacja['decyzja'], 0, 30)) . '...' : '-' ?></td>
                            <td><?= $reklamacja['data_rozpatrzenia'] ? date('d.m.Y H:i', strtotime($reklamacja['data_rozpatrzenia'])) : '-' ?></td>
                            <td>
                                <!-- Przycisk uruchamiający formularz edycji -->
                                <button onclick="pokazFormularzEdycji(
                                    '<?= $reklamacja['id_reklamacji'] ?>',
                                    '<?= $reklamacja['status'] ?>',
                                    '<?= htmlspecialchars($reklamacja['decyzja'] ?? '', ENT_QUOTES) ?>'
                                )">Rozpatrz</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Formularz edycji (początkowo ukryty) -->
            <div id="formularz-edycji" class="formularz-edycji" style="display: none;">
                <h3>Rozpatrz reklamację</h3>
                <form method="POST">
                    <input type="hidden" name="id" id="edit-id">

                    <div class="formularz-grupa">
                        <label for="status">Status:</label>
                        <select name="status" id="edit-status" required>
                            <option value="otwarta">Otwarta</option>
                            <option value="w_trakcie">W trakcie</option>
                            <option value="rozpatrzona">Rozpatrzona</option>
                            <option value="odrzucona">Odrzucona</option>
                        </select>
                    </div>

                    <div class="formularz-grupa">
                        <label for="decyzja">Decyzja/Uzasadnienie:</label>
                        <textarea name="decyzja" id="edit-decyzja" required></textarea>
                    </div>

                    <button type="submit" name="edytuj" class="przycisk-edycji">Zapisz zmiany</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Stopka strony -->
    <footer>
        <div class="kontener">
            <div class="zawartosc-stopki">
                <div class="kolumna-stopki">
                    <h3>Kontakt</h3>
                    <p><i class="fas fa-map-marker-alt"></i> ul. Mięsna 14, 69-420 Radomyśl Wielki</p>
                    <p><i class="fas fa-phone"></i> +48 694 202 137</p>
                    <p><i class="fas fa-envelope"></i> kontaktujSieWariacieEssa@meatmaster.pl</p>
                </div>
                <div class="kolumna-stopki">
                    <h3>Godziny otwarcia</h3>
                    <p>Pon-Pt: 6:00 - 22:00</p>
                    <p>Sob: 7:00 - 14:00</p>
                    <p>Niedz: Zamknięte</p>
                </div>
                <div class="kolumna-stopki">
                    <h3>Śledź nas</h3>
                    <div class="linki-spolecznosciowe">
                        <a href="#" aria-label="Twitter" class="x-icon">X</a>
                        <a href="#" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
                        <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            <div class="prawa-autorskie">
                <p>&copy; 2025 MeatMaster - Hurtownia Mięsa. Wszelkie prawa zastrzeżone.</p>
            </div>
        </div>
    </footer>

    <!-- Skrypt JavaScript -->
    <script>
        // Funkcja pokazująca formularz edycji i wypełniająca go danymi
        function pokazFormularzEdycji(id, status, decyzja) {
            // Ustawienie wartości w formularzu
            document.getElementById('edit-id').value = id;
            document.getElementById('edit-status').value = status.toLowerCase();
            document.getElementById('edit-decyzja').value = decyzja;

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