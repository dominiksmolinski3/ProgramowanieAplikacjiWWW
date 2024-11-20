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

$page = isset($_GET['page']) ? $_GET['page'] : 'home';
$page_title = isset($pages[$page]) ? $pages[$page] : $pages['home'];

$stmt = $mysqli->prepare("SELECT page_content FROM page_list WHERE page_title = ? LIMIT 1");
$stmt->bind_param('s', $page_title); 
$stmt->execute();
$stmt->bind_result($content);
$stmt->fetch();

if (!$content) {
    $content = "<p>Page not found.</p>";
}

$template = file_get_contents('html/template.html');

$output = str_replace('{{content}}', $content, $template);

echo $output;

$stmt->close();
$mysqli->close();
?>
