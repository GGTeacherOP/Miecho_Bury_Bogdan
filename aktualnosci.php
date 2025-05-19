<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Podstawowe meta tagi -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aktualności</title>
    
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

    <!-- Sekcja hero z dużym zdjęciem w tle -->
    <section class="sekcja-glowna">
        <div class="kontener">
            <h2>Świeże mięso do Twojego sklepu!</h2>
            <p>Najwyższej jakości produkty mięsne od sprawdzonych dostawców</p>
            
            <!-- Kontener z przyciskami Call-to-Action -->
            <div class="kontener-przyciskow">
                <a href="oferta.php" class="przycisk">Oferta</a>
                <a href="sklep.php" class="przycisk">Sklep</a>
                <a href="faq.php" class="przycisk">FAQ</a>
                <a href="kontakt.php" class="przycisk">Kontakt</a>
            </div>
        </div>
    </section>

    <!-- Główna zawartość strony -->
    <main>
        <!-- Sekcja z aktualnościami -->
        <section class="sekcja-o-nas">
            <div class="kontener">
                <h2 class="tytul-sekcji">Aktualności</h2>
                
                <!-- Siatka z kartami aktualności -->
                <div class="siatka-opinii">
                    <!-- Aktualność 1 -->
                    <div class="karta-opinii">
                        <div class="tresc-opinii">
                            <p><strong>Nowość:</strong> Wprowadziliśmy mięso z jelenia – świeże, pakowane próżniowo, idealne dla restauracji premium.</p>
                        </div>
                        <div class="autor-opinii">04.05.2025</div>
                    </div>
                    
                    <!-- Aktualność 2 -->
                    <div class="karta-opinii">
                        <div class="tresc-opinii">
                            <p><strong>Promocja:</strong> Tylko w tym tygodniu – udka z kurczaka -10% przy zamówieniach powyżej 30 kg!</p>
                        </div>
                        <div class="autor-opinii">02.05.2025</div>
                    </div>
                    
                    <!-- Aktualność 3 -->
                    <div class="karta-opinii">
                        <div class="tresc-opinii">
                            <p><strong>Nowy dział:</strong> Dodaliśmy mięso BIO z certyfikowanych gospodarstw ekologicznych.</p>
                        </div>
                        <div class="autor-opinii">01.05.2025</div>
                    </div>
                    
                    <!-- Aktualność 4 -->
                    <div class="karta-opinii">
                        <div class="tresc-opinii">
                            <p><strong>Zmiana godzin:</strong> Od 6 maja pracujemy również w soboty od 7:00 do 13:00.</p>
                        </div>
                        <div class="autor-opinii">30.04.2025</div>
                    </div>
                    
                    <!-- Aktualność 5 -->
                    <div class="karta-opinii">
                        <div class="tresc-opinii">
                            <p><strong>Dostawy:</strong> Nowy rejon – dostarczamy teraz również na terenie woj. lubelskiego!</p>
                        </div>
                        <div class="autor-opinii">28.04.2025</div>
                    </div>
                    
                    <!-- Aktualność 6 -->
                    <div class="karta-opinii">
                        <div class="tresc-opinii">
                            <p><strong>Nowa oferta:</strong> Mięso mielone do burgerów – 100% wołowina, pakowane po 5 kg, dostępne od zaraz.</p>
                        </div>
                        <div class="autor-opinii">26.04.2025</div>
                    </div>
                    
                    <!-- Aktualność 7 -->
                    <div class="karta-opinii">
                        <div class="tresc-opinii">
                            <p><strong>Certyfikat:</strong> Uzyskaliśmy nowy certyfikat jakości HACCP – gwarancja bezpieczeństwa i świeżości.</p>
                        </div>
                        <div class="autor-opinii">24.04.2025</div>
                    </div>
                    
                    <!-- Aktualność 8 -->
                    <div class="karta-opinii">
                        <div class="tresc-opinii">
                            <p><strong>Aktualizacja sklepu:</strong> Nowy wygląd i łatwiejszy proces składania zamówień. Sprawdź już teraz!</p>
                        </div>
                        <div class="autor-opinii">22.04.2025</div>
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