<?php
session_start();
$db = mysqli_connect('localhost', 'root', '', 'meatmasters');

// Pobierz dane zalogowanego użytkownika
$dane_uzytkownika = [
    'imie' => '',
    'email' => '',
    'telefon' => ''
];

if (isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] && isset($_SESSION['user_id'])) {
    $result = mysqli_query($db, "SELECT imie, nazwisko, email, telefon FROM klienci WHERE id = {$_SESSION['user_id']}");
    if ($result && $row = mysqli_fetch_assoc($result)) {
        $dane_uzytkownika = [
            'imie' => $row['imie'] . ' ' . $row['nazwisko'],
            'email' => $row['email'],
            'telefon' => $row['telefon']
        ];
    }
}

// Obsługa formularza
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $imie = mysqli_real_escape_string($db, $_POST['imie'] ?? '');
    $email = mysqli_real_escape_string($db, $_POST['email'] ?? '');
    $telefon = mysqli_real_escape_string($db, $_POST['telefon'] ?? '');
    $temat = mysqli_real_escape_string($db, $_POST['temat'] ?? '');
    $wiadomosc = mysqli_real_escape_string($db, $_POST['wiadomosc'] ?? '');

    if (!empty($imie) && !empty($email) && !empty($wiadomosc)) {
        $klient_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'NULL';
        
        $sql = "INSERT INTO kontakty (klient_id, imie, email, telefon, temat, wiadomosc) 
                VALUES ($klient_id, '$imie', '$email', '$telefon', '$temat', '$wiadomosc')";
        
        if (mysqli_query($db, $sql)) {
            $komunikat = '<div class="komunikat-sukces">Wiadomość została wysłana!</div>';
        } else {
            $komunikat = '<div class="komunikat-blad">Błąd: ' . mysqli_error($db) . '</div>';
        }
    } else {
        $komunikat = '<div class="komunikat-blad">Proszę wypełnić wszystkie wymagane pola</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontakt - MeatMaster</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="icon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .komunikat-sukces {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            margin: 15px 0;
            border-radius: 5px;
        }
        .komunikat-blad {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            margin: 15px 0;
            border-radius: 5px;
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
                    <?php if (isset($_SESSION['zalogowany']) && $_SESSION['zalogowany'] === true): ?>
                        <li><a href="profil.php"><i class="fas fa-user"></i> Profil</a></li>
                    <?php else: ?>
                        <li><a href="logowanie.php"><i class="fas fa-user"></i> Logowanie</a></li>
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
        <section class="sekcja-o-nas">
            <div class="kontener">
                <h2 class="tytul-sekcji">Nasz zespół kontaktowy</h2>
                
                <?php if (isset($komunikat)) echo $komunikat; ?>
                
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
                    <form method="POST" class="contact-form">
                        <input type="hidden" name="imie" value="<?= htmlspecialchars($dane_uzytkownika['imie']) ?>">
                        <input type="hidden" name="email" value="<?= htmlspecialchars($dane_uzytkownika['email']) ?>">
                        <input type="hidden" name="telefon" value="<?= htmlspecialchars($dane_uzytkownika['telefon']) ?>">
                        
                        <div class="form-group">
                            <label for="temat">Temat wiadomości</label>
                            <select id="temat" name="temat" required>
                                <option value="">-- Wybierz temat --</option>
                                <option value="zamowienie">Zamówienie</option>
                                <option value="reklamacja">Reklamacja</option>
                                <option value="wspolpraca">Współpraca</option>
                                <option value="inne">Inne</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="wiadomosc">Treść wiadomości</label>
                            <textarea id="wiadomosc" name="wiadomosc" rows="5" required></textarea>
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