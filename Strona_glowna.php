<!DOCTYPE html>
<html lang="pl">

<head>
    <!-- Podstawowe meta tagi -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MeatMaster - Hurtownia Mięsa</title>
    
    <!-- Podpięcie arkuszy stylów -->
    <link rel="stylesheet" href="style.css"> <!-- Główny arkusz stylów -->
    <link rel="icon" type="image/png" href="icon.png"> <!-- Favicon strony -->
    
    <!-- Biblioteka ikon Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <?php
    // Rozpoczęcie sesji PHP (musi być przed jakimkolwiek outputem)
    session_start();
    ?>
</head>

<body>
    <!-- Nagłówek strony z logo i menu nawigacyjnym -->
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

    <!-- Sekcja hero z dużym zdjęciem w tle i przyciskami CTA -->
    <section class="sekcja-glowna">
        <div class="kontener zawartosc-sekcji">
            <h2>Świeże mięso do Twojego sklepu!</h2>
            <p>Najwyższej jakości produkty mięsne od sprawdzonych dostawców</p>
            
            <!-- Kontener z przyciskami Call-to-Action -->
            <div class="kontener-przyciskow">
                <a href="Oferta.php" class="przycisk">Oferta</a>
                <a href="sklep.php" class="przycisk">Sklep</a>
                <a href="faq.php" class="przycisk">FAQ</a>
                <a href="kontakt.php" class="przycisk">Kontakt</a>
            </div>
        </div>
    </section>

    <!-- Sekcja "O nas" z tekstem i zdjęciem -->
    <section class="sekcja-o-nas">
        <div class="kontener">
            <h2 class="tytul-sekcji">Hurtownia MeatMaster</h2>
            
            <div class="zawartosc-o-nas">
                <!-- Tekst informacyjny o firmie -->
                <div class="tekst-o-nas">
                    <p>Jesteśmy liderem w dostawach wysokiej jakości mięsa dla sklepów i restauracji w całym kraju. Nasza hurtownia działa na rynku od ponad 15 lat, zdobywając zaufanie setek zadowolonych klientów.</p>
                    <p>Współpracujemy wyłącznie ze sprawdzonymi hodowcami i dostawcami, co gwarantuje najwyższą jakość naszych produktów. Wszystkie mięsa przechodzą rygorystyczne kontrole weterynaryjne.</p>
                    <p>Oferujemy konkurencyjne ceny, regularne dostawy i profesjonalne doradztwo w doborze asortymentu dla Twojego biznesu.</p>
                </div>
                
                <!-- Zdjęcie ilustracyjne -->
                <div class="obraz-o-nas">
                    <img src="miecho1.avif" alt="Hurtownia mięsa">
                </div>
            </div>
        </div>
    </section>

    <!-- Sekcja z opiniami klientów -->
    <section class="sekcja-opinie">
        <div class="kontener">
            <h2 class="tytul-sekcji">Opinie naszych klientów</h2>
            
            <!-- Siatka z kartami opinii -->
            <div class="siatka-opinii">
                <!-- Opinia 1 -->
                <div class="karta-opinii">
                    <div class="tresc-opinii">
                        <p>Współpracujemy z MeatMaster od wczoraj i nigdy nie zawiedliśmy się na jakości ich produktów. Świeże mięso, terminowe dostawy i profesjonalna obsługa to ich znaki rozpoznawcze.</p>
                    </div>
                    <div class="autor-opinii">- Bonifacy Boiler, właściciel kebabowni "Kula mocy u Bonifacego"</div>
                </div>
                
                <!-- Opinia 2 -->
                <div class="karta-opinii">
                    <div class="tresc-opinii">
                        <p>Jako restauracja premium stawiamy tylko na najlepsze składniki. MeatMaster zawsze dostarcza mięso najwyższej jakości, które zachwyca naszych gości. Polecam z czystym sumieniem!</p>
                    </div>
                    <div class="autor-opinii">- Anna Nowak, szefowa kuchni "Bistro Oby piąteczka 🙏"</div>
                </div>
            </div>
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