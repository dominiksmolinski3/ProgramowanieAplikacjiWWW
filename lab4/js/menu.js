function loadMenu() {
    const isInHtmlFolder = window.location.pathname.includes("/html/");

    const pathPrefix = isInHtmlFolder ? "../" : "";

    const menu = `
        <table class="menu">
            <tr>
                <td><a href="${pathPrefix}index.html">Strona Główna</a></td>
                <td><a href="${pathPrefix}html/most1.html">Akashi Kaikyō</a></td>
                <td><a href="${pathPrefix}html/most2.html">Hong Kong-Zhuhai-Macau</a></td>
                <td><a href="${pathPrefix}html/most3.html">Golden Gate</a></td>
                <td><a href="${pathPrefix}html/most4.html">Vasco da Gama</a></td>
                <td><a href="${pathPrefix}html/most5.html">Brooklyn Bridge</a></td>
                <td><a href="${pathPrefix}html/kontakt.html">Kontakt</a></td>
                <td><a href="${pathPrefix}html/changebackground.html">Zmień tło</a></td>
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
}
