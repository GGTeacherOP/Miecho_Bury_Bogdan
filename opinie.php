<!DOCTYPE html>
<html lang="pl">

<head>
    <!-- 1. METADANE STRONY -->
    <meta charset="UTF-8"> <!-- Deklaracja kodowania znaków UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Responsywność na urządzeniach mobilnych -->
    <title>Opinie - Hurtownia Mięsa MeatMaster</title> <!-- Tytuł strony widoczny w przeglądarce -->
    
    <!-- 2. PODŁĄCZENIE ZASOBÓW ZEWNĘTRZNYCH -->
    <link rel="stylesheet" href="style.css"> <!-- Główny arkusz stylów -->
    <link rel="icon" type="image/png" href="icon.png"> <!-- Favicon - ikona strony -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"> <!-- Biblioteka ikon FontAwesome -->

    <!-- 3. SEKCJA PHP -->
    <?php
    session_start(); // Inicjalizacja sesji do przechowywania danych użytkownika
    ?>
    
    <!-- 4. PRZEKAZANIE DANYCH PHP DO JAVASCRIPT -->
    <script>
    // Pobranie danych użytkownika z sesji PHP
    const imieUzytkownika = <?php echo isset($_SESSION['imie']) ? json_encode($_SESSION['imie']) : 'null'; ?>;
    const nazwiskoUzytkownika = <?php echo isset($_SESSION['nazwisko']) ? json_encode($_SESSION['nazwisko']) : 'null'; ?>;
    </script>
</head>

<body>
    <!-- 5. NAGŁÓWEK STRONY -->
    <header>
        <div class="kontener naglowek-kontener">
            <!-- Logo firmy -->
            <div class="logo">
                <img src="Logo.png" alt="MeatMaster Logo"> <!-- Logo z tekstem alternatywnym -->
            </div>
            
            <!-- 6. GŁÓWNA NAWIGACJA -->
            <nav>
                <ul>
                    <!-- Lista linków nawigacyjnych -->
                    <li><a href="Strona_glowna.php">Strona główna</a></li>
                    <li><a href="Oferta.php">Oferta</a></li>
                    <li><a href="sklep.php">Sklep</a></li>
                    <li><a href="o_nas.php">O nas</a></li>
                    <li><a href="kontakt.php">Kontakt</a></li>
                    <li><a href="faq.php">FAQ</a></li>
                    <li><a href="aktualnosci.php">Aktualności</a></li>
                    <li><a href="opinie.php">Opinie</a></li>

                    <!-- 7. LINK DO PROFILU LUB LOGOWANIA (W ZALEŻNOŚCI OD STATUSU) -->
                    <?php if (isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] === true): ?>
                        <li><a href="profil.php" id="profile-link"><i class="fas fa-user"></i> Profil</a></li>
                    <?php else: ?>
                        <li><a href="logowanie.php" id="login-link"><i class="fas fa-user"></i> Logowanie</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <!-- 8. SEKCJA GŁÓWNA Z BANEREM -->
    <section class="sekcja-glowna">
        <div class="kontener">
            <h2>Świeże mięso do Twojego sklepu!</h2> <!-- Nagłówek sekcji -->
            <p>Najwyższej jakości produkty mięsne od sprawdzonych dostawców</p> <!-- Tekst opisowy -->
            
            <!-- 9. KONTENER Z PRZYCISKAMI -->
            <div class="kontener-przyciskow">
                <a href="oferta.php" class="przycisk">Oferta</a>
                <a href="sklep.php" class="przycisk">Sklep</a>
                <a href="faq.php" class="przycisk">FAQ</a>
                <a href="kontakt.php" class="przycisk">Kontakt</a>
            </div>
        </div>
    </section>

    <!-- 10. GŁÓWNA ZAWARTOŚĆ STRONY -->
    <main>
        <section class="sekcja-opinie">
            <div class="kontener">
                <h2 class="tytul-sekcji">Opinie naszych klientów</h2> <!-- Tytuł sekcji opinii -->

                <!-- 11. KONTENER Z ZAWARTOŚCIĄ -->
                <div class="zawartosc-o-nas" style="align-items: flex-start;">
                    <!-- 12. SEKCJA Z OPINIAMI -->
                    <div class="tekst-o-nas" style="flex: 1.5;">
                        <div class="siatka-opinii">
                            <!-- Przykładowa opinia 1 -->
                            <div class="karta-opinii">
                                <div class="tresc-opinii">
                                    <p>"Zamawiamy regularnie od 2 lat. Mięso zawsze świeże i świetnie zapakowane. Obsługa ekspresowa!"</p>
                                </div>
                                <div class="autor-opinii">
                                    <i class="fas fa-user"></i> Jan K. – właściciel kebaba, Warszawa
                                </div>
                            </div>

                            <!-- Przykładowa opinia 2 -->
                            <div class="karta-opinii">
                                <div class="tresc-opinii">
                                    <p>"Bardzo dobra jakość mięsa. Klienci zauważyli różnicę. Polecam z czystym sumieniem."</p>
                                </div>
                                <div class="autor-opinii">
                                    <i class="fas fa-user"></i> Monika L. – restauracja „GrillHouse”
                                </div>
                            </div>

                            <!-- Przykładowa opinia 3 -->
                            <div class="karta-opinii">
                                <div class="tresc-opinii">
                                    <p>"Obsługa klienta na najwyższym poziomie. Pomogli dobrać idealną ofertę dla naszego food trucka."</p>
                                </div>
                                <div class="autor-opinii">
                                    <i class="fas fa-user"></i> Tomasz R. – StreetFood24
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 13. FORMUŁARZ DODAWANIA OPINII -->
                    <div class="obraz-o-nas" style="flex: 1; background: #f5f5f5; padding: 30px; border-radius: 8px;">
                        <h3 style="color: #c00; margin-bottom: 20px;">Dodaj swoją opinię</h3>
                        <form class="contact-form" id="formularz-opinia">
                            <div class="form-group">
                                <label for="opinion">Twoja opinia</label>
                                <textarea id="opinion" rows="4" required></textarea>
                            </div>
                            <button type="submit" class="przycisk" style="width: 100%;">Wyślij opinię</button>
                        </form>
                    </div>
                </div>

                <!-- 14. KONTENER NA DYNAMICZNIE DODAWANE OPINIE -->
                <div id="nowe-opinie" class="siatka-opinii" style="margin-top: 40px;"></div>

                <!-- 15. DODATKOWE STATYCZNE OPINIE -->
                <div class="siatka-opinii" style="margin-top: 40px;">
                    <!-- Opinia 4 -->
                    <div class="karta-opinii">
                        <div class="tresc-opinii">
                            <p>"Najlepsza hurtownia mięsa, z jaką współpracowaliśmy. Zamówienia zawsze na czas."</p>
                        </div>
                        <div class="autor-opinii">
                            <i class="fas fa-user"></i> Karolina Z. – sklep spożywczy „Smaczek”
                        </div>
                    </div>

                    <!-- Opinia 5 -->
                    <div class="karta-opinii">
                        <div class="tresc-opinii">
                            <p>"Dzięki nim nasza karta menu zyskała nowy poziom. Świetna jakość i duży wybór."</p>
                        </div>
                        <div class="autor-opinii">
                            <i class="fas fa-user"></i> Paweł M. – Bistro „Mięsiwo”
                        </div>
                    </div>

                    <!-- Opinia 6 -->
                    <div class="karta-opinii">
                        <div class="tresc-opinii">
                            <p>"Mięso halal w świetnej cenie i dostępne od ręki. Bardzo wygodna współpraca."</p>
                        </div>
                        <div class="autor-opinii">
                            <i class="fas fa-user"></i> Ahmad A. – kebab „Ali Baba”
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- 16. STOPKA STRONY -->
    <footer>
        <div class="kontener">
            <div class="zawartosc-stopki">
                <!-- 17. DANE KONTAKTOWE -->
                <div class="kolumna-stopki">
                    <h3>Kontakt</h3>
                    <p><i class="fas fa-map-marker-alt"></i> ul. Mięsna 14, 69-420 Radomyśl Wielki</p>
                    <p><i class="fas fa-phone"></i> +48 694 202 137</p>
                    <p><i class="fas fa-envelope"></i> kontakt@meatmaster.pl</p>
                </div>

                <!-- 18. GODZINY OTWARCIA -->
                <div class="kolumna-stopki">
                    <h3>Godziny otwarcia</h3>
                    <p>Pon-Pt: 6:00 - 22:00</p>
                    <p>Sob: 7:00 - 14:00</p>
                    <p>Niedz: Zamknięte</p>
                </div>

                <!-- 19. LINKI DO MEDIÓW SPOŁECZNOŚCIOWYCH -->
                <div class="kolumna-stopki">
                    <h3>Śledź nas</h3>
                    <div class="linki-spolecznosciowe">
                        <a href="#" aria-label="Twitter" class="x-icon">X</a>
                        <a href="#" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
                        <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>

            <!-- 20. INFORMACJA O PRAWACH AUTORSKICH -->
            <div class="prawa-autorskie">
                <p>&copy; 2025 MeatMaster - Hurtownia Mięsa. Wszelkie prawa zastrzeżone.</p>
            </div>
        </div>
    </footer>

    <!-- 21. SKRYPT ZARZĄDZAJĄCY OPINIAMI -->
    <script>
    /**
     * SYSTEM ZARZĄDZANIA OPINIAMI
     * Funkcje:
     * 1. Zapis i odczyt opinii w localStorage
     * 2. Dodawanie nowych opinii
     * 3. Usuwanie opinii
     * 4. Wyświetlanie listy opinii
     */

    // Poczekaj na załadowanie DOM
    document.addEventListener("DOMContentLoaded", function() {
        // 1. Pobranie danych użytkownika
        const imie = <?php echo isset($_SESSION['imie']) ? json_encode($_SESSION['imie']) : 'null'; ?>;
        const nazwisko = <?php echo isset($_SESSION['nazwisko']) ? json_encode($_SESSION['nazwisko']) : 'null'; ?>;
        
        // 2. Przygotowanie identyfikatora
        const identyfikator = (imie && nazwisko) ? imie + " " + nazwisko : null;
        
        // 3. Pobranie elementów DOM
        const form = document.getElementById("formularz-opinia");
        const textarea = document.getElementById("opinion");
        const kontener = document.getElementById("nowe-opinie");

        // 4. Funkcja zapisująca opinie do localStorage
        function zapiszDoLS(opinie) {
            localStorage.setItem("opinieMM", JSON.stringify(opinie));
        }

        // 5. Funkcja wczytująca opinie z localStorage
        function wczytajZLS() {
            const dane = localStorage.getItem("opinieMM");
            return dane ? JSON.parse(dane) : [];
        }

        // 6. Funkcja tworząca kartę opinii
        function stworzKarte(tresc, autor, id, index, zapisz) {
            const karta = document.createElement("div");
            karta.className = "karta-opinii";
            
            // Sprawdź czy użytkownik może usunąć opinię
            const czyMozeUsunac = (identyfikator && identyfikator === id) || 
                                 (!identyfikator && !id);
            
            // Generuj HTML karty
            karta.innerHTML = `
                <div class="tresc-opinii">
                    <p>"${tresc}"</p>
                </div>
                <div class="autor-opinii">
                    <i class="fas fa-user"></i> ${autor || "Anonim"}
                    ${czyMozeUsunac ? `<button class="btn-usun" data-index="${index}">Usuń</button>` : ""}
                </div>
            `;
            
            // Dodaj obsługę przycisku usuwania
            if (czyMozeUsunac) {
                karta.querySelector(".btn-usun").addEventListener("click", function() {
                    const opinie = wczytajZLS();
                    opinie.splice(index, 1);
                    zapiszDoLS(opinie);
                    odswiezListe();
                });
            }
            
            kontener.appendChild(karta);
            
            // Zapisz do localStorage jeśli wymagane
            if (zapisz) {
                const opinie = wczytajZLS();
                opinie.push({ tresc, autor: autor || "Anonim", identyfikator: id });
                zapiszDoLS(opinie);
            }
        }

        // 7. Funkcja odświeżająca listę opinii
        function odswiezListe() {
            kontener.innerHTML = "";
            const opinie = wczytajZLS();
            opinie.forEach((opinia, i) => {
                stworzKarte(opinia.tresc, opinia.autor, opinia.identyfikator, i, false);
            });
        }

        // 8. Obsługa formularza
        form.addEventListener("submit", function(e) {
            e.preventDefault();
            
            const tresc = textarea.value.trim();
            if (!tresc) return;
            
            let autor = null;
            if (imie && nazwisko) {
                const inicjal = nazwisko.charAt(0).toUpperCase() + ".";
                autor = imie + " " + inicjal;
            }
            
            stworzKarte(tresc, autor, identyfikator, null, true);
            textarea.value = "";
        });

        // 9. Inicjalizacja - wyświetl opinie
        odswiezListe();
    });
    </script>
</body>
</html>