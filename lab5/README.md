Zadanie 1. Utwórz plik labor_nr_indeksu_nr_grupy.php, w pliku wyświetl za pomocą funkcji echo()
swoje imię.
<?
 $nr_indeksu = ‘1234567’;
 $nrGrupy = ‘X’;
 echo ‘Jan Kowalski ‘.$nr_indeksu.’ grupa ‘.$nrGrupy.’ <br /><br />’;
 echo ‘Zastosowanie metody include() <br />’;
?>
TIP 1. Użycie w echo pojedynczego apostrofu ‘ informuje interpreter kodu aby nie sprawdzad go pod
kątem wyszukiwania zmiennych. Zastosowanie podwójnego apostrofu ”, informuje interpreter, że w
danym stringu mogą byd zmienne i będzie próbował je znaleźd – co jest bardziej obciążające.
Optymalnie jest więc pisad np. echo ‘wyświetl moją zmienną: ’.$zmienna.’ I lecimy dalej’;
TIP 2. W środowisku XAMPP, pliku php należy umieścid w folderze xampp/htdocs/moj_projekt
TIP 3. Gdy środowisko jest uruchomione do naszej strony dostajemy się poprzez wpisanie w oknie
przeglądarki -> localhost/mój_projekt/nazwa_pliku.php
Zadanie 2. Wykonaj poniższe podpunkty w pliku plik labor_nr_indeksu_nr_grupy.php poprzedzając je
opisem punktu w echo().
a) Metoda include(), require_once() -> https://www.php.net/manual/en/function.include.php
b) Warunki if, else, elseif, switch -> https://www.php.net/manual/en/control-structures.if.php
c) Pętla while() i for() -> https://www.php.net/manual/en/control-structures.while.php
d) Typy zmiennych $_GET, $_POST, $_SESSION ->
https://www.php.net/manual/en/reserved.variables.get
Zadanie 3. Uporządkuj strukturę swojej strony do wersji v1.3 (przygotowanie do przerobienia jej na
php). W tym celu, utwórz foldery: html, img, css, js. W folderach osadź odpowiednio pliki swojej
strony. Plik index.html zostaw w folderze głównym (nie wrzucaj go do katalogu z pozostałymi plikami
podstron). Pozmieniaj ścieżki plików dostosowując je do nowej struktury folderów (linki, grafiki, js)
tak aby strona działała poprawnie.