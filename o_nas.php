<!DOCTYPE html>
<html lang="pl">

<head>
    <!-- Podstawowe meta tagi -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>O nas - MeatMaster</title>
    
    <!-- Podpięcie arkuszy stylów -->
    <link rel="stylesheet" href="style.css"> <!-- Główny arkusz stylów -->
    <link rel="stylesheet" href="style-o_nas.css"> <!-- Specyficzny CSS dla tej strony -->
    <link rel="icon" type="image/png" href="icon.png"> <!-- Favicon strony -->
    
    <!-- Biblioteka ikon Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <?php
    // Rozpoczęcie sesji PHP (musi być przed jakimkolwiek outputem)
    session_start();
    ?>
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
                    <li><a href="o_nas.php" class="active">O nas</a></li> <!-- Aktywna strona "O nas" -->
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

    <!-- Sekcja hero z dużym zdjęciem w tle -->
    <section class="sekcja-glowna">
        <div class="kontener">
            <h1>Poznaj naszą historię</h1>
            <p class="podtytul">10 lat doświadczenia w dostarczaniu najwyższej jakości mięsa</p>
            
            <!-- Kontener z przyciskami Call-to-Action -->
            <div class="kontener-przyciskow">
                <a href="oferta.php" class="przycisk">Zobacz ofertę</a>
                <a href="kontakt.php" class="przycisk przycisk-odwrocony">Skontaktuj się</a>
            </div>
        </div>
    </section>

    <!-- Główna zawartość strony -->
    <main>
        <section class="o-nas-sekcja">
            <div class="o-nas-kontener">
                <h2 class="o-nas-tytul">O nas</h2>
                
                <div class="o-nas-zawartosc">
                    <!-- Lewa kolumna z tekstem -->
                    <div class="o-nas-tekst">
                        <!-- Sekcja "O firmie" -->
                        <article class="o-nas-artykul">
                            <h2><i class="fas fa-building"></i> O firmie</h2>
                            <p>Nasza hurtownia działa od ponad 10 lat, obsługując setki klientów w całej Polsce. Specjalizujemy się w hurtowej sprzedaży mięsa do kebaba, wołowiny, wieprzowiny oraz drobiu.</p>
                            <p>Współpracujemy z najlepszymi zakładami mięsnymi i producentami, dzięki czemu gwarantujemy najwyższą jakość naszych produktów.</p>
                        </article>

                        <!-- Sekcja "Nasze osiągnięcia" -->
                        <article class="o-nas-artykul">
                            <h2><i class="fas fa-trophy"></i> Nasze osiągnięcia</h2>
                            <ul class="o-nas-lista lista-osiagniec">
                                <li>Obsługa ponad 1200 lokali gastronomicznych w Polsce</li>
                                <li>Flota 12 nowoczesnych chłodni zapewniających dostawy w 24h</li>
                                <li>Ustanowienie rekordu Guinnessa w produkcji największej kaszanki świata (226 m, Radomyśl Wielki 2014)</li>
                                <li>Wyróżnienia za jakość i terminowość dostaw (2021, 2023)</li>
                                <li>Stale rosnąca baza klientów i partnerów handlowych</li>
                            </ul>
                        </article>

                        <!-- Sekcja "Dlaczego my?" -->
                        <article class="o-nas-artykul">
                            <h2><i class="fas fa-star"></i> Dlaczego my?</h2>
                            <ul class="o-nas-lista lista-dlaczego-my">
                                <li>Sprawdzeni dostawcy i surowce najwyższej jakości</li>
                                <li>Indywidualne podejście do klienta i elastyczność współpracy</li>
                                <li>Własne centrum logistyczne i transport w chłodni</li>
                                <li>Certyfikaty HACCP i przestrzeganie standardów sanitarnych</li>
                            </ul>
                        </article>
                    </div>

                    <!-- Prawa kolumna ze zdjęciem -->
                    <div class="o-nas-obraz">
                        <img src="firma.png" alt="Hurtownia mięsa MeatMaster">
                    </div>
                </div>
            </div>
        </section>
    </main>

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