<?php
require_once "sesje.php";
sprawdzStanowisko(['Kierownik']); // Tylko kierownik ma dostęp

require_once "db.php";

// Obsługa dodawania nowego pracownika
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['dodaj'])) {
    $imie = $_POST['imie'];
    $nazwisko = $_POST['nazwisko'];
    $email = $_POST['email'];
    $haslo = password_hash($_POST['haslo'], PASSWORD_DEFAULT);
    $telefon = $_POST['telefon'];
    $stanowisko = $_POST['stanowisko'];
    $data_zatrudnienia = $_POST['data_zatrudnienia'];
    $wynagrodzenie = $_POST['wynagrodzenie'];

    $insert_query = "INSERT INTO pracownicy (imie, nazwisko, email, haslo, telefon, stanowisko, data_zatrudnienia, wynagrodzenie) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param("sssssssd", $imie, $nazwisko, $email, $haslo, $telefon, $stanowisko, $data_zatrudnienia, $wynagrodzenie);

    if ($stmt->execute()) {
        $success = "Pracownik został dodany!";
    } else {
        $error = "Błąd podczas dodawania pracownika: " . $conn->error;
    }
}

// Obsługa aktualizacji pracownika
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edytuj'])) {
    $id = $_POST['id'];
    $imie = $_POST['imie'];
    $nazwisko = $_POST['nazwisko'];
    $email = $_POST['email'];
    $telefon = $_POST['telefon'];
    $stanowisko = $_POST['stanowisko'];
    $data_zatrudnienia = $_POST['data_zatrudnienia'];
    $wynagrodzenie = $_POST['wynagrodzenie'];

    $update_query = "UPDATE pracownicy SET 
                    imie = ?,
                    nazwisko = ?,
                    email = ?,
                    telefon = ?,
                    stanowisko = ?,
                    data_zatrudnienia = ?,
                    wynagrodzenie = ?
                    WHERE id = ?";

    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("ssssssdi", $imie, $nazwisko, $email, $telefon, $stanowisko, $data_zatrudnienia, $wynagrodzenie, $id);

    if ($stmt->execute()) {
        $success = "Dane pracownika zostały zaktualizowane!";
    } else {
        $error = "Błąd podczas aktualizacji danych pracownika: " . $conn->error;
    }
}

// Obsługa usuwania pracownika
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['usun'])) {
    $id = $_POST['id'];

    $delete_query = "DELETE FROM pracownicy WHERE id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $success = "Pracownik został usunięty!";
    } else {
        $error = "Błąd podczas usuwania pracownika: " . $conn->error;
    }
}

// Pobierz dane pracowników z bazy
$query = "SELECT * FROM pracownicy_widok";
$result = $conn->query($query);
$pracownicy = $result->fetch_all(MYSQLI_ASSOC);

// Lista dostępnych stanowisk
$stanowiska = ['Kierownik', 'Programista', 'Pracownik linii pakowania', 'Magazynier', 'Księgowy', 'Specjalista HR', 'Logistyk'];
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MeatMaster - Zarządzanie pracownikami</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="icon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .sekcja-pracownicy {
            padding: 80px 0;
            background: #f5f5f5;
            min-height: calc(100vh - 300px);
        }

        .kontener-pracownicy {
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

        .formularz {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
        }

        .formularz-grupa {
            margin-bottom: 15px;
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .formularz-grupa>div {
            flex: 1;
            min-width: 200px;
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

        .przyciski-formularza {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .przycisk {
            padding: 10px 15px;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
        }

        .przycisk-dodaj {
            background: #4CAF50;
        }

        .przycisk-edytuj {
            background: #2196F3;
        }

        .przycisk-usun {
            background: #f44336;
        }

        .przycisk-anuluj {
            background: #9E9E9E;
        }

        .przycisk:hover {
            opacity: 0.8;
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

        .przycisk-nowy {
            display: inline-block;
            padding: 10px 15px;
            background: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-bottom: 20px;
        }

        .przycisk-nowy:hover {
            opacity: 0.8;
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

    <section class="sekcja-pracownicy">
        <div class="kontener-pracownicy">
            <h2>Zarządzanie pracownikami</h2>

            <?php if (isset($success)): ?>
                <div class="alert alert-success"><?= $success ?></div>
            <?php endif; ?>

            <?php if (isset($error)): ?>
                <div class="alert alert-error"><?= $error ?></div>
            <?php endif; ?>

            <button class="przycisk-nowy" onclick="pokazFormularzDodawania()">Dodaj nowego pracownika</button>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Imię</th>
                        <th>Nazwisko</th>
                        <th>Email</th>
                        <th>Telefon</th>
                        <th>Stanowisko</th>
                        <th>Data zatrudnienia</th>
                        <th>Wynagrodzenie</th>
                        <th>Akcje</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pracownicy as $pracownik): ?>
                        <tr>
                            <td><?= $pracownik['id'] ?></td>
                            <td><?= htmlspecialchars($pracownik['imie']) ?></td>
                            <td><?= htmlspecialchars($pracownik['nazwisko']) ?></td>
                            <td><?= htmlspecialchars($pracownik['email']) ?></td>
                            <td><?= htmlspecialchars($pracownik['telefon'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($pracownik['stanowisko']) ?></td>
                            <td><?= date('d.m.Y', strtotime($pracownik['data_zatrudnienia'])) ?></td>
                            <td><?= number_format($pracownik['wynagrodzenie'], 2) ?> zł</td>
                            <td>
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
                                <button onclick="potwierdzUsuniecie(<?= $pracownik['id'] ?>)">Usuń</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div id="formularz-dodawania" class="formularz" style="display: none;">
                <h3>Dodaj nowego pracownika</h3>
                <form method="POST">
                    <div class="formularz-grupa">
                        <div>
                            <label for="imie">Imię:</label>
                            <input type="text" name="imie" required>
                        </div>
                        <div>
                            <label for="nazwisko">Nazwisko:</label>
                            <input type="text" name="nazwisko" required>
                        </div>
                    </div>

                    <div class="formularz-grupa">
                        <div>
                            <label for="email">Email:</label>
                            <input type="email" name="email" required>
                        </div>
                        <div>
                            <label for="haslo">Hasło:</label>
                            <input type="password" name="haslo" required>
                        </div>
                    </div>

                    <div class="formularz-grupa">
                        <div>
                            <label for="telefon">Telefon:</label>
                            <input type="text" name="telefon">
                        </div>
                        <div>
                            <label for="stanowisko">Stanowisko:</label>
                            <select name="stanowisko" required>
                                <?php foreach ($stanowiska as $stanowisko): ?>
                                    <option value="<?= $stanowisko ?>"><?= $stanowisko ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="formularz-grupa">
                        <div>
                            <label for="data_zatrudnienia">Data zatrudnienia:</label>
                            <input type="date" name="data_zatrudnienia" required>
                        </div>
                        <div>
                            <label for="wynagrodzenie">Wynagrodzenie (zł):</label>
                            <input type="number" step="0.01" name="wynagrodzenie" required>
                        </div>
                    </div>

                    <div class="przyciski-formularza">
                        <button type="submit" name="dodaj" class="przycisk przycisk-dodaj">Dodaj</button>
                        <button type="button" onclick="ukryjFormularz('formularz-dodawania')" class="przycisk przycisk-anuluj">Anuluj</button>
                    </div>
                </form>
            </div>

            <div id="formularz-edycji" class="formularz" style="display: none;">
                <h3>Edytuj pracownika</h3>
                <form method="POST">
                    <input type="hidden" name="id" id="edit-id">

                    <div class="formularz-grupa">
                        <div>
                            <label for="imie">Imię:</label>
                            <input type="text" name="imie" id="edit-imie" required>
                        </div>
                        <div>
                            <label for="nazwisko">Nazwisko:</label>
                            <input type="text" name="nazwisko" id="edit-nazwisko" required>
                        </div>
                    </div>

                    <div class="formularz-grupa">
                        <div>
                            <label for="email">Email:</label>
                            <input type="email" name="email" id="edit-email" required>
                        </div>
                        <div>
                            <label for="telefon">Telefon:</label>
                            <input type="text" name="telefon" id="edit-telefon">
                        </div>
                    </div>

                    <div class="formularz-grupa">
                        <div>
                            <label for="stanowisko">Stanowisko:</label>
                            <select name="stanowisko" id="edit-stanowisko" required>
                                <?php foreach ($stanowiska as $stanowisko): ?>
                                    <option value="<?= $stanowisko ?>"><?= $stanowisko ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label for="data_zatrudnienia">Data zatrudnienia:</label>
                            <input type="date" name="data_zatrudnienia" id="edit-data_zatrudnienia" required>
                        </div>
                    </div>

                    <div class="formularz-grupa">
                        <div>
                            <label for="wynagrodzenie">Wynagrodzenie (zł):</label>
                            <input type="number" step="0.01" name="wynagrodzenie" id="edit-wynagrodzenie" required>
                        </div>
                    </div>

                    <div class="przyciski-formularza">
                        <button type="submit" name="edytuj" class="przycisk przycisk-edytuj">Zapisz zmiany</button>
                        <button type="button" onclick="ukryjFormularz('formularz-edycji')" class="przycisk przycisk-anuluj">Anuluj</button>
                    </div>
                </form>
            </div>

            <div id="formularz-usuwania" class="formularz" style="display: none;">
                <h3>Czy na pewno chcesz usunąć tego pracownika?</h3>
                <form method="POST">
                    <input type="hidden" name="id" id="delete-id">
                    <p>Ta operacja jest nieodwracalna!</p>

                    <div class="przyciski-formularza">
                        <button type="submit" name="usun" class="przycisk przycisk-usun">Usuń</button>
                        <button type="button" onclick="ukryjFormularz('formularz-usuwania')" class="przycisk przycisk-anuluj">Anuluj</button>
                    </div>
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
        function pokazFormularzDodawania() {
            ukryjFormularz('formularz-edycji');
            ukryjFormularz('formularz-usuwania');
            document.getElementById('formularz-dodawania').style.display = 'block';
            window.scrollTo({
                top: document.getElementById('formularz-dodawania').offsetTop,
                behavior: 'smooth'
            });
        }

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

        function ukryjFormularz(idFormularza) {
            document.getElementById(idFormularza).style.display = 'none';
        }
    </script>
</body>

</html>