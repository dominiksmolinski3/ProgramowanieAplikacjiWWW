<?php
class ProductManager {
    private $conn;

    public function __construct($dbHost, $dbUser, $dbPass, $dbName) {
        $this->conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    // Dodaj produkt
    public function addProduct($tytul, $opis, $data_wygasniecia, $cena_netto, $podatek_vat, $ilosc, $status_dostepnosci, $kategoria_id, $gabaryt, $zdjecie) {
        // Check if the file was uploaded
        if (isset($_FILES['zdjecie']) && $_FILES['zdjecie']['error'] === UPLOAD_ERR_OK) {
            // Handle the uploaded file
            $fileContent = file_get_contents($_FILES['zdjecie']['tmp_name']);
            $base64Image = base64_encode($fileContent);
        } else {
            // If no file was uploaded, leave the field empty
            $base64Image = '';
        }
    
        // Prepare and execute the SQL query to insert the product
        $stmt = $this->conn->prepare("INSERT INTO products (tytul, opis, data_wygasniecia, cena_netto, podatek_vat, ilosc, status_dostepnosci, kategoria_id, gabaryt, zdjecie) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssddiibbs", $tytul, $opis, $data_wygasniecia, $cena_netto, $podatek_vat, $ilosc, $status_dostepnosci, $kategoria_id, $gabaryt, $base64Image);
        $stmt->execute();
        $stmt->close();
    }
    

    // Usuń produkt
    public function deleteProduct($id) {
        $stmt = $this->conn->prepare("DELETE FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }

    // Edytuj produkt
    public function editProduct($id, $tytul, $opis, $data_wygasniecia, $cena_netto, $podatek_vat, $ilosc, $status_dostepnosci, $kategoria_id, $gabaryt, $zdjecie) {
        $stmt = $this->conn->prepare("UPDATE products SET tytul = ?, opis = ?, data_wygasniecia = ?, cena_netto = ?, podatek_vat = ?, ilosc = ?, status_dostepnosci = ?, kategoria_id = ?, gabaryt = ?, zdjecie = ? WHERE id = ?");
        $stmt->bind_param("sssddiibbsi", $tytul, $opis, $data_wygasniecia, $cena_netto, $podatek_vat, $ilosc, $status_dostepnosci, $kategoria_id, $gabaryt, $zdjecie, $id);
        $stmt->execute();
        $stmt->close();
    }

    // Wyświetl produkty
    public function displayProducts() {
        $result = $this->conn->query("SELECT * FROM products");
        while ($row = $result->fetch_assoc()) {
            // Display product details
            echo "ID: {$row['id']}, Tytuł: {$row['tytul']}, Cena netto: {$row['cena_netto']}, VAT: {$row['podatek_vat']}, Ilość: {$row['ilosc']}, Dostępność: " . ($row['status_dostepnosci'] ? "Dostępny" : "Niedostępny") . "<br>";
    
            // Display image if available
            if (!empty($row['zdjecie'])) {
                echo 'Zdjęcie: <img src="data:image/jpeg;base64,' . $row['zdjecie'] . '" alt="' . $row['tytul'] . '" style="width:100px;height:auto;"><br>';
            } else {
                echo "Brak zdjęcia<br>";
            }
    
            echo "<br>";
        }
    }
    
    

    // Warunki dostępności
    public function checkAvailability($id) {
        $stmt = $this->conn->prepare("SELECT status_dostepnosci, ilosc, data_wygasniecia FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        $available = $result['status_dostepnosci'] && $result['ilosc'] > 0 && (empty($result['data_wygasniecia']) || $result['data_wygasniecia'] > date("Y-m-d H:i:s"));
        $stmt->close();

        return $available ? "Produkt dostępny" : "Produkt niedostępny";
    }
}
?>
