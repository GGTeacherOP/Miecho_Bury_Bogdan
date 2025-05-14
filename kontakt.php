<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontakt</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="icon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
                <h2 class="tytul-sekcji">Nasz zespół kontaktowy</h2>
                
                <div class="siatka-opinii">
                   
                    <div class="karta-opinii">
                        <div class="kontakt-osoba">
                            <div class="kontakt-avatar">DB</div>
                            <h3>Dominik Bogdan</h3>
                            <p class="kontakt-dane"><i class="fas fa-briefcase"></i> Kierownik Działu Sprzedaży</p>
                            <p class="kontakt-dane"><i class="fas fa-phone"></i> +48 123 456 700</p>
                            <p class="kontakt-dane"><i class="fas fa-envelope"></i> dominik.bogdan@meatmaster.pl</p>
                            <p class="kontakt-dane"><i class="fas fa-clock"></i> Pon-Pt: 7:00-15:00</p>
                        </div>
                    </div>
                    
                  
                    <div class="karta-opinii">
                        <div class="kontakt-osoba">
                            <div class="kontakt-avatar">KB</div>
                            <h3>Kacper Bury</h3>
                            <p class="kontakt-dane"><i class="fas fa-briefcase"></i> Specjalista ds. Klienta</p>
                            <p class="kontakt-dane"><i class="fas fa-phone"></i> +48 123 456 701</p>
                            <p class="kontakt-dane"><i class="fas fa-envelope"></i> kacper.bury@meatmaster.pl</p>
                            <p class="kontakt-dane"><i class="fas fa-clock"></i> Pon-Pt: 9:00-17:00</p>
                        </div>
                    </div>
                    
                 
                    <div class="karta-opinii">
                        <div class="kontakt-osoba">
                            <div class="kontakt-avatar"><i class="fas fa-headset kontakt-ikona"></i></div>
                            <h3>Dział Obsługi Klienta</h3>
                            <p class="kontakt-dane"><i class="fas fa-phone"></i> +48 123 456 789</p>
                            <p class="kontakt-dane"><i class="fas fa-envelope"></i> kontakt@meatmaster.pl</p>
                            <p class="kontakt-dane"><i class="fas fa-clock"></i> Pon-Pt: 6:00-18:00</p>
                        </div>
                    </div>
                </div>
                
                
                <div class="kontakt-formularz">
                    <h3><i class="fas fa-envelope"></i> Formularz kontaktowy</h3>
                    <form class="contact-form">
                        
                        <div class="form-group">
                            <label for="temat">Temat wiadomości</label>
                            <select id="temat" required>
                                <option value="">-- Wybierz temat --</option>
                                <option value="zamowienia">Zamówienia</option>
                                <option value="reklamacje">Reklamacje</option>
                                <option value="wspolpraca">Współpraca</option>
                                <option value="inne">Inne</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="wiadomosc">Treść wiadomości</label>
                            <textarea id="wiadomosc" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="przycisk" style="width: 100%;">
                            <i class="fas fa-paper-plane"></i> Wyślij wiadomość
                        </button>
                    </form>
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