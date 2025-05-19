<!DOCTYPE html>
<html lang="pl">

<head>
    <!-- Podstawowe meta tagi -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oferta - MeatMaster Hurtownia Mięsa</title>
    
    <!-- Podpięcie arkuszy stylów -->
    <link rel="stylesheet" href="style_oferta.css"> <!-- Główny arkusz stylów dla oferty -->
    <link rel="icon" type="image/png" href="icon.png"> <!-- Favicon strony -->
    
    <!-- Biblioteka ikon Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <?php
    // Rozpoczęcie sesji PHP (musi być przed jakimkolwiek outputem)
    session_start();
    ?>
    
    <!-- Style wewnętrzne dla przycisków -->
    <style>
        /* Style dla przycisków "Zapytaj o ofertę" */
        a.przycisk-zapytaj {
            display: inline-block;
            padding: 10px 20px;
            background-color: #d32f2f; /* Czerwony kolor */
            color: white; /* Biały tekst */
            text-decoration: none; /* Brak podkreślenia */
            border-radius: 4px; /* Zaokrąglone rogi */
            font-weight: bold; /* Pogrubienie */
            transition: background-color 0.3s; /* Efekt przejścia */
            text-align: center; /* Wyśrodkowanie tekstu */
            border: none; /* Brak obramowania */
            cursor: pointer; /* Kursor wskazujący */
            font-size: 16px; /* Rozmiar czcionki */
        }

        /* Efekt hover na przyciskach */
        a.przycisk-zapytaj:hover {
            background-color: #b71c1c; /* Ciemniejszy czerwony */
        }
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
                    <!-- Standardowe linki nawigacyjne -->
                    <li><a href="Strona_glowna.php">Strona główna</a></li>
                    <li><a href="Oferta.php">Oferta</a></li>
                    <li><a href="sklep.php">Sklep</a></li>
                    <li><a href="o_nas.php">O nas</a></li>
                    <li><a href="kontakt.php">Kontakt</a></li>
                    <li><a href="faq.php">FAQ</a></li>
                    <li><a href="aktualnosci.php">Aktualności</a></li>
                    <li><a href="opinie.php">Opinie</a></li>

                    <?php if (isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] === true): ?>
                        <!-- Link do profilu (widoczny tylko po zalogowaniu) -->
                        <li><a href="profil.php" id="profile-link"><i class="fas fa-user"></i> Profil</a></li>
                    <?php else: ?>
                        <!-- Link do logowania (widoczny tylko dla niezalogowanych) -->
                        <li><a href="logowanie.php" id="login-link"><i class="fas fa-user"></i> Logowanie</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Główna sekcja oferty -->
    <section class="sekcja-oferty">
        <div class="kontener">
            <!-- Nagłówek sekcji -->
            <h1 class="tytul-sekcji">Nasza Oferta</h1>
            <p class="podtytul">Najwyższej jakości mięso dla Twojego biznesu</p>

            <!-- Kontener kategorii produktów -->
            <div class="kategorie-produktow">
                <!-- Kategoria 1: Mięso do kebaba -->
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

                <!-- Kategoria 2: Wołowina -->
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

                <!-- Kategoria 3: Wieprzowina -->
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

                <!-- Kategoria 4: Drób -->
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

    <!-- Stopka strony -->
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
                
                <!-- Kolumna z mediami społecznościowymi -->
                <div class="kolumna-stopki">
                    <h3>Śledź nas</h3>
                    <div class="linki-spolecznosciowe">
                        <!-- Twitter (X) -->
                        <a href="#" aria-label="Twitter" class="x-icon">X</a>
                        <!-- TikTok -->
                        <a href="#" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
                        <!-- Instagram -->
                        <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
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