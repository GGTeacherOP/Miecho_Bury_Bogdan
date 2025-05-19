<?php
// Włączenie wyświetlania wszystkich błędów PHP (tylko do celów developerskich)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Sprawdzamy czy formularz został wysłany metodą POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Nawiązanie połączenia z bazą danych MySQL
    $conn = new mysqli("localhost", "root", "", "meatmasters");

    // Obsługa błędu połączenia
    if ($conn->connect_error) {
        die("Błąd połączenia: " . $conn->connect_error);
    }

    // Funkcja czyszcząca dane wejściowe (usuwa białe znaki i konwertuje znaki specjalne)
    function clean($dane) {
        return htmlspecialchars(trim($dane));
    }

    // Pobieranie i czyszczenie danych z formularza:
    $imie = clean($_POST['imie']);
    $nazwisko = clean($_POST['nazwisko']);
    $email = clean($_POST['email']);
    // Hasła nie czyścimy, aby nie modyfikować specjalnych znaków w haśle
    $haslo = $_POST['haslo']; 
    $potwierdz_haslo = $_POST['potwierdz-haslo'];
    $telefon = clean($_POST['telefon']);
    $typ_formularza = clean($_POST['typ-konta']);

    // Mapowanie wartości z formularza na wartości ENUM w bazie danych
    $mapa_typow = [
        'klient' => 'klient indywidualny',
        'firma' => 'firma/hurtownia',
        'restauracja' => 'restauracja'
    ];

    // Ustalenie typu konta z domyślną wartością 'klient indywidualny'
    $typ_konta = $mapa_typow[$typ_formularza] ?? 'klient indywidualny';

    // Pobieranie opcjonalnych danych firmy (jeśli istnieją)
    $nazwa_firmy = !empty($_POST['nazwa-firmy']) ? clean($_POST['nazwa-firmy']) : null;
    $nip = !empty($_POST['nip']) ? clean($_POST['nip']) : null;
    // Sprawdzenie czy checkbox regulaminu jest zaznaczony
    $regulamin = isset($_POST['regulamin']);

    // Walidacja danych:
    if ($haslo !== $potwierdz_haslo) {
        $error = "Hasła nie są takie same!";
    } elseif (strlen($haslo) < 8) {
        $error = "Hasło musi mieć co najmniej 8 znaków!";
    } elseif (!$regulamin) {
        $error = "Musisz zaakceptować regulamin!";
    } else {
        // Przypisanie hasła bez haszowania (UWAGA: to jest niebezpieczne w prawdziwej aplikacji)
        $czyste_haslo = $haslo;

        // Sprawdzenie unikalności emaila w bazie danych
        $stmt = $conn->prepare("SELECT id FROM klienci WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "Ten adres email już istnieje!";
        } else {
            // Przygotowanie zapytania INSERT
            $stmt = $conn->prepare("INSERT INTO klienci 
                (imie, nazwisko, email, haslo, telefon, typ_konta, nazwa_firmy, nip) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssss", $imie, $nazwisko, $email, $czyste_haslo, $telefon, $typ_konta, $nazwa_firmy, $nip);

            // Wykonanie zapytania i przekierowanie po sukcesie
            if ($stmt->execute()) {
                header("Location: logowanie.php?registered=1");
                exit();
            } else {
                $error = "Błąd przy rejestracji: " . $stmt->error;
            }
        }
        $stmt->close();
    }

    // Zamknięcie połączenia z bazą danych
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <!-- Podstawowe meta tagi -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MeatMaster - Rejestracja</title>
    
    <!-- Podpięcie zewnętrznych zasobów -->
    <link rel="stylesheet" href="style.css"> <!-- Główny arkusz stylów -->
    <link rel="icon" type="image/png" href="icon.png"> <!-- Favicon -->
    <!-- Biblioteka ikon Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Style wewnętrzne specyficzne dla tej strony -->
    <style>
        /* Reset marginesów dla całej strony */
        body {
            margin: 0;
            font-family: sans-serif;
        }

        /* Styl sekcji rejestracji - tło i odstępy */
        .sekcja-rejestracji {
            padding: 80px 20px;
            background: #f5f5f5;
            min-height: 100vh;
        }

        /* Kontener formularza - białe tło z cieniem */
        .kontener-rejestracji {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px #ccc;
        }

        /* Tytuł formularza - stylizacja */
        .tytul-rejestracji {
            text-align: center;
            font-size: 28px;
            color: #c00;
            margin-bottom: 20px;
        }
        /* Dekoracyjna linia pod tytułem */
        .tytul-rejestracji::after {
            content: "";
            display: block;
            width: 60px;
            height: 3px;
            background: #c00;
            margin: 10px auto;
        }

        /* Styl grupy formularza (etykieta + input) */
        .formularz-grupa {
            margin-bottom: 15px;
        }
        /* Styl etykiet formularza */
        .formularz-grupa label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
        }
        /* Styl inputów i selectów */
        .formularz-grupa input,
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        /* Układ dwóch kolumn dla niektórych pól */
        .podwojna-kolumna {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        /* Przycisk rejestracji */
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
        /* Efekt hover dla przycisku */
        .przycisk-rejestracji:hover {
            background: #a00;
        }

        /* Styl checkboxów */
        .checkbox-grupa {
            display: flex;
            align-items: center;
            margin: 10px 0;
        }
        .checkbox-grupa input {
            margin-right: 10px;
        }

        /* Sekcja dodatkowych informacji */
        .informacje-dodatkowe {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 4px;
            font-size: 14px;
            margin-top: 15px;
        }

        /* Komunikat o błędzie */
        .error-message {
            color: red;
            background: #ffeeee;
            padding: 10px;
            border: 1px solid red;
            margin-bottom: 20px;
        }

        /* Linki dodatkowe pod formularzem */
        .linki-dodatkowe {
            text-align: center;
            margin-top: 20px;
        }
        .linki-dodatkowe a {
            color: #c00;
            text-decoration: none;
            font-weight: bold;
        }

        /* Responsywność - brak specjalnych reguł, zakładamy że layout jest responsywny */
    </style>
</head>

<body>
    <!-- Nagłówek strony -->
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
                </ul>
            </nav>
        </div>
    </header>

    <!-- Główna sekcja z formularzem rejestracji -->
    <section class="sekcja-rejestracji">
        <div class="kontener-rejestracji">
            <!-- Tytuł formularza -->
            <h2 class="tytul-rejestracji">Rejestracja konta</h2>

            <!-- Wyświetlanie błędów (jeśli istnieją) -->
            <?php if (isset($error)): ?>
                <div class="error-message">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <!-- Formularz rejestracyjny -->
            <form action="" method="POST">
                <!-- Sekcja imienia i nazwiska w dwóch kolumnach -->
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

                <!-- Pole email -->
                <div class="formularz-grupa">
                    <label for="email">Adres e-mail <span class="wymagane">*</span></label>
                    <input type="email" id="email" name="email" required placeholder="Wprowadź swój e-mail">
                </div>

                <!-- Sekcja haseł w dwóch kolumnach -->
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

                <!-- Pole telefonu -->
                <div class="formularz-grupa">
                    <label for="telefon">Telefon kontaktowy <span class="wymagane">*</span></label>
                    <input type="tel" id="telefon" name="telefon" required placeholder="Wprowadź numer telefonu">
                </div>

                <!-- Wybór typu konta -->
                <div class="formularz-grupa">
                    <label for="typ-konta">Typ konta <span class="wymagane">*</span></label>
                    <select id="typ-konta" name="typ-konta" required>
                        <option value="">-- Wybierz typ konta --</option>
                        <option value="klient">Klient indywidualny</option>
                        <option value="firma">Firma/hurtownik</option>
                        <option value="restauracja">Restauracja</option>
                    </select>
                </div>

                <!-- Sekcja dodatkowych danych firmowych -->
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

                <!-- Przycisk submit -->
                <button type="submit" class="przycisk-rejestracji">Zarejestruj się</button>

                <!-- Link do logowania -->
                <div class="linki-dodatkowe">
                    <span>Masz już konto?</span>
                    <a href="logowanie.php">Zaloguj się</a>
                </div>
            </form>
        </div>
    </section>

    <!-- Stopka strony -->
    <footer>
        <div class="kontener">
            <div class="zawartosc-stopki">
                <!-- Kolumna z danymi kontaktowymi -->
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

                <!-- Kolumna z mediami społecznościowymi -->
                <div class="kolumna-stopki">
                    <h3>Śledź nas</h3>
                    <div class="linki-spolecznosciowe">
                        <a href="#" class="x-icon">X</a>
                        <a href="#"><i class="fab fa-tiktok"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>

            <!-- Informacja o prawach autorskich -->
            <div class="prawa-autorskie">
                <p>&copy; 2025 MeatMaster - Hurtownia Mięsa. Wszelkie prawa zastrzeżone.</p>
            </div>
        </div>
    </footer>
</body>
</html>