<?php
class CategoryManager {
    private $conn;

    public function __construct($dbHost, $dbUser, $dbPass, $dbName) {
        $this->conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    // Dodaj kategorię
    public function addCategory($name, $parentId = 0) {
        $stmt = $this->conn->prepare("INSERT INTO categories (nazwa, matka) VALUES (?, ?)");
        $stmt->bind_param("si", $name, $parentId);
        $stmt->execute();
        $stmt->close();
    }

    // Usuń kategorię
    public function deleteCategory($id) {
        $stmt = $this->conn->prepare("DELETE FROM categories WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }

    // Edytuj kategorię
    public function editCategory($id, $name, $parentId = 0) {
        $stmt = $this->conn->prepare("UPDATE categories SET nazwa = ?, matka = ? WHERE id = ?");
        $stmt->bind_param("sii", $name, $parentId, $id);
        $stmt->execute();
        $stmt->close();
    }

    // Wyświetl kategorie z rekurencją
    public function displayCategories($parentId = 0, $level = 0) {
        $stmt = $this->conn->prepare("SELECT id, nazwa FROM categories WHERE matka = ?");
        $stmt->bind_param("i", $parentId);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            echo str_repeat("--", $level) . " " . $row['nazwa'] . "<br>";
            $this->displayCategories($row['id'], $level + 1);
        }

        $stmt->close();
    }
    public function getCategory($id) {
        $stmt = $this->conn->prepare("SELECT * FROM categories WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function displayCategoriesForSelect($parentId = 0, $level = 0) {
        // Prepare the query to fetch categories with the specified parent ID
        $stmt = $this->conn->prepare("SELECT id, nazwa FROM categories WHERE matka = ?");
        $stmt->bind_param("i", $parentId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        // Iterate through each category and display it as an option in the dropdown
        while ($row = $result->fetch_assoc()) {
            // Display the category with indentation based on level
            echo '<option value="' . $row['id'] . '">' . str_repeat("--", $level) . ' ' . htmlspecialchars($row['nazwa']) . '</option>';
            
            // Recursively display subcategories, incrementing the level for nested categories
            $this->displayCategoriesForSelect($row['id'], $level + 1);
        }
        
        // Close the prepared statement
        $stmt->close();
    }
    
    
    
}
?>
