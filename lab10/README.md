Zadanie 1. Stwórz system zarządzania kategoriami do produktów w sklepie internetowym.
Wykorzystaj w tym celu znane z dodawania produktów metody i zapytania SQL. W tym celu -> w
bazie danych stwórz nową tabelę, która będzie przetrzymywad dane o naszych kategoriach i
podkategoriach. Tabela SQL powinna zawierad min: id (w trybie auto_increment), matka (pole typu
integer, domyślnie wartośd = 0), nazwa (pole typu VARCHAR). Kategorie główne nie mają matki bo
same nimi są, więc przyjmują wartośd 0. Podkategorie (dzieci swoich matek) w polu matka mają id
należące do ich matki. Generowanie drzewa kategorii -> zastosuj pętle zagnieżdżone, aby w pierwszej
pętli wyświetlid kategorie główne (matki), a w drugiej pętli -> podkategorie (dzieci należące do
matek).
Przykładowa struktura systemu zarządzania kategoriami. Można to rozwiązad tworząc zestaw kilku
metod:
DodajKategorie()
UsunKategorie()
EdytujKategorie()
PokazKategorie()
lub
ZarzadzajKategoriami() w formie rozbudowanej metody, która zawiera warunki dla powyższych
działao.
lub
ZarzadzajKategoriami() w formie klasy + metody powyżej
TIP 2. Pętle zagnieżdżone to optymalne rozwiązanie do wyświetlania kategorii i podkategorii.
TIP 3. Pamiętaj o LIMIT w zapytaniu SQL i działaniu awaryjnym break w pętlach.
Zadanie 2. Zaimplementuj zbudowany system w posiadanym już panelu CMS