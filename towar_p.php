<?php
require_once "sesje.php";
sprawdzStanowisko(['Kierownik']); // Tylko kierownik ma dostęp

require_once "db.php";

// Pobierz dane towarów z bazy
$query = "SELECT * FROM towary_widok";
$result = $conn->query($query);
$towary = $result->fetch_all(MYSQLI_ASSOC);

// Obsługa aktualizacji towaru
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edytuj'])) {
    $id = $_POST['id'];
    $nazwa = $_POST['nazwa'];
    $cena = $_POST['cena'];
    $kategoria = $_POST['kategoria'];
    $dostepnosc = $_POST['dostepnosc'];

    $update_query = "UPDATE towary SET 
                    nazwa = ?,
                    cena_zl_kg = ?,
                    kategoria = ?,
                    dostepnosc = ?
                    WHERE id = ?";

    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("sdssi", $nazwa, $cena, $kategoria, $dostepnosc, $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $success = "Towar został zaktualizowany!";
        // Odśwież dane
        $result = $conn->query($query);
        $towary = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        $error = "Błąd podczas aktualizacji towaru!";
    }
}
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MeatMaster - Zarządzanie towarem</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="icon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .sekcja-towary {
            padding: 80px 0;
            background: #f5f5f5;
            min-height: calc(100vh - 300px);
        }

        .kontener-towary {
            max-width: 1000px;
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

        .formularz-grupa input,
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

    <section class="sekcja-towary">
        <div class="kontener-towary">
            <h2>Zarządzanie towarem</h2>

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
                        <th>Nazwa</th>
                        <th>Cena (zł/kg)</th>
                        <th>Kategoria</th>
                        <th>Dostępność</th>
                        <th>Akcje</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($towary as $towar): ?>
                        <tr>
                            <td><?= $towar['id'] ?></td>
                            <td><?= htmlspecialchars($towar['nazwa']) ?></td>
                            <td><?= number_format($towar['cena_zl_kg'], 2) ?></td>
                            <td><?= $towar['kategoria'] ?></td>
                            <td><?= $towar['dostepnosc'] ?></td>
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

            <div id="formularz-edycji" class="formularz-edycji" style="display: none;">
                <h3>Edytuj towar</h3>
                <form method="POST">
                    <input type="hidden" name="id" id="edit-id">

                    <div class="formularz-grupa">
                        <label for="nazwa">Nazwa:</label>
                        <input type="text" name="nazwa" id="edit-nazwa" required>
                    </div>

                    <div class="formularz-grupa">
                        <label for="cena">Cena (zł/kg):</label>
                        <input type="number" step="0.01" name="cena" id="edit-cena" required>
                    </div>

                    <div class="formularz-grupa">
                        <label for="kategoria">Kategoria:</label>
                        <select name="kategoria" id="edit-kategoria" required>
                            <option value="wołowina">Wołowina</option>
                            <option value="wieprzowina">Wieprzowina</option>
                            <option value="drób">Drób</option>
                            <option value="mieszanka">Mieszanka</option>
                        </select>
                    </div>

                    <div class="formularz-grupa">
                        <label for="dostepnosc">Dostępność:</label>
                        <select name="dostepnosc" id="edit-dostepnosc" required>
                            <option value="dostępny">Dostępny</option>
                            <option value="na zamówienie">Na zamówienie</option>
                            <option value="zapytaj">Zapytaj</option>
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
        function pokazFormularzEdycji(id, nazwa, cena, kategoria, dostepnosc) {
            document.getElementById('edit-id').value = id;
            document.getElementById('edit-nazwa').value = nazwa;
            document.getElementById('edit-cena').value = cena;
            document.getElementById('edit-kategoria').value = kategoria;
            document.getElementById('edit-dostepnosc').value = dostepnosc;

            document.getElementById('formularz-edycji').style.display = 'block';
            window.scrollTo({
                top: document.getElementById('formularz-edycji').offsetTop,
                behavior: 'smooth'
            });
        }
    </script>
</body>

</html>