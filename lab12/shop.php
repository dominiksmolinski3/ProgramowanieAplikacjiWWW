<?php
session_start();

// Użycie istniejącego połączenia z bazą danych
global $mysqli;
include 'cfg/cfg.php'; // db config

// Sprawdzamy, czy koszyk istnieje, jeśli nie to go tworzymy
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Funkcja do wyświetlania kategorii w formie listy rozwijanej
function displayCategoryDropdown() {
    global $mysqli;

    // Funkcja pomocnicza do rekurencyjnego wyświetlania kategorii
    function fetchCategories($parentId = 0, $prefix = '') {
        global $mysqli;

        $categoryQuery = "SELECT id, nazwa FROM categories WHERE matka = $parentId";
        $categoryResult = $mysqli->query($categoryQuery);

        $options = '';
        if ($categoryResult->num_rows > 0) {
            while ($category = $categoryResult->fetch_assoc()) {
                $selected = (isset($_GET['category_id']) && $_GET['category_id'] == $category['id']) ? 'selected' : '';
                $options .= '<option value="' . $category['id'] . '" ' . $selected . '>' . $prefix . htmlspecialchars($category['nazwa']) . '</option>';
                
                // Rekurencja dla podkategorii
                $options .= fetchCategories($category['id'], $prefix . '--');
            }
        }

        return $options;
    }

    echo '<form action="shop.php" method="get" class="category-dropdown">';
    echo '<select name="category_id" onchange="this.form.submit()">';
    echo '<option value="">Wybierz kategorię</option>';
    echo fetchCategories(); // Wywołanie funkcji pomocniczej
    echo '</select>';
    echo '</form>';
}

// Funkcja do wyświetlania kategorii i produktów
function displayCategoriesAndProducts() {
    global $mysqli;

    // Sprawdzamy, czy została wybrana kategoria
    $categoryId = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 0;

    // Funkcja pomocnicza do rekurencyjnego wyciągania podkategorii
    function fetchCategoriesAndProducts($parentId = 0, $categoryId = 0) {
        global $mysqli;

        // Zapytanie SQL do pobrania kategorii
        $categoryQuery = "SELECT id, nazwa FROM categories WHERE matka = $parentId";
        $categoryResult = $mysqli->query($categoryQuery);

        if ($categoryResult->num_rows > 0) {
            while ($category = $categoryResult->fetch_assoc()) {
                // Jeśli kategoria została wybrana, wyświetlamy jej produkty
                if ($categoryId == 0 || $categoryId == $category['id'] || isDescendant($category['id'], $categoryId)) {
                    echo '<h4>' . htmlspecialchars($category['nazwa']) . '</h4>';

                    // Zapytanie SQL do pobrania produktów danej kategorii i jej podkategorii
                    $productQuery = "
                        SELECT id, tytul, cena_netto, podatek_vat, gabaryt, zdjecie 
                        FROM products 
                        WHERE status_dostepnosci = 1 
                        AND (kategoria_id = " . $category['id'] . " OR kategoria_id IN (SELECT id FROM categories WHERE matka = " . $category['id'] . "))
                    ";
                    $productResult = $mysqli->query($productQuery);

                    if ($productResult->num_rows > 0) {
                        echo '<div class="product-grid">';
                        while ($row = $productResult->fetch_assoc()) {
                            $cenaBrutto = $row['cena_netto'] * (1 + $row['podatek_vat'] / 100);
                            echo '<div class="product">';
                            echo '<h3>' . htmlspecialchars($row['tytul']) . '</h3>';
                            echo '<p>Cena netto: ' . number_format($row['cena_netto'], 2) . ' zł</p>';
                            echo '<p>VAT: ' . number_format($row['podatek_vat'], 2) . '%</p>';
                            echo '<p>Cena brutto: ' . number_format($cenaBrutto, 2) . ' zł</p>';
                            echo '<p>Gabaryt: ' . htmlspecialchars($row['gabaryt']) . '</p>';

                            // Wyświetlanie zdjęcia, jeśli istnieje
                            if ($row['zdjecie']) {
                                echo 'Zdjęcie: <img src="data:image/jpeg;base64,' . $row['zdjecie'] . '" alt="' . $row['tytul'] . '" style="width:100px;height:auto;"><br>';
                            } else {
                                echo '<p>Brak zdjęcia</p>';
                            }

                            // Przycisk dodania do koszyka
                            echo '<button class="add-to-cart" onclick="location.href=\'shop.php?add_to_cart=' . $row['id'] . '\'">Dodaj do koszyka</button>';
                            echo '</div>';
                        }
                        echo '</div>';
                    } else {
                        echo '<b>Brak produktów w tej kategorii.</b>';
                    }
                }

                // Rekurencyjne wywołanie dla podkategorii
                fetchCategoriesAndProducts($category['id'], $categoryId);
            }
        }
    }

    // Funkcja pomocnicza do sprawdzenia, czy kategoria jest podkategorią
    function isDescendant($categoryId, $parentId) {
        global $mysqli;

        // Sprawdzamy, czy kategoria jest podkategorią danej kategorii
        $query = "SELECT 1 FROM categories WHERE id = $categoryId AND matka = $parentId";
        $result = $mysqli->query($query);
        return $result->num_rows > 0;
    }

    // Wywołanie funkcji do wyświetlania kategorii i produktów
    fetchCategoriesAndProducts(0, $categoryId);
}

// Funkcja dodająca produkt do koszyka
function addToCart($productId, $quantity = 1) {
    global $mysqli;

    // Check if the product exists in the database and get the stock quantity
    $query = "SELECT ilosc FROM products WHERE id = $productId";
    $result = $mysqli->query($query);

    if ($result && $result->num_rows > 0) {
        $product = $result->fetch_assoc();
        $availableStock = $product['ilosc'];

        // If the requested quantity is greater than the available stock, set an error message
        if ($quantity > $availableStock) {
            $_SESSION['cart_error'] = 'Niestety, nie posiadamy tyle towaru w asortymencie.';
            return; // Stop adding the product to the cart
        }

        // Proceed with adding the product to the cart
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        $found = false;
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] == $productId) {
                // If the product is already in the cart, update its quantity
                if ($item['quantity'] + $quantity <= $availableStock) {
                    $item['quantity'] += $quantity;
                    $found = true;
                } else {
                    $_SESSION['cart_error'] = 'Niestety, nie posiadamy tyle towaru w asortymencie.';
                }
                break;
            }
        }

        if (!$found) {
            // Add the product to the cart if it's not already there
            $_SESSION['cart'][] = ['id' => $productId, 'quantity' => $quantity];
        }
    } else {
        $_SESSION['cart_error'] = 'Produkt nie istnieje lub wystąpił błąd podczas pobierania danych o produkcie.';
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
        echo '<form action="shop.php" method="get">';
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
                    <td><input type='number' name='quantity[{$product['id']}]' value='{$quantity}' min='1' /></td>
                    <td>" . number_format($cenaBrutto, 2) . " zł</td>
                    <td><a href='shop.php?remove_from_cart={$product['id']}'>Usuń</a></td>
                  </tr>";
        }

        echo "<tr><td colspan='5'>Łączna wartość: " . number_format($total, 2) . " zł</td></tr>";
        echo '</table>';
        echo '<button type="submit" name="update_cart" class="btn btn-secondary">Zaktualizuj koszyk</button>';
        echo '</form>';
        echo '<a href="shop.php?clear_cart=true" class="btn btn-secondary">Wyczyść koszyk</a>';
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




?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/shop.css">
    <title>Sklep</title>
    <link rel="icon" href="img/webicon.png" type="image/png">
</head>
<body>

<div class="center-container">
    <div class="sidebar">
        <?php displayCategoryDropdown(); ?>
        
        <a href="shop.php?view_cart=true" class="btn-back">Zobacz koszyk</a>
        <a href="shop.php" class="btn-back">Powrót do produktów</a>
        <a href="index.php?page=home" class="btn-back">Powrót na stronę</a>
    </div>
</div>



<?php
// Check if there is an error message in the session
if (isset($_SESSION['cart_error'])) {
    // Output the JavaScript alert with the error message
    echo "<script>alert('" . htmlspecialchars($_SESSION['cart_error'], ENT_QUOTES, 'UTF-8') . "');</script>";
    // Clear the error message after displaying it
    unset($_SESSION['cart_error']);
}

if (!isset($_GET['view_cart'])) {
    displayCategoriesAndProducts();  // Wyświetlamy produkty pogrupowane po kategoriach
} else {
    showCart();  // Wyświetlamy koszyk
}
// Obsługa żądań HTTP (dodawanie do koszyka, usuwanie z koszyka, czyszczenie koszyka)
if (isset($_GET['add_to_cart'])) {
    $productId = (int)$_GET['add_to_cart'];
    addToCart($productId);
    header('Location: shop.php');
    exit;
}

if (isset($_GET['remove_from_cart'])) {
    $productId = (int)$_GET['remove_from_cart'];
    removeFromCart($productId);
    header('Location: shop.php');
    exit;
}

if (isset($_GET['clear_cart'])) {
    clearCart();
    header('Location: shop.php');
    exit;
}
// Obsługa zmiany ilości sztuk w koszyku
if (isset($_GET['update_cart'])) {
    if (isset($_GET['quantity'])) {
        foreach ($_GET['quantity'] as $productId => $newQuantity) {
            $newQuantity = (int)$newQuantity;
            
            // Check if the new quantity is available in stock
            $query = "SELECT ilosc FROM products WHERE id = $productId";
            $result = $mysqli->query($query);
            if ($result && $result->num_rows > 0) {
                $product = $result->fetch_assoc();
                $availableStock = $product['ilosc'];

                // Update the quantity if available stock is sufficient
                if ($newQuantity > $availableStock) {
                    echo "<script>alert('Niestety, nie posiadamy tyle towaru w asortymencie.');</script>";
                } else {
                    // Update the quantity in the cart
                    foreach ($_SESSION['cart'] as &$item) {
                        if ($item['id'] == $productId) {
                            $item['quantity'] = $newQuantity;
                            break;
                        }
                    }
                }
            }
        }
    }
    header('Location: shop.php?view_cart=true');
    exit;
}
?>

</body>
</html>
