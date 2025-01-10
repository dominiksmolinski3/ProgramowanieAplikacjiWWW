<?php
session_start();

// Użycie istniejącego połączenia z bazą danych
global $mysqli;
include '../cfg/cfg.php'; // db config

// Sprawdzamy, czy koszyk istnieje, jeśli nie to go tworzymy
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Funkcja do wyświetlania produktów
function displayProducts() {
    global $mysqli;

    // Zapytanie SQL do pobrania produktów
    $query = "SELECT id, tytul, cena_netto, podatek_vat FROM products WHERE status_dostepnosci = 1";
    $result = $mysqli->query($query);

    if ($result->num_rows > 0) {
        echo '<h2>Produkty</h2>';
        echo '<div class="product-grid">';
        while ($row = $result->fetch_assoc()) {
            $cenaBrutto = $row['cena_netto'] * (1 + $row['podatek_vat'] / 100);
            echo '<div class="product">';
            echo '<h3>' . htmlspecialchars($row['tytul']) . '</h3>';
            echo '<p>Cena netto: ' . number_format($row['cena_netto'], 2) . ' zł</p>';
            echo '<p>VAT: ' . number_format($row['podatek_vat'], 2) . '%</p>';
            echo '<p>Cena brutto: ' . number_format($cenaBrutto, 2) . ' zł</p>';
            echo '<button class="add-to-cart" onclick="location.href=\'koszyk.php?add_to_cart=' . $row['id'] . '\'">Dodaj do koszyka</button>';
            echo '</div>';
        }
        echo '</div>';
    } else {
        echo 'Brak produktów w ofercie.';
    }
}

// Funkcja dodająca produkt do koszyka
function addToCart($productId) {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $productId) {
            $item['quantity']++;
            $found = true;
            break;
        }
    }

    if (!$found) {
        $_SESSION['cart'][] = ['id' => $productId, 'quantity' => 1];
    }
}

// Funkcja do wyświetlania koszyka
function showCart() {
    global $mysqli;

    if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
        $cartIds = array_column($_SESSION['cart'], 'id');
        $idsPlaceholder = implode(',', $cartIds);

        $query = "SELECT id, tytul, cena_netto, podatek_vat FROM products WHERE id IN ($idsPlaceholder)";
        $result = $mysqli->query($query);

        echo '<h2>Twój koszyk</h2>';
        echo '<table>';
        echo '<tr><th>Produkt</th><th>Cena netto</th><th>VAT</th><th>Ilość</th><th>Cena brutto</th><th>Akcja</th></tr>';

        $total = 0;
        while ($product = $result->fetch_assoc()) {
            $quantity = 0;
            foreach ($_SESSION['cart'] as $item) {
                if ($item['id'] == $product['id']) {
                    $quantity = $item['quantity'];
                    break;
                }
            }

            $cenaBrutto = $product['cena_netto'] * (1 + $product['podatek_vat'] / 100);
            $sumaBrutto = $cenaBrutto * $quantity;
            $total += $sumaBrutto;

            echo "<tr>
                    <td>{$product['tytul']}</td>
                    <td>" . number_format($product['cena_netto'], 2) . " zł</td>
                    <td>" . number_format($product['podatek_vat'], 2) . "%</td>
                    <td>{$quantity}</td>
                    <td>" . number_format($cenaBrutto, 2) . " zł</td>
                    <td><a href='koszyk.php?remove_from_cart={$product['id']}'>Usuń</a></td>
                  </tr>";
        }

        echo "<tr><td colspan='5'>Łączna wartość: " . number_format($total, 2) . " zł</td></tr>";
        echo '</table>';
        echo '<a href="koszyk.php?clear_cart=true" class="btn btn-secondary">Wyczyść koszyk</a>';
    } else {
        echo 'Twój koszyk jest pusty.';
    }
}

// Funkcja do usuwania produktu z koszyka
function removeFromCart($productId) {
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['id'] == $productId) {
            unset($_SESSION['cart'][$key]);
            break;
        }
    }
}

// Funkcja do czyszczenia koszyka
function clearCart() {
    $_SESSION['cart'] = [];
}

// Obsługa żądań HTTP (dodawanie do koszyka, usuwanie z koszyka, czyszczenie koszyka)
if (isset($_GET['add_to_cart'])) {
    $productId = (int)$_GET['add_to_cart'];
    addToCart($productId);
    header('Location: koszyk.php');
    exit;
}

if (isset($_GET['remove_from_cart'])) {
    $productId = (int)$_GET['remove_from_cart'];
    removeFromCart($productId);
    header('Location: koszyk.php');
    exit;
}

if (isset($_GET['clear_cart'])) {
    clearCart();
    header('Location: koszyk.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/shop.css">
    <title>Koszyk</title>
</head>
<body>

<?php
echo '<a href="koszyk.php?view_cart=true" class="btn btn-secondary">Zobacz koszyk</a>';
echo '<a href="koszyk.php" class="btn btn-secondary">Powrót do produktów</a>';
if (!isset($_GET['view_cart'])) {
    displayProducts();  // Wyświetlamy produkty, jeśli nie jesteśmy w koszyku
} else {
    showCart();  // Wyświetlamy koszyk, jeśli użytkownik chce zobaczyć zawartość koszyka
}
?>

</body>
</html>
