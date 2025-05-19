<?php
/**
 * LOGOWANIE.PHP - SYSTEM LOGOWANIA DLA HURTOWNI MIĘSA

 * 
 * Funkcje:
 * 1. Logowanie pracowników i klientów
 * 2. Weryfikacja danych
 * 3. Ustawianie sesji użytkownika
 */

// 1. INICJALIZACJA SESJI - wymagana do przechowywania stanu logowania
session_start();

// 2. DOŁĄCZENIE PLIKU Z POŁĄCZENIEM DO BAZY DANYCH
require_once "db.php"; // Plik powinien zawierać zmienną $conn z połączeniem

// 3. INICJALIZACJA ZMIENNEJ NA KOMUNIKATY
$komunikat = ""; // Będzie przechowywać komunikaty o błędach

// 4. OBSŁUGA FORMULARZA LOGOWANIA (tylko dla żądań POST)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    // 5. POBRANIE I WALIDACJA DANYCH Z FORMULARZA
    $email = trim($_POST['email']); // Usunięcie białych znaków
    $haslo = trim($_POST['haslo']); // Usunięcie białych znaków

    // 6. SPRAWDZENIE CZY POLA NIE SĄ PUSTE
    if (empty($email) || empty($haslo)) {
        $komunikat = "Wprowadź email i hasło.";
    } else {
        // 7. PRÓBA LOGOWANIA
        
        // Zmienne na dane użytkownika
        $user = null;
        $rola = null;

        // 8. SPRAWDZENIE PRACOWNIKA
        $stmt = $conn->prepare("SELECT * FROM pracownicy WHERE email = ?");
        $stmt->bind_param("s", $email); // Zabezpieczenie przed SQL injection
        $stmt->execute();
        $result = $stmt->get_result();
        $pracownik = $result->fetch_assoc(); // Pobranie wyników

        // 9. WERYFIKACJA HASŁA PRACOWNIKA
        if ($pracownik && $pracownik['haslo'] === $haslo) {
            $user = $pracownik;
            $rola = "pracownik";
        } else {
            // 10. SPRAWDZENIE KLIENTA (jeśli nie znaleziono pracownika)
            $stmt = $conn->prepare("SELECT * FROM klienci WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $klient = $result->fetch_assoc();

            // 11. WERYFIKACJA HASŁA KLIENTA
            if ($klient && $klient['haslo'] === $haslo) {
                $user = $klient;
                $rola = "klient";
            }
        }

        // 12. JEŚLI ZNALEZIONO UŻYTKOWNIKA
        if ($user) {
            // 13. USTAWIANIE DANYCH SESYJNYCH
            $_SESSION['zalogowany'] = true; // Flaga zalogowania
            $_SESSION['rola'] = $rola;     // Rola (pracownik/klient)
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['imie'] = $user['imie'];
            $_SESSION['nazwisko'] = $user['nazwisko'];

            // 14. DODATKOWE DANE W ZALEŻNOŚCI OD ROLI
            if ($rola === 'pracownik') {
                $_SESSION['stanowisko'] = $user['stanowisko']; // Stanowisko pracownika
            } elseif ($rola === 'klient') {
                $_SESSION['typ_konta'] = $user['typ_konta'];   // Typ konta klienta
            }

            // 15. PRZEKIEROWANIE PO ZALOGOWANIU
            header("Location: Strona_glowna.php");
            exit();
        } else {
            // 16. KOMUNIKAT O BŁĘDNYM LOGOWANIU
            $komunikat = "Nieprawidłowy email lub hasło.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <!-- 1. METADANE STRONY -->
    <meta charset="UTF-8"> <!-- Kodowanie znaków UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Responsywność -->
    <title>MeatMaster - Logowanie</title> <!-- Tytuł strony -->
    
    <!-- 2. ARKUSZE STYLÓW -->
    <link rel="stylesheet" href="style.css"> <!-- Główny arkusz stylów -->
    <link rel="icon" type="image/png" href="icon.png"> <!-- Favicon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"> <!-- Ikony FontAwesome -->
    
    <style>
        /* 3. STYL KOMUNIKATU BŁĘDU */
        .komunikat-blad {
            background: #ffdddd; /* Jasnoczerwone tło */
            color: #c00;       /* Ciemnoczerwony tekst */
            padding: 10px;     /* Wewnętrzny odstęp */
            border: 1px solid #c00; /* Czerwona obramówka */
            border-radius: 4px; /* Zaokrąglone rogi */
            margin-bottom: 20px; /* Odstęp od dołu */
            text-align: center; /* Wyśrodkowany tekst */
        }

        /* 4. SEKCJA LOGOWANIA */
        .sekcja-logowania {
            padding: 80px 0; /* Odstępy góra-dół */
            background: #f5f5f5; /* Szare tło */
            min-height: calc(100vh - 300px); /* Minimalna wysokość */
        }

        /* 5. KONTENER FORMULARZA */
        .kontener-logowania {
            max-width: 500px; /* Maksymalna szerokość */
            margin: 0 auto; /* Wyśrodkowanie */
            background: #fff; /* Białe tło */
            padding: 40px; /* Wewnętrzny odstęp */
            border-radius: 8px; /* Zaokrąglone rogi */
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1); /* Cień */
        }

        /* 6. TYTUŁ FORMULARZA */
        .tytul-logowania {
            text-align: center; /* Wyśrodkowanie */
            color: #c00; /* Czerwony kolor */
            font-size: 28px; /* Rozmiar czcionki */
            margin-bottom: 30px; /* Odstęp od dołu */
        }

        /* 7. DEKORACJA POD TYTUŁEM */
        .tytul-logowania::after {
            content: ""; /* Pseudoelement */
            display: block; /* Element blokowy */
            width: 60px; /* Szerokość linii */
            height: 3px; /* Wysokość linii */
            background: #c00; /* Czerwony kolor */
            margin: 15px auto 0; /* Marginesy */
        }

        /* 8. GRUPA POLA FORMULARZA */
        .formularz-grupa {
            margin-bottom: 20px; /* Odstęp między grupami */
        }

        /* 9. ETYKIETA POLA */
        .formularz-grupa label {
            display: block; /* Element blokowy */
            margin-bottom: 8px; /* Odstęp od pola */
            font-weight: 600; /* Pogrubienie */
            color: #333; /* Kolor tekstu */
        }

        /* 10. POLE WEJŚCIOWE */
        .formularz-grupa input {
            width: 100%; /* Pełna szerokość */
            padding: 12px 15px; /* Wewnętrzny odstęp */
            border: 1px solid #ddd; /* Szara obramówka */
            border-radius: 4px; /* Zaokrąglone rogi */
            font-size: 16px; /* Rozmiar czcionki */
        }

        /* 11. STYL AKTYWNEGO POLA */
        .formularz-grupa input:focus {
            border-color: #c00; /* Czerwona obramówka */
            outline: none; /* Usunięcie domyślnego stylu */
        }

        /* 12. PRZYCISK LOGOWANIA */
        .przycisk-logowania {
            width: 100%; /* Pełna szerokość */
            padding: 14px; /* Wewnętrzny odstęp */
            background: #c00; /* Czerwone tło */
            color: #fff; /* Biały tekst */
            border: none; /* Brak obramowania */
            border-radius: 4px; /* Zaokrąglone rogi */
            font-size: 16px; /* Rozmiar czcionki */
            font-weight: 600; /* Pogrubienie */
            cursor: pointer; /* Kursor wskazujący */
            transition: 0.3s; /* Animacja hover */
        }

        /* 13. EFEKT HOVER PRZYCISKU */
        .przycisk-logowania:hover {
            background: #a00; /* Ciemniejszy czerwony */
        }

        /* 14. LINKI DODATKOWE */
        .linki-dodatkowe {
            margin-top: 20px; /* Odstęp od góry */
            text-align: center; /* Wyśrodkowanie */
        }

        /* 15. STYL LINKÓW */
        .linki-dodatkowe a {
            color: #c00; /* Czerwony kolor */
            text-decoration: none; /* Brak podkreślenia */
            font-weight: 600; /* Pogrubienie */
        }

        /* 16. EFEKT HOVER LINKÓW */
        .linki-dodatkowe a:hover {
            text-decoration: underline; /* Podkreślenie */
        }

        /* 17. SEPARATOR MIĘDZY LINKAMI */
        .separator {
            margin: 0 10px; /* Odstępy po bokach */
            color: #999; /* Szary kolor */
        }
    </style>
</head>

<body>
    <!-- 18. NAGŁÓWEK STRONY -->
    <header>
        <div class="kontener naglowek-kontener">
            <!-- Logo firmy -->
            <div class="logo">
                <img src="Logo.png" alt="MeatMaster Logo">
            </div>
            
            <!-- 19. GŁÓWNA NAWIGACJA -->
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

    <!-- 20. SEKCJA FORMULARZA LOGOWANIA -->
    <section class="sekcja-logowania">
        <div class="kontener-logowania">
            <h2 class="tytul-logowania">Logowanie</h2>

            <!-- 21. WYŚWIETLANIE KOMUNIKATÓW BŁĘDÓW -->
            <?php if (!empty($komunikat)): ?>
                <div class="komunikat-blad"><?php echo htmlspecialchars($komunikat); ?></div>
            <?php endif; ?>

            <!-- 22. FORMULARZ LOGOWANIA -->
            <form action="" method="POST">
                <!-- 23. GRUPA POLA EMAIL -->
                <div class="formularz-grupa">
                    <label for="email">Adres e-mail</label>
                    <input type="email" id="email" name="email" required placeholder="Wprowadź swój e-mail">
                </div>

                <!-- 24. GRUPA POLA HASŁA -->
                <div class="formularz-grupa">
                    <label for="haslo">Hasło</label>
                    <input type="password" id="haslo" name="haslo" required placeholder="Wprowadź swoje hasło">
                </div>

                <!-- 25. PRZYCISK WYŚLIJ -->
                <button type="submit" class="przycisk-logowania">Zaloguj się</button>

                <!-- 26. LINKI DODATKOWE -->
                <div class="linki-dodatkowe">
                    <a href="kontakt.php">Zapomniałeś hasła?</a>
                    <span class="separator">|</span>
                    <a href="rejestrowanie.php">Zarejestruj się</a>
                </div>
            </form>
        </div>
    </section>

    <!-- 27. STOPKA STRONY -->
    <footer>
        <div class="kontener">
            <div class="zawartosc-stopki">
                <!-- 28. DANE KONTAKTOWE -->
                <div class="kolumna-stopki">
                    <h3>Kontakt</h3>
                    <p><i class="fas fa-map-marker-alt"></i> ul. Mięsna 14, 69-420 Radomyśl Wielki</p>
                    <p><i class="fas fa-phone"></i> +48 694 202 137</p>
                    <p><i class="fas fa-envelope"></i> kontaktujSieWariacieEssa@meatmaster.pl</p>
                </div>
                
                <!-- 29. GODZINY OTWARCIA -->
                <div class="kolumna-stopki">
                    <h3>Godziny otwarcia</h3>
                    <p>Pon-Pt: 6:00 - 22:00</p>
                    <p>Sob: 7:00 - 14:00</p>
                    <p>Niedz: Zamknięte</p>
                </div>
                
                <!-- 30. LINKI DO SOCIAL MEDIÓW -->
                <div class="kolumna-stopki">
                    <h3>Śledź nas</h3>
                    <div class="linki-spolecznosciowe">
                        <a href="#" aria-label="Twitter" class="x-icon">X</a>
                        <a href="#" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
                        <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            
            <!-- 31. PRAWA AUTORSKIE -->
            <div class="prawa-autorskie">
                <p>&copy; 2025 MeatMaster - Hurtownia Mięsa. Wszelkie prawa zastrzeżone.</p>
            </div>
        </div>
    </footer>
</body>
</html>