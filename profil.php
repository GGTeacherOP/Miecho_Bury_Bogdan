<?php
// 1. Ustawienia początkowe - KODOWANIE
header('Content-Type: text/html; charset=UTF-8');
ini_set('default_charset', 'UTF-8');
mb_internal_encoding('UTF-8');

require_once "sesje.php";
require_once "db.php";

// 2. Ustawienie kodowania połączenia z bazą danych
$conn->set_charset("utf8mb4");

// 3. Obsługa wylogowania
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['wyloguj'])) {
    session_unset();
    session_destroy();
    header("Location: logowanie.php");
    exit;
}

// 4. Funkcja do bezpiecznego wyświetlania tekstu
function safeText($text)
{
    return htmlspecialchars($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
}

// 5. Pobranie danych użytkownika
$uzytkownik = [
    'imie' => safeText($_SESSION['imie'] ?? ''),
    'nazwisko' => safeText($_SESSION['nazwisko'] ?? ''),
    'email' => safeText($_SESSION['user_email'] ?? ''),
    'telefon' => '+48 123 456 789',
    'rejestracja' => date('d.m.Y'),
    'typ_konta' => ($_SESSION['rola'] === 'pracownik') ? 'Pracownik' : 'Klient indywidualny',
    'zamowienia' => 0,
    'wartosc' => '0 zł'
];

// 6. Pobranie statystyk dla klienta
if ($_SESSION['rola'] === 'klient' && isset($_SESSION['user_id'])) {
    $user_id = (int)$_SESSION['user_id'];


    // Liczba zamówień
    $wynik = $conn->query("SELECT COUNT(*) as liczba FROM zamowienia WHERE klient_id = $user_id");
    $uzytkownik['zamowienia'] = $wynik->fetch_assoc()['liczba'];


    // Wartość zamówień
    $wynik = $conn->query("SELECT SUM(z.ilosc_kg * z.cena_zl_kg) as wartosc 
                          FROM zamowienia_towary z
                          JOIN zamowienia za ON z.zamowienie_id = za.id
                          WHERE za.klient_id = $user_id");
    $wartosc = $wynik->fetch_assoc()['wartosc'] ?? 0;
    $uzytkownik['wartosc'] = number_format($wartosc, 2, ',', ' ') . ' zł';
}

// 7. Dodanie stanowiska dla pracownika
if ($_SESSION['rola'] === 'pracownik') {
    $uzytkownik['stanowisko'] = safeText($_SESSION['stanowisko'] ?? '');
}

// 8. Generowanie inicjałów
$inicjaly = mb_strtoupper(

    mb_substr($uzytkownik['imie'], 0, 1) .
        mb_substr($uzytkownik['nazwisko'], 0, 1),

    'UTF-8'
);
?>
<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MeatMaster - Profil</title>
    <!-- 8.2. LINKI DO ZASOBÓW -->
    <link rel="stylesheet" href="style.css"> <!-- Główny arkusz stylów -->
    <link rel="icon" type="image/png" href="icon.png"> <!-- Ikona strony -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"> <!-- Ikony FontAwesome -->
    <style>
        /* Główna sekcja profilu - tło i minimalna wysokość */
        .sekcja-profilu {
            padding: 80px 0;
            /* Wewnętrzny odstęp góra/dół */
            background: #f5f5f5;
            /* Jasnoszare tło */
            min-height: calc(100vh - 300px);
            /* Minimalna wysokość (cały ekran minus 300px) */
        }

        /* Kontener z zawartością profilu */
        .kontener-profilu {
            max-width: 800px;
            /* Maksymalna szerokość */
            margin: 0 auto;
            /* Wyśrodkowanie */
            background: #fff;
            /* Białe tło */
            padding: 40px;
            /* Wewnętrzny odstęp */
            border-radius: 8px;
            /* Zaokrąglone rogi */
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            /* Subtelny cień */
            display: flex;
            /* Flexbox dla układu */
            flex-direction: column;
            /* Elementy w kolumnie */
            gap: 30px;
            /* Odstęp między dziećmi */
        }

        /* Nagłówek profilu (awatar + dane) */
        .naglowek-profilu {
            display: flex;
            /* Flexbox dla układu poziomego */
            align-items: center;
            /* Wyśrodkowanie w pionie */
            gap: 30px;
            /* Odstęp między awatarem a danymi */
            border-bottom: 1px solid #eee;
            /* Szara linia oddzielająca */
            padding-bottom: 20px;
            /* Odstęp od linii */
        }

        /* Okrągły awatar z inicjałami */
        .awatar {
            width: 120px;
            /* Szerokość */
            height: 120px;
            /* Wysokość */
            border-radius: 50%;
            /* Kółko (50% border-radius) */
            background-color: #c00;
            /* Czerwone tło (#c00) */
            color: white;
            /* Biały tekst */
            display: flex;
            /* Flexbox dla wyśrodkowania */
            align-items: center;
            /* Wyśrodkowanie w pionie */
            justify-content: center;
            /* Wyśrodkowanie w poziomie */
            font-size: 48px;
            /* Duży rozmiar czcionki */
            font-weight: bold;
            /* Pogrubienie */
        }

        /* Nagłówek z danymi użytkownika */
        .informacje-uzytkownika h2 {
            color: #c00;
            /* Czerwony kolor tekstu */
            margin-bottom: 10px;
            /* Odstęp od dołu */
            font-size: 28px;
            /* Rozmiar czcionki */
        }

        /* Etykieta typu konta (np. "Pracownik") */
        .typ-konta {
            display: inline-block;
            /* Element liniowo-blokowy */
            background: #c00;
            /* Czerwone tło */
            color: white;
            /* Biały tekst */
            padding: 5px 15px;
            /* Wewnętrzny odstęp */
            border-radius: 20px;
            /* Bardzo zaokrąglone rogi (efekt "pigułki") */
            font-size: 14px;
            /* Rozmiar czcionki */
            margin-top: 5px;
            /* Mały odstęp od góry */
        }

        /* Kontener statystyk (2 kolumny) */
        .sekcja-statystyk {
            display: grid;
            /* Grid layout */
            grid-template-columns: repeat(2, 1fr);
            /* 2 kolumny o równej szerokości */
            gap: 20px;
            /* Odstęp między kolumnami */
        }

        /* Pojedyncza statystyka (np. "Złożone zamówienia") */
        .statystyka {
            background: #f9f9f9;
            /* Bardzo jasnoszare tło */
            padding: 20px;
            /* Wewnętrzny odstęp */
            border-radius: 8px;
            /* Lekko zaokrąglone rogi */
            text-align: center;
            /* Tekst wyśrodkowany */
            border-left: 4px solid #c00;
            /* Czerwony akcent z lewej strony */
        }

        /* Nagłówek statystyki (np. "Wartość zamówień") */
        .statystyka h3 {
            color: #333;
            /* Ciemnoszary tekst */
            font-size: 16px;
            /* Rozmiar czcionki */
            margin-bottom: 10px;
            /* Odstęp od dołu */
        }

        /* Wartość statystyki (np. "5" lub "120,50 zł") */
        .wartosc-statystyki {
            font-size: 28px;
            /* Duży rozmiar czcionki */
            font-weight: bold;
            /* Pogrubienie */
            color: #c00;
            /* Czerwony kolor */
        }

        /* Sekcja z danymi użytkownika (np. "Dane osobowe") */
        .sekcja-danych {
            display: grid;
            /* Grid layout */
            grid-template-columns: 1fr;
            /* 1 kolumna */
            gap: 20px;
            /* Odstęp między grupami danych */
        }

        /* Grupa danych (np. "Dane kontaktowe") */
        .grupa-danych {
            margin-bottom: 20px;
            /* Odstęp od dołu */
        }

        /* Nagłówek grupy danych */
        .grupa-danych h3 {
            color: #333;
            /* Ciemnoszary tekst */
            margin-bottom: 10px;
            /* Odstęp od dołu */
            font-size: 18px;
            /* Rozmiar czcionki */
            border-bottom: 2px solid #eee;
            /* Szara linia pod nagłówkiem */
            padding-bottom: 5px;
            /* Odstęp od linii */
        }

        /* Pojedynczy wiersz z danymi (np. "Imię: Jan") */
        .dane {
            display: flex;
            /* Flexbox dla układu poziomego */
            justify-content: space-between;
            /* Rozłożenie na szerokość (etykieta z lewej, wartość z prawej) */
            padding: 8px 0;
            /* Odstęp góra/dół */
            border-bottom: 1px solid #f0f0f0;
            /* Bardzo subtelna szara linia oddzielająca */
        }

        /* Etykieta danych (np. "Imię:") */
        .etykieta {
            font-weight: 600;
            /* Pogrubienie (ale nie bold) */
            color: #666;
            /* Średnio szary tekst */
        }

        /* Wartość danych (np. "Jan") */
        .wartosc {
            color: #333;
            /* Ciemnoszary tekst */
        }

        /* Kontener przycisków dla pracowników */
        .przyciski-pracownika {
            display: flex;
            /* Flexbox dla układu poziomego */
            gap: 15px;
            /* Odstęp między przyciskami */
            margin-top: 20px;
            /* Odstęp od góry */
            flex-wrap: wrap;
            /* Zawijanie przycisków na małych ekranach */
        }

        /* Pojedynczy przycisk dla pracownika */
        .przycisk-pracownika {
            flex: 1;
            /* Rozciąganie do dostępnej szerokości */
            min-width: 200px;
            /* Minimalna szerokość */
            padding: 12px;
            /* Wewnętrzny odstęp */
            background: #c00;
            /* Czerwone tło */
            color: white;
            /* Biały tekst */
            text-align: center;
            /* Tekst wyśrodkowany */
            text-decoration: none;
            /* Brak podkreślenia */
            border-radius: 4px;
            /* Lekko zaokrąglone rogi */
            font-weight: 600;
            /* Pogrubienie */
            transition: 0.3s;
            /* Animacja hover */
        }

        /* Efekt hover na przyciskach */
        .przycisk-pracownika:hover {
            background: #a00;
            /* Ciemniejszy czerwony */
            transform: translateY(-2px);
            /* Lekkie uniesienie */
        }

        /* Przycisk wylogowania */
        .przycisk-wyloguj {
            width: 100%;
            /* Pełna szerokość */
            padding: 14px;
            /* Wewnętrzny odstęp */
            background: #c00;
            /* Czerwone tło */
            color: #fff;
            /* Biały tekst */
            border: none;
            /* Brak obramowania */
            border-radius: 4px;
            /* Lekko zaokrąglone rogi */
            font-size: 16px;
            /* Rozmiar czcionki */
            font-weight: 600;
            /* Pogrubienie */
            cursor: pointer;
            /* Kursor wskazujący */
            transition: 0.3s;
            /* Animacja hover */
            margin-top: 30px;
            /* Duży odstęp od góry */
        }

        /* Efekt hover na przycisku wylogowania */
        .przycisk-wyloguj:hover {
            background: #a00;
            /* Ciemniejszy czerwony */
        }

        /* Responsywność - zmiany dla ekranów <= 600px */
        @media (max-width: 600px) {

            /* Nagłówek profilu - zmiana na układ kolumnowy */
            .naglowek-profilu {
                flex-direction: column;
                /* Elementy w kolumnie */
                text-align: center;
                /* Tekst wyśrodkowany */
            }

            /* Awatar - wyśrodkowanie */
            .awatar {
                margin: 0 auto;
                /* Wyśrodkowanie poziome */
            }

            /* Przyciski pracownika - pełna szerokość */
            .przycisk-pracownika {
                min-width: 100%;
                /* Pełna szerokość kontenera */
            }
        }
    </style>
</head>

<body>

    <!-- 12. NAGŁÓWEK STRONY (menu nawigacyjne) -->

    <header>
        <div class="kontener naglowek-kontener">
            <div class="logo">
                <img src="Logo.png" alt="MeatMaster Logo"> <!-- Logo firmy -->
            </div>
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
                    <li><a href="profil.php" id="profile-link"><i class="fas fa-user"></i> Profil</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- 13. GŁÓWNA SEKCJA PROFILU -->
    <section class="sekcja-profilu">
        <div class="kontener-profilu">
            <!-- 13.1. NAGŁÓWEK PROFILU (awatar + dane) -->
            <div class="naglowek-profilu">
                <div class="awatar"><?= $inicjaly ?></div> <!-- Wyświetl inicjały -->
                <div class="informacje-uzytkownika">
                    <h2><?= "{$uzytkownik['imie']} {$uzytkownik['nazwisko']}" ?></h2>
                    <p><?= $uzytkownik['email'] ?></p>
                    <span class="typ-konta"><?= $uzytkownik['typ_konta'] ?></span>
                </div>
            </div>

            <!-- 13.2. SEKCJA STATYSTYK -->
            <div class="sekcja-statystyk">
                <!-- Statystyka 1: Liczba zamówień -->
                <div class="statystyka">
                    <h3>Złożone zamówienia</h3>
                    <div class="wartosc-statystyki"><?= $uzytkownik['zamowienia'] ?></div>
                </div>
                <!-- Statystyka 2: Wartość zamówień -->
                <div class="statystyka">
                    <h3>Wartość zamówień</h3>
                    <div class="wartosc-statystyki"><?= $uzytkownik['wartosc'] ?></div>
                </div>
            </div>

            <!-- 13.3. SEKCJA DANYCH UŻYTKOWNIKA -->
            <div class="sekcja-danych">
                <!-- Grupa 1: Dane osobowe -->
                <div class="grupa-danych">
                    <h3>Dane osobowe</h3>
                    <div class="dane">
                        <span class="etykieta">Imię:</span>
                        <span class="wartosc"><?= $uzytkownik['imie'] ?></span>
                    </div>
                    <div class="dane">
                        <span class="etykieta">Nazwisko:</span>
                        <span class="wartosc"><?= $uzytkownik['nazwisko'] ?></span>
                    </div>
                </div>

                <!-- Grupa 2: Dane kontaktowe -->
                <div class="grupa-danych">
                    <h3>Dane kontaktowe</h3>
                    <div class="dane">
                        <span class="etykieta">Telefon:</span>
                        <span class="wartosc"><?= $uzytkownik['telefon'] ?></span>
                    </div>
                    <div class="dane">
                        <span class="etykieta">Data rejestracji:</span>
                        <span class="wartosc"><?= $uzytkownik['rejestracja'] ?></span>
                    </div>
                </div>

                <?php if ($_SESSION['rola'] === 'pracownik'): ?>
                    <div class="grupa-danych">
                        <h3>Informacje o pracowniku</h3>
                        <div class="dane">
                            <span class="etykieta">Stanowisko:</span>
                            <span class="wartosc"><?= $uzytkownik['stanowisko'] ?></span>
                        </div>

                        <!-- Przyciski funkcjonalności pracowniczych -->
                        <div class="przyciski-pracownika">
                            <?php if (czyWlasciciel()): ?>
                                <!-- Przyciski dla właściciela - dostęp do wszystkiego -->
                                <a href="pracownicy_p.php" class="przycisk-pracownika">Zarządzaj pracownikami</a>
                                <a href="towar_p.php" class="przycisk-pracownika">Zarządzaj towarem</a>
                                <a href="kontakty_p.php" class="przycisk-pracownika">Zgłoszenia kontaktowe</a>
                                <a href="reklamacje_p.php" class="przycisk-pracownika">Przeglądaj reklamacje</a>
                                <a href="zamowienia_p.php" class="przycisk-pracownika">Przeglądaj zamówienia</a>
                            <?php elseif (czyKierownik()): ?>
                                <!-- Przyciski dla kierownika - tylko towar i kontakty -->
                                <a href="towar_p.php" class="przycisk-pracownika">Zarządzaj towarem</a>
                                <a href="kontakty_p.php" class="przycisk-pracownika">Zgłoszenia kontaktowe</a>
                            <?php else: ?>
                                <!-- Dla innych pracowników - standardowe przyciski -->
                                <?php if (in_array($_SESSION['stanowisko'], ['Kierownik'])): ?>
                                    <a href="pracownicy_p.php" class="przycisk-pracownika">Zarządzaj pracownikami</a>
                                    <a href="towar_p.php" class="przycisk-pracownika">Zarządzaj towarem</a>
                                <?php endif; ?>

                                <?php if (in_array($_SESSION['stanowisko'], ['Kierownik', 'Specjalista HR', 'Logistyk'])): ?>
                                    <a href="kontakty_p.php" class="przycisk-pracownika">Zgłoszenia kontaktowe</a>
                                <?php endif; ?>

                                <?php if (!in_array($_SESSION['stanowisko'], ['Kierownik', 'Programista'])): ?>
                                    <a href="reklamacje_p.php" class="przycisk-pracownika">Przeglądaj reklamacje</a>
                                    <a href="zamowienia_p.php" class="przycisk-pracownika">Przeglądaj zamówienia</a>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- 13.5. FORMULARZ WYLOGOWANIA -->
                <form method="post">
                    <button type="submit" name="wyloguj" class="przycisk-wyloguj">Wyloguj się</button>
                </form>
            </div>
    </section>

    <!-- 14. STOPKA STRONY -->
    <footer>
        <div class="kontener">
            <div class="zawartosc-stopki">
                <!-- Kolumna 1: Dane kontaktowe -->
                <div class="kolumna-stopki">
                    <h3>Kontakt</h3>
                    <p><i class="fas fa-map-marker-alt"></i> ul. Mięsna 14, 69-420 Radomyśl Wielki</p>
                    <p><i class="fas fa-phone"></i> +48 694 202 137</p>
                    <p><i class="fas fa-envelope"></i> kontakt@meatmaster.pl</p>
                </div>

                <!-- Kolumna 2: Godziny otwarcia -->
                <div class="kolumna-stopki">
                    <h3>Godziny otwarcia</h3>
                    <p>Pon-Pt: 6:00 - 22:00</p>
                    <p>Sob: 7:00 - 14:00</p>
                    <p>Niedz: Zamknięte</p>
                </div>

                <!-- Kolumna 3: Media społecznościowe -->
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