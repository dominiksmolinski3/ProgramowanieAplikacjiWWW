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

    <h1>Napisz do nas!</h1>
     
     <form class="contact" action="mailto:adres@example.com" method="post" enctype="text/plain">
         <label for="name">Imię i nazwisko:</label><br>
         <input type="text" id="name" name="name"><br><br>
 
         <label for="email">Adres e-mail:</label><br>
         <input type="email" id="email" name="email"><br><br>
 
         <label for="message">Wiadomość:</label><br>
         <textarea id="message" name="message" rows="5" cols="40"></textarea><br><br>
 
         <input type="submit" value="Wyślij">
     </form>
</body>
</html>