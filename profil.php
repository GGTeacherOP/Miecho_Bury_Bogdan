<?php
require_once "sesje.php";

// Obsługa wylogowania
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['wyloguj'])) {
    session_unset();
    session_destroy();
    header("Location: logowanie.php");
    exit;
}

// Pobranie danych użytkownika z sesji
$uzytkownik = [
    'imie' => $_SESSION['imie'],
    'nazwisko' => $_SESSION['nazwisko'],
    'email' => $_SESSION['user_email'],
    'telefon' => '+48 123 456 789',
    'rejestracja' => date('d.m.Y', strtotime('now')),
    'typ_konta' => $_SESSION['rola'] === 'pracownik' ? 'Pracownik' : ($_SESSION['typ_konta'] ?? 'Klient indywidualny'),
    'zamowienia' => 15,
    'wartosc' => '3450 zł'
];

// Dodanie stanowiska dla pracownika
if ($_SESSION['rola'] === 'pracownik') {
    $uzytkownik['stanowisko'] = $_SESSION['stanowisko'];
}

$inicjaly = strtoupper(substr($uzytkownik['imie'], 0, 1) . substr($uzytkownik['nazwisko'], 0, 1));
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MeatMaster - Profil użytkownika</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="icon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .sekcja-profilu {
            padding: 80px 0;
            background: #f5f5f5;
            min-height: calc(100vh - 300px);
        }

        .kontener-profilu {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            gap: 30px;
        }

        .naglowek-profilu {
            display: flex;
            align-items: center;
            gap: 30px;
            border-bottom: 1px solid #eee;
            padding-bottom: 20px;
        }

        .awatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background-color: #c00;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 48px;
            font-weight: bold;
        }

        .informacje-uzytkownika h2 {
            color: #c00;
            margin-bottom: 10px;
            font-size: 28px;
        }

        .typ-konta {
            display: inline-block;
            background: #c00;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 14px;
            margin-top: 5px;
        }

        .sekcja-statystyk {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .statystyka {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            border-left: 4px solid #c00;
        }

        .statystyka h3 {
            color: #333;
            font-size: 16px;
            margin-bottom: 10px;
        }

        .wartosc-statystyki {
            font-size: 28px;
            font-weight: bold;
            color: #c00;
        }

        .sekcja-danych {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .grupa-danych {
            margin-bottom: 20px;
        }

        .grupa-danych h3 {
            color: #333;
            margin-bottom: 10px;
            font-size: 18px;
            border-bottom: 2px solid #eee;
            padding-bottom: 5px;
        }

        .dane {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .etykieta {
            font-weight: 600;
            color: #666;
        }

        .wartosc {
            color: #333;
        }

        .przyciski-pracownika {
            display: flex;
            gap: 15px;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .przycisk-pracownika {
            flex: 1;
            min-width: 200px;
            padding: 12px;
            background: #c00;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 4px;
            font-weight: 600;
            transition: 0.3s;
        }

        .przycisk-pracownika:hover {
            background: #a00;
            transform: translateY(-2px);
        }

        .przycisk-wyloguj {
            width: 100%;
            padding: 14px;
            background: #c00;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 30px;
        }

        .przycisk-wyloguj:hover {
            background: #a00;
        }

        @media (max-width: 600px) {
            .naglowek-profilu {
                flex-direction: column;
                text-align: center;
            }

            .awatar {
                margin: 0 auto;
            }

            .przycisk-pracownika {
                min-width: 100%;
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
                </ul>
            </nav>
        </div>
    </header>

    <section class="sekcja-profilu">
        <div class="kontener-profilu">
            <div class="naglowek-profilu">
                <div class="awatar"><?= $inicjaly ?></div>
                <div class="informacje-uzytkownika">
                    <h2><?= htmlspecialchars($uzytkownik['imie'] . ' ' . $uzytkownik['nazwisko']) ?></h2>
                    <p><?= htmlspecialchars($uzytkownik['email']) ?></p>
                    <span class="typ-konta"><?= htmlspecialchars($uzytkownik['typ_konta']) ?></span>
                </div>
            </div>

            <div class="sekcja-statystyk">
                <div class="statystyka">
                    <h3>Złożone zamówienia</h3>
                    <div class="wartosc-statystyki"><?= $uzytkownik['zamowienia'] ?></div>
                </div>
                <div class="statystyka">
                    <h3>Wartość zamówień</h3>
                    <div class="wartosc-statystyki"><?= $uzytkownik['wartosc'] ?></div>
                </div>
            </div>

            <div class="sekcja-danych">
                <div class="grupa-danych">
                    <h3>Dane osobowe</h3>
                    <div class="dane">
                        <span class="etykieta">Imię:</span>
                        <span class="wartosc"><?= htmlspecialchars($uzytkownik['imie']) ?></span>
                    </div>
                    <div class="dane">
                        <span class="etykieta">Nazwisko:</span>
                        <span class="wartosc"><?= htmlspecialchars($uzytkownik['nazwisko']) ?></span>
                    </div>
                </div>

                <div class="grupa-danych">
                    <h3>Dane kontaktowe</h3>
                    <div class="dane">
                        <span class="etykieta">Telefon:</span>
                        <span class="wartosc"><?= htmlspecialchars($uzytkownik['telefon']) ?></span>
                    </div>
                    <div class="dane">
                        <span class="etykieta">Data rejestracji:</span>
                        <span class="wartosc"><?= htmlspecialchars($uzytkownik['rejestracja']) ?></span>
                    </div>
                </div>

                <?php if ($_SESSION['rola'] === 'pracownik'): ?>
                    <div class="grupa-danych">
                        <h3>Informacje o pracowniku</h3>
                        <div class="dane">
                            <span class="etykieta">Stanowisko:</span>
                            <span class="wartosc"><?= htmlspecialchars($uzytkownik['stanowisko']) ?></span>
                        </div>

                        <div class="przyciski-pracownika">
                            <?php if (in_array($_SESSION['stanowisko'], ['Kierownik', 'Programista'])): ?>
                                <a href="pracownicy.php" class="przycisk-pracownika">Zarządzaj pracownikami</a>
                                <a href="towar.php" class="przycisk-pracownika">Zarządzaj towarem</a>
                            <?php endif; ?>

                            <?php if (!in_array($_SESSION['stanowisko'], ['Kierownik', 'Programista'])): ?>
                                <a href="reklamacje.php" class="przycisk-pracownika">Przeglądaj reklamacje</a>
                                <a href="zamowienia.php" class="przycisk-pracownika">Przeglądaj zamówienia</a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <form method="post">
                <button type="submit" name="wyloguj" class="przycisk-wyloguj">Wyloguj się</button>
            </form>
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