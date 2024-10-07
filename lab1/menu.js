// menu.js
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
            </tr>
        </table>`;
    document.getElementById('menu').innerHTML = menu;
}
