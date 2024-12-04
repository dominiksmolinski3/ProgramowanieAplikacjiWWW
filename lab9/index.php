<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

require_once 'cfg.php';

$pages = [
    'home' => 'home',
    'gallery' => 'gallery',
    'most1' => 'most1',
    'most2' => 'most2',
    'most3' => 'most3',
    'most4' => 'most4',
    'most5' => 'most5',
    'changebackground' => 'changebackground',
    'kontakt' => 'kontakt',
    'videos' => 'videos'
];

$page = isset($_GET['page']) ? $_GET['page'] : '';
$page_title = isset($pages[$page]) ? $pages[$page] : '';

$stmt = $mysqli->prepare("SELECT page_content, status FROM page_list WHERE page_title = ? LIMIT 1");
$stmt->bind_param('s', $page_title); 
$stmt->execute();
$stmt->bind_result($content, $status);
$stmt->fetch();

$notification = '';

if (empty($content)) {
    $notification = "The page was not found.";
    $content = file_get_contents('home.php'); 
} elseif ($status == 0) {
    $notification = "The page is inactive and is not available.";
    $content = file_get_contents('home.php'); 
}

$template = file_get_contents('html (backup)/template.html');
if ($template === false) {
    die("Error: Template file not found or inaccessible.");
}

$notificationScript = '';
if ($notification) {
    $notificationScript = "
        <script src='/js/notifications.js'></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                showNotification('" . addslashes($notification) . "', 'error');
            });
        </script>
    ";
    // Inject the notification script before the closing </body> tag
    $template = str_replace('</body>', $notificationScript . '</body>', $template);
}

$output = str_replace('{{content}}', $content, $template);

echo $output;

$stmt->close();
$mysqli->close();
?>
