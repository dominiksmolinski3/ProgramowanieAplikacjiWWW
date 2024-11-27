<?php
require '../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load configuration
$config = require '../cfgsmtp.php';

// Function to display the contact form
function PokazKontakt() {
    echo '
    <form method="post" action="contact.php">
        <label for="email">Twój e-mail:</label><br>
        <input type="email" name="email" id="email" required><br><br>

        <label for="temat">Temat:</label><br>
        <input type="text" name="temat" id="temat" required><br><br>

        <label for="tresc">Treść:</label><br>
        <textarea name="tresc" id="tresc" rows="5" required></textarea><br><br>

        <input type="hidden" name="action" value="sendContact">
        <input type="submit" value="Wyślij">
    </form>';
}

// Function to send contact email
function WyslijMailKontakt($odbiorca, $config) {
    if (empty($_POST['temat']) || empty($_POST['tresc']) || empty($_POST['email'])) {
        echo 'Nie wypełniłeś wszystkich pól.';
        return;
    }

    $mail = new PHPMailer(true);

    try {
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host = $config['smtp_host'];
        $mail->SMTPAuth = true;
        $mail->Username = $config['smtp_username'];
        $mail->Password = $config['smtp_password'];
        $mail->SMTPSecure = $config['smtp_secure'];
        $mail->Port = $config['smtp_port'];

        // Mail details
        $mail->setFrom($config['smtp_username'], 'Formularz Kontaktowy');
        $mail->addAddress($odbiorca);

        $mail->isHTML(false);
        $mail->Subject = $_POST['temat'];
        $mail->Body = $_POST['tresc'];

        $mail->send();
        echo "Wiadomość została wysłana.";
    } catch (Exception $e) {
        echo "Błąd podczas wysyłania wiadomości: {$mail->ErrorInfo}";
    }
}

// Function to send admin password reminder
function PrzypomnijHaslo($odbiorca, $config) {
    $mail = new PHPMailer(true);

    try {
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host = $config['smtp_host'];
        $mail->SMTPAuth = true;
        $mail->Username = $config['smtp_username'];
        $mail->Password = $config['smtp_password'];
        $mail->SMTPSecure = $config['smtp_secure'];
        $mail->Port = $config['smtp_port'];

        // Mail details
        $mail->setFrom($config['smtp_username'], 'Administrator');
        $mail->addAddress($odbiorca);

        $mail->Subject = 'Przypomnienie hasła do panelu admina';
        $mail->Body = "Twoje hasło do panelu admina to: " . $config['admin_password'];

        $mail->send();
        echo 'Wiadomość z przypomnieniem hasła została wysłana.';
    } catch (Exception $e) {
        echo "Błąd podczas wysyłania wiadomości: {$mail->ErrorInfo}";
    }
}

// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    switch ($action) {
        case 'sendContact':
            WyslijMailKontakt('recipient@example.com', $config); // Use recipient email
            break;
        case 'remindPassword':
            PrzypomnijHaslo('recipient@example.com', $config); // Use admin email
            break;
    }
} else {
    // Display the appropriate form based on the GET parameter
    if (isset($_GET['action']) && $_GET['action'] === 'remindPassword') {
        echo '<form method="post" action="contact.php">
                <input type="hidden" name="action" value="remindPassword">
                <input type="submit" value="Przypomnij hasło">
              </form>';
    } else {
        PokazKontakt();
    }
}
?>
