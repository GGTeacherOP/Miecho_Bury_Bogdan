<?php
// Rozpoczęcie sesji PHP (musi być przed jakimkolwiek outputem)
session_start();
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <!-- Podstawowe meta tagi -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hurtownia Mięsa - FAQ</title>
    
    <!-- Podpięcie arkuszy stylów -->
    <link rel="stylesheet" href="style.css"> <!-- Główny arkusz stylów -->
    <link rel="icon" type="image/png" href="icon.png"> <!-- Favicon strony -->
    
    <!-- Biblioteka ikon Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Style wewnętrzne specyficzne dla tej strony -->
    <style>
        /* Kontener główny FAQ */
        .faq-container {
            max-width: 1200px; /* Maksymalna szerokość zawartości */
            margin: 30px auto; /* Wyśrodkowanie i odstęp od góry */
            padding: 0 20px; /* Dopełnienie boczne */
            font-family: Arial, sans-serif; /* Czcionka podstawowa */
            overflow: hidden; /* Zapobiega problemom z float */
        }
        
        /* Nagłówek sekcji FAQ */
        .faq-header {
            text-align: center; /* Wyśrodkowanie tekstu */
            margin-bottom: 40px; /* Odstęp od kolejnych elementów */
        }
        
        /* Tytuł FAQ */
        .faq-header h2 {
            color: #d32f2f; /* Czerwony kolor */
            font-size: 32px; /* Rozmiar czcionki */
            margin-bottom: 15px; /* Odstęp od podtytułu */
        }
        
        /* Kontener głównej zawartości FAQ */
        .faq-content {
            display: flex; /* Układ flexbox */
            flex-wrap: wrap; /* Zawijanie na małych ekranach */
            gap: 30px; /* Odstęp między kolumnami */
        }
        
        /* Lista pytań i odpowiedzi */
        .faq-list {
            flex: 1; /* Elastyczne wypełnienie przestrzeni */
            min-width: 300px; /* Minimalna szerokość */
        }
        
        /* Pojedynczy element FAQ */
        .faq-item {
            background: white; /* Białe tło */
            margin-bottom: 30px; /* Odstęp między elementami */
            border-radius: 8px; /* Zaokrąglone rogi */
            box-shadow: 0 3px 10px rgba(0,0,0,0.1); /* Subtelny cień */
        }
        
        /* Styl pytania */
        .faq-question {
            background: #f8f8f8; /* Jasne szare tło */
            padding: 20px; /* Wewnętrzny odstęp */
            font-size: 18px; /* Rozmiar czcionki */
            font-weight: bold; /* Pogrubienie */
            color: #333; /* Kolor tekstu */
            border-left: 4px solid #d32f2f; /* Czerwony akcent */
        }
        
        /* Styl odpowiedzi */
        .faq-answer {
            padding: 20px; /* Wewnętrzny odstęp */
            color: #555; /* Kolor tekstu */
            line-height: 1.6; /* Interlinia */
        }
        
        /* Kontener ze zdjęciem */
        .faq-image-box {
            flex: 1; /* Elastyczne wypełnienie przestrzeni */
            min-width: 300px; /* Minimalna szerokość */
        }
        
        /* Styl zdjęcia */
        .faq-image-box img {
            width: 100%; /* Pełna szerokość kontenera */
            border-radius: 8px; /* Zaokrąglone rogi */
            box-shadow: 0 3px 10px rgba(0,0,0,0.1); /* Subtelny cień */
            margin-bottom: 30px; /* Odstęp od kolejnych elementów */
        }
        
        /* Box kontaktowy */
        .faq-contact-box {
            background: #f9f9f9; /* Jasne szare tło */
            padding: 40px; /* Wewnętrzny odstęp */
            border-radius: 8px; /* Zaokrąglone rogi */
            margin: 80px auto 0; /* Odstęp od góry i wyśrodkowanie */
            text-align: center; /* Wyśrodkowanie tekstu */
            clear: both; /* Reset float */
            width: 100%; /* Pełna szerokość */
            max-width: 800px; /* Maksymalna szerokość */
            box-shadow: 0 3px 10px rgba(0,0,0,0.1); /* Subtelny cień */
        }
        
        /* Nagłówek boxu kontaktowego */
        .faq-contact-box h3 {
            color: #d32f2f; /* Czerwony kolor */
            margin-bottom: 20px; /* Odstęp od tekstu */
            font-size: 24px; /* Rozmiar czcionki */
        }
        
        /* Tekst w boxie kontaktowym */
        .faq-contact-box p {
            color: #666; /* Kolor tekstu */
            font-size: 16px; /* Rozmiar czcionki */
            margin-bottom: 25px; /* Odstęp od przycisku */
            line-height: 1.5; /* Interlinia */
        }
        
        /* Przycisk kontaktowy */
        .faq-contact-box .przycisk {
            display: inline-block; /* Wyświetlanie inline-block */
            padding: 12px 30px; /* Wewnętrzny odstęp */
            background: #d32f2f; /* Czerwone tło */
            color: white; /* Biały tekst */
            text-decoration: none; /* Brak podkreślenia */
            border-radius: 5px; /* Zaokrąglone rogi */
            font-weight: bold; /* Pogrubienie */
            transition: background 0.3s ease; /* Animacja hover */
        }
        
        /* Efekt hover na przycisku */
        .faq-contact-box .przycisk:hover {
            background: #b71c1c; /* Ciemniejszy czerwony */
        }
        
        /* Responsywność - zmiany dla ekranów <= 768px */
        @media (max-width: 768px) {
            .faq-content {
                flex-direction: column; /* Układ kolumnowy */
            }
            
            .faq-contact-box {
                margin: 50px auto 0; /* Mniejszy odstęp od góry */
                padding: 30px; /* Mniejsze dopełnienie */
            }
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
                        <li><a href="profil.php"><i class="fas fa-user"></i> Profil</a></li>
                    <?php else: ?>
                        <!-- Link do logowania (widoczny tylko dla niezalogowanych) -->
                        <li><a href="logowanie.php"><i class="fas fa-user"></i> Logowanie</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Główna zawartość strony -->
    <main>
        <!-- Kontener FAQ -->
        <div class="faq-container">
            <!-- Nagłówek sekcji FAQ -->
            <div class="faq-header">
                <h2>Najczęściej zadawane pytania</h2>
                <p>Znajdź odpowiedzi na najpopularniejsze pytania dotyczące naszych produktów i usług</p>
            </div>
            
            <!-- Główna zawartość FAQ -->
            <div class="faq-content">
                <!-- Lewa kolumna z pytaniami -->
                <div class="faq-list">
                    <!-- Pytanie 1 -->
                    <div class="faq-item">
                        <div class="faq-question">
                            Czy dostarczacie mięso do sklepów i restauracji?
                        </div>
                        <div class="faq-answer">
                            <p>Tak, specjalizujemy się w dostawach dla profesjonalnych klientów. Oferujemy dostawy na terenie całego kraju do restauracji, hoteli i sklepów mięsnych.</p>
                        </div>
                    </div>
                    
                    <!-- Pytanie 2 -->
                    <div class="faq-item">
                        <div class="faq-question">
                            Jak należy przechowywać Wasze produkty?
                        </div>
                        <div class="faq-answer">
                            <p>Produkty należy przechowywać w temperaturze 0-4°C. Mięso pakowane próżniowo zachowuje świeżość do 14 dni w odpowiednich warunkach.</p>
                        </div>
                    </div>
                    
                    <!-- Pytanie 3 -->
                    <div class="faq-item">
                        <div class="faq-question">
                            Jakie certyfikaty posiadają Wasze produkty?
                        </div>
                        <div class="faq-answer">
                            <p>Wszystkie nasze produkty posiadają wymagane certyfikaty UE, w tym HACCP i ISO 9001. Prowadzimy rygorystyczną kontrolę jakości.</p>
                        </div>
                    </div>

                    <!-- Pytanie 4 -->
                    <div class="faq-item">
                        <div class="faq-question">
                            Czy oferujecie mięso ekologiczne?
                        </div>
                        <div class="faq-answer">
                            <p>Tak, w naszej ofercie znajduje się również linia produktów ekologicznych, pochodzących z certyfikowanych hodowli.</p>
                        </div>
                    </div>
                </div>
                
                <!-- Prawa kolumna ze zdjęciem i dodatkowymi pytaniami -->
                <div class="faq-image-box">
                    <img src="faq.jpg" alt="Nasza hurtownia mięsa">
                    
                    <!-- Pytanie 5 -->
                    <div class="faq-item">
                        <div class="faq-question">
                            Jak długo trwa dostawa?
                        </div>
                        <div class="faq-answer">
                            <p>Standardowo realizujemy dostawy w ciągu 24-48 godzin. Dla Warszawy i okolic gwarantujemy dostawę w ciągu 24 godzin od złożenia zamówienia.</p>
                        </div>
                    </div>
                    
                    <!-- Pytanie 6 -->
                    <div class="faq-item">
                        <div class="faq-question">
                            Jakie mięso znajdę w ofercie?
                        </div>
                        <div class="faq-answer">
                            <p>Oferujemy wołowinę, wieprzowinę, drób (kurczak, indyk), a także specjalności jak mięso do kebaba i mieszanki własnej receptury.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Box kontaktowy -->
            <div class="faq-contact-box">
                <h3>Masz dodatkowe pytania?</h3>
                <p>Nasz zespół chętnie na nie odpowie!</p>
                <a href="kontakt.php" class="przycisk">Skontaktuj się z nami</a>
            </div>
        </div>
    </main>

    <!-- Stopka strony -->
    <footer>
        <div class="kontener">
            <div class="zawartosc-stopki">
                <!-- Kolumna kontaktowa -->
                <div class="kolumna-stopki">
                    <h3>Kontakt</h3>
                    <p><i class="fas fa-map-marker-alt"></i> ul. Mięsna 14, 69-420 Radomyśl Wielki</p>
                    <p><i class="fas fa-phone"></i> +48 694 202 137</p>
                    <p><i class="fas fa-envelope"></i> kontakt@meatmaster.pl</p>
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
                        <a href="#" aria-label="Twitter" class="x-icon">X</a>
                        <a href="#" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
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