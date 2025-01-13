Zadanie 1. Stwórz prosty koszyk do sklepu internetowego oparty o $_SESSION. Posłuż się
przykładowym kodem do zbudowania części funkcjonalności. Koszyk powinien mied możliwośd
dodawania i usuwania produktów. Produkty dodane do koszyka powinny mied możliwośd edycji ilości
szt. Koszyk powinien zliczad wartośd produktów w nim znajdujących się po cenach brutto (czyli cena
netto + wartośd podatku VAT).
TIP 2. Tablica zmiennych $_SESSION jest tablicą jednowymiarową, aby zapisad w sposób
uporządkowany tablice dwuwymiarową w tablicy jednowymiarowej posłużymy się programistyczną
sztuczką i „upchniemy” w jeden wymiar - dwa wymiary.
Przykładowe użycie $_SESSION w koszyku:
Przykładowe nazwy dla metod:
addToCard()
removeFromCard()
showCard()
TIP 3. Aby usunąd zmienną z sesji użyj -> unset($_SESSION[$nazwa_zmiennej])
TIP 4. Koszyki zaawansowane mają dodatkowe możliwości tj. zapisanie produktów w koszyku w
bazie danych, umożliwia to monitorowanie co klienci wrzucają do koszyka, obliczanie statystyk
porzuconych koszyków zakupów. Jest to istotne z punktu widzenia marketingu, jeżeli wiemy że klient
chce kupid ale nie kupił – można go dodatkowo zachęcid np. rabatem.
TIP 5. Zwród uwagę na resetowanie ilości produktów w koszyku, oraz na ilośd parametru count po
usunięciu produktu. Nałożenie się numeracji produktów w koszyku prowadzi do wadliwego działania
koszyka.
Zadanie 2. Zaimplementuj zbudowany system w produktach swojej aplikacji WWW.