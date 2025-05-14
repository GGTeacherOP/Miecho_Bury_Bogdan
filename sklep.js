// 1. Znajdź potrzebne elementy
const kategorieSelect = document.getElementById('kategoria');
const sortowanieSelect = document.getElementById('sortowanie');
const kontenerProduktow = document.querySelector('.siatka-produktow');
const wszystkieProdukty = Array.from(document.querySelectorAll('.karta-produktu'));

// 2. Funkcja aktualizująca produkty
function aktualizujProdukty() {
  const wybranaKategoria = kategorieSelect.value;
  const sposobSortowania = sortowanieSelect.value;
  
  // Filtruj produkty
  const przefiltrowane = wszystkieProdukty.filter(produkt => {
    const kategoria = produkt.dataset.kategoria;
    return wybranaKategoria === 'wszystkie' || 
           kategoria === wybranaKategoria ||
           (wybranaKategoria === 'kebab' && (kategoria === 'kebab' || kategoria === 'kebab-drobiowe'));
  });

  // Sortuj produkty
  przefiltrowane.sort((a, b) => {
    if (sposobSortowania === 'cena-rosnaco') {
      return pobierzCene(a) - pobierzCene(b);
    } else if (sposobSortowania === 'cena-malejaco') {
      return pobierzCene(b) - pobierzCene(a);
    } else if (sposobSortowania === 'nazwa') {
      return pobierzNazwe(a).localeCompare(pobierzNazwe(b));
    }
    return 0;
  });

  // Wyświetl produkty
  kontenerProduktow.innerHTML = '';
  przefiltrowane.forEach(p => kontenerProduktow.appendChild(p));
}

// 3. Pomocnicze funkcje
function pobierzCene(produkt) {
  const cenaText = produkt.querySelector('.cena-produktu').textContent;
  return cenaText.includes('Zapytaj') ? 0 : parseFloat(cenaText);
}

function pobierzNazwe(produkt) {
  return produkt.querySelector('.nazwa-produktu').textContent.toLowerCase();
}

// 4. Nasłuchuj zmian
kategorieSelect.addEventListener('change', aktualizujProdukty);
sortowanieSelect.addEventListener('change', aktualizujProdukty);