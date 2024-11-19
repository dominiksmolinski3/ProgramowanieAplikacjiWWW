Zadanie 1. Oznacz projekt jako wersja v1.5, wykonaj poniższe czynności modyfikujące projekt.
Utwórz katalog admin w swoim projekcie. W katalogu admin, utwórz plik admin.php
Zadanie 2. Uruchom z pomocą panelu XAMPP, bazy danych MySQL. Następnie uruchom opcje
„admin” dla baz danych. Otworzy się środowisko do obsługi baz danych PHPmyAdmin.
Następnie wykonaj czynności:
1. Utwórz bazę danych: moja_strona
2. Utwórz w bazie danych tabele: page_list
Zdefiniuj pola (kolumny) tabeli ich typy: id -> autoincrement, start od 1, page_title ->
varchar(255), page_content -> text, status -> INTEGER, domyślną wartośd ustaw na 1.
3. Wprowadź do tabeli zawartośd swoich podstron z użyciem PHPmyAdmin.
TIP 2. Opcjonalnie można w tabeli page_list dodad dodatkowe pole: alias –> varchar(20), UNIQUE,
które pozwoli również na wyszukiwanie zawartości stron.
Zadanie 3. Połącz swoją stronę z bazą danych. Utwórz plik cfg.php w folderze głównym projektu. Plik
zaimplementuj cfg.php wywołaj w metodzie include() na początku pliku index.php
TIP 3. Sprawdź jakie masz ustawioną domyślną nazwę użytkownika i hasło, zależnie od środowiska
może byd root/root lub jeszcze inaczej.
Zadanie 4. Utwórz plik showpage.php i użyj zapytania SELECT do wyświetlenia treści swojej strony
WWW. Opakuj to odpowiednimi warunkami (zmodyfikuj warunki jakie miałeś w wersji 1.4 to
includowania plików html.
TIP 4. Podstawowym elementem optymalizacji wyszukiwania w bazach danych jest ustawienie
odpowiedniej wartości parametru LIMIT. Jeżeli nie ma parametru limit, a w bazie jest np. milion
rekordów, to nawet jak znajdzie ten dla nas najważniejszy – zapytanie będzie wykonywało się do
samego kooca bazy. Jest to niepotrzebne obciążenie, gdy wiemy, że wynik już został znaleziony.
TIP 5. W bazach MySQL, zapytanie LIMIT można użyd z dwoma parametrami, początku i kooca –
używa się to najczęściej do tworzenia stronicowania długich list rekordów.
TIP 6. Tu w naszej stronie pojawia się potencjalna luka w zabezpieczeniach, wszędzie tam gdzie są
pobierane pola z POST lub GET, należy byd czułym na zagrożenie. Ktoś może próbowad podstawid
inne parametry, a nawet całe kody skryptów i przejąd kontrolę nad stroną lub wykraśd wrażliwe dane.