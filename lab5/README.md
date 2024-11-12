Zadanie 1. Zmieo nazwę pliku indexu swojej strony WWW, na rozszerzenie .php, następnie dodaj do
niego identyfikator projektu. Poniższy kod umieśd na koocu pliku index.php
<?
 $nr_indeksu = ‘1234567’;
 $nrGrupy = ‘X’;
 echo ‘Autor: Jan Kowalski ‘.$nr_indeksu.’ grupa ‘.$nrGrupy.’ <br /><br />’;
?>
TIP 1. Aby wszystko działało prawidło pamiętaj, aby umieścid kod przed sekcją zamknięcia </body>
Zadanie 2. Posłuż się zmienną $_GET i metodą include() do wywołania treści strony. Zmodyfikuj
menu swojej strony, aby poprawnie otwierała treści. Odseparuj szablon strony od treści.
W statystycznych stronach HTML, szablon strony zazwyczaj jest powiązany z treścią – jest
duplikowany na każdej podstronie. W stronach generowanych dynamicznie, szablon możemy
oddzielid i skupid się na „includowaniu” wyłącznie treści. Zrób kopię projektu swojego strony (kopie
zawsze dobrze mied, a najlepiej dwie kopie). Następnie oznaczą ją jako wersja v1.4, wykonaj poniższe
czynności modyfikujące projekt:
1. Oczyśd wszystkie pliki z katalogu /html elementów szablonu, jakie są już w pliku index.php.
Oczyśd również ze znaczników <html>, <body>, <meta> i ich zamknięd. Czynnośd ta ma na
celu uniknięcia duplikacji „śmiecenia” kodu poprzez podwójne tagi i elementy szablonu.
2. W pliku index.php treśd strony wytnij i zapisz w folderze /html/glowna.html. Teraz plik
index.php powinien byd już samą strukturą szablonu naszej strony, a cała treśd powinna byd
w zewnętrznych plikach w katalogu /html.
3. Na początku pliku index.php dodaj tagi PHP ->
<?
 error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
 /* po tym komentarzu będzie kod do dynamicznego ładowania stron */
?>
Metoda error_reporting() wymusza na środowisku aby pokazywało wszystkie możliwe błędy,
ostrzeżenia i uwagi związane z kompilacją naszego kodu.
4. Dodaj warunki z użyciem $_GET do wszystkich swoich podstron.
Przykład:
 if($_GET[‘idp’] == ‘’) $strona = ‘/html/glowna.html’;
 if($_GET[‘idp’] == ‘podstrona1’) $strona = ‘/html/podstrona1.html’;
 if($_GET[‘idp’] == ‘podstrona2’) $strona = ‘/html/podstrona2.html’;
5. Dodaj metodę include() w miejscu szablonu w pliku index.php gdzie chcesz, aby wyświetliła
się treśd strony. Jako parametr metody podaj $strona, czyli include($strona);
6. Zmodyfikuj linki w menu dodając w nich parametry wywołania odpowiedniej podstrony, np.
index.php?idp=podstrona1.
7. Dodaj warunek sprawdzający (zabezpiecz warunki), czy dany plik (podstrona) istnieje
patrz: https://www.php.net/manual/en/function.file-exists.php
8. Gotowe, jeśli wszystko zrobiłeś poprawnie – powinno działad. Jeśli nie, wród do pierwszego
zadania i przeanalizuj, co poszło nie tak. Debuguj do skutku.
TIP 2. Strony „includowane” wymagają dostosowania ścieżek do plików graficznych, js, css. Teraz jeśli
otwieramy treśd pliku znajdującego się w katalogu /html, to jego treśd będzie interpretowana tak jak
w miejscu znajdowania się pliku .php, który „includuje” dany plik.
TIP 3. W profesjonalnej realizacji projektu, kopie trzymamy w repozytorium np. GitLab –
repozytorium pozwala na powrót lub zajrzenie do starszych wersji kodu. Często starsze, są lepiej
działające niż nowsze – stąd repozytorium ma potężną moc naprawczą dla rzeczy, które się zepsuły.
Zadanie 3. Stwórz nową podstronę o nazwie „filmy” i dodaj na niej 3 nawiązujące do tematyki twojej
strony filmy. Możesz w tym celu wykorzystad gotowe implementacje np. youtube. Zapoznaj się z
tagiem html <iframe>.
TIP 4. Na YouTube przy każdym filmie jest przycisk „Udostępnij”, po kliknięciu jest do wyboru < >, a
tam jest kod <iframe> z linkiem do filmu.