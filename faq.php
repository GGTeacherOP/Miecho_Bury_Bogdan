<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hurtownia Mięsa - FAQ</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="icon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
       
        .faq-container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
            font-family: Arial, sans-serif;
            overflow: hidden; 
        }
        
        .faq-header {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .faq-header h2 {
            color: #d32f2f;
            font-size: 32px;
            margin-bottom: 15px;
        }
        
        .faq-content {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
        }
        
        .faq-list {
            flex: 1;
            min-width: 300px;
        }
        
        .faq-item {
            background: white;
            margin-bottom: 30px; 
            border-radius: 8px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }
        
        .faq-question {
            background: #f8f8f8;
            padding: 20px;
            font-size: 18px;
            font-weight: bold;
            color: #333;
            border-left: 4px solid #d32f2f;
        }
        
        .faq-answer {
            padding: 20px;
            color: #555;
            line-height: 1.6;
        }
        
        .faq-image-box {
            flex: 1;
            min-width: 300px;
        }
        
        .faq-image-box img {
            width: 100%;
            border-radius: 8px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px; 
        }
        
      
        .faq-contact-box {
            background: #f9f9f9;
            padding: 40px;
            border-radius: 8px;
            margin: 80px auto 0;
            text-align: center;
            clear: both;
            width: 100%;
            max-width: 800px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }
        
        .faq-contact-box h3 {
            color: #d32f2f;
            margin-bottom: 20px;
            font-size: 24px;
        }
        
        .faq-contact-box p {
            color: #666;
            font-size: 16px;
            margin-bottom: 25px;
            line-height: 1.5;
        }
        
        .faq-contact-box .przycisk {
            display: inline-block;
            padding: 12px 30px;
            background: #d32f2f;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background 0.3s ease;
        }
        
        .faq-contact-box .przycisk:hover {
            background: #b71c1c;
        }
        
        @media (max-width: 768px) {
            .faq-content {
                flex-direction: column;
            }
            
            .faq-contact-box {
                margin: 50px auto 0;
                padding: 30px;
            }
        }
    </style>
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
                        <li><a href="profil.php"><i class="fas fa-user"></i> Profil</a></li>
                    <?php else: ?>
                        <li><a href="logowanie.php"><i class="fas fa-user"></i> Logowanie</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <div class="faq-container">
            <div class="faq-header">
                <h2>Najczęściej zadawane pytania</h2>
                <p>Znajdź odpowiedzi na najpopularniejsze pytania dotyczące naszych produktów i usług</p>
            </div>
            
            <div class="faq-content">
                <div class="faq-list">
                    <div class="faq-item">
                        <div class="faq-question">
                            Czy dostarczacie mięso do sklepów i restauracji?
                        </div>
                        <div class="faq-answer">
                            <p>Tak, specjalizujemy się w dostawach dla profesjonalnych klientów. Oferujemy dostawy na terenie całego kraju do restauracji, hoteli i sklepów mięsnych.</p>
                        </div>
                    </div>
                    
                    <div class="faq-item">
                        <div class="faq-question">
                            Jak należy przechowywać Wasze produkty?
                        </div>
                        <div class="faq-answer">
                            <p>Produkty należy przechowywać w temperaturze 0-4°C. Mięso pakowane próżniowo zachowuje świeżość do 14 dni w odpowiednich warunkach.</p>
                        </div>
                    </div>
                    
                    <div class="faq-item">
                        <div class="faq-question">
                            Jakie certyfikaty posiadają Wasze produkty?
                        </div>
                        <div class="faq-answer">
                            <p>Wszystkie nasze produkty posiadają wymagane certyfikaty UE, w tym HACCP i ISO 9001. Prowadzimy rygorystyczną kontrolę jakości.</p>
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question">
                            Czy oferujecie mięso ekologiczne?
                        </div>
                        <div class="faq-answer">
                            <p>Tak, w naszej ofercie znajduje się również linia produktów ekologicznych, pochodzących z certyfikowanych hodowli.</p>
                        </div>
                    </div>
                </div>
                
                <div class="faq-image-box">
                    <img src="faq.jpg" alt="Nasza hurtownia mięsa">
                    
                    <div class="faq-item">
                        <div class="faq-question">
                            Jak długo trwa dostawa?
                        </div>
                        <div class="faq-answer">
                            <p>Standardowo realizujemy dostawy w ciągu 24-48 godzin. Dla Warszawy i okolic gwarantujemy dostawę w ciągu 24 godzin od złożenia zamówienia.</p>
                        </div>
                    </div>
                    
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
            
            <div class="faq-contact-box">
                <h3>Masz dodatkowe pytania?</h3>
                <p>Nasz zespół chętnie na nie odpowie!</p>
                <a href="kontakt.php" class="przycisk">Skontaktuj się z nami</a>
            </div>
        </div>
    </main>

    <footer>
        <div class="kontener">
            <div class="zawartosc-stopki">
                <div class="kolumna-stopki">
                    <h3>Kontakt</h3>
                    <p><i class="fas fa-map-marker-alt"></i> ul. Mięsna 14, 69-420 Radomyśl Wielki</p>
                    <p><i class="fas fa-phone"></i> +48 694 202 137</p>
                    <p><i class="fas fa-envelope"></i> kontakt@meatmaster.pl</p>
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