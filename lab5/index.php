<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

$pages = [
    'home' => 'home.php',
    'gallery' => 'gallery.php',
    'most1' => 'html/most1.html',
    'most2' => 'html/most2.html',
    'most3' => 'html/most3.html',
    'most4' => 'html/most4.html',
    'most5' => 'html/most5.html',
    'changebackground' => 'html/changebackground.html',
    'kontakt' => 'html/kontakt.html',
    'videos'=> 'html/videos.html'
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
