// colorbackground.js

function changeBackground(imagePath) {
    document.body.style.backgroundImage = `url('${imagePath}')`;
    localStorage.setItem('backgroundImage', imagePath);
}

function loadBackground() {
    const savedBackground = localStorage.getItem('backgroundImage');
    if (savedBackground) {
        document.body.style.backgroundImage = `url('${savedBackground}')`;
    }
    else {
        document.body.style.backgroundImage = `url('../img/backgrounds/background2.jpg')`;
    }
}

function loadIndexBackground() {
    const savedBackground = localStorage.getItem('backgroundImage');
    const cleanedPath = savedBackground.substring(3);
    if (savedBackground) {
        document.body.style.backgroundImage = `url('${cleanedPath}')`;
    }
    else {
        document.body.style.backgroundImage = `url('img/backgrounds/background2.jpg')`;
    }
}

window.onload = function() {
    const currentPage = window.location.pathname.split('/').pop();
    if (currentPage === 'index.html') {
        loadIndexBackground();
        console.log('Loading index.html background'); 
    } else {
        console.log('Loading background for other page');
        loadBackground();
    }
};
