<?php
require_once "sesje.php";
require_once "db.php";
sprawdzStanowisko(['Kierownik', 'Specjalista HR', 'Logistyk', 'Księgowy']);

// Pobierz zgłoszenia
$kontakty = $conn->query("
    SELECT k.*, CONCAT(p.imie, ' ', p.nazwisko) as pracownik
    FROM kontakty k
    LEFT JOIN pracownicy p ON k.pracownik_id = p.id
    ORDER BY k.data_zgloszenia DESC
")->fetch_all(MYSQLI_ASSOC);

// Zmiana statusu
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['zmien_status'])) {
    $id = $conn->real_escape_string($_POST['id']);
    $status = $conn->real_escape_string($_POST['status']);
    
    $conn->query("UPDATE kontakty SET 
                status = '$status',
                pracownik_id = {$_SESSION['user_id']},
                data_zakonczenia = " . ($status == 'zamknieta' ? "NOW()" : "NULL") . "
                WHERE id = $id");
    
    header("Location: kontakty_p.php?updated=1");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Zgłoszenia kontaktowe</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="icon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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

        th, td {
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

        .status-nowa {
            color: #ff9800;
            font-weight: bold;
        }

        .status-w_trakcie {
            color: #2196f3;
            font-weight: bold;
        }

        .status-zamknieta {
            color: #4caf50;
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
            <h2>Zgłoszenia kontaktowe</h2>

            <?php if (isset($_GET['updated'])): ?>
                <div class="alert alert-success">Status zgłoszenia został zaktualizowany!</div>
            <?php endif; ?>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Data</th>
                        <th>Nadawca</th>
                        <th>Temat</th>
                        <th>Status</th>
                        <th>Pracownik</th>
                        <th>Akcje</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($kontakty as $k): ?>
                    <tr>
                        <td><?= $k['id'] ?></td>
                        <td><?= date('d.m.Y H:i', strtotime($k['data_zgloszenia'])) ?></td>
                        <td><?= htmlspecialchars($k['imie']) ?></td>
                        <td><?= htmlspecialchars($k['temat']) ?></td>
                        <td class="status-<?= str_replace(' ', '', $k['status']) ?>">
                            <?= $k['status'] ?>
                        </td>
                        <td><?= htmlspecialchars($k['pracownik'] ?? 'Brak') ?></td>
                        <td>
                            <button onclick="pokazFormularz(<?= $k['id'] ?>, '<?= $k['status'] ?>')">
                                Zmień status
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div id="formularz-edycji" class="formularz-edycji" style="display: none;">
                <h3>Zmiana statusu zgłoszenia</h3>
                <form method="post">
                    <input type="hidden" name="id" id="edit-id">
                    <input type="hidden" name="zmien_status" value="1">

                    <div class="formularz-grupa">
                        <label for="status">Status:</label>
                        <select name="status" id="edit-status" required>
                            <option value="nowa">Nowa</option>
                            <option value="w_trakcie">W trakcie</option>
                            <option value="zamknieta">Zamknięta</option>
                        </select>
                    </div>

                    <button type="submit" class="przycisk-edycji">Zapisz zmiany</button>
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
                    <p><i class="fas fa-envelope"></i> kontakt@meatmaster.pl</p>
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
        function pokazFormularz(id, status) {
            document.getElementById('edit-id').value = id;
            document.getElementById('edit-status').value = status;

            document.getElementById('formularz-edycji').style.display = 'block';
            window.scrollTo({
                top: document.getElementById('formularz-edycji').offsetTop,
                behavior: 'smooth'
            });
        }
    </script>
</body>
</html>