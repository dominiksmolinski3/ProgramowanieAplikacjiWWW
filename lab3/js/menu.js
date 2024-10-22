function loadMenu() {
    const menu = `
        <table class="menu">
            <tr>
                <td><a href="index.html">Strona Główna</a></td>
                <td><a href="most1.html">Akashi Kaikyō</a></td>
                <td><a href="most2.html">Hong Kong-Zhuhai-Macau</a></td>
                <td><a href="most3.html">Golden Gate</a></td>
                <td><a href="most4.html">Vasco da Gama</a></td>
                <td><a href="most5.html">Brooklyn Bridge</a></td>
                <td><a href="kontakt.html">Kontakt</a></td>
                <td><a href="changebackground.html">Zmień tło</a></td>
            </tr>
        </table>`;
    document.getElementById('menu').innerHTML = menu;

    // Store the original widths
    $('#menu td').each(function() {
        $(this).data('originalWidth', $(this).width());
    });

    // Mouse events
    $('#menu td').on({
        mouseover: function() {
            const originalWidth = $(this).data('originalWidth'); // Retrieve original width
            $(this).stop().animate({
                width: originalWidth + 50 // Enlarge the width by 50px
            }, 800);
        },
        mouseout: function() {
            const originalWidth = $(this).data('originalWidth'); // Retrieve original width
            $(this).stop().animate({
                width: originalWidth // Return to original width
            }, 800);
        }
    });
}