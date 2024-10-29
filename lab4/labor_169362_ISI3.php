<?php
$nr_indeksu = '169362';
$nrGrupy = 'ISI3';
echo 'Dominik Smolinski '.$nr_indeksu.' grupa '.$nrGrupy.' <br /><br />';

// a) Metoda include() i require_once()
echo 'Punkt a) Metoda include() i require_once() <br />';
// Tworzymy plik do załączenia, np. "header.php", który możemy włączyć do kodu
include('header.php');  // Zakładając, że plik header.php istnieje
require_once('footer.php'); // Zakładając, że plik footer.php istnieje

// b) Warunki if, else, elseif, switch
echo 'Punkt b) Warunki if, else, elseif, switch <br />';
$liczba = 10;

if ($liczba > 10) {
    echo 'Liczba jest większa niż 10 <br />';
} elseif ($liczba == 10) {
    echo 'Liczba jest równa 10 <br />';
} else {
    echo 'Liczba jest mniejsza niż 10 <br />';
}

$kolor = 'czerwony';
switch ($kolor) {
    case 'czerwony':
        echo 'Kolor to czerwony <br />';
        break;
    case 'zielony':
        echo 'Kolor to zielony <br />';
        break;
    default:
        echo 'Nieznany kolor <br />';
}

// c) Pętla while() i for()
echo 'Punkt c) Pętla while() i for() <br />';
echo 'Pętla while: ';
$i = 1;
while ($i <= 5) {
    echo $i . ' ';
    $i++;
}
echo '<br />';

echo 'Pętla for: ';
for ($j = 1; $j <= 5; $j++) {
    echo $j . ' ';
}
echo '<br />';

// d) Typy zmiennych $_GET, $_POST, $_SESSION
echo 'Punkt d) Typy zmiennych $_GET, $_POST, $_SESSION <br />';

echo 'Metoda $_GET <br />';
if (isset($_GET['param'])) {
    echo 'Wartość parametru GET: ' . htmlspecialchars($_GET['param']) . '<br />';
} else {
    echo 'Brak parametru GET <br />';
}

echo 'Metoda $_POST <br />';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['param'])) {
    echo 'Wartość parametru POST: ' . htmlspecialchars($_POST['param']) . '<br />';
} else {
    echo 'Brak parametru POST <br />';
}

session_start();
$_SESSION['przykladowa_wartosc'] = 'Sesja działa!';
echo 'Wartość z sesji: ' . $_SESSION['przykladowa_wartosc'] . '<br />';
?>
