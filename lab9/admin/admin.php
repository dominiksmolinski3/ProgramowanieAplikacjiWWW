<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formularz Kontaktowy</title>
    <link rel="stylesheet" href="../css/admin.css"> <!-- Add this line in the <head> section -->
</head>
<body>
<?php

session_start([
    'cookie_httponly' => true,
    'cookie_secure' => isset($_SERVER['HTTPS']), // Set to true if using HTTPS
    'use_strict_mode' => true,
]);

include '../cfg.php';

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

    $entered_login = $_POST['login'] ?? '';
    $entered_pass = $_POST['pass'] ?? '';

    if ($entered_login === $login && $entered_pass === $pass) {
        session_regenerate_id(true);
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

// Sprawdzanie, czy użytkownik jest zalogowany
if (!isset($_SESSION['zalogowany'])) {
    FormularzLogowania();
} else {
    // Obsługa różnych akcji
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
        // Domyślnie wyświetlamy listę podstron
        ListaPodstron();
    }
}


function ListaPodstron() {
    global $mysqli; // Używamy połączenia z bazy danych zdefiniowanego w cfg.php

    // Zapytanie do bazy o podstrony
    $query = "SELECT * FROM page_list LIMIT 30"; // LIMIT 30 do pokazania tylko 30 podstron
    $result = $mysqli->query($query); // Wykonanie zapytania

    echo "<h3>Lista podstron</h3>";
    
    // Logout button in the ListaPodstron() function

    echo "<a href='admin.php?action=add'>Dodaj stronę</a><br>";

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
            echo "<td><a href='javascript:void(0);' onclick=\"if(confirm('Czy na pewno chcesz usunąć tę podstronę?')) window.location.href='admin.php?action=delete&id=" . $row['id'] . "';\">Usuń</a></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "Brak podstron w bazie.";
    }

    echo '<div style="text-align: center; margin-top: 30px;">
    <form method="get" action="admin.php" style="display: inline;">
        <input type="hidden" name="logout" value="1">
        <button type="submit">Wyloguj</button>
    </form>
  </div>';
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
                <button type="button" onclick="window.location.href=\'admin.php\'">Powrót do Listy Podstron</button>
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
        echo '<h3>Dodaj Nową Podstronę</h3>';
        echo '<form method="post">
                Tytuł: <input type="text" name="page_title"><br>
                Treść: <textarea name="page_content"></textarea><br>
                Aktywna: <input type="checkbox" name="status"><br>
                <input type="submit" value="Dodaj Podstronę">
                <button type="button" onclick="window.location.href=\'admin.php\'">Powrót do Listy Podstron</button>
              </form>';
    }
}


function UsunPodstrone($id) {
    // Display a confirmation form instead of relying on JavaScript
    echo '<h3>Czy na pewno chcesz usunąć tę podstronę?</h3>';
    echo '<form method="post" action="admin.php?action=delete_confirmed">
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






?>
</body>
</html>