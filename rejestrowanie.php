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
        /* Sekcja rejestracji użytkownika */
        .sekcja-rejestracji {
            padding: 80px 0;
            background: #f5f5f5;
            min-height: calc(100vh - 300px);
            /* pełna wysokość minus nagłówek i stopka */
        }

        .kontener-rejestracji {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            /* delikatny cień dla estetyki */
        }

        .tytul-rejestracji {
            text-align: center;
            color: #c00;
            font-size: 28px;
            margin-bottom: 30px;
        }

        .tytul-rejestracji::after {
            content: "";
            display: block;
            width: 60px;
            height: 3px;
            background: #c00;
            margin: 15px auto 0;
            /* pasek dekoracyjny pod tytułem */
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

        .formularz-grupa input,
        .formularz-grupa select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        /* Podświetlenie pola przy aktywności */
        .formularz-grupa input:focus,
        .formularz-grupa select:focus {
            border-color: #c00;
            outline: none;
        }

        .podwojna-kolumna {
            display: grid;
            grid-template-columns: 1fr 1fr;
            /* dwa równe pola obok siebie */
            gap: 20px;
            /* odstęp między nimi */
        }

        .przycisk-rejestracji {
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
            margin-top: 10px;
        }

        .przycisk-rejestracji:hover {
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

        .wymagane {
            color: #c00;
        }

        .informacje-dodatkowe {
            margin-top: 30px;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 4px;
            font-size: 14px;
        }

        .checkbox-grupa {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .checkbox-grupa input {
            width: auto;
            margin-right: 10px;
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

            <!-- Formularz rejestracyjny -->
            <form action="rejestracja.php" method="POST">
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