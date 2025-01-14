<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admina</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
<?php
// admin.php
session_start([
    'cookie_httponly' => true,
    'cookie_secure' => isset($_SERVER['HTTPS']), // Set to true if using HTTPS
    'use_strict_mode' => true,
]);

include '../cfg/cfg.php'; // db config

if (session_status() !== PHP_SESSION_ACTIVE) {
    die('Unable to start session.');
}

require_once 'categoryManager.php';
require_once 'productManager.php';

$categoryManager = new categoryManager($dbhost, $dbuser, $dbpass, $dbname);
$productManager = new productManager($dbhost, $dbuser, $dbpass, $dbname);

if (session_status() !== PHP_SESSION_ACTIVE) {
    die('Unable to start session.');
}

function FormularzLogowania() {
    echo '<form method="post">
            Login: <input type="text" name="login"><br>
            Hasło: <input type="password" name="pass"><br>
            <input type="submit" value="Zaloguj">
          </form>';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_SESSION['zalogowany'])) {
    include '../cfg/cfg.php'; // This file should define $login and $pass variables

    $entered_login = $_POST['login'] ?? '';
    $entered_pass = $_POST['pass'] ?? '';

    if ($entered_login === $login && $entered_pass === $pass) {
        $_SESSION['zalogowany'] = true;
        header("Location: admin.php"); // Redirect to avoid resubmission of the form
        exit;
    } else {
        echo "Nieprawidłowy login lub hasło.";
    }
}

// Logout logic
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: admin.php");
    exit;
}

if (!isset($_SESSION['zalogowany'])) {
    FormularzLogowania();
}
elseif (isset($_GET['type']) && $_GET['type'] === 'category') {
    $action = $_GET['action'] ?? '';
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    switch ($action) {
        case 'add':
            DodajKategorie($categoryManager);
            break;
        case 'edit':
            if ($id > 0) {
                EdytujKategorie($categoryManager, $id);
            }
            break;
        case 'delete':
            if ($id > 0) {
                UsunKategorie($categoryManager, $id);
            }
            break;
        default:
            // Display the category list
            ListaKategorii($categoryManager);
            break;
    }
} elseif (isset($_GET['type']) && $_GET['type'] === 'product') {
    $action = $_GET['action'] ?? '';
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    switch ($action) {
        case 'add':
            DodajProdukt($productManager);
            break;
        case 'edit':
            if ($id > 0) {
                EdytujProdukt($productManager, $id);
            }
            break;
        case 'delete':
            if ($id > 0) {
                UsunProdukt($productManager, $id);
            }
            break;
        default:
            ListaProduktow($productManager);
            break;
    }
} else {
    // Default to managing pages
    if (isset($_GET['action'])) {
        $action = $_GET['action'];
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

        if ($action == 'add') {
            DodajNowaPodstrone();
        }
        elseif ($action == 'edit' && $id > 0) {
            EdytujPodstrone($id);
        } elseif ($action == 'delete' && $id > 0) {
            UsunPodstrone($id);
        } elseif ($action == 'delete_confirmed') {
            UsunPodstroneConfirmed();
        } else {
            ListaPodstron();
        }
    } else {
        ListaPodstron();
    }
}

function DodajKategorie($categoryManager) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'];
        $parentId = $_POST['parent_id'] ?? 0;

        $categoryManager->addCategory($name, $parentId);

        echo "Kategoria została dodana!<br>";
        echo "<a href='admin.php?type=category'>Powróć do listy kategorii</a>";
    } else {
        echo '<h3>Dodaj kategorię</h3>';
        echo '<form method="post">
                Nazwa: <input type="text" name="name" required><br>
                Rodzic: 
                <select name="parent_id">
                    <option value="0">Główna kategoria</option>';
        $categoryManager->displayCategoriesForSelect();
        echo '  </select><br>
                <input type="submit" value="Dodaj">
              </form>';
    }
}

function EdytujKategorie($categoryManager, $id) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'];
        $parentId = $_POST['parent_id'] ?? 0;

        $categoryManager->editCategory($id, $name, $parentId);

        echo "Kategoria została zaktualizowana!<br>";
        echo "<a href='admin.php?type=category'>Powróć do listy kategorii</a>";
    } else {
        $category = $categoryManager->getCategory($id);

        echo '<h3>Edytuj kategorię</h3>';
        echo '<form method="post">
                Nazwa: <input type="text" name="name" value="' . $category['nazwa'] . '"><br>
                Rodzic: 
                <select name="parent_id">
                    <option value="0">Główna kategoria</option>';
        $categoryManager->displayCategoriesForSelect(0, 0, $category['matka']);
        echo '  </select><br>
                <input type="submit" value="Zapisz">
              </form>';
    }
}
function UsunKategorie($categoryManager, $id) {
    $categoryManager->deleteCategory($id);

    echo "Kategoria została usunięta!<br>";
    echo "<a href='admin.php?type=category'>Powróć do listy kategorii</a>";
}

function ListaKategorii($categoryManager) {
    echo "<h3>Lista kategorii</h3>";
    echo "<a href='admin.php?type=category&action=add'>Dodaj kategorię</a><br>";
    echo "<a href='admin.php'>Powróć do listy podstron</a><br><br>";
    $categoryManager->displayCategories();

}


function ListaPodstron() {
    global $mysqli; // Używamy połączenia z bazy danych zdefiniowanego w cfg.php

    // Zapytanie do bazy o podstrony
    $query = "SELECT * FROM page_list LIMIT 30"; // LIMIT 10 do pokazania tylko 10 podstron
    $result = $mysqli->query($query); // Wykonanie zapytania

    echo "<h3>Lista podstron</h3>";
    echo "<a href='admin.php?action=add'>Dodaj stronę</a><br>";
    echo "<a href='contact.php'>Przejdz do kontaktu</a><br>";
    echo "<a href='admin.php?type=category'>Przejdz do kategorii</a><br>";
    echo "<a href='admin.php?type=product'>Przejdz do produktow</a><br>";

    if ($result->num_rows > 0) {
        // Wyświetlanie wyników w tabeli
        echo "<table>";
        echo "<tr><th>ID</th><th>Tytuł</th><th>Aktywna</th><th>Edytuj</th><th>Usuń</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['page_title'] . "</td>";
            echo "<td>" . ($row['status'] ? 'Tak' : 'Nie') . "</td>";
            echo "<td><a href='admin.php?action=edit&id=" . $row['id'] . "'>Edytuj</a></td>";
            echo "<td><a href='admin.php?action=delete&id=" . $row['id'] . "'>Usuń</a></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "Brak podstron w bazie.";
    }

}



function EdytujPodstrone($id) {
    global $mysqli;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $page_title = $_POST['page_title'];
        $page_content = $_POST['page_content'];
        $status = isset($_POST['status']) ? 1 : 0;

        // Zapytanie do bazy w celu aktualizacji podstrony
        $query = "UPDATE page_list SET page_title = ?, page_content = ?, status = ? WHERE id = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('ssii', $page_title, $page_content, $status, $id);
        $stmt->execute();

        echo "Podstrona została zaktualizowana!";
        ListaPodstron();
    } else {
        // Pobieranie danych podstrony z bazy
        $query = "SELECT * FROM page_list WHERE id = ? LIMIT 1";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        // Wyświetlanie formularza z danymi podstrony
        echo '<form method="post">
                Tytuł: <input type="text" name="page_title" value="' . $row['page_title'] . '"><br>
                Treść: <textarea name="page_content">' . $row['page_content'] . '</textarea><br>
                Aktywna: <input type="checkbox" name="status" ' . ($row['status'] ? 'checked' : '') . '><br>
                <input type="submit" value="Zapisz">
              </form>';
    }
}

function DodajNowaPodstrone() {
    global $mysqli;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $page_title = $_POST['page_title'];
        $page_content = $_POST['page_content'];
        $status = isset($_POST['status']) ? 1 : 0;

        // Zapytanie SQL do dodania nowej podstrony
        $query = "INSERT INTO page_list (page_title, page_content, status) VALUES (?, ?, ?)";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('ssi', $page_title, $page_content, $status);
        $stmt->execute();

        echo "Nowa podstrona została dodana!<br>";
        echo "<a href='admin.php'>Powróć do listy podstron</a>";
    } else {
        // Wyświetlanie formularza
        echo '<form method="post">
                <h3>Dodaj Nową Podstronę</h3>
                Tytuł: <input type="text" name="page_title"><br>
                Treść: <textarea name="page_content"></textarea><br>
                Aktywna: <input type="checkbox" name="status"><br>
                <input type="submit" value="Dodaj Podstronę">
              </form>';
    }
}


function UsunPodstrone($id) {
    // Display a confirmation form instead of relying on JavaScript
    echo '<form method="post" action="admin.php?action=delete_confirmed">
            <h3>Czy na pewno chcesz usunąć tę podstronę?</h3>
            <input type="hidden" name="id" value="' . $id . '">
            <button type="submit">Tak, usuń</button>
            <button type="button" onclick="window.location.href=\'admin.php\'">Anuluj</button>
          </form>';
}

function UsunPodstroneConfirmed() {
    global $mysqli;

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
        $id = (int)$_POST['id'];

        // Execute deletion
        $query = "DELETE FROM page_list WHERE id = ? LIMIT 1";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();

        // Redirect after processing
        header("Location: admin.php");
        exit; // Ensure the script stops executing after the redirect
    }

    // If no valid POST request, redirect to the list as fallback
    header("Location: admin.php");
    exit;
}

function DodajProdukt($productManager) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Ensure to capture all necessary inputs (fields that match your ProductManager class)
        $tytul = $_POST['tytul'];
        $opis = $_POST['opis'];
        $data_wygasniecia = $_POST['data_wygasniecia'];
        $cena_netto = $_POST['cena_netto'];
        $podatek_vat = $_POST['podatek_vat'];
        $ilosc = $_POST['ilosc'];
        $status_dostepnosci = $_POST['status_dostepnosci'] ?? 0; // Assuming 0 for unavailable, 1 for available
        $kategoria_id = $_POST['kategoria_id'] ?? 0;
        $gabaryt = $_POST['gabaryt'];
        $zdjecie = $_FILES['zdjecie']['name']; // Assuming image upload handling will be done

        $kategoria_id = (int)$kategoria_id;

        $productManager->addProduct($tytul, $opis, $data_wygasniecia, $cena_netto, $podatek_vat, $ilosc, $status_dostepnosci, $kategoria_id, $gabaryt, $zdjecie);
        echo "Produkt został dodany!<br>";
        echo "<a href='admin.php?type=product'>Powróć do listy produktów</a>";
    } else {
        echo '<h3>Dodaj produkt</h3>';
        echo '<form method="post" enctype="multipart/form-data">
                Tytuł: <input type="text" name="tytul" required><br>
                Opis: <textarea name="opis" required></textarea><br>
                Data wygaśnięcia: <input type="date" name="data_wygasniecia"><br>
                Cena netto: <input type="number" step="0.01" name="cena_netto" required><br>
                Podatek VAT: <input type="number" step="0.01" name="podatek_vat" required><br>
                Ilość: <input type="number" name="ilosc" required><br>
                Status dostępności: <input type="checkbox" name="status_dostepnosci" value="1"><br>
                Kategoria: 
                <select name="kategoria_id">
                    <option value="0">Bez kategorii</option>';
        global $categoryManager;
        $categoryManager->displayCategoriesForSelect();
        echo '  </select><br>
                Gabaryt: 
                <select name="gabaryt">
                    <option value="small">Small</option>
                    <option value="medium">Medium</option>
                    <option value="large">Large</option>
                </select><br>
                Zdjęcie: <input type="file" name="zdjecie" accept="image/*" required><br>
                <input type="submit" value="Dodaj">
              </form>';
    }
}


function EdytujProdukt($productManager, $id) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Capture form data
        $tytul = $_POST['tytul'];
        $opis = $_POST['opis'];
        $data_wygasniecia = $_POST['data_wygasniecia'];
        $cena_netto = $_POST['cena_netto'];
        $podatek_vat = $_POST['podatek_vat'];
        $ilosc = $_POST['ilosc'];
        $status_dostepnosci = $_POST['status_dostepnosci'] ?? 0;
        $kategoria_id = $_POST['kategoria_id'] ?? 0;
        $gabaryt = $_POST['gabaryt'];
        $zdjecie = $_FILES['zdjecie']['name'];

        // Handle file upload for the image
        if ($_FILES['zdjecie']['error'] === UPLOAD_ERR_OK) {
            move_uploaded_file($_FILES['zdjecie']['tmp_name'], 'uploads/' . $zdjecie);
        }

        // Update the product details
        $productManager->editProduct($id, $tytul, $opis, $data_wygasniecia, $cena_netto, $podatek_vat, $ilosc, $status_dostepnosci, $kategoria_id, $gabaryt, $zdjecie);

        echo "Produkt został zaktualizowany!<br>";
        echo "<a href='admin.php?type=product'>Powróć do listy produktów</a>";
    } else {
        // Fetch current product data
        $product = $productManager->getProduct($id);

        echo '<h3>Edytuj produkt</h3>';
        echo '<form method="post" enctype="multipart/form-data">
                Tytuł: <input type="text" name="tytul" value="' . htmlspecialchars($product['tytul']) . '"><br>
                Opis: <textarea name="opis">' . htmlspecialchars($product['opis']) . '</textarea><br>
                Data wygaśnięcia: <input type="date" name="data_wygasniecia" value="' . $product['data_wygasniecia'] . '"><br>
                Cena netto: <input type="number" step="0.01" name="cena_netto" value="' . $product['cena_netto'] . '" required><br>
                Podatek VAT: <input type="number" step="0.01" name="podatek_vat" value="' . $product['podatek_vat'] . '" required><br>
                Ilość: <input type="number" name="ilosc" value="' . $product['ilosc'] . '" required><br>
                Status dostępności: <input type="checkbox" name="status_dostepnosci" value="1" ' . ($product['status_dostepnosci'] ? 'checked' : '') . '><br>
                Kategoria: 
                <select name="kategoria_id">';
        global $categoryManager;
        $categoryManager->displayCategoriesForSelect(0, 0);
        echo '  </select><br>
                Gabaryt: <input type="text" name="gabaryt" value="' . $product['gabaryt'] . '"><br>
                Zdjęcie: <input type="file" name="zdjecie" accept="image/*"><br>
                <input type="submit" value="Zapisz">
              </form>';
    }
}


function UsunProdukt($productManager, $id) {
    $productManager->deleteProduct($id);

    echo "Produkt został usunięty!<br>";
    echo "<a href='admin.php?type=product'>Powróć do listy produktów</a>";
}


function ListaProduktow($productManager) {
    echo "<h3>Lista produktów</h3>";
    echo "<a href='admin.php?type=product&action=add'>Dodaj produkt</a><br><br>";
    echo "<a href='admin.php'>Powróć do listy podstron</a><br><br>";
    $productManager->displayProducts();
}




?>
</body>
</html>