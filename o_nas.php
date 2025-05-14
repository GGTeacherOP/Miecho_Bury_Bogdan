<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>O nas - MeatMaster</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="icon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <?php
    session_start();
    ?>

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

                    <?php if (isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] === true): ?>
                        <li><a href="profil.php" id="profile-link"><i class="fas fa-user"></i> Profil</a></li>
                    <?php else: ?>
                        <li><a href="logowanie.php" id="login-link"><i class="fas fa-user"></i> Logowanie</a></li>
                    <?php endif; ?>

                </ul>
            </nav>
        </div>
    </header>
    <section class="sekcja-glowna">
        <div class="kontener">
            <h2>Świeże mięso do Twojego sklepu!</h2>
            <p>Najwyższej jakości produkty mięsne od sprawdzonych dostawców</p>
            <div class="kontener-przyciskow">
                <a href="oferta.php" class="przycisk">Oferta</a>
                <a href="sklep.php " class="przycisk">Sklep</a>
                <a href="faq.php" class="przycisk">FAQ</a>
                <a href="kontakt.php" class="przycisk">Kontakt</a>
            </div>
        </div>
    </section>
    <main>
        <section class="sekcja-o-nas">
            <div class="kontener">
                <h2 class="tytul-sekcji">O nas</h2>
                <div class="zawartosc-o-nas">
                    <div class="tekst-o-nas">
                        <h2>O firmie</h2>
                        <p>Nasza hurtownia działa od ponad 10 lat, obsługując setki klientów w całej Polsce. Specjalizujemy się w hurtowej sprzedaży mięsa do kebaba, wołowiny, wieprzowiny oraz drobiu.</p>
                        <p>Współpracujemy z najlepszymi zakładami mięsnymi i producentami, dzięki czemu gwarantujemy najwyższą jakość naszych produktów.</p>

                        <h2>Nasze osiągnięcia</h2>
                        <ul>
                            <li>Obsługa ponad 1200 lokali gastronomicznych w Polsce.</li>
                            <li>Flota 12 nowoczesnych chłodni zapewniających dostawy w 24h.</li>
                            <li>Wyróżnienia za jakość i terminowość dostaw (2021, 2023).</li>
                            <li>Stale rosnąca baza klientów i partnerów handlowych.</li>
                        </ul>

                        <h2>Dlaczego my?</h2>
                        <ul>
                            <li>Sprawdzeni dostawcy i surowce najwyższej jakości.</li>
                            <li>Indywidualne podejście do klienta i elastyczność współpracy.</li>
                            <li>Własne centrum logistyczne i transport w chłodni.</li>
                            <li>Certyfikaty HACCP i przestrzeganie standardów sanitarnych.</li>
                        </ul>

                        <p>Zapraszamy do współpracy i poznania naszej pełnej oferty. Zaufaj doświadczeniu i jakości, które tworzymy z myślą o Twoim biznesie.</p>
                    </div>
                    <div class="obraz-o-nas">
                        <img src="firma.png" alt="Hurtownia mięsa">
                    </div>
                </div>
            </div>
        </section>
    </main>
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