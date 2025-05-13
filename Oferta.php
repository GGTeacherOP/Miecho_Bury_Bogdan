<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oferta - MeatMaster Hurtownia Mięsa</title>
    <link rel="stylesheet" href="style_oferta.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Dodatkowe style aby linki wyglądały jak przyciski */
        a.przycisk-zapytaj {
            display: inline-block;
            padding: 10px 20px;
            background-color: #d32f2f;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
            transition: background-color 0.3s;
            text-align: center;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }

        a.przycisk-zapytaj:hover {
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
                    <li><a href="onas.php">O nas</a></li>
                    <li><a href="kontakt.php">Kontakt</a></li>
                    <li><a href="faq.php">FAQ</a></li>
                    <li><a href="aktualnosci.php">Aktualności</a></li>
                    <li><a href="logowanie.php" id="login-link"><i class="fas fa-user"></i> Logowanie</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Sekcja główna oferty -->
    <section class="sekcja-oferty">
        <div class="kontener">
            <h1 class="tytul-sekcji">Nasza Oferta</h1>
            <p class="podtytul">Najwyższej jakości mięso dla Twojego biznesu</p>

            <!-- Kategorie produktów -->
            <div class="kategorie-produktow">
                <!-- Kategoria 1 -->
                <div class="kategoria">
                    <h2 class="nazwa-kategorii">Mięso do kebaba</h2>
                    <div class="produkty-siatka">
                        <!-- Produkt 1 -->
                        <div class="produkt-karta">
                            <div class="produkt-obraz">
                                <img src="kebabwol.jpg" alt="Mięso do kebaba klasyczne">
                            </div>
                            <div class="produkt-info">
                                <h3>Mieszanka do kebaba klasycznego</h3>
                                <p class="produkt-opis">Idealna proporcja mięsa wieprzowego i drobiowego</p>
                                <p class="produkt-cena">Zapytaj o ofertę</p>
                                <a href="kontakt.php" class="przycisk-zapytaj">Zapytaj</a>
                            </div>
                        </div>
                        <!-- Produkt 2 -->
                        <div class="produkt-karta">
                            <div class="produkt-obraz">
                                <img src="kabab-drobiowy.jpg" alt="Mięso do kebaba drobiowego">
                            </div>
                            <div class="produkt-info">
                                <h3>Mieszanka do kebaba drobiowego</h3>
                                <p class="produkt-opis">100% filet z kurczaka, delikatna marynata</p>
                                <p class="produkt-cena">Zapytaj o ofertę</p>
                                <a href="kontakt.php" class="przycisk-zapytaj">Zapytaj</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kategoria 2 -->
                <div class="kategoria">
                    <h2 class="nazwa-kategorii">Wołowina</h2>
                    <div class="produkty-siatka">
                        <!-- Produkt 1 -->
                        <div class="produkt-karta">
                            <div class="produkt-obraz">
                                <img src="rostbef.jpg" alt="Rostbef wołowy">
                            </div>
                            <div class="produkt-info">
                                <h3>Rostbef wołowy</h3>
                                <p class="produkt-opis">Klasa premium, idealny do steków</p>
                                <p class="produkt-cena">89.99 zł/kg</p>
                                <a href="kontakt.php" class="przycisk-zapytaj">Zapytaj</a>
                            </div>
                        </div>
                        <!-- Produkt 2 -->
                        <div class="produkt-karta">
                            <div class="produkt-obraz">
                                <img src="mielonka-wolowa.jpg" alt="Mielonka wołowa">
                            </div>
                            <div class="produkt-info">
                                <h3>Mielonka wołowa</h3>
                                <p class="produkt-opis">Świeża mielonka 100% wołowina</p>
                                <p class="produkt-cena">34.99 zł/kg</p>
                                <a href="kontakt.php" class="przycisk-zapytaj">Zapytaj</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kategoria 3 -->
                <div class="kategoria">
                    <h2 class="nazwa-kategorii">Wieprzowina</h2>
                    <div class="produkty-siatka">
                        <!-- Produkt 1 -->
                        <div class="produkt-karta">
                            <div class="produkt-obraz">
                                <img src="schab.jpg" alt="Schab wieprzowy">
                            </div>
                            <div class="produkt-info">
                                <h3>Schab wieprzowy</h3>
                                <p class="produkt-opis">Świeży schab bez kości</p>
                                <p class="produkt-cena">29.99 zł/kg</p>
                                <a href="kontakt.php" class="przycisk-zapytaj">Zapytaj</a>
                            </div>
                        </div>
                        <!-- Produkt 2 -->
                        <div class="produkt-karta">
                            <div class="produkt-obraz">
                                <img src="karkowka.jpg" alt="Karkówka wieprzowa">
                            </div>
                            <div class="produkt-info">
                                <h3>Karkówka wieprzowa</h3>
                                <p class="produkt-opis">Mięso idealne do grillowania</p>
                                <p class="produkt-cena">27.99 zł/kg</p>
                                <a href="kontakt.php" class="przycisk-zapytaj">Zapytaj</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kategoria 4 -->
                <div class="kategoria">
                    <h2 class="nazwa-kategorii">Drób</h2>
                    <div class="produkty-siatka">
                        <!-- Produkt 1 -->
                        <div class="produkt-karta">
                            <div class="produkt-obraz">
                                <img src="filet-z-kurczaka.jpg" alt="Filet z kurczaka">
                            </div>
                            <div class="produkt-info">
                                <h3>Filet z kurczaka</h3>
                                <p class="produkt-opis">Świeże filety bez skóry</p>
                                <p class="produkt-cena">25.99 zł/kg</p>
                                <a href="kontakt.php" class="przycisk-zapytaj">Zapytaj</a>
                            </div>
                        </div>
                        <!-- Produkt 2 -->
                        <div class="produkt-karta">
                            <div class="produkt-obraz">
                                <img src="udka-z-kurczaka.jpg" alt="Udka z kurczaka">
                            </div>
                            <div class="produkt-info">
                                <h3>Udka z kurczaka</h3>
                                <p class="produkt-opis">Udka ze skórą, idealne do pieczenia</p>
                                <p class="produkt-cena">18.99 zł/kg</p>
                                <a href="kontakt.php" class="przycisk-zapytaj">Zapytaj</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Sekcja kontaktowa -->
    <section class="sekcja-kontaktowa">
        <div class="kontener">
            <h2>Masz pytania dotyczące oferty?</h2>
            <p>Skontaktuj się z naszym działem handlowym</p>
            <a href="kontakt.php" class="przycisk">Kontakt</a>
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