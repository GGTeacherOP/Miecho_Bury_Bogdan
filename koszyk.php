<?php
/**
 * KOSZYK.PHP - SYSTEM ZAMÓWIEŃ HURTOWNI MIĘSA
 * 
 * Funkcje:
 * 1. Zarządzanie zawartością koszyka
 * 2. Składanie zamówień
 * 3. Integracja z bazą danych
 * 4. Obsługa sesji użytkownika
 */

// 1. INICJALIZACJA SESJI - pozwala przechowywać dane koszyka między stronami
session_start();

// 2. POŁĄCZENIE Z BAZĄ DANYCH
$polaczenie = new mysqli('localhost', 'root', '', 'meatmasters');
if ($polaczenie->connect_error) {
    die("Błąd połączenia z bazą: " . $polaczenie->connect_error);
}
$polaczenie->set_charset("utf8"); // Ustawienie kodowania dla polskich znaków

/**
 * 3. FUNKCJA POBRANIA DANYCH KLIENTA
 * @param mysqli $polaczenie - Połączenie z bazą
 * @param int $id_klienta - ID klienta
 * @return array - Dane klienta
 */
function pobierzDaneKlienta($polaczenie, $id_klienta) {
    // Zabezpieczone zapytanie SQL (prepared statement)
    $zapytanie = $polaczenie->prepare("SELECT * FROM klienci WHERE id = ?");
    $zapytanie->bind_param("i", $id_klienta);
    $zapytanie->execute();
    return $zapytanie->get_result()->fetch_assoc();
}

// 4. OBSŁUGA SKŁADANIA ZAMÓWIENIA (formularz POST)
if (isset($_POST['zloz_zamowienie']) && !empty($_SESSION['koszyk'])) {
    
    // Sprawdzenie czy użytkownik jest zalogowany
    if (!isset($_SESSION['zalogowany']) || $_SESSION['zalogowany'] !== true) {
        $_SESSION['powrot_po_logowaniu'] = 'koszyk.php'; // Zapamiętaj stronę dla powrotu
        header("Location: logowanie.php");
        exit();
    }

    // Pobranie danych klienta z bazy
    $dane_klienta = pobierzDaneKlienta($polaczenie, $_SESSION['user_id']);
    if (!$dane_klienta) {
        die("Nie znaleziono danych klienta");
    }

    // Przygotowanie listy produktów i obliczenie wagi
    $lista_produktow = [];
    $laczna_waga = 0;
    foreach ($_SESSION['koszyk'] as $produkt) {
        $lista_produktow[] = $produkt['nazwa'];
        $laczna_waga += $produkt['ilosc'];
    }

    // Określenie czy klient jest firmą
    $czy_firma = ($dane_klienta['typ_konta'] !== 'klient indywidualny');
    $nazwa_firmy = $czy_firma ? $dane_klienta['nazwa_firmy'] : NULL;
    $nip = $czy_firma ? $dane_klienta['nip'] : NULL;

    // 5. ZAPIS ZAMÓWIENIA DO BAZY
    $zapytanie = $polaczenie->prepare("
        INSERT INTO zamowienia (
            klient_id, imie, nazwisko, email, telefon, 
            firma, nip, asortyment, waga, 
            data_zamowienia, status
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), 'oczekujące')
    ");
    
    // Powiązanie parametrów z zapytaniem
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

    // Pobranie ID nowego zamówienia
    $id_zamowienia = $polaczenie->insert_id;
    $zapytanie->close();

    // 6. ZAPIS SZCZEGÓŁÓW ZAMÓWIENIA (produktów)
    foreach ($_SESSION['koszyk'] as $produkt) {
        // Sprawdzenie czy produkt istnieje w bazie
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

    // Wyczyszczenie koszyka i przekierowanie
    unset($_SESSION['koszyk']);
    header("Location: zamowienie.php?id=$id_zamowienia");
    exit();
}

// 7. USUWANIE PRODUKTU Z KOSZYKA (parametr GET)
if (isset($_GET['usun'])) {
    $id_produktu = (int)$_GET['usun']; // Zabezpieczenie przed SQL injection
    if (isset($_SESSION['koszyk'][$id_produktu])) {
        unset($_SESSION['koszyk'][$id_produktu]);
    }
    header("Location: koszyk.php");
    exit();
}

// 8. AKTUALIZACJA ILOŚCI PRODUKTÓW (formularz POST)
if (isset($_POST['aktualizuj_koszyk'])) {
    foreach ($_POST['ilosc'] as $id => $ilosc) {
        $id = (int)$id; // Zabezpieczenie
        $ilosc = (float)$ilosc; // Zabezpieczenie
        
        if (isset($_SESSION['koszyk'][$id])) {
            if ($ilosc > 0) {
                $_SESSION['koszyk'][$id]['ilosc'] = $ilosc;
            } else {
                unset($_SESSION['koszyk'][$id]); // Usuń jeśli ilość = 0
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
    <!-- 9. METADANE STRONY -->
    <meta charset="UTF-8"> <!-- Obsługa polskich znaków -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Responsywność -->
    <title>Koszyk - MeatMaster</title> <!-- Tytuł strony -->
    
    <!-- 10. ARKUSZE STYLÓW -->
    <link rel="stylesheet" href="style.css"> <!-- Główny arkusz stylów -->
    <link rel="icon" type="image/png" href="icon.png"> <!-- Favicon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"> <!-- Ikony FontAwesome -->
    
    <!-- 11. STYLE WEWNĘTRZNE -->
    <style>
        /* 12. SEKCJA KOSZYKA */
        .sekcja-koszyka {
            padding: 50px 0; /* Odstępy góra-dół */
            min-height: 60vh; /* Minimalna wysokość */
        }
        
        /* 13. KONTENER GŁÓWNY */
        .kontener-koszyka {
            max-width: 1000px; /* Maksymalna szerokość */
            margin: 0 auto; /* Wyśrodkowanie */
            padding: 30px; /* Wewnętrzny odstęp */
            background: #fff; /* Białe tło */
            box-shadow: 0 0 10px rgba(0,0,0,0.1); /* Cień */
            border-radius: 8px; /* Zaokrąglone rogi */
        }
        
        /* 14. TABELA PRODUKTÓW */
        .tabela-koszyka {
            width: 100%; /* Pełna szerokość */
            border-collapse: collapse; /* Łączenie obramowań */
            margin-bottom: 20px; /* Odstęp od dołu */
        }
        
        /* 15. NAGŁÓWKI TABELI */
        .tabela-koszyka th {
            background: #d32f2f; /* Czerwone tło */
            color: white; /* Biały tekst */
            padding: 12px; /* Wewnętrzny odstęp */
            text-align: left; /* Wyrównanie tekstu */
        }
        
        /* 16. KOMÓRKI TABELI */
        .tabela-koszyka td {
            padding: 12px;
            border-bottom: 1px solid #eee;
            vertical-align: middle;
            text-align: center;
        }
        
        .tabela-koszyka td:first-child {
            text-align: left;
        }
        
        /* 17. POLE DO WPROWADZANIA ILOŚCI */
        .ilosc-input {
            width: 70px;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            text-align: center;
        }
        
        /* 18. PRZYCISK USUWANIA */
        .usun-produkt {
            color: #d32f2f; /* Czerwony kolor */
            font-size: 18px; /* Rozmiar ikony */
        }
        
        /* 19. STYL DLA PUSTEGO KOSZYKA */
        .koszyk-pusty {
            display: flex; /* Flexbox */
            flex-direction: column; /* Elementy w kolumnie */
            align-items: center; /* Wyśrodkowanie poziome */
            justify-content: center; /* Wyśrodkowanie pionowe */
            height: 300px; /* Stała wysokość */
            text-align: center; /* Wyśrodkowany tekst */
        }
        
        /* 20. IKONA PUSTEGO KOSZYKA */
        .koszyk-pusty i {
            font-size: 60px; /* Duża ikona */
            color: #ddd; /* Szary kolor */
            margin-bottom: 20px; /* Odstęp od dołu */
        }
        
        /* 21. NAGŁÓWEK PUSTEGO KOSZYKA */
        .koszyk-pusty h3 {
            margin-bottom: 25px; /* Odstęp od dołu */
            color: #555; /* Ciemnoszary tekst */
            font-weight: normal; /* Normalna grubość */
        }
        
        /* 22. KONTENER PRZYCISKÓW */
        .przyciski-wrapper {
            display: flex; /* Flexbox */
            align-items: center; /* Wyrównanie pionowe */
            gap: 15px; /* Odstęp między przyciskami */
            margin-top: 20px; /* Odstęp od góry */
        }
        
        /* 23. STYL OGÓLNY PRZYCISKU */
        .przycisk {
            flex: 1; /* Równe szerokości */
            padding: 12px 0; /* Wewnętrzny odstęp */
            text-align: center; /* Wyśrodkowany tekst */
            height: 44px; /* Stała wysokość */
            line-height: 20px; /* Wysokość linii */
            box-sizing: border-box; /* Model pudełkowy */
            border-radius: 4px; /* Zaokrąglone rogi */
            border: none; /* Brak obramowania */
            cursor: pointer; /* Kursor wskazujący */
            font-size: 15px; /* Rozmiar tekstu */
            font-family: inherit; /* Dziedziczenie czcionki */
        }
        
        /* 24. PRZYCISK "KONTYNUUJ ZAKUPY" */
        .przycisk-sklep {
            padding: 12px 30px; /* Większy odstęp */
            background: #d32f2f; /* Czerwone tło */
            color: white; /* Biały tekst */
            border: none; /* Brak obramowania */
            border-radius: 4px; /* Zaokrąglone rogi */
            text-decoration: none; /* Brak podkreślenia */
            transition: background 0.3s; /* Animacja hover */
        }
        
        /* 25. EFEKT HOVER DLA PRZYCISKÓW */
        .przycisk:hover, .przycisk-sklep:hover {
            background: #b71c1c; /* Ciemniejszy czerwony */
        }
        
        /* 26. KARTA PODSUMOWANIA */
        .karta-podsumowania {
            padding: 20px; /* Wewnętrzny odstęp */
            background: #f9f9f9; /* Jasne tło */
            border-radius: 5px; /* Zaokrąglone rogi */
            margin-bottom: 20px; /* Odstęp od dołu */
        }
        
        /* 27. WIERSZ PODSUMOWANIA */
        .wiersz-podsumowania {
            display: flex; /* Flexbox */
            justify-content: space-between; /* Rozłożenie elementów */
            margin-bottom: 10px; /* Odstęp od dołu */
            padding: 8px 0; /* Wewnętrzny odstęp */
        }
        
        /* 28. SUMA KOŃCOWA */
        .wiersz-podsumowania.razem {
            font-weight: bold; /* Pogrubienie */
            font-size: 1.2em; /* Większy rozmiar */
            border-top: 1px solid #ddd; /* Linia oddzielająca */
            padding-top: 15px; /* Odstęp od góry */
            margin-top: 10px; /* Odstęp od góry */
        }
        
        /* 29. KOMUNIKATY BŁĘDÓW */
        .blad {
            color: #d32f2f; /* Czerwony tekst */
            margin-bottom: 20px; /* Odstęp od dołu */
            padding: 15px; /* Wewnętrzny odstęp */
            background: #ffebee; /* Jasnoczerwone tło */
            border-radius: 5px; /* Zaokrąglone rogi */
            border-left: 4px solid #d32f2f; /* Czerwony pasek */
        }
        
        /* 30. RESPONSYWNOŚĆ - WERSJA MOBILNA */
        @media (max-width: 768px) {
            .kontener-koszyka {
                padding: 20px 15px; /* Mniejsze odstępy */
            }
            
            .tabela-koszyka {
                display: block; /* Pełna szerokość */
                overflow-x: auto; /* Przewijanie poziome */
            }
            
            .przyciski-wrapper {
                flex-direction: column; /* Przyciski w kolumnie */
            }
            
            .przycisk {
                width: 100%; /* Pełna szerokość */
                margin-bottom: 10px; /* Odstęp między przyciskami */
            }
        }
    </style>
</head>
<body>
    <!-- 31. NAGŁÓWEK STRONY -->
    <header>
        <div class="kontener naglowek-kontener">
            <!-- Logo firmy -->
            <div class="logo">
                <img src="Logo.png" alt="MeatMaster Logo">
            </div>
            
            <!-- 32. GŁÓWNA NAWIGACJA -->
            <nav>
                <ul>
                    <li><a href="Strona_glowna.php">Strona główna</a></li>
                    <li><a href="Oferta.php">Oferta</a></li>
                    <li><a href="sklep.php">Sklep</a></li>
                    <li><a href="o_nas.php">O nas</a></li>
                    <li><a href="kontakt.php">Kontakt</a></li>
                    <li><a href="faq.php">FAQ</a></li>
                    <li><a href="aktualnosci.php">Aktualności</a></li>
                    
                    <!-- 33. LINK DO PROFILU/LUB LOGOWANIA -->
                    <?php if (isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] === true): ?>
                        <li><a href="profil.php"><i class="fas fa-user"></i> Profil</a></li>
                    <?php else: ?>
                        <li><a href="logowanie.php"><i class="fas fa-user"></i> Logowanie</a></li>
                    <?php endif; ?>
                    
                    <!-- 34. IKONA KOSZYKA Z LICZNIKIEM -->
                    <li>
                        <a href="koszyk.php" id="cart-link">
                            <i class="fas fa-shopping-cart"></i> Koszyk 
                            (<span id="cart-count">
                                <?= count($_SESSION['koszyk'] ?? []) ?>
                            </span>)
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- 35. GŁÓWNA SEKCJA Z KOSZYKIEM -->
    <section class="sekcja-koszyka">
        <div class="kontener-koszyka">
            <h2>Twój koszyk</h2>
            
            <!-- 36. WYŚWIETLANIE BŁĘDÓW -->
            <?php if(isset($_SESSION['blad_zamowienia'])): ?>
                <div class="blad">
                    <?= $_SESSION['blad_zamowienia'] ?>
                </div>
                <?php unset($_SESSION['blad_zamowienia']); ?>
            <?php endif; ?>
            
            <!-- 37. SPRAWDZENIE CZY KOSZYK JEST PUSTY -->
            <?php if(empty($_SESSION['koszyk'])): ?>
                <div class="koszyk-pusty">
                    <i class="fas fa-shopping-cart"></i>
                    <h3>Twój koszyk jest pusty</h3>
                    <a href="sklep.php" class="przycisk-sklep">Przejdź do sklepu</a>
                </div>
            <?php else: ?>
                <!-- 38. FORMULARZ KOSZYKA -->
                <form method="post" id="form-koszyk">
                    <!-- 39. TABELA Z PRODUKTAMI -->
                    <table class="tabela-koszyka">
                        <thead>
                            <tr>
                                <th>Produkt</th>
                                <th>Cena</th>
                                <th>Waga (kg)</th>
                                <th>Wartość</th>
                                <th>Akcje</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $suma = 0; // Inicjalizacja sumy
                            
                            // 40. PĘTLA PRZEZ PRODUKTY W KOSZYKU
                            foreach($_SESSION['koszyk'] as $produkt): 
                                $wartosc = $produkt['cena'] * $produkt['ilosc'];
                                $suma += $wartosc;
                            ?>
                            <tr>
                                <!-- 41. NAZWA PRODUKTU (zabezpieczona przed XSS) -->
                                <td><?= htmlspecialchars($produkt['nazwa']) ?></td>
                                
                                <!-- 42. CENA JEDNOSTKOWA (sformatowana) -->
                                <td><?= number_format($produkt['cena'], 2) ?> zł/kg</td>
                                
                                <!-- 43. POLE DO EDYCJI WAGI -->
                                <td>
                                    <input type="number" 
                                           name="ilosc[<?= $produkt['id'] ?>]" 
                                           value="<?= $produkt['ilosc'] ?>" 
                                           min="0.1" 
                                           step="0.1" 
                                           class="ilosc-input"
                                           onchange="aktualizujWartosc(this)">
                                </td>
                                
                                <!-- 44. WARTOŚĆ CAŁKOWITA PRODUKTU -->
                                <td class="wartosc-produktu">
                                    <?= number_format($wartosc, 2) ?> zł
                                </td>
                                
                                <!-- 45. PRZYCISK USUWANIA -->
                                <td>
                                    <a href="koszyk.php?usun=<?= $produkt['id'] ?>" 
                                       class="usun-produkt" 
                                       title="Usuń produkt">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    
                    <!-- 46. SEKCJA PODSUMOWANIA -->
                    <div class="podsumowanie-koszyka">
                        <div class="karta-podsumowania">
                            <div class="wiersz-podsumowania">
                                <span>Wartość produktów:</span>
                                <span id="wartosc-produktow"><?= number_format($suma, 2) ?> zł</span>
                            </div>
                            <div class="wiersz-podsumowania razem">
                                <span>Do zapłaty:</span>
                                <span id="suma-zamowienia"><?= number_format($suma, 2) ?> zł</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- 47. PRZYCISKI AKCJI -->
                    <div class="przyciski-wrapper">
                        <a href="sklep.php" class="przycisk">Kontynuuj zakupy</a>
                        <button type="submit" name="zloz_zamowienie" class="przycisk">Złóż zamówienie</button>
                        <button type="submit" name="aktualizuj_koszyk" class="przycisk" style="display:none;">Aktualizuj koszyk</button>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </section>

    <!-- 48. STOPKA STRONY -->
    <footer>
        <div class="kontener">
            <div class="zawartosc-stopki">
                <!-- 49. DANE KONTAKTOWE -->
                <div class="kolumna-stopki">
                    <h3>Kontakt</h3>
                    <p><i class="fas fa-map-marker-alt"></i> ul. Mięsna 14, 69-420 Radomyśl Wielki</p>
                    <p><i class="fas fa-phone"></i> +48 694 202 137</p>
                    <p><i class="fas fa-envelope"></i> kontakt@meatmaster.pl</p>
                </div>
                
                <!-- 50. GODZINY OTWARCIA -->
                <div class="kolumna-stopki">
                    <h3>Godziny otwarcia</h3>
                    <p>Pon-Pt: 6:00 - 22:00</p>
                    <p>Sob: 7:00 - 14:00</p>
                    <p>Niedz: Zamknięte</p>
                </div>
                
                <!-- 51. LINKI DO SOCIAL MEDIÓW -->
                <div class="kolumna-stopki">
                    <h3>Śledź nas</h3>
                    <div class="linki-spolecznosciowe">
                        <a href="#" aria-label="Twitter" class="x-icon">X</a>
                        <a href="#" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
                        <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            
            <!-- 52. PRAWA AUTORSKIE -->
            <div class="prawa-autorskie">
                <p>&copy; 2025 MeatMaster - Hurtownia Mięsa. Wszelkie prawa zastrzeżone.</p>
            </div>
        </div>
    </footer>

    <script>
        // Funkcja aktualizująca wartość produktu
        function aktualizujWartosc(input) {
            const row = input.closest('tr');
            const cena = parseFloat(row.querySelector('td:nth-child(2)').textContent.replace(' zł/kg', ''));
            const ilosc = parseFloat(input.value);
            const wartosc = cena * ilosc;
            
            row.querySelector('.wartosc-produktu').textContent = wartosc.toFixed(2) + ' zł';
            
            // Aktualizacja podsumowania
            let suma = 0;
            document.querySelectorAll('tbody tr').forEach(row => {
                const wartosc = parseFloat(row.querySelector('.wartosc-produktu').textContent.replace(' zł', ''));
                suma += wartosc;
            });
            
            document.getElementById('wartosc-produktow').textContent = suma.toFixed(2) + ' zł';
            document.getElementById('suma-zamowienia').textContent = suma.toFixed(2) + ' zł';
            
            // Automatyczne wysłanie formularza po 1 sekundzie
            setTimeout(() => {
                document.querySelector('button[name="aktualizuj_koszyk"]').click();
            }, 1000);
        }
    </script>
</body>
</html>