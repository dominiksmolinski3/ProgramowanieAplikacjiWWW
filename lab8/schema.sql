-- Create the page_list table
CREATE TABLE `page_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_title` varchar(255) NOT NULL,
  `page_content` text NOT NULL,
  `status` int(11) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16402;

-- Insert records into page_list table
INSERT INTO `page_list` (`id`, `page_title`, `page_content`, `status`) VALUES
(1, 'template', '<!-- template.html -->\n<!DOCTYPE html>\n<html lang="pl">\n<head>\n    <meta charset="UTF-8">\n    <title>Mosty</title>\n    <link rel="stylesheet" href="css/style.css">\n    <script src="js/menu.js"></script>\n    <script src="js/colorbackground.js"></script>\n    <script src="js/timedate.js"></script>\n    <script src="js/jquery.js"></script>\n</head>\n<body class="centered-content" onload="loadMenu(); loadIndexBackground(); startclock();">\n    <div id="menu"></div>\n    <div id="zegarek"></div>\n    <div id="data"></div>\n\n    <!-- Content Placeholder -->\n    {{content}}\n\n</body>\n</html>', 1),
(2, 'gallery', '<h2>Galeria Mostów</h2>\n<div class="gallery">\n    <img src="img/gallery/1.jpg" alt="1" width="200" height="300">\n    <img src="img/gallery/2.jpg" alt="2" width="200" height="300">\n    <img src="img/gallery/3.jpg" alt="3" width="200" height="300">\n    <img src="img/gallery/4.jpg" alt="4" width="200" height="300">\n    <img src="img/gallery/5.jpg" alt="5" width="200" height="300">\n    <img src="img/gallery/6.jpg" alt="6" width="200" height="300">\n    <img src="img/gallery/7.jpg" alt="7" width="200" height="300">\n    <img src="img/gallery/8.jpg" alt="8" width="200" height="300">\n    <img src="img/gallery/9.jpg" alt="9" width="200" height="300">\n    <img src="img/gallery/10.jpg" alt="10" width="200" height="300">\n    <img src="img/gallery/11.jpg" alt="11" width="200" height="300">\n    <img src="img/gallery/12.jpg" alt="12" width="200" height="300">\n    <img src="img/gallery/13.jpg" alt="13" width="200" height="300">\n    <img src="img/gallery/14.jpg" alt="14" width="200" height="300">\n    <img src="img/gallery/15.jpg" alt="15" width="200" height="300">\n    <img src="img/gallery/16.jpg" alt="16" width="200" height="300">\n</div>\n<p>\n    <span class="highlight">Kliknij w menu powyżej, aby dowiedzieć się więcej o tych niesamowitych mostach!</span>\n</p>', 1),
(3, 'kontakt', '<!DOCTYPE html>\n<html lang="pl">\n<head>\n    <meta charset="UTF-8">\n    <title>Mosty</title>\n</head>\n<body onload="loadMenu(); loadBackground(); startclock();">\n    <div id="menu"></div>\n    <div id="zegarek"></div>\n    <div id="data"></div>\n    <h1>Napisz do nas!</h1>\n    <form class="contact" action="mailto:adres@example.com" method="post" enctype="text/plain">\n        <label for="name">Imię i nazwisko:</label><br>\n        <input type="text" id="name" name="name"><br><br>\n        <label for="email">Adres e-mail:</label><br>\n        <input type="email" id="email" name="email"><br><br>\n        <label for="message">Wiadomość:</label><br>\n        <textarea id="message" name="message" rows="5" cols="40"></textarea><br><br>\n        <input type="submit" value="Wyślij">\n    </form>\n</body>\n</html>', 1),
(4, 'most1', '<!DOCTYPE html>\n<html lang="pl">\n<head>\n    <meta charset="UTF-8">\n    <title>Mosty</title>\n</head>\n<body onload="loadMenu(); loadBackground(); startclock();">\n    <div id="menu"></div>\n    <div id="zegarek"></div>\n    <div id="data"></div>\n    <h1>Most Akashi Kaikyō</h1>\n    <div class="text-format">\n        <img src="img/akashi.jpg" alt="Most Akashi Kaikyō" width="600">\n        <p><span class="highlight">Most <span class="underline">Akashi Kaikyō</span>, znany również jako <span class="italic">Pearl Bridge</span>, łączy miasta <span class="italic">Kobe</span> i <span class="italic">Awaji</span> na wyspie <span class="italic">Awaji.</span></span></p>\n        <p><span class="highlight">Jego konstrukcja rozpoczęła się w 1988 roku, a ukończono ją w 1998 roku. Most jest odporny na trzęsienia ziemi i silne wiatry, co czyni go jednym z najbezpieczniejszych mostów na świecie.</span></p>\n    </div>\n</body>\n</html>', 1),
(5, 'most2', '<!DOCTYPE html>\n<html lang="pl">\n<head>\n    <meta charset="UTF-8">\n    <title>Mosty</title>\n</head>\n<body onload="loadMenu(); loadBackground(); startclock();">\n    <div id="menu"></div>\n    <div id="zegarek"></div>\n    <div id="data"></div>\n    <h1>Most Hong Kong-Zhuhai-Macau</h1>\n    <div class="text-format">\n        <img src="img/zhuhai.jpg" alt="Most Hong Kong-Zhuhai-Macau" width="600">\n        <p><span class="highlight">Most <span class="underline">Hong Kong-Zhuhai-Macau</span> to najdłuższy most morski na świecie, łączący <span class="italic">Hongkong, Zhuhai i Makau.</span></span></p>\n        <p><span class="highlight">Rozciąga się na dystansie 55 kilometrów i jest jednym z największych osiągnięć współczesnej inżynierii w Chinach.</span></p>\n    </div>\n</body>\n</html>', 1),
(6, 'most3', '<!DOCTYPE html>\n<html lang="pl">\n<head>\n    <meta charset="UTF-8">\n    <title>Mosty</title>\n</head>\n<body onload="loadMenu(); loadBackground(); startclock();">\n    <div id="menu"></div>\n\n    <div id = "zegarek"></div>\n    <div id = "data"></div>\n    <h1>Golden Gate Bridge</h1>\n    <div class="text-format">\n        <img src="img/goldengate.jpg" alt="Golden Gate Bridge" width="600">\n        <p><span class="highlight">Most <span class="underline">Golden Gate</span> to jeden z najbardziej rozpoznawalnych mostów na świecie, znajdujący się w <span class="italic">San Francisco, USA.</span></span></p>\n        <p><span class="highlight">Został ukończony w 1937 roku i przez wiele lat był najdłuższym mostem wiszącym na świecie.</span></p>\n    </div>\n</body>\n</html>', 1),
(7, 'most4', '<!DOCTYPE html>\n<html lang="pl">\n<head>\n    <meta charset="UTF-8">\n    <title>Mosty</title>\n</head>\n<body onload="loadMenu(); loadBackground(); startclock();">\n    <div id="menu"></div>\n    <div id = "zegarek"></div>\n    <div id = "data"></div>\n    <h1>Most Millau</h1>\n    <div class="text-format">\n        <img src="img/millau.jpg" alt="Most Millau" width="600">\n        <p><span class="highlight">Most <span class="underline">Millau</span> to most wiszący znajdujący się w południowej Francji.</span></p>\n        <p><span class="highlight">Został ukończony w 2004 roku i jest jednym z najwyższych mostów na świecie.</span></p>\n    </div>\n</body>\n</html>', 1),
(8, 'most5', '<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Mosty</title>
</head>
<body onload="loadMenu(); loadBackground(); startclock();">
    <div id="menu"></div>

    <div id = "zegarek"></div>
    
    <div id = "data"></div>

    <h1>Most Vasco da Gama</h1>
    <div class="text-format">
        <img src="img/vasco.jpg" alt="Most Vasco da Gama" width="600">
        <p>
            <span class="highlight">Most <span class="underline">Vasco da Gama</span> to najdłuższy most w <span class="italic">Europie.</span></span>
        </p>
        <p>
            <span class="highlight">Znajduje się w <span class="italic">Lizbonie, Portugalia</span>, a jego długość wynosi 17,2 km.</span>
        </p>
    </div>
</body>
</html>', 1),
(9, 'changebackground', '<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Mosty</title>
</head>

<body onload="loadMenu(); loadBackground(); startclock();">
    <div id="menu"></div>

    <div id="zegarek"></div>
    
    <div id="data"></div>
    <h1>Zmień Tło!</h1>
    <form method="POST" name="background">
        <input type="button" value="Tło 1" onclick="changeBackground(\'img/backgrounds/background1.jpg\')">
        <input type="button" value="Tło 2" onclick="changeBackground(\'img/backgrounds/background2.jpg\')">
        <input type="button" value="Tło 3" onclick="changeBackground(\'img/backgrounds/background3.jpg\')">
        <input type="button" value="Tło 4" onclick="changeBackground(\'img/backgrounds/background4.jpg\')">
        <input type="button" value="Tło 5" onclick="changeBackground(\'img/backgrounds/background5.jpg\')">
    </form>
    
</body>

</html>', 1),
(10, 'home', '<h1>Największe Mosty Świata</h1>
<p>
    <span class="highlight">Odkryj najbardziej imponujące mosty na całym świecie...</span>
</p>', 1),
(11, 'videos', '<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Mosty</title>
</head>
<body onload="loadMenu(); loadBackground(); startclock();">
    <div id="menu"></div>

    <div id = "zegarek"></div>
    
    <div id = "data"></div>
    <h1>Filmy na temat Mostów</h1>

    <div class="video-container">
        <iframe width="800" height="400" src="https://www.youtube.com/embed/34f3Cl_lQI8?si=LfERMzJp-oyWsL0j" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
    </div>

    <div class="video-container">
        <iframe width="800" height="400" src="https://www.youtube.com/embed/C8ZwEbhrco0?si=frDOZag9qLuUjNm4" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
    </div>

    <div class="video-container">
        <iframe width="800" height="400" src="https://www.youtube.com/embed/yq2l3ARrRzI?si=KtjkxOoTlFP-QS6W" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
    </div>
</body>
</html>', 1);