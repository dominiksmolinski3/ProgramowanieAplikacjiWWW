
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formularz Kontaktowy</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
<?php
// contact.php
require '../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load configuration
$config = require '../cfg/cfgsmtp.php';

// Function to display the contact form
function PokazKontakt() {
    echo "<strong><a href='admin.php'>Wróć do panelu głównego</a></strong><br>";
    echo '
    <form method="post" action="contact.php">
        <h2>Formularz Kontaktowy</h2>
        <label for="email">Twój e-mail:</label><br>
        <input type="email" name="email" id="email" required><br><br>

        <label for="temat">Temat:</label><br>
        <input type="text" name="temat" id="temat" required><br><br>

        <label for="tresc">Treść:</label><br>
        <textarea name="tresc" id="tresc" rows="5" required></textarea><br><br>

        <input type="hidden" name="action" value="sendContact">
        <input type="submit" value="Wyślij">
    </form>
    <hr>
    <form method="post" action="contact.php">
        <h2>Przypomnij hasło</h2>
        <input type="hidden" name="action" value="remindPassword">
        <input type="email" name="email" id="email_reminder" placeholder="Podaj e-mail" required><br><br>
        <input type="submit" value="Przypomnij hasło">
    </form>';
}

// Function to send contact email
function WyslijMailKontakt($config) {
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
        $mail->addAddress($_POST['email']); // Use the email provided in the form

        $mail->isHTML(false);
        $mail->Subject = $_POST['temat'];
        $mail->Body = $_POST['tresc'];

        $mail->send();
        echo "Wiadomość została wysłana.";

        // Redirect after sending the email to prevent resending on refresh
        header("Location: contact.php?success=true");
        exit;

    } catch (Exception $e) {
        echo "Błąd podczas wysyłania wiadomości: {$mail->ErrorInfo}";
    }
}

// Function to send admin password reminder
function PrzypomnijHaslo($config) {
    if (empty($_POST['email'])) {
        // Show error message if the email field is empty after form submission
        echo 'Proszę podać adres e-mail.';
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
        $mail->setFrom($config['smtp_username'], 'Administrator');
        $mail->addAddress($_POST['email']); // Use the email provided in the form

        $mail->Subject = 'Przypomnienie hasla do panelu admina';
        $mail->Body = "Twoje haslo do panelu admina to: " . $config['admin_password'];

        $mail->send();
        echo 'Wiadomość z przypomnieniem hasła została wysłana.';

        // Redirect after sending the password reminder
        header("Location: contact.php?password_reminder=true");
        exit;

    } catch (Exception $e) {
        echo "Błąd podczas wysyłania wiadomości: {$mail->ErrorInfo}";
    }
}

// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    switch ($action) {
        case 'sendContact':
            WyslijMailKontakt($config);
            break;
        case 'remindPassword':
            PrzypomnijHaslo($config);
            break;
    }
} else {
    // Display the appropriate form based on the GET parameter
    if (isset($_GET['success']) && $_GET['success'] === 'true') {
        echo '<p>Wiadomość została pomyślnie wysłana!</p>';
        PokazKontakt();
    } elseif (isset($_GET['password_reminder']) && $_GET['password_reminder'] === 'true') {
        echo '<p>Wiadomość z przypomnieniem hasła została wysłana!</p>';
        PokazKontakt();
    } else {
        PokazKontakt();
    }
}
?>
</body>
</html>
