<?php
require_once "sesje.php";
sprawdzStanowisko(['Pracownik linii pakowania', 'Magazynier', 'Księgowy', 'Specjalista HR', 'Logistyk']); // Tylko wybrane stanowiska mają dostęp

require_once "db.php";

// Pobierz dane reklamacji z bazy
$query = "SELECT * FROM reklamacje_widok";
$result = $conn->query($query);
$reklamacje = $result->fetch_all(MYSQLI_ASSOC);

// Obsługa aktualizacji reklamacji
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edytuj'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];
    $decyzja = $_POST['decyzja'];

    $update_query = "UPDATE reklamacje SET 
                    status = ?,
                    decyzja = ?,
                    data_rozpatrzenia = NOW(),
                    pracownik_id = ?
                    WHERE id = ?";

    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("ssii", $status, $decyzja, $_SESSION['user_id'], $id);
    $stmt->execute();

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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MeatMaster - Przegląd reklamacji</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="icon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .sekcja-reklamacje {
            padding: 80px 0;
            background: #f5f5f5;
            min-height: calc(100vh - 300px);
        }

        .kontener-reklamacje {
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

        .formularz-grupa select,
        .formularz-grupa textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .formularz-grupa textarea {
            min-height: 100px;
            resize: vertical;
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

        .status-otwarta {
            color: #ff9800;
            font-weight: bold;
        }

        .status-w_trakcie {
            color: #2196f3;
            font-weight: bold;
        }

        .status-rozpatrzona {
            color: #4caf50;
            font-weight: bold;
        }

        .status-odrzucona {
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

    <section class="sekcja-reklamacje">
        <div class="kontener-reklamacje">
            <h2>Przegląd reklamacji</h2>

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
                    <?php foreach ($reklamacje as $reklamacja): ?>
                        <tr>
                            <td><?= $reklamacja['id_reklamacji'] ?></td>
                            <td><?= date('d.m.Y H:i', strtotime($reklamacja['data_zgloszenia'])) ?></td>
                            <td><?= htmlspecialchars($reklamacja['klient']) ?></td>
                            <td><?= $reklamacja['id_zamowienia'] ?></td>
                            <td><?= htmlspecialchars(substr($reklamacja['tresc'], 0, 50)) ?>...</td>
                            <td class="status-<?= str_replace(' ', '', $reklamacja['status']) ?>">
                                <?= $reklamacja['status'] ?>
                            </td>
                            <td><?= $reklamacja['decyzja'] ? htmlspecialchars(substr($reklamacja['decyzja'], 0, 30)) . '...' : '-' ?></td>
                            <td><?= $reklamacja['data_rozpatrzenia'] ? date('d.m.Y H:i', strtotime($reklamacja['data_rozpatrzenia'])) : '-' ?></td>
                            <td>
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
        function pokazFormularzEdycji(id, status, decyzja) {
            document.getElementById('edit-id').value = id;
            document.getElementById('edit-status').value = status.toLowerCase();
            document.getElementById('edit-decyzja').value = decyzja;

            document.getElementById('formularz-edycji').style.display = 'block';
            window.scrollTo({
                top: document.getElementById('formularz-edycji').offsetTop,
                behavior: 'smooth'
            });
        }
    </script>
</body>

</html>