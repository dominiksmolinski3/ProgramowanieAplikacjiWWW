<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Mosty</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="../js/menu.js"></script>
    <script src="../js/colorbackground.js"></script>
    <script src="../js/timedate.js"></script>
    <script src="../js/jquery.js"></script>
</head>

<body onload="loadMenu(); loadBackground(); startclock();">
    <div id="menu"></div>

    <div id = "zegarek"></div>
    
    <div id = "data"></div>
    <h1>Zmień Tło!</h1>
    <form method="POST" name="background">
        <input type="button" value="Tło 1" onclick="changeBackground('../img/backgrounds/background1.jpg')">
        <input type="button" value="Tło 2" onclick="changeBackground('../img/backgrounds/background2.jpg')">
        <input type="button" value="Tło 3" onclick="changeBackground('../img/backgrounds/background3.jpg')">
        <input type="button" value="Tło 4" onclick="changeBackground('../img/backgrounds/background4.jpg')">
        <input type="button" value="Tło 5" onclick="changeBackground('../img/backgrounds/background5.jpg')">
    </form>
    
</body>

</html>