// Prosty skrypt do filtrowania i sortowania produktów
document.addEventListener('DOMContentLoaded', function() {
    // Pobieramy elementy strony
    const selectKategoria = document.getElementById('kategoria');
    const selectSortowanie = document.getElementById('sortowanie');
    const kontener = document.querySelector('.siatka-produktow');
    const produkty = Array.from(document.querySelectorAll('.karta-produktu'));

    // Funkcja do filtrowania i sortowania
    function aktualizujWidok() {
        const kategoria = selectKategoria.value;
        const sortowanie = selectSortowanie.value;

        // Filtrowanie
        let przefiltrowane = produkty.filter(produkt => {
            if (kategoria === 'wszystkie') return true;
            if (kategoria === 'kebab') {
                return produkt.dataset.kategoria === 'kebab' || 
                       produkt.dataset.kategoria === 'kebab-drobiowe';
            }
            return produkt.dataset.kategoria === kategoria;
        });

        // Sortowanie
        if (sortowanie === 'cena-rosnaco') {
            przefiltrowane.sort(sortujCenaRosnaco);
        } else if (sortowanie === 'cena-malejaco') {
            przefiltrowane.sort(sortujCenaMalejaco);
        } else if (sortowanie === 'nazwa') {
            przefiltrowane.sort(sortujNazwa);
        }

        // Wyświetlanie
        kontener.innerHTML = '';
        przefiltrowane.forEach(p => kontener.appendChild(p));
    }

    // Funkcje sortujące
    function sortujCenaRosnaco(a, b) {
        return pobierzCene(a) - pobierzCene(b);
    }

    function sortujCenaMalejaco(a, b) {
        return pobierzCene(b) - pobierzCene(a);
    }

    function sortujNazwa(a, b) {
        const nazwaA = a.querySelector('.nazwa-produktu').textContent.toLowerCase();
        const nazwaB = b.querySelector('.nazwa-produktu').textContent.toLowerCase();
        return nazwaA.localeCompare(nazwaB);
    }

    // Pomocnicza funkcja do pobierania ceny
    function pobierzCene(produkt) {
        const cenaText = produkt.querySelector('.cena-produktu').textContent;
        const cena = parseFloat(cenaText.replace(' zł/kg', '').replace(',', '.'));
        return isNaN(cena) ? 0 : cena; // Dla "Zapytaj o ofertę" zwracamy 0
    }

    // Nasłuchiwanie zmian w selectach
    selectKategoria.addEventListener('change', aktualizujWidok);
    selectSortowanie.addEventListener('change', aktualizujWidok);

    // Inicjalizacja
    aktualizujWidok();
});