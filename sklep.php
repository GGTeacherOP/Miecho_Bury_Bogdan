<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sklep Online - MeatMaster</title>
    
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="icon.png">
    <link rel="stylesheet" href="sklep_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <!-- Nagłówek strony -->
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
                    <li><a href="logowanie.php" id="login-link"><i class="fas fa-user"></i> Logowanie</a></li>
                    <li><a href="koszyk.php" id="cart-link"><i class="fas fa-shopping-cart"></i> Koszyk (<span id="cart-count">0</span>)</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Główna zawartość sklepu -->
    <main class="kontener">
        <section class="sekcja-produkty">
            <h1 class="tytul-sekcji">Sklep Online</h1>
            <p class="podtytul">Świeże mięso prosto do Twojego domu</p>

            <div class="filtry">
                <div class="kategorie">
                    <select id="kategoria">
                        <option value="wszystkie">Wszystkie kategorie</option>
                        <option value="wieprzowina">Wieprzowina</option>
                        <option value="drobiowe">Drób</option>
                        <option value="wołowina">Wołowina</option>
                        <option value="kebab">Kebab</option>
                    </select>
                </div>
                <div class="sortowanie">
                    <select id="sortowanie">
                        <option value="domyslne">Domyślne sortowanie</option>
                        <option value="cena-rosnaco">Cena: od najniższej</option>
                        <option value="cena-malejaco">Cena: od najwyższej</option>
                        <option value="nazwa">Nazwa A-Z</option>
                    </select>
                </div>
            </div>

            <div class="siatka-produktow">
                <!-- Produkty wołowe -->
                <div class="karta-produktu" data-kategoria="wołowina">
                    <div class="obraz-produktu">
                        <img src="rostbef.jpg" alt="Rostbef wołowy">
                    </div>
                    <div class="info-produktu">
                        <h3 class="nazwa-produktu">Rostbef wołowy</h3>
                        <div class="ceny">
                            <span class="cena-produktu">89.99 zł/kg</span>
                        </div>
                        <div class="ilosc-container">
                            <label for="ilosc-7">Ilość (kg):</label>
                            <input type="number" id="ilosc-7" min="0.5" step="0.1" value="1" class="ilosc">
                        </div>
                        <button class="przycisk-koszyk">Dodaj do koszyka</button>
                    </div>
                </div>

                <div class="karta-produktu" data-kategoria="wołowina">
                    <div class="obraz-produktu">
                        <img src="mielonka-wolowa.jpg" alt="Mielonka wołowa">
                    </div>
                    <div class="info-produktu">
                        <h3 class="nazwa-produktu">Mielonka wołowa</h3>
                        <div class="ceny">
                            <span class="cena-produktu">34.99 zł/kg</span>
                        </div>
                        <div class="ilosc-container">
                            <label for="ilosc-8">Ilość (kg):</label>
                            <input type="number" id="ilosc-8" min="0.5" step="0.1" value="1" class="ilosc">
                        </div>
                        <button class="przycisk-koszyk">Dodaj do koszyka</button>
                    </div>
                </div>

                <!-- Produkty wieprzowe -->
                <div class="karta-produktu" data-kategoria="wieprzowina">
                    <div class="obraz-produktu">
                        <img src="schab.jpg" alt="Schab wieprzowy">
                        <span class="promocja">-15%</span>
                    </div>
                    <div class="info-produktu">
                        <h3 class="nazwa-produktu">Schab wieprzowy</h3>
                        <div class="ceny">
                            <span class="cena-stara">29.99 zł/kg</span>
                            <span class="cena-produktu">24.99 zł/kg</span>
                        </div>
                        <div class="ilosc-container">
                            <label for="ilosc-1">Ilość (kg):</label>
                            <input type="number" id="ilosc-1" min="0.5" step="0.1" value="1" class="ilosc">
                        </div>
                        <button class="przycisk-koszyk">Dodaj do koszyka</button>
                    </div>
                </div>

                <div class="karta-produktu" data-kategoria="wieprzowina">
                    <div class="obraz-produktu">
                        <img src="karkowka.jpg" alt="Karkówka wieprzowa">
                    </div>
                    <div class="info-produktu">
                        <h3 class="nazwa-produktu">Karkówka wieprzowa</h3>
                        <div class="ceny">
                            <span class="cena-produktu">27.99 zł/kg</span>
                        </div>
                        <div class="ilosc-container">
                            <label for="ilosc-5">Ilość (kg):</label>
                            <input type="number" id="ilosc-5" min="0.5" step="0.1" value="1" class="ilosc">
                        </div>
                        <button class="przycisk-koszyk">Dodaj do koszyka</button>
                    </div>
                </div>

                <!-- Produkty drobiowe -->
                <div class="karta-produktu" data-kategoria="drobiowe">
                    <div class="obraz-produktu">
                        <img src="filet-z-kurczaka.jpg" alt="Filet z kurczaka">
                    </div>
                    <div class="info-produktu">
                        <h3 class="nazwa-produktu">Filet z kurczaka</h3>
                        <div class="ceny">
                            <span class="cena-produktu">25.99 zł/kg</span>
                        </div>
                        <div class="ilosc-container">
                            <label for="ilosc-2">Ilość (kg):</label>
                            <input type="number" id="ilosc-2" min="0.5" step="0.1" value="1" class="ilosc">
                        </div>
                        <button class="przycisk-koszyk">Dodaj do koszyka</button>
                    </div>
                </div>

                <div class="karta-produktu" data-kategoria="drobiowe">
                    <div class="obraz-produktu">
                        <img src="udka-z-kurczaka.jpg" alt="Udka z kurczaka">
                    </div>
                    <div class="info-produktu">
                        <h3 class="nazwa-produktu">Udka z kurczaka</h3>
                        <div class="ceny">
                            <span class="cena-produktu">18.99 zł/kg</span>
                        </div>
                        <div class="ilosc-container">
                            <label for="ilosc-9">Ilość (kg):</label>
                            <input type="number" id="ilosc-9" min="0.5" step="0.1" value="1" class="ilosc">
                        </div>
                        <button class="przycisk-koszyk">Dodaj do koszyka</button>
                    </div>
                </div>

                <!-- Mięso do kebaba -->
                <div class="karta-produktu" data-kategoria="specjalne">
                    <div class="obraz-produktu">
                        <img src="kebabwol.jpg" alt="Mięso do kebaba klasyczne">
                        <span class="promocja">Bestseller</span>
                    </div>
                    <div class="info-produktu">
                        <h3 class="nazwa-produktu">Mieszanka do kebaba</h3>
                        <div class="ceny">
                            <span class="cena-produktu">Zapytaj o ofertę</span>
                        </div>
                        <div class="ilosc-container">
                            <label for="ilosc-10">Ilość (kg):</label>
                            <input type="number" id="ilosc-10" min="0.5" step="0.1" value="1" class="ilosc">
                        </div>
                        <button class="przycisk-koszyk">Dodaj do koszyka</button>
                    </div>
                </div>
                <div class="karta-produktu" data-kategoria="kebab-drobiowe">
                    <div class="obraz-produktu">
                        <img src="kabab-drobiowy.jpg" alt="Mięso do kebaba drobiowe">
                        <span class="promocja">Nowość</span>
                    </div>
                    <div class="info-produktu">
                        <h3 class="nazwa-produktu">Mięso do kebaba drobiowe</h3>
                        <div class="ceny">
                            <span class="cena-produktu">Zapytaj o ofertę</span>
                        </div>
                        <div class="ilosc-container">
                            <label for="ilosc-11">Ilość (kg):</label>
                            <input type="number" id="ilosc-11" min="0.5" step="0.1" value="1" class="ilosc">
                        </div>
                        <button class="przycisk-koszyk">Dodaj do koszyka</button>
                    </div>
                </div>
            </div>


            <!-- Koszyk -->
            <section id="koszyk" class="sekcja-koszyk">
                <div class="koszyk-container">
                    <h2 class="tytul-sekcji">Twój Koszyk</h2>
                    <div id="koszyk-tabela">
                        <table>
                            <thead>
                                <tr>
                                    <th>Produkt</th>
                                    <th>Cena</th>
                                    <th>Ilość</th>
                                    <th>Wartość</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="koszyk-zawartosc">
                                <tr id="koszyk-pusty">
                                    <td colspan="5">Twój koszyk jest pusty</td>
                                </tr>
                            </tbody>
                            <tfoot id="koszyk-podsumowanie" style="display: none;">
                                <tr>
                                    <td colspan="3">Suma:</td>
                                    <td id="koszyk-suma">0.00 zł</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>

                        <div class="koszyk-akcje">
                            <button id="kontynuuj-zakupy" class="przycisk">Kontynuuj zakupy</button>
                            <button id="przejdz-do-zamowienia" class="przycisk">Przejdź do zamówienia</button>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Formularz zamówienia -->
            <section id="formularz-zamowienia" class="sekcja-zamowienia">
                <div class="zamowienie-container">
                    <h2 class="tytul-sekcji">Dane do zamówienia</h2>

                    <div class="zamowienie-columns">
                        <div class="dane-uzytkownika">
                            <h3>Dane osobowe</h3>
                            <form id="dane-form">
                                <div class="form-group">
                                    <label for="imie">Imię *</label>
                                    <input type="text" id="imie" required>
                                </div>
                                <div class="form-group">
                                    <label for="nazwisko">Nazwisko *</label>
                                    <input type="text" id="nazwisko" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email *</label>
                                    <input type="email" id="email" required>
                                </div>
                                <div class="form-group">
                                    <label for="telefon">Telefon *</label>
                                    <input type="tel" id="telefon" required>
                                </div>
                            </form>

                            <h3>Adres dostawy</h3>
                            <form id="adres-form">
                                <div class="form-group">
                                    <label for="ulica">Ulica i nr domu *</label>
                                    <input type="text" id="ulica" required>
                                </div>
                                <div class="form-group">
                                    <label for="miasto">Miasto *</label>
                                    <input type="text" id="miasto" required>
                                </div>
                                <div class="form-group">
                                    <label for="kod">Kod pocztowy *</label>
                                    <input type="text" id="kod" required>
                                </div>
                                <div class="form-group">
                                    <label for="uwagi">Uwagi do zamówienia</label>
                                    <textarea id="uwagi" rows="3"></textarea>
                                </div>
                            </form>
                        </div>

                        <div class="podsumowanie-zamowienia">
                            <h3>Podsumowanie</h3>
                            <div id="podsumowanie-zawartosc">
                                <p>Wybierz produkty w koszyku</p>
                            </div>

                            <h3>Sposób dostawy</h3>
                            <div class="dostawa-options">
                                <div class="dostawa-option">
                                    <input type="radio" id="dostawa-kurier" name="dostawa" value="kurier" checked>
                                    <label for="dostawa-kurier">Kurier (24h) - 15.00 zł</label>
                                </div>
                                <div class="dostawa-option">
                                    <input type="radio" id="dostawa-paczkomat" name="dostawa" value="paczkomat">
                                    <label for="dostawa-paczkomat">Paczkomat (48h) - 10.00 zł</label>
                                </div>
                                <div class="dostawa-option">
                                    <input type="radio" id="dostawa-odbior" name="dostawa" value="odbior">
                                    <label for="dostawa-odbior">Odbiór osobisty - 0.00 zł</label>
                                </div>
                            </div>

                            <div class="platnosc-options">
                                <h3>Sposób płatności</h3>
                                <div class="platnosc-option">
                                    <input type="radio" id="platnosc-przelew" name="platnosc" value="przelew" checked>
                                    <label for="platnosc-przelew">Przelew bankowy</label>
                                </div>
                                <div class="platnosc-option">
                                    <input type="radio" id="platnosc-blik" name="platnosc" value="blik">
                                    <label for="platnosc-blik">BLIK</label>
                                </div>
                                <div class="platnosc-option">
                                    <input type="radio" id="platnosc-karta" name="platnosc" value="karta">
                                    <label for="platnosc-karta">Karta płatnicza</label>
                                </div>
                            </div>

                            <div class="podsumowanie-cena">
                                <div class="wiersz">
                                    <span>Wartość produktów:</span>
                                    <span id="wartosc-produktow">0.00 zł</span>
                                </div>
                                <div class="wiersz">
                                    <span>Dostawa:</span>
                                    <span id="koszt-dostawy">0.00 zł</span>
                                </div>
                                <div class="wiersz suma">
                                    <span>Do zapłaty:</span>
                                    <span id="suma-zamowienia">0.00 zł</span>
                                </div>
                            </div>

                            <button id="zloz-zamowienie" class="przycisk">Złóż zamówienie</button>
                        </div>
                    </div>
                </div>
            </section>
    </main>

    <!-- Stopka -->
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

    <script src="sklep.js"></script>
</body>

</html>