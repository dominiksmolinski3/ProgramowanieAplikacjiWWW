function loadMenu() {
    const isInPhpFolder = window.location.pathname.includes("/php/");
    const pathPrefix = isInPhpFolder ? "../" : "";

    const menu = `
        <table class="menu">
            <tr>
                <td><a href="${pathPrefix}index.php?page=home">Strona Główna</a></td>
                <td><a href="${pathPrefix}index.php?page=gallery">Galeria Mostów</a></td>
                <td><a href="${pathPrefix}index.php?page=videos">Filmy</a></td>
                <td><a href="${pathPrefix}index.php?page=most1">Akashi Kaikyō</a></td>
                <td><a href="${pathPrefix}index.php?page=most2">Hong Kong-Zhuhai-Macau</a></td>
                <td><a href="${pathPrefix}index.php?page=most3">Golden Gate</a></td>
                <td><a href="${pathPrefix}index.php?page=most4">Vasco da Gama</a></td>
                <td><a href="${pathPrefix}index.php?page=most5">Brooklyn Bridge</a></td>
                <td><a href="${pathPrefix}index.php?page=kontakt">Kontakt</a></td>
                <td><a href="${pathPrefix}index.php?page=changebackground">Zmień tło</a></td>
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