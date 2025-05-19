// Prosty skrypt do filtrowania i sortowania produktów
document.addEventListener('DOMContentLoaded', function() {
    // 1. POBRANIE ELEMENTÓW STRONY
    const selectKategoria = document.getElementById('kategoria'); // Select z kategoriami
    const selectSortowanie = document.getElementById('sortowanie'); // Select z sortowaniem
    const kontener = document.querySelector('.siatka-produktow'); // Kontener na produkty
    const produkty = Array.from(document.querySelectorAll('.karta-produktu')); // Wszystkie produkty jako tablica

    // 2. GŁÓWNA FUNKCJA AKTUALIZUJĄCA WIDOK
    function aktualizujWidok() {
        // Pobieramy wybrane wartości
        const kategoria = selectKategoria.value;
        const sortowanie = selectSortowanie.value;

        // 2.1. FILTROWANIE PRODUKTÓW
        let przefiltrowane = produkty.filter(produkt => {
            if (kategoria === 'wszystkie') return true; // Pokazuj wszystkie produkty
            
            // Specjalna obsługa kategorii "kebab" (obejmuje też "kebab-drobiowe")
            if (kategoria === 'kebab') {
                return produkt.dataset.kategoria === 'kebab' || 
                       produkt.dataset.kategoria === 'kebab-drobiowe';
            }
            
            // Dla innych kategorii - dokładne dopasowanie
            return produkt.dataset.kategoria === kategoria;
        });

        // 2.2. SORTOWANIE PRODUKTÓW
        if (sortowanie === 'cena-rosnaco') {
            przefiltrowane.sort(sortujCenaRosnaco);
        } else if (sortowanie === 'cena-malejaco') {
            przefiltrowane.sort(sortujCenaMalejaco);
        } else if (sortowanie === 'nazwa') {
            przefiltrowane.sort(sortujNazwa);
        }

        // 2.3. WYŚWIETLANIE WYNIKÓW
        kontener.innerHTML = ''; // Wyczyszczenie kontenera
        przefiltrowane.forEach(p => kontener.appendChild(p)); // Dodanie przefiltrowanych produktów
    }

    // 3. FUNKCJE SORTUJĄCE
    function sortujCenaRosnaco(a, b) {
        return pobierzCene(a) - pobierzCene(b); // Sortowanie od najtańszego
    }

    function sortujCenaMalejaco(a, b) {
        return pobierzCene(b) - pobierzCene(a); // Sortowanie od najdroższego
    }

    function sortujNazwa(a, b) {
        const nazwaA = a.querySelector('.nazwa-produktu').textContent.toLowerCase();
        const nazwaB = b.querySelector('.nazwa-produktu').textContent.toLowerCase();
        return nazwaA.localeCompare(nazwaB); // Sortowanie alfabetyczne
    }

    // 4. FUNKCJA POMOCNICZA DO POBRANIA CENY
    function pobierzCene(produkt) {
        const cenaText = produkt.querySelector('.cena-produktu').textContent;
        // Konwersja tekstu ceny na liczbę (zamiana , na . i usunięcie "zł/kg")
        const cena = parseFloat(cenaText.replace(' zł/kg', '').replace(',', '.'));
        return isNaN(cena) ? 0 : cena; // Dla "Zapytaj o ofertę" zwracamy 0
    }

    // 5. NASŁUCHIWANIE ZDARZEŃ
    selectKategoria.addEventListener('change', aktualizujWidok); // Zmiana kategorii
    selectSortowanie.addEventListener('change', aktualizujWidok); // Zmiana sortowania

    // 6. INICJALIZACJA - PIERWSZE WYŚWIETLENIE
    aktualizujWidok();
});