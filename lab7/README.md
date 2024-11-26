Zadanie 1. Oznacz projekt jako wersja v1.6, wykonaj poniższe czynności modyfikujące projekt.
Utwórz w pliku admin.php metodę FormularzLogowania(), zdefiniuj zmienne $login i $pass w pliku
cfg.php. Utwórz warunki dostępu do dalszych metod administracyjnych w pliku admin.php. Jeśli
logowanie się nie powiodło, zwród komunikat o błędzie i wyświetl pod nim FormularzLogowania().
Wykorzystaj zmienną typu $_SESSION do zapamiętania informacji o logowaniu.
Zadanie 2. W pliku admin.php utwórz metodę ListaPodstron(), wyświetl z pomocą pętli while, liste
podstron (pokaż: id, tytuł podstrony, przyciski usuo i edytuj.
Przykład wyświetlenia danych z bazy z użyciem pętli:
Zadanie 3. W pliku admin.php utwórz metodę EdytujPodstrone(), stwórz formularz edycji podstrony:
pole typu <input type=”text”> dla tytułu, pole <textarea> dla treści strony, <input type="checkbox">
dla oznaczenia czy strona ma byd aktywna czy nieaktywna.
Zadanie 4. W pliku admin.php utwórz metodę DodajNowaPodstrone(), użyj zapytania SQL typu
INSERT, w metodzie zbuduj formularz dodawania podstrony.
TIP 2. Sprytnie można użyd formularz z metody EdytujPodstrone()
Zadanie 5. W pliku admin.php utwórz metodę UsunPodstrone(), wykorzystaj polecenie DELETE w
zapytaniu SQL po ID podstrony, w celu jej usunięcia.
TIP 3. W zapytaniach typu UPDATE, DELETE, SELECT zawsze używaj na koocu parametru LIMIT, np.
dla potrzeby naszego projektu CMSa należy użyd LIMIT 1, oznacza to że modyfikacji ulegnie pierwszy
znaleziony rekord. W przypadku gdy warunek jest „nieszczelny”, i brakuje opcji LIMIT, można
„wysadzid” sobie całą bazę – historia pełna jest takich przypadków. Chodzi o sytuacje, gdzie np.
wszystkie treści strony przez przypadek, lub w wyniku ataku SQL INJECTION są zastępowane np.
NULLem.