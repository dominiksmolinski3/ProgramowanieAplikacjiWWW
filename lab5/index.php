<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Mosty</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/menu.js"></script>
    <script src="js/colorbackground.js"></script>
    <script src="js/timedate.js"></script>
    <script src="js/jquery.js"></script>
</head>
<body class="centered-content" onload="loadMenu(); loadIndexBackground(); startclock();">
    <div id="menu"></div>
    <div id="zegarek"></div>
    <div id="data"></div>

    <?php
        $page = isset($_GET['page']) ? $_GET['page'] : 'home';

        switch ($page) {
            case 'gallery':
                include 'gallery.php';
                break;
            case 'home':
            default:
                include 'home.php';
                break;
        }
    ?>

    <script src="js/main.js"></script>
</body>
</html>
