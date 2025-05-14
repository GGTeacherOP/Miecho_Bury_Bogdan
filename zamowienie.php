<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zamówienie powiodło się - MeatMaster</title>
    <!-- Plik CSS ze stylami -->

    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="icon.png">
    <!-- Ikony Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <?php
    session_start();
    ?>

    <style>
        /* Dodatkowe style dla strony potwierdzenia */
        .sekcja-potwierdzenia {
            min-height: 60vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 50px 0;
        }

        .kontener-potwierdzenia {
            max-width: 800px;
            margin: 0 auto;
            padding: 40px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .ikonka-sukcesu {
            font-size: 80px;
            color: #4CAF50;
            margin-bottom: 20px;
        }

        .przycisk-powrotu {
            display: inline-block;
            margin-top: 30px;
            padding: 12px 30px;
            background-color: #d32f2f;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .przycisk-powrotu:hover {
            background-color: #b71c1c;
        }
    </style>
</head>

<body>
    <!-- Nagłówek strony z logo i nawigacją -->
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

                    <?php if (isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] === true): ?>
                        <li><a href="profil.php" id="profile-link"><i class="fas fa-user"></i> Profil</a></li>
                    <?php else: ?>
                        <li><a href="logowanie.php" id="login-link"><i class="fas fa-user"></i> Logowanie</a></li>
                    <?php endif; ?>

                </ul>
            </nav>
        </div>
    </header>

    <!-- Sekcja potwierdzenia zamówienia -->
    <section class="sekcja-potwierdzenia">
        <div class="kontener">
            <div class="kontener-potwierdzenia">
                <div class="ikonka-sukcesu">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h1>Zamówienie powiodło się!</h1>
                <p>Dziękujemy za złożenie zamówienia w naszej hurtowni. Twoje zamówienie zostało pomyślnie przyjęte i jest przetwarzane.</p>
                <p>W ciągu najbliższych godzin otrzymasz e-mail z potwierdzeniem zamówienia i szczegółami dostawy.</p>
                <p>W razie pytań prosimy o kontakt pod numerem telefonu: +48 694 202 137</p>
                <a href="Strona_glowna.php" class="przycisk-powrotu">Powrót do strony głównej</a>
            </div>
        </div>
    </section>

    <!-- Stopka z informacjami kontaktowymi i społecznościowymi -->
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
                <!-- Kolumna z linkami do social mediów -->
                <div class="kolumna-stopki">
                    <h3>Śledź nas</h3>
                    <div class="linki-spolecznosciowe">
                        <!-- Twitter jako X -->
                        <a href="#" aria-label="Twitter" class="x-icon">X</a>
                        <!-- TikTok -->
                        <a href="#" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
                        <!-- Instagram -->
                        <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
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