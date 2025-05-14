<?php
session_start();
require_once "db.php"; // upewnij się, że ten plik zawiera połączenie z bazą

$komunikat = "";

// Obsługa formularza logowania
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);
    $haslo = trim($_POST['haslo']);

    if (empty($email) || empty($haslo)) {
        $komunikat = "Wprowadź email i hasło.";
    } else {
        $user = null;
        $rola = null;

        // Sprawdź PRACOWNIKA
        $stmt = $conn->prepare("SELECT * FROM pracownicy WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $pracownik = $result->fetch_assoc();

        if ($pracownik && $pracownik['haslo'] === $haslo) {
            $user = $pracownik;
            $rola = "pracownik";
        } else {
            // Sprawdź KLIENTA
            $stmt = $conn->prepare("SELECT * FROM klienci WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $klient = $result->fetch_assoc();

            if ($klient && $klient['haslo'] === $haslo) {
                $user = $klient;
                $rola = "klient";
            }
        }

        if ($user) {
            $_SESSION['zalogowany'] = true;
            $_SESSION['rola'] = $rola;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['imie'] = $user['imie'];
            $_SESSION['nazwisko'] = $user['nazwisko'];

            header("Location: Strona_glowna.php");
            exit();
        } else {
            $komunikat = "Nieprawidłowy email lub hasło.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MeatMaster - Logowanie</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="icon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Styl komunikatu błędu */
        .komunikat-blad {
            background: #ffdddd;
            color: #c00;
            padding: 10px;
            border: 1px solid #c00;
            border-radius: 4px;
            margin-bottom: 20px;
            text-align: center;
        }

        .sekcja-logowania {
            padding: 80px 0;
            background: #f5f5f5;
            min-height: calc(100vh - 300px);
        }

        .kontener-logowania {
            max-width: 500px;
            margin: 0 auto;
            background: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .tytul-logowania {
            text-align: center;
            color: #c00;
            font-size: 28px;
            margin-bottom: 30px;
        }

        .tytul-logowania::after {
            content: "";
            display: block;
            width: 60px;
            height: 3px;
            background: #c00;
            margin: 15px auto 0;
        }

        .formularz-grupa {
            margin-bottom: 20px;
        }

        .formularz-grupa label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }

        .formularz-grupa input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        .formularz-grupa input:focus {
            border-color: #c00;
            outline: none;
        }

        .przycisk-logowania {
            width: 100%;
            padding: 14px;
            background: #c00;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
        }

        .przycisk-logowania:hover {
            background: #a00;
        }

        .linki-dodatkowe {
            margin-top: 20px;
            text-align: center;
        }

        .linki-dodatkowe a {
            color: #c00;
            text-decoration: none;
            font-weight: 600;
        }

        .linki-dodatkowe a:hover {
            text-decoration: underline;
        }

        .separator {
            margin: 0 10px;
            color: #999;
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
                </ul>
            </nav>
        </div>
    </header>

    <!-- FORMULARZ LOGOWANIA -->
    <section class="sekcja-logowania">
        <div class="kontener-logowania">
            <h2 class="tytul-logowania">Logowanie</h2>

            <?php if (!empty($komunikat)): ?>
                <div class="komunikat-blad"><?php echo htmlspecialchars($komunikat); ?></div>
            <?php endif; ?>

            <form action="" method="POST">
                <div class="formularz-grupa">
                    <label for="email">Adres e-mail</label>
                    <input type="email" id="email" name="email" required placeholder="Wprowadź swój e-mail">
                </div>

                <div class="formularz-grupa">
                    <label for="haslo">Hasło</label>
                    <input type="password" id="haslo" name="haslo" required placeholder="Wprowadź swoje hasło">
                </div>

                <button type="submit" class="przycisk-logowania">Zaloguj się</button>

                <div class="linki-dodatkowe">
                    <a href="kontakt.php">Zapomniałeś hasła?</a>
                    <span class="separator">|</span>
                    <a href="rejestrowanie.php">Zarejestruj się</a>
                </div>
            </form>
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
</body>

</html>