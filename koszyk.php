<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MeatMaster - Twój koszyk</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="icon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        .sekcja-koszyka {
            padding: 50px 0;
            background: #f5f5f5;
            min-height: calc(100vh - 300px);
            /* Obliczenie minimalnej wysokości widoku – odejmuje 300px od pełnej wysokości okna */
        }

        .kontener-koszyka {
            max-width: 1000px;
            margin: 0 auto;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            /* Cień wokół kontenera */
        }

        .tytul-koszyka {
            text-align: center;
            color: #c00;
            font-size: 28px;
            margin-bottom: 30px;
        }

        .tytul-koszyka::after {
            content: "";
            display: block;
            width: 60px;
            height: 3px;
            background: #c00;
            margin: 15px auto 0;
            /* Pasek dekoracyjny pod nagłówkiem */
        }

        .tabela-koszyka {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .tabela-koszyka th {
            background: #c00;
            color: #fff;
            padding: 12px;
            text-align: left;
        }

        .tabela-koszyka td {
            padding: 15px 12px;
            border-bottom: 1px solid #eee;
            vertical-align: middle;
        }

        .tabela-koszyka tr:hover {
            background: #f9f9f9;
        }

        .produkt-info {
            display: flex;
            align-items: center;
        }

        .produkt-zdjecie {
            width: 80px;
            height: 60px;
            object-fit: cover;
            /* Przycinanie i skalowanie obrazka bez zniekształcenia */
            border-radius: 4px;
            margin-right: 15px;
        }

        .ilosc-input {
            width: 60px;
            padding: 8px;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .usun-produkt {
            color: #c00;
            cursor: pointer;
            transition: 0.3s;
            /* Płynna zmiana koloru przy najechaniu */
        }

        .usun-produkt:hover {
            color: #a00;
        }

        .podsumowanie-koszyka {
            display: flex;
            justify-content: flex-end;
            margin-top: 30px;
        }

        .karta-podsumowania {
            width: 300px;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            /* Subtelny cień podsumowania */
        }

        .wiersz-podsumowania {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px dashed #ddd;
        }

        .wiersz-podsumowania.razem {
            font-weight: 600;
            font-size: 18px;
            margin-top: 15px;
            border-bottom: none;
        }

        .przyciski-koszyka {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }

        .przycisk-koszyk {
            padding: 12px 25px;
            border-radius: 4px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
        }

        .przycisk-kontynuuj {
            background: #fff;
            border: 1px solid #c00;
            color: #c00;
        }

        .przycisk-kontynuuj:hover {
            background: #f5f5f5;
        }

        .przycisk-zamow {
            background: #c00;
            color: #fff;
            border: 1px solid #c00;
        }

        .przycisk-zamow:hover {
            background: #a00;
        }

        .koszyk-pusty {
            text-align: center;
            padding: 50px 0;
            display: none;
            /* Domyślnie ukryty – pokazany przez JS gdy koszyk pusty */
        }

        .koszyk-pusty i {
            font-size: 60px;
            color: #ddd;
            margin-bottom: 20px;
        }

        .koszyk-pusty h3 {
            color: #666;
            margin-bottom: 20px;
        }

        .koszyk-pusty .przycisk {
            padding: 12px 30px;
            background: #c00;
            color: #fff;
            border: 2px solid #c00;
            border-radius: 4px;
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s;
        }

        .koszyk-pusty .przycisk:hover {
            background: transparent;
            color: #c00;
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
                    <li><a href="logowanie.php" id="login-link"><i class="fas fa-user"></i> Logowanie</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section class="sekcja-koszyka">
        <div class="kontener-koszyka">
            <h2 class="tytul-koszyka">Twój koszyk</h2>

            <table class="tabela-koszyka">
                <thead>
                    <tr>
                        <th>Produkt</th>
                        <th>Cena</th>
                        <th>Ilość</th>
                        <th>Razem</th>
                        <th></th> <!-- Kolumna na przycisk usuwania -->
                    </tr>
                </thead>
                <tbody id="koszyk-produkty">

                </tbody>
            </table>

            <!-- Sekcja podsumowania koszyka -->
            <div class="podsumowanie-koszyka">
                <div class="karta-podsumowania">
                    <h3>Podsumowanie zamówienia</h3>
                    <div class="wiersz-podsumowania">
                        <span>Wartość produktów:</span>
                        <span id="wartosc-produktow">0,00 zł</span>
                    </div>
                    <div class="wiersz-podsumowania">
                        <span>Dostawa:</span>
                        <span id="koszt-dostawy">0,00 zł</span>
                    </div>
                    <div class="wiersz-podsumowania razem">
                        <span>Do zapłaty:</span>
                        <span id="do-zaplaty">0,00 zł</span>
                    </div>
                </div>
            </div>

            <!-- Przyciski: kontynuuj zakupy / przejdź do zamówienia -->
            <div class="przyciski-koszyka">
                <a href="sklep.php" class="przycisk-koszyk przycisk-kontynuuj">
                    <i class="fas fa-arrow-left"></i> Kontynuuj zakupy
                </a>
                <a href="zamowienie.php" class="przycisk-koszyk przycisk-zamow">
                    Zamów <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            <!-- Informacja o pustym koszyku -->
            <div class="koszyk-pusty" id="koszyk-pusty">
                <i class="fas fa-shopping-cart"></i>
                <h3>Twój koszyk jest pusty</h3>
                <p>Dodaj produkty do koszyka, aby móc je zamówić</p>
                <a href="sklep.php" class="przycisk">Przejdź do sklepu</a>
            </div>
        </div>
    </section>

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