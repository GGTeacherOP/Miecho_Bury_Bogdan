<?php
session_start(); // Rozpoczęcie sesji – umożliwia przechowywanie danych (np. koszyka) między żądaniami użytkownika

// Inicjalizacja koszyka jeśli nie istnieje
if (!isset($_SESSION['koszyk'])) {
    $_SESSION['koszyk'] = []; // Jeśli koszyk nie istnieje w sesji, tworzony jest jako pusty array
}

// Obsługa dodawania do koszyka
if (isset($_POST['dodaj_do_koszyka'])) { // Sprawdzenie, czy formularz z przyciskiem "dodaj do koszyka" został wysłany
    $produkt_id = $_POST['produkt_id']; // Pobranie ID produktu z formularza
    $ilosc = (float)$_POST['ilosc']; // Pobranie ilości z formularza i rzutowanie na typ float

    // Dane produktów (w rzeczywistej aplikacji pobierane z bazy danych)
    $produkty = [ // Tablica produktów z przykładowymi danymi – ID => dane produktu
        '1' => ['nazwa' => 'Schab wieprzowy', 'cena' => 24.99, 'kategoria' => 'wieprzowina'],
        '2' => ['nazwa' => 'Filet z kurczaka', 'cena' => 25.99, 'kategoria' => 'drobiowe'],
        '5' => ['nazwa' => 'Karkówka wieprzowa', 'cena' => 27.99, 'kategoria' => 'wieprzowina'],
        '7' => ['nazwa' => 'Rostbef wołowy', 'cena' => 89.99, 'kategoria' => 'wołowina'],
        '8' => ['nazwa' => 'Mielonka wołowa', 'cena' => 34.99, 'kategoria' => 'wołowina'],
        '9' => ['nazwa' => 'Udka z kurczaka', 'cena' => 18.99, 'kategoria' => 'drobiowe'],
        '10' => ['nazwa' => 'Mieszanka do kebaba', 'cena' => 42.00, 'kategoria' => 'kebab'],
        '11' => ['nazwa' => 'Mięso do kebaba drobiowe', 'cena' => 38.00, 'kategoria' => 'kebab']
    ];

    // Sprawdzenie, czy produkt o danym ID istnieje i czy ilość jest większa od 0
    if (isset($produkty[$produkt_id]) && $ilosc > 0) {
        // Jeśli produkt już jest w koszyku, zwiększ jego ilość
        if (isset($_SESSION['koszyk'][$produkt_id])) {
            $_SESSION['koszyk'][$produkt_id]['ilosc'] += $ilosc;
        } else {
            // Jeśli produkt nie jest jeszcze w koszyku, dodaj go z pełnymi danymi
            $_SESSION['koszyk'][$produkt_id] = [
                'id' => $produkt_id,
                'nazwa' => $produkty[$produkt_id]['nazwa'],
                'cena' => $produkty[$produkt_id]['cena'],
                'ilosc' => $ilosc,
                'kategoria' => $produkty[$produkt_id]['kategoria']
            ];
        }
    }

    // Po dodaniu przekierowanie z powrotem do strony sklepu, by odświeżyć widok
    header("Location: sklep.php");
    exit(); // Zakończenie działania skryptu po przekierowaniu
}
?>


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
    <style>
        /* Dodatkowe style dla koszyka */
        #koszyk,
        #formularz-zamowienia {
            display: none;
            margin-top: 40px;
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
        }

        .usun-produkt {
            color: #d32f2f;
            text-decoration: none;
        }

        #cart-count {
            background: #d32f2f;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 12px;
            position: relative;
            top: -8px;
            right: -5px;
        }

        .zamowienie-columns {
            display: flex;
            gap: 30px;
        }

        .dane-uzytkownika,
        .podsumowanie-zamowienia {
            flex: 1;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .dostawa-options,
        .platnosc-options {
            margin-bottom: 20px;
        }

        .podsumowanie-cena .wiersz {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .podsumowanie-cena .suma {
            font-weight: bold;
            font-size: 1.1em;
            margin-top: 15px;
        }
    </style>
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
                    <?php if (isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] === true): ?>
                        <li><a href="profil.php" id="profile-link"><i class="fas fa-user"></i> Profil</a></li>
                    <?php else: ?>
                        <li><a href="logowanie.php" id="login-link"><i class="fas fa-user"></i> Logowanie</a></li>
                    <?php endif; ?>
                    <li><a href="koszyk.php" id="cart-link"><i class="fas fa-shopping-cart"></i> Koszyk (<span id="cart-count"><?= count($_SESSION['koszyk']) ?></span>)</a></li>
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
                        <form method="post" class="form-koszyk">
                            <input type="hidden" name="produkt_id" value="7">
                            <div class="ilosc-container">
                                <label for="ilosc-7">Ilość (kg):</label>
                                <input type="number" id="ilosc-7" name="ilosc" min="0.5" step="0.1" value="1" class="ilosc">
                            </div>
                            <button type="submit" name="dodaj_do_koszyka" class="przycisk-koszyk">Dodaj do koszyka</button>
                        </form>
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
                        <form method="post" class="form-koszyk">
                            <input type="hidden" name="produkt_id" value="8">
                            <div class="ilosc-container">
                                <label for="ilosc-8">Ilość (kg):</label>
                                <input type="number" id="ilosc-8" name="ilosc" min="0.5" step="0.1" value="1" class="ilosc">
                            </div>
                            <button type="submit" name="dodaj_do_koszyka" class="przycisk-koszyk">Dodaj do koszyka</button>
                        </form>
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
                        <form method="post" class="form-koszyk">
                            <input type="hidden" name="produkt_id" value="1">
                            <div class="ilosc-container">
                                <label for="ilosc-1">Ilość (kg):</label>
                                <input type="number" id="ilosc-1" name="ilosc" min="0.5" step="0.1" value="1" class="ilosc">
                            </div>
                            <button type="submit" name="dodaj_do_koszyka" class="przycisk-koszyk">Dodaj do koszyka</button>
                        </form>
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
                        <form method="post" class="form-koszyk">
                            <input type="hidden" name="produkt_id" value="5">
                            <div class="ilosc-container">
                                <label for="ilosc-5">Ilość (kg):</label>
                                <input type="number" id="ilosc-5" name="ilosc" min="0.5" step="0.1" value="1" class="ilosc">
                            </div>
                            <button type="submit" name="dodaj_do_koszyka" class="przycisk-koszyk">Dodaj do koszyka</button>
                        </form>
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
                        <form method="post" class="form-koszyk">
                            <input type="hidden" name="produkt_id" value="2">
                            <div class="ilosc-container">
                                <label for="ilosc-2">Ilość (kg):</label>
                                <input type="number" id="ilosc-2" name="ilosc" min="0.5" step="0.1" value="1" class="ilosc">
                            </div>
                            <button type="submit" name="dodaj_do_koszyka" class="przycisk-koszyk">Dodaj do koszyka</button>
                        </form>
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
                        <form method="post" class="form-koszyk">
                            <input type="hidden" name="produkt_id" value="9">
                            <div class="ilosc-container">
                                <label for="ilosc-9">Ilość (kg):</label>
                                <input type="number" id="ilosc-9" name="ilosc" min="0.5" step="0.1" value="1" class="ilosc">
                            </div>
                            <button type="submit" name="dodaj_do_koszyka" class="przycisk-koszyk">Dodaj do koszyka</button>
                        </form>
                    </div>
                </div>

                <!-- Mięso do kebaba -->
                <div class="karta-produktu" data-kategoria="kebab">
                    <div class="obraz-produktu">
                        <img src="kebabwol.jpg" alt="Mięso do kebaba klasyczne">
                        <span class="promocja">Bestseller</span>
                    </div>
                    <div class="info-produktu">
                        <h3 class="nazwa-produktu">Mieszanka do kebaba</h3>
                        <div class="ceny">
                            <span class="cena-produktu">Zapytaj o ofertę</span>
                        </div>
                        <form method="post" class="form-koszyk">
                            <input type="hidden" name="produkt_id" value="10">
                            <div class="ilosc-container">
                                <label for="ilosc-10">Ilość (kg):</label>
                                <input type="number" id="ilosc-10" name="ilosc" min="0.5" step="0.1" value="1" class="ilosc">
                            </div>
                            <button type="submit" name="dodaj_do_koszyka" class="przycisk-koszyk">Dodaj do koszyka</button>
                        </form>
                    </div>
                </div>
                <div class="karta-produktu" data-kategoria="kebab">
                    <div class="obraz-produktu">
                        <img src="kabab-drobiowy.jpg" alt="Mięso do kebaba drobiowe">
                        <span class="promocja">Nowość</span>
                    </div>
                    <div class="info-produktu">
                        <h3 class="nazwa-produktu">Mięso do kebaba drobiowe</h3>
                        <div class="ceny">
                            <span class="cena-produktu">Zapytaj o ofertę</span>
                        </div>
                        <form method="post" class="form-koszyk">
                            <input type="hidden" name="produkt_id" value="11">
                            <div class="ilosc-container">
                                <label for="ilosc-11">Ilość (kg):</label>
                                <input type="number" id="ilosc-11" name="ilosc" min="0.5" step="0.1" value="1" class="ilosc">
                            </div>
                            <button type="submit" name="dodaj_do_koszyka" class="przycisk-koszyk">Dodaj do koszyka</button>
                        </form>
                    </div>
                </div>
            </div>

                            </tbody>
                        </table>      
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


    <script>
        // Czekamy aż cała strona się załaduje
        document.addEventListener('DOMContentLoaded', function() {
            // 1. Pobieramy potrzebne elementy
            const selectKategoria = document.getElementById('kategoria');
            const selectSortowanie = document.getElementById('sortowanie');
            const kontenerProduktow = document.querySelector('.siatka-produktow');
            const wszystkieProdukty = Array.from(document.querySelectorAll('.karta-produktu'));

            // 2. Funkcja do aktualizacji widoku
            function aktualizujWidok() {
                const kategoria = selectKategoria.value;
                const sortowanie = selectSortowanie.value;

                // Filtrowanie produktów
                const przefiltrowane = wszystkieProdukty.filter(function(produkt) {
                    if (kategoria === 'wszystkie') return true;
                    if (kategoria === 'kebab') {

                        return produkt.dataset.kategoria === 'kebab' || 
                               produkt.dataset.kategoria === 'kebab-drobiowe';
                    }
                    return produkt.dataset.kategoria === kategoria;
                });

                // Sortowanie produktów
                if (sortowanie === 'cena-rosnaco') {
                    przefiltrowane.sort(function(a, b) {
                        return pobierzCene(a) - pobierzCene(b);
                    });
                } else if (sortowanie === 'cena-malejaco') {
                    przefiltrowane.sort(function(a, b) {
                        return pobierzCene(b) - pobierzCene(a);
                    });
                } else if (sortowanie === 'nazwa') {
                    przefiltrowane.sort(function(a, b) {
                        const nazwaA = a.querySelector('.nazwa-produktu').textContent.toLowerCase();
                        const nazwaB = b.querySelector('.nazwa-produktu').textContent.toLowerCase();
                        return nazwaA.localeCompare(nazwaB);
                    });
                }

                // Wyświetlamy produkty
                kontenerProduktow.innerHTML = '';
                przefiltrowane.forEach(function(produkt) {
                    kontenerProduktow.appendChild(produkt);
                });
            }

            // 3. Funkcja pomocnicza do pobierania ceny
            function pobierzCene(produkt) {
                const cenaText = produkt.querySelector('.cena-produktu').textContent;
                const cena = parseFloat(cenaText.replace(' zł/kg', '').replace(',', '.'));
                return isNaN(cena) ? 0 : cena; // Dla "Zapytaj o ofertę" zwracamy 0
            }

            
            // 4. Dodajemy nasłuchiwanie zmian
            selectKategoria.addEventListener('change', aktualizujWidok);
            selectSortowanie.addEventListener('change', aktualizujWidok);
            
            // 5. Inicjalizacja - pierwsze sortowanie
            aktualizujWidok();
            
            // 6. Obsługa koszyka (pozostała funkcjonalność)
            const koszykSection = document.getElementById('koszyk');
            const formularzZamowienia = document.getElementById('formularz-zamowienia');
            

            document.getElementById('przejdz-do-zamowienia').addEventListener('click', function(e) {
                e.preventDefault();
                koszykSection.style.display = 'none';
                formularzZamowienia.style.display = 'block';
            });

            document.getElementById('kontynuuj-zakupy').addEventListener('click', function(e) {
                e.preventDefault();
                koszykSection.style.display = 'none';
            });

            
            document.querySelectorAll('input[name="dostawa"]').forEach(function(radio) {
                radio.addEventListener('change', function() {
                    const kosztDostawy = this.value === 'kurier' ? 15 : 
                                        this.value === 'paczkomat' ? 10 : 0;
                    document.getElementById('koszt-dostawy').textContent = kosztDostawy.toFixed(2) + ' zł';
                    

                    const wartoscText = document.getElementById('wartosc-produktow').textContent;
                    const wartoscProduktow = parseFloat(wartoscText.replace(' zł', ''));
                    document.getElementById('suma-zamowienia').textContent = (wartoscProduktow + kosztDostawy).toFixed(2) + ' zł';
                });
            });
        });
    </script>
</body>

</html>