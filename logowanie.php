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
        /* Sekcja logowania - tło, odstępy i minimalna wysokość */
        .sekcja-logowania {
            padding: 80px 0;
            background: #f5f5f5;
            min-height: calc(100vh - 300px);
            /* Zapewnia minimalną wysokość, aby stopka była na dole */
        }

        /* Kontener formularza logowania */
        .kontener-logowania {
            max-width: 500px;
            margin: 0 auto;
            background: #fff;
            padding: 40px;
            border-radius: 8px;
            /* Zaokrąglenie rogów */
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            /* Cień dla kontenera */
        }

        /* Tytuł logowania */
        .tytul-logowania {
            text-align: center;
            color: #c00;
            font-size: 28px;
            margin-bottom: 30px;
        }

        /* Pionowa linia po tytule */
        .tytul-logowania::after {
            content: "";
            display: block;
            width: 60px;
            height: 3px;
            background: #c00;
            margin: 15px auto 0;
            /* Środkowanie linii */
        }

        /* Styl dla grupy formularza */
        .formularz-grupa {
            margin-bottom: 20px;
        }

        /* Stylowanie etykiety */
        .formularz-grupa label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }

        /* Stylowanie pól tekstowych w formularzu */
        .formularz-grupa input {
            width: 100%;
            /* Wypełnia całą szerokość */
            padding: 12px 15px;
            border: 1px solid #ddd;
            /* Szary obramowanie */
            border-radius: 4px;
            font-size: 16px;
        }

        /* Stylowanie pola tekstowego, gdy jest w fokusie (po kliknięciu) */
        .formularz-grupa input:focus {
            border-color: #c00;
            /* Zmiana koloru obramowania na czerwony */
            outline: none;
            /* Usunięcie domyślnego obramowania po kliknięciu */
        }

        /* Przycisk logowania */
        .przycisk-logowania {
            width: 100%;
            /* Pełna szerokość przycisku */
            padding: 14px;
            background: #c00;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            /* Wskaźnik kursora wskazujący na kliknięcie */
            transition: 0.3s;
            /* Płynna zmiana koloru tła po najechaniu */
        }

        /* Zmiana koloru przycisku po najechaniu */
        .przycisk-logowania:hover {
            background: #a00;
        }

        /* Linki dodatkowe (np. "zapomniałeś hasła") */
        .linki-dodatkowe {
            margin-top: 20px;
            text-align: center;
        }

        /* Stylowanie linków w sekcji dodatkowych linków */
        .linki-dodatkowe a {
            color: #c00;
            text-decoration: none;
            font-weight: 600;
        }

        /* Stylowanie linków po najechaniu */
        .linki-dodatkowe a:hover {
            text-decoration: underline;
        }

        /* Separator pomiędzy linkami */
        .separator {
            margin: 0 10px;
            color: #999;
        }
    </style>
</head>

<body>
    <!-- Nagłówek strony -->
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

    <!-- Sekcja logowania -->
    <section class="sekcja-logowania">
        <div class="kontener-logowania">
            <h2 class="tytul-logowania">Logowanie</h2>
            <form action="logowanie.php" method="POST">
                <div class="formularz-grupa">
                    <label for="email">Adres e-mail</label>
                    <input type="email" id="email" name="email" required placeholder="Wprowadź swój e-mail">
                </div>

                <div class="formularz-grupa">
                    <label for="haslo">Hasło</label>
                    <input type="password" id="haslo" name="haslo" required placeholder="Wprowadź swoje hasło">
                </div>

                <!-- Przycisk logowania -->
                <button type="submit" class="przycisk-logowania">Zaloguj się</button>

                <!-- Linki dodatkowe do odzyskania hasła i rejestracji -->
                <div class="linki-dodatkowe">
                    <a href="kontakt.php">Zapomniałeś hasła?</a>
                    <span class="separator">|</span>
                    <a href="rejestrowanie.php">Zarejestruj się</a>
                </div>
            </form>
        </div>
    </section>

    <!-- Stopka -->
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