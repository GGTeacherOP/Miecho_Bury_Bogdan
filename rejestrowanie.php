<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = new mysqli("localhost", "root", "", "meatmasters");

    if ($conn->connect_error) {
        die("Błąd połączenia: " . $conn->connect_error);
    }

    function clean($dane)
    {
        return htmlspecialchars(trim($dane));
    }

    $imie = clean($_POST['imie']);
    $nazwisko = clean($_POST['nazwisko']);
    $email = clean($_POST['email']);
    $haslo = $_POST['haslo'];
    $potwierdz_haslo = $_POST['potwierdz-haslo'];
    $telefon = clean($_POST['telefon']);
    $typ_formularza = clean($_POST['typ-konta']);

    // Mapowanie wartości z formularza na wartości typu ENUM z bazy danych
    $mapa_typow = [
        'klient' => 'klient indywidualny',
        'firma' => 'firma/hurtownia',
        'restauracja' => 'restauracja'
    ];

    $typ_konta = $mapa_typow[$typ_formularza] ?? 'klient indywidualny';

    $nazwa_firmy = !empty($_POST['nazwa-firmy']) ? clean($_POST['nazwa-firmy']) : null;
    $nip = !empty($_POST['nip']) ? clean($_POST['nip']) : null;
    $regulamin = isset($_POST['regulamin']);

    if ($haslo !== $potwierdz_haslo) {
        $error = "Hasła nie są takie same!";
    } elseif (strlen($haslo) < 8) {
        $error = "Hasło musi mieć co najmniej 8 znaków!";
    } elseif (!$regulamin) {
        $error = "Musisz zaakceptować regulamin!";
    } else {
        $czyste_haslo = $haslo; // UWAGA: brak haszowania hasła

        // Przygotowanie zapytania do sprawdzenia, czy email już istnieje
        $stmt = $conn->prepare("SELECT id FROM klienci WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "Ten adres email już istnieje!";
        } else {
            // Przygotowanie zapytania INSERT do dodania nowego użytkownika
            $stmt = $conn->prepare("INSERT INTO klienci 
                (imie, nazwisko, email, haslo, telefon, typ_konta, nazwa_firmy, nip) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssss", $imie, $nazwisko, $email, $czyste_haslo, $telefon, $typ_konta, $nazwa_firmy, $nip);

            if ($stmt->execute()) {
                header("Location: logowanie.php?registered=1");
                exit();
            } else {
                $error = "Błąd przy rejestracji: " . $stmt->error;
            }
        }
        $stmt->close();
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MeatMaster - Rejestracja</title>

    <!-- Podpięcie głównego pliku stylów -->

    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="icon.png">

    <!-- Font Awesome do ikon (np. Instagram, telefon) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Style specyficzne tylko dla strony rejestracji -->
    <style>
        body {
            margin: 0;
            font-family: sans-serif;
        }

        .sekcja-rejestracji {
            padding: 80px 20px;
            background: #f5f5f5;
            min-height: 100vh;
        }

        .kontener-rejestracji {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px #ccc;
        }

        .tytul-rejestracji {
            text-align: center;
            font-size: 28px;
            color: #c00;
            margin-bottom: 20px;
        }

        .tytul-rejestracji::after {
            content: "";
            display: block;
            width: 60px;
            height: 3px;
            background: #c00;
            margin: 10px auto;
        }

        .formularz-grupa {
            margin-bottom: 15px;
        }

        .formularz-grupa label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
        }

        .formularz-grupa input,
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .podwojna-kolumna {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .przycisk-rejestracji {
            width: 100%;
            padding: 14px;
            background: #c00;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        .przycisk-rejestracji:hover {
            background: #a00;
        }

        .checkbox-grupa {
            display: flex;
            align-items: center;
            margin: 10px 0;
        }

        .checkbox-grupa input {
            margin-right: 10px;
        }

        .informacje-dodatkowe {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 4px;
            font-size: 14px;
            margin-top: 15px;
        }

        .error-message {
            color: red;
            background: #ffeeee;
            padding: 10px;
            border: 1px solid red;
            margin-bottom: 20px;
        }

        .linki-dodatkowe {
            text-align: center;
            margin-top: 20px;
        }

        .linki-dodatkowe a {
            color: #c00;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <!-- Nagłówek z logo i nawigacją -->
    <header>
        <div class="kontener naglowek-kontener">
            <div class="logo">
                <img src="Logo.png" alt="MeatMaster Logo">
            </div>
            <nav>
                <ul>
                    <!-- Linki do stron -->
                    <li><a href="Strona_glowna.php">Strona główna</a></li>
                    <li><a href="Oferta.php">Oferta</a></li>
                    <li><a href="sklep.php">Sklep</a></li>
                    <li><a href="o_nas.php">O nas</a></li>
                    <li><a href="kontakt.php">Kontakt</a></li>
                    <li><a href="faq.php">FAQ</a></li>
                    <li><a href="aktualnosci.php">Aktualności</a></li>
                    <li><a href="opinie.php">Opinie</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Sekcja rejestracji -->
    <section class="sekcja-rejestracji">
        <div class="kontener-rejestracji">
            <h2 class="tytul-rejestracji">Rejestracja konta</h2>

            <!-- Wyświetlanie błędów -->
            <?php if (isset($error)): ?>
                <div class="error-message" style="color: red; margin-bottom: 20px; padding: 10px; background: #ffeeee; border: 1px solid red;">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>




            <!-- Formularz rejestracyjny -->
            <form action="" method="POST">
                <!-- Imię i nazwisko -->
                <div class="podwojna-kolumna">
                    <div class="formularz-grupa">
                        <label for="imie">Imię <span class="wymagane">*</span></label>
                        <input type="text" id="imie" name="imie" required placeholder="Wprowadź swoje imię">
                    </div>

                    <div class="formularz-grupa">
                        <label for="nazwisko">Nazwisko <span class="wymagane">*</span></label>
                        <input type="text" id="nazwisko" name="nazwisko" required placeholder="Wprowadź swoje nazwisko">
                    </div>
                </div>

                <!-- E-mail -->
                <div class="formularz-grupa">
                    <label for="email">Adres e-mail <span class="wymagane">*</span></label>
                    <input type="email" id="email" name="email" required placeholder="Wprowadź swój e-mail">
                </div>

                <!-- Hasło i powtórzenie -->
                <div class="podwojna-kolumna">
                    <div class="formularz-grupa">
                        <label for="haslo">Hasło <span class="wymagane">*</span></label>
                        <input type="password" id="haslo" name="haslo" required placeholder="Wprowadź hasło">
                    </div>

                    <div class="formularz-grupa">
                        <label for="potwierdz-haslo">Potwierdź hasło <span class="wymagane">*</span></label>
                        <input type="password" id="potwierdz-haslo" name="potwierdz-haslo" required placeholder="Powtórz hasło">
                    </div>
                </div>

                <!-- Telefon -->
                <div class="formularz-grupa">
                    <label for="telefon">Telefon kontaktowy <span class="wymagane">*</span></label>
                    <input type="tel" id="telefon" name="telefon" required placeholder="Wprowadź numer telefonu">
                </div>

                <!-- Typ konta -->
                <div class="formularz-grupa">
                    <label for="typ-konta">Typ konta <span class="wymagane">*</span></label>
                    <select id="typ-konta" name="typ-konta" required>
                        <option value="">-- Wybierz typ konta --</option>
                        <option value="klient">Klient indywidualny</option>
                        <option value="firma">Firma/hurtownik</option>
                        <option value="restauracja">Restauracja</option>
                    </select>
                </div>

                <!-- Dodatkowe dane firmowe -->
                <div class="informacje-dodatkowe">
                    <h3>Dane firmy (wypełnij jeśli rejestrujesz konto firmowe)</h3>

                    <div class="formularz-grupa">
                        <label for="nazwa-firmy">Nazwa firmy</label>
                        <input type="text" id="nazwa-firmy" name="nazwa-firmy" placeholder="Wprowadź nazwę firmy">
                    </div>

                    <div class="formularz-grupa">
                        <label for="nip">NIP</label>
                        <input type="text" id="nip" name="nip" placeholder="Wprowadź NIP">
                    </div>
                </div>

                <!-- Checkboxy -->
                <div class="checkbox-grupa">
                    <input type="checkbox" id="regulamin" name="regulamin" required>
                    <label for="regulamin">Akceptuję <a href="regulamin.php" target="_blank">Regulamin</a> serwisu <span class="wymagane">*</span></label>
                </div>

                <div class="checkbox-grupa">
                    <input type="checkbox" id="newsletter" name="newsletter">
                    <label for="newsletter">Chcę otrzymywać newsletter z ofertami specjalnymi</label>
                </div>

                <!-- Przycisk rejestracji -->
                <button type="submit" class="przycisk-rejestracji">Zarejestruj się</button>

                <!-- Link do logowania -->
                <div class="linki-dodatkowe">
                    <span>Masz już konto?</span>
                    <a href="logowanie.php">Zaloguj się</a>
                </div>
            </form>
        </div>
    </section>

    <!-- Stopka z trzema kolumnami -->
    <footer>
        <div class="kontener">
            <div class="zawartosc-stopki">
                <!-- Kolumna kontaktowa -->
                <div class="kolumna-stopki">
                    <h3>Kontakt</h3>
                    <p><i class="fas fa-map-marker-alt"></i> ul. Mięsna 14, 69-420 Radomyśl Wielki</p>
                    <p><i class="fas fa-phone"></i> +48 694 202 137</p>
                    <p><i class="fas fa-envelope"></i> kontaktujSieWariacieEssa@meatmaster.pl</p>
                </div>

                <!-- Kolumna z godzinami otwarcia -->
                <div class="kolumna-stopki">
                    <h3>Godziny otwarcia</h3>
                    <p>Pon-Pt: 6:00 - 22:00</p>
                    <p>Sob: 7:00 - 14:00</p>
                    <p>Niedz: Zamknięte</p>
                </div>

                <!-- Kolumna z social mediami -->
                <div class="kolumna-stopki">
                    <h3>Śledź nas</h3>
                    <div class="linki-spolecznosciowe">
                        <a href="#" class="x-icon">X</a>
                        <a href="#"><i class="fab fa-tiktok"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
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