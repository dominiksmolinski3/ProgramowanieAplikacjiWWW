<?php
session_start();
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
    include '../cfg.php'; // This file should define $login and $pass variables

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
        }
    } else {
        // Domyślnie wyświetlamy listę podstron
        ListaPodstron();
    }
}


function ListaPodstron() {
    global $mysqli; // Używamy połączenia z bazy danych zdefiniowanego w cfg.php

    // Zapytanie do bazy o podstrony
    $query = "SELECT * FROM page_list LIMIT 30"; // LIMIT 10 do pokazania tylko 10 podstron
    $result = $mysqli->query($query); // Wykonanie zapytania

    echo "<h3>Lista podstron</h3>";
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
        echo '<h3>Dodaj Nową Podstronę</h3>';
        echo '<form method="post">
                Tytuł: <input type="text" name="page_title"><br>
                Treść: <textarea name="page_content"></textarea><br>
                Aktywna: <input type="checkbox" name="status"><br>
                <input type="submit" value="Dodaj Podstronę">
              </form>';
    }
}


function UsunPodstrone($id) {
    global $mysqli;

    // Zapytanie do usunięcia podstrony
    $query = "DELETE FROM page_list WHERE id = ? LIMIT 1";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();

    echo "Podstrona została usunięta!";
    ListaPodstron();
}



?>
