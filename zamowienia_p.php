<?php
require_once "sesje.php";
// Sprawdza czy użytkownik ma odpowiednie stanowisko do dostępu
sprawdzStanowisko(['Pracownik linii pakowania', 'Magazynier', 'Księgowy', 'Specjalista HR', 'Logistyk']);

require_once "db.php";

// Pobiera dane zamówień z bazy danych
$query = "SELECT * FROM zamowienia_widok";
$result = $conn->query($query);
$zamowienia = $result->fetch_all(MYSQLI_ASSOC); // Pobiera wszystkie wyniki jako tablicę asocjacyjną

// Obsługa aktualizacji zamówienia
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edytuj'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];

    // Przygotowuje zapytanie SQL z parametrami do wiązania
    $update_query = "UPDATE zamowienia SET 
                    status = ?
                    WHERE id = ?";

    // Przygotowuje statement do wykonania (zabezpieczenie przed SQL injection)
    $stmt = $conn->prepare($update_query);
    // Wiąże parametry do zapytania ("s" - string, "i" - integer)
    $stmt->bind_param("si", $status, $id);
    $stmt->execute();

    // Sprawdza czy aktualizacja się powiodła
    if ($stmt->affected_rows > 0) {
        $success = "Status zamówienia został zaktualizowany!";
        // Odświeża dane po aktualizacji
        $result = $conn->query($query);
        $zamowienia = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        $error = "Błąd podczas aktualizacji statusu zamówienia!";
    }
}
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MeatMaster - Przegląd zamówień</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="icon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .sekcja-zamowienia {
            padding: 80px 0;
            background: #f5f5f5;
            min-height: calc(100vh - 300px);
        }

        .kontener-zamowienia {
            max-width: 1200px;
            margin: 0 auto;
            background: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #c00;
            margin-bottom: 30px;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        th,
        td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #c00;
            color: white;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .formularz-edycji {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
        }

        .formularz-grupa {
            margin-bottom: 15px;
        }

        .formularz-grupa label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .formularz-grupa select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .przycisk-edycji {
            padding: 10px 15px;
            background: #c00;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .przycisk-edycji:hover {
            background: #a00;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        .alert-success {
            background-color: #dff0d8;
            color: #3c763d;
        }

        .alert-error {
            background-color: #f2dede;
            color: #a94442;
        }

        .status-oczekujace {
            color: #ff9800;
            font-weight: bold;
        }

        .status-realizacja {
            color: #2196f3;
            font-weight: bold;
        }

        .status-wyslane {
            color: #673ab7;
            font-weight: bold;
        }

        .status-zrealizowane {
            color: #4caf50;
            font-weight: bold;
        }

        .status-anulowane {
            color: #f44336;
            font-weight: bold;
        }
    </style>
</head>

<body>
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

    <section class="sekcja-zamowienia">
        <div class="kontener-zamowienia">
            <h2>Przegląd zamówień</h2>

            <?php if (isset($success)): ?>
                <div class="alert alert-success"><?= $success ?></div>
            <?php endif; ?>

            <?php if (isset($error)): ?>
                <div class="alert alert-error"><?= $error ?></div>
            <?php endif; ?>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Data</th>
                        <th>Klient</th>
                        <th>Firma</th>
                        <th>Asortyment</th>
                        <th>Waga (kg)</th>
                        <th>Status</th>
                        <th>Akcje</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($zamowienia as $zamowienie): ?>
                        <tr>
                            <td><?= $zamowienie['id_zamowienia'] ?></td>
                            <td><?= date('d.m.Y H:i', strtotime($zamowienie['data_zamowienia'])) ?></td>
                            <td><?= htmlspecialchars($zamowienie['klient']) ?></td>
                            <td><?= htmlspecialchars($zamowienie['firma'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($zamowienie['asortyment']) ?></td>
                            <td><?= number_format($zamowienie['waga'], 2) ?></td>
                            <td class="status-<?= str_replace(' ', '', $zamowienie['status']) ?>">
                                <?= $zamowienie['status'] ?>
                            </td>
                            <td>
                                <button onclick="pokazFormularzEdycji(
                                    '<?= $zamowienie['id_zamowienia'] ?>',
                                    '<?= $zamowienie['status'] ?>'
                                )">Zmień status</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div id="formularz-edycji" class="formularz-edycji" style="display: none;">
                <h3>Zmień status zamówienia</h3>
                <form method="POST">
                    <input type="hidden" name="id" id="edit-id">

                    <div class="formularz-grupa">
                        <label for="status">Status:</label>
                        <select name="status" id="edit-status" required>
                            <option value="oczekujące">Oczekujące</option>
                            <option value="w realizacji">W realizacji</option>
                            <option value="wysłane">Wysłane</option>
                            <option value="zrealizowane">Zrealizowane</option>
                            <option value="anulowane">Anulowane</option>
                        </select>
                    </div>

                    <button type="submit" name="edytuj" class="przycisk-edycji">Zapisz zmiany</button>
                </form>
            </div>
        </div>
    </section>

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

    <script>
        function pokazFormularzEdycji(id, status) {
            document.getElementById('edit-id').value = id;
            document.getElementById('edit-status').value = status.toLowerCase();

            document.getElementById('formularz-edycji').style.display = 'block';
            window.scrollTo({
                top: document.getElementById('formularz-edycji').offsetTop,
                behavior: 'smooth'
            });
        }
    </script>
</body>

</html>