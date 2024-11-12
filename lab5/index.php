<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

$pages = [
    'home' => 'home.php',
    'gallery' => 'gallery.php',
    'most1' => 'php/most1.php',
    'most2' => 'php/most2.php',
    'most3' => 'php/most3.php',
    'most4' => 'php/most4.php',
    'most5' => 'php/most5.php',
    'changebackground' => 'php/changebackground.php',
    'kontakt' => 'php/kontakt.php',
    'videos'=> 'php/videos.php'
];

$page = isset($_GET['page']) ? $_GET['page'] : 'home';
$file_to_include = isset($pages[$page]) ? $pages[$page] : $pages['home'];

if (file_exists($file_to_include)) {
    ob_start(); 
    include $file_to_include; 
    $content = ob_get_clean(); 
} else {
    $content = "<p>Page not found.</p>";
}

$template = file_get_contents('html/template.html');

$output = str_replace('{{content}}', $content, $template);

echo $output;
?>
