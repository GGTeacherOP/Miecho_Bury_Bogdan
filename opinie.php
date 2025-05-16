<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Opinie - Hurtownia Mięsa MeatMaster</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="icon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <?php
    session_start();
    ?>
    <script>
    const imieUzytkownika = <?php echo isset($_SESSION['imie']) ? json_encode($_SESSION['imie']) : 'null'; ?>;
    const nazwiskoUzytkownika = <?php echo isset($_SESSION['nazwisko']) ? json_encode($_SESSION['nazwisko']) : 'null'; ?>;
</script>
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
                <a href="sklep.php" class="przycisk">Sklep</a>
                <a href="faq.php" class="przycisk">FAQ</a>
                <a href="kontakt.php" class="przycisk">Kontakt</a>
            </div>
        </div>
    </section>

    <main>
        <section class="sekcja-opinie">
            <div class="kontener">
                <h2 class="tytul-sekcji">Opinie naszych klientów</h2>

                <div class="zawartosc-o-nas" style="align-items: flex-start;">
                    <div class="tekst-o-nas" style="flex: 1.5;">
                        <div class="siatka-opinii">
                            <div class="karta-opinii">
                                <div class="tresc-opinii">
                                    <p>"Zamawiamy regularnie od 2 lat. Mięso zawsze świeże i świetnie zapakowane. Obsługa ekspresowa!"</p>
                                </div>
                                <div class="autor-opinii">
                                    <i class="fas fa-user"></i> Jan K. – właściciel kebaba, Warszawa
                                </div>
                            </div>

                            <div class="karta-opinii">
                                <div class="tresc-opinii">
                                    <p>"Bardzo dobra jakość mięsa. Klienci zauważyli różnicę. Polecam z czystym sumieniem."</p>
                                </div>
                                <div class="autor-opinii">
                                    <i class="fas fa-user"></i> Monika L. – restauracja „GrillHouse”
                                </div>
                            </div>

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

                <!-- Miejsce na nowe opinie -->
                <div id="nowe-opinie" class="siatka-opinii" style="margin-top: 40px;"></div>

                <div class="siatka-opinii" style="margin-top: 40px;">
                    <div class="karta-opinii">
                        <div class="tresc-opinii">
                            <p>"Najlepsza hurtownia mięsa, z jaką współpracowaliśmy. Zamówienia zawsze na czas."</p>
                        </div>
                        <div class="autor-opinii">
                            <i class="fas fa-user"></i> Karolina Z. – sklep spożywczy „Smaczek”
                        </div>
                    </div>

                    <div class="karta-opinii">
                        <div class="tresc-opinii">
                            <p>"Dzięki nim nasza karta menu zyskała nowy poziom. Świetna jakość i duży wybór."</p>
                        </div>
                        <div class="autor-opinii">
                            <i class="fas fa-user"></i> Paweł M. – Bistro „Mięsiwo”
                        </div>
                    </div>

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

    <!-- Skrypt dodający nowe opinie -->

<script>
document.addEventListener("DOMContentLoaded", function () {
    const imieUzytkownika = <?php echo isset($_SESSION['imie']) ? json_encode($_SESSION['imie']) : 'null'; ?>;
    const nazwiskoUzytkownika = <?php echo isset($_SESSION['nazwisko']) ? json_encode($_SESSION['nazwisko']) : 'null'; ?>;
    const identyfikatorZalogowanego = (imieUzytkownika && nazwiskoUzytkownika)
        ? imieUzytkownika + " " + nazwiskoUzytkownika
        : null;

    const form = document.getElementById("formularz-opinia");
    const textarea = document.getElementById("opinion");
    const kontener = document.getElementById("nowe-opinie");

    function zapiszDoLocalStorage(opinie) {
        localStorage.setItem("opinieMM", JSON.stringify(opinie));
    }

    function wczytajZLocalStorage() {
        return JSON.parse(localStorage.getItem("opinieMM") || "[]");
    }

    function stworzKarteOpinii(tresc, autor, identyfikator, index, zapisz = false) {
        const nowaKarta = document.createElement("div");
        nowaKarta.className = "karta-opinii";

        const autorTekst = autor || "Użytkownik anonimowy";
        const czyMozeUsunac = (
            (identyfikatorZalogowanego && identyfikatorZalogowanego === identyfikator) ||
            (!identyfikatorZalogowanego && !identyfikator)
        );

        nowaKarta.innerHTML = `
            <div class="tresc-opinii">
                <p>"${tresc}"</p>
            </div>
            <div class="autor-opinii">
                <i class="fas fa-user"></i> ${autorTekst}
                ${czyMozeUsunac ? `<button style="float:right; background:#c00; color:#fff; border:none; padding:5px 10px; cursor:pointer;" data-index="${index}">Usuń</button>` : ""}
            </div>
        `;

        if (czyMozeUsunac) {
            nowaKarta.querySelector("button").addEventListener("click", function () {
                const opinie = wczytajZLocalStorage();
                opinie.splice(index, 1);
                zapiszDoLocalStorage(opinie);
                odswiezOpinie();
            });
        }

        kontener.appendChild(nowaKarta);

        if (zapisz) {
            const opinie = wczytajZLocalStorage();
            opinie.push({ tresc, autor: autorTekst, identyfikator });
            zapiszDoLocalStorage(opinie);
            odswiezOpinie(); // dla aktualnych indeksów
        }
    }

    function odswiezOpinie() {
        kontener.innerHTML = "";
        const opinie = wczytajZLocalStorage();
        opinie.forEach((opinia, i) => {
            stworzKarteOpinii(opinia.tresc, opinia.autor, opinia.identyfikator, i, false);
        });
    }

    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const tresc = textarea.value.trim();
        if (!tresc) return;

        let autor = "Użytkownik anonimowy";
        let identyfikator = null;

        if (imieUzytkownika && nazwiskoUzytkownika) {
            const inicjal = nazwiskoUzytkownika.charAt(0).toUpperCase() + ".";
            autor = `${imieUzytkownika} ${inicjal}`;
            identyfikator = `${imieUzytkownika} ${nazwiskoUzytkownika}`;
        }

        stworzKarteOpinii(tresc, autor, identyfikator, null, true);
        textarea.value = "";
    });

    odswiezOpinie();
});

</script>
</body>

</html>