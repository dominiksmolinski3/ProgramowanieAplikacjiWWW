Zadanie 1. Oznacz projekt jako wersja v1.7, wykonaj poniższe czynności modyfikujące projekt.
Utwórz plik contact.php i utwórz w nim trzy metody:
1. PokazKontakt()
2. WyslijMailKontakt() -> TIP 2. Patrz koniec pliku dwiczenia – przykład.
3. PrzypomnijHaslo()
Zadanie 2. W metodzie PokazKontakt() skomponuj formularz kontaktowy HTML kompatybilny z
metodą WyslijMailKontakt().
Zadanie 3. W metodzie PrzypomnijHaslo() użyj modyfikacji metody WyslijMailKontakt(), celem
wysyłania maila z hasłem do panelu admina. UWAGA: jest to forma uproszczona przypominania,
słabo zabezpieczona – niebezpieczna. W wersji rozwiniętej jednym z możliwych metod przypomnienia
jest przesłanie specjalnego linka z możliwością zresetowania hasła do konta.
Zadanie 4. Zaimplementuj kod z przykładu poniżej do zaprogramowania metody WyslijMailKontakt().
Przykład metody wysyłającej mail z użyciem standardowej poczty serwera:
TIP 3. Maila można wysyład również z pomocą połączenia się do IMAP lub SMTP z użyciem klasycznej
skrzynki pocztowej. 