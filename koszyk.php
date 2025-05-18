<?php
session_start();

// Podstawowe połączenie z bazą danych
$polaczenie = new mysqli('localhost', 'root', '', 'meatmasters');
if ($polaczenie->connect_error) {
    die("Nie udało się połączyć z bazą danych: " . $polaczenie->connect_error);
}
$polaczenie->set_charset("utf8");

// Pobranie danych klienta
function pobierzDaneKlienta($polaczenie, $id_klienta) {
    $zapytanie = $polaczenie->prepare("SELECT * FROM klienci WHERE id = ?");
    $zapytanie->bind_param("i", $id_klienta);
    $zapytanie->execute();
    return $zapytanie->get_result()->fetch_assoc();
}

// Składanie zamówienia
if (isset($_POST['zloz_zamowienie']) && !empty($_SESSION['koszyk'])) {
    
    // Sprawdzenie czy użytkownik jest zalogowany
    if (!isset($_SESSION['zalogowany']) || $_SESSION['zalogowany'] !== true) {
        $_SESSION['powrot_po_logowaniu'] = 'koszyk.php';
        header("Location: logowanie.php");
        exit();
    }

    // Pobranie danych klienta
    $dane_klienta = pobierzDaneKlienta($polaczenie, $_SESSION['user_id']);
    if (!$dane_klienta) {
        die("Nie znaleziono danych klienta");
    }

    // Przygotowanie listy produktów
    $lista_produktow = [];
    $laczna_waga = 0;
    
    foreach ($_SESSION['koszyk'] as $produkt) {
        $lista_produktow[] = $produkt['nazwa'];
        $laczna_waga += $produkt['ilosc'];
    }

    // Ustalenie czy to firma
    $czy_firma = ($dane_klienta['typ_konta'] !== 'klient indywidualny');
    $nazwa_firmy = $czy_firma ? $dane_klienta['nazwa_firmy'] : NULL;
    $nip = $czy_firma ? $dane_klienta['nip'] : NULL;

    // Zapis zamówienia
    $zapytanie = $polaczenie->prepare("
        INSERT INTO zamowienia (
            klient_id, imie, nazwisko, email, telefon, 
            firma, nip, asortyment, waga, 
            data_zamowienia, status
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), 'oczekujące')
    ");
    
    $zapytanie->bind_param(
        "isssssssd", 
        $_SESSION['user_id'],
        $dane_klienta['imie'],
        $dane_klienta['nazwisko'],
        $dane_klienta['email'],
        $dane_klienta['telefon'],
        $nazwa_firmy,
        $nip,
        implode('; ', $lista_produktow),
        $laczna_waga
    );

    if (!$zapytanie->execute()) {
        die("Błąd przy zapisie zamówienia: " . $polaczenie->error);
    }

    $id_zamowienia = $polaczenie->insert_id;
    $zapytanie->close();

    // Zapis produktów w zamówieniu
    foreach ($_SESSION['koszyk'] as $produkt) {
        // Sprawdzenie czy produkt istnieje
        $sprawdz = $polaczenie->query("SELECT id FROM towary WHERE id = " . $produkt['id']);
        
        if ($sprawdz && $sprawdz->num_rows > 0) {
            $zapytanie = $polaczenie->prepare("
                INSERT INTO zamowienia_towary (
                    zamowienie_id, towar_id, ilosc_kg, cena_zl_kg
                ) VALUES (?, ?, ?, ?)
            ");
            $zapytanie->bind_param(
                "iidd", 
                $id_zamowienia,
                $produkt['id'],
                $produkt['ilosc'],
                $produkt['cena']
            );
            $zapytanie->execute();
            $zapytanie->close();
        }
    }

    // Wyczyść koszyk i przekieruj
    unset($_SESSION['koszyk']);
    header("Location: zamowienie.php?id=$id_zamowienia");
    exit();
}

// Usuwanie produktu z koszyka
if (isset($_GET['usun'])) {
    $id_produktu = (int)$_GET['usun'];
    if (isset($_SESSION['koszyk'][$id_produktu])) {
        unset($_SESSION['koszyk'][$id_produktu]);
    }
    header("Location: koszyk.php");
    exit();
}

// Aktualizacja ilości produktów
if (isset($_POST['aktualizuj_koszyk'])) {
    foreach ($_POST['ilosc'] as $id => $ilosc) {
        $id = (int)$id;
        $ilosc = (float)$ilosc;
        
        if (isset($_SESSION['koszyk'][$id])) {
            if ($ilosc > 0) {
                $_SESSION['koszyk'][$id]['ilosc'] = $ilosc;
            } else {
                unset($_SESSION['koszyk'][$id]);
            }
        }
    }
    header("Location: koszyk.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koszyk - MeatMaster</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="icon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .sekcja-koszyka {
            padding: 50px 0;
            min-height: 60vh;
        }
        
        .kontener-koszyka {
            max-width: 1000px;
            margin: 0 auto;
            padding: 30px;
            background: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 8px;
        }
        
        .tabela-koszyka {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        .tabela-koszyka th {
            background: #d32f2f;
            color: white;
            padding: 12px;
            text-align: left;
        }
        
        .tabela-koszyka td {
            padding: 12px;
            border-bottom: 1px solid #eee;
            vertical-align: middle;
        }
        
        .ilosc-input {
            width: 70px;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        
        .usun-produkt {
            color: #d32f2f;
            font-size: 18px;
        }
        
        .koszyk-pusty {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 300px;
            text-align: center;
        }
        
        .koszyk-pusty i {
            font-size: 60px;
            color: #ddd;
            margin-bottom: 20px;
        }
        
        .koszyk-pusty h3 {
            margin-bottom: 25px;
            color: #555;
            font-weight: normal;
        }
        
.przyciski-wrapper {
    display: flex;
    align-items: center; /* Wyrównanie wertykalne */
    gap: 15px;
    margin-top: 20px;
}

.przycisk {
    flex: 1;
    padding: 12px 0;
    text-align: center;
    height: 44px; /* Stała wysokość */
    line-height: 20px; /* Wyrównanie tekstu */
    box-sizing: border-box;
    border-radius: 4px;
    border: none;
    cursor: pointer;
    font-size: 15px;
    font-family: inherit; /* Spójna czcionka */
}
.przycisk-koszyk:hover {
    background: #b71c1c;
}

        
        
        .przycisk-sklep {
            padding: 12px 30px;
            background: #d32f2f;
            color: white;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            transition: background 0.3s;
        }
        
        .przycisk-sklep:hover {
            background: #b71c1c;
        }
        
        .karta-podsumowania {
            padding: 20px;
            background: #f9f9f9;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .wiersz-podsumowania {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding: 8px 0;
        }
        
        .wiersz-podsumowania.razem {
            font-weight: bold;
            font-size: 1.2em;
            border-top: 1px solid #ddd;
            padding-top: 15px;
            margin-top: 10px;
        }
        
        .blad {
            color: #d32f2f;
            margin-bottom: 20px;
            padding: 15px;
            background: #ffebee;
            border-radius: 5px;
            border-left: 4px solid #d32f2f;
        }
        
        @media (max-width: 768px) {
            .kontener-koszyka {
                padding: 20px 15px;
            }
            
            .tabela-koszyka {
                display: block;
                overflow-x: auto;
            }
            
            .przyciski-koszyka {
                flex-direction: column;
            }
            
            .przycisk-koszyk {
                width: 100%;
                margin-bottom: 10px;
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
                    <?php if (isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] === true): ?>
                        <li><a href="profil.php"><i class="fas fa-user"></i> Profil</a></li>
                    <?php else: ?>
                        <li><a href="logowanie.php"><i class="fas fa-user"></i> Logowanie</a></li>
                    <?php endif; ?>
                    <li><a href="koszyk.php" id="cart-link"><i class="fas fa-shopping-cart"></i> Koszyk (<span id="cart-count"><?= array_sum(array_column($_SESSION['koszyk'] ?? [], 'ilosc')) ?></span>)</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section class="sekcja-koszyka">
        <div class="kontener-koszyka">
            <h2>Twój koszyk</h2>
            
            <?php if(isset($_SESSION['blad_zamowienia'])): ?>
                <div class="blad">
                    <?= $_SESSION['blad_zamowienia'] ?>
                </div>
                <?php unset($_SESSION['blad_zamowienia']); ?>
            <?php endif; ?>
            
            <?php if(empty($_SESSION['koszyk'])): ?>
                <div class="koszyk-pusty">
                    <i class="fas fa-shopping-cart"></i>
                    <h3>Twój koszyk jest pusty</h3>
                    <a href="sklep.php" class="przycisk-sklep">Przejdź do sklepu</a>
                </div>
            <?php else: ?>
                <form method="post">
                    <table class="tabela-koszyka">
                        <thead>
                            <tr>
                                <th>Produkt</th>
                                <th>Cena</th>
                                <th>Ilość</th>
                                <th>Wartość</th>
                                <th>Akcje</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $suma = 0;
                            foreach($_SESSION['koszyk'] as $produkt): 
                                $wartosc = $produkt['cena'] * $produkt['ilosc'];
                                $suma += $wartosc;
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($produkt['nazwa']) ?></td>
                                <td><?= number_format($produkt['cena'], 2) ?> zł/kg</td>
                                <td>
                                    <input type="number" name="ilosc[<?= $produkt['id'] ?>]" 
                                           value="<?= $produkt['ilosc'] ?>" min="0.1" step="0.1" 
                                           class="ilosc-input">
                                </td>
                                <td><?= number_format($wartosc, 2) ?> zł</td>
                                <td>
                                    <a href="koszyk.php?usun=<?= $produkt['id'] ?>" class="usun-produkt" title="Usuń produkt">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    
                    <div class="podsumowanie-koszyka">
                        <div class="karta-podsumowania">
                            <div class="wiersz-podsumowania">
                                <span>Wartość produktów:</span>
                                <span><?= number_format($suma, 2) ?> zł</span>
                            </div>
                            <div class="wiersz-podsumowania razem">
                                <span>Do zapłaty:</span>
                                <span><?= number_format($suma, 2) ?> zł</span>
                            </div>
                        </div>
                    </div>
                    
                 <div class="przyciski-wrapper">
    <a href="sklep.php" class="przycisk">Kontynuuj zakupy</a>
    <button type="submit" name="zloz_zamowienie" class="przycisk">Złóż zamówienie</button>
</div>
                </form>
            <?php endif; ?>
        </div>
    </section>
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