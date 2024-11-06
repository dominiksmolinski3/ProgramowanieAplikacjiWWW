function loadMenu() {
    const isInPhpFolder = window.location.pathname.includes("/php/");
    const pathPrefix = isInPhpFolder ? "../" : "";

    const menu = `
        <table class="menu">
            <tr>
                <td><a href="${pathPrefix}index.php?page=home">Strona Główna</a></td>
                <td><a href="${pathPrefix}index.php?page=gallery">Galeria Mostów</a></td>
                <td><a href="${pathPrefix}php/most1.php">Akashi Kaikyō</a></td>
                <td><a href="${pathPrefix}php/most2.php">Hong Kong-Zhuhai-Macau</a></td>
                <td><a href="${pathPrefix}php/most3.php">Golden Gate</a></td>
                <td><a href="${pathPrefix}php/most4.php">Vasco da Gama</a></td>
                <td><a href="${pathPrefix}php/most5.php">Brooklyn Bridge</a></td>
                <td><a href="${pathPrefix}php/kontakt.php">Kontakt</a></td>
                <td><a href="${pathPrefix}php/changebackground.php">Zmień tło</a></td>
            </tr>
        </table>`;

    document.getElementById('menu').innerHTML = menu;

    $('#menu td').each(function() {
        $(this).data('originalWidth', $(this).width());
    });

    $('#menu td').on({
        mouseover: function() {
            const originalWidth = $(this).data('originalWidth'); 
            $(this).stop().animate({
                width: originalWidth + 50 
            }, 800);
        },
        mouseout: function() {
            const originalWidth = $(this).data('originalWidth'); 
            $(this).stop().animate({
                width: originalWidth 
            }, 800);
        }
    });

    console.log("Current Path:", window.location.pathname);
    console.log("Path Prefix:", pathPrefix);
}