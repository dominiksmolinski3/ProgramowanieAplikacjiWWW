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
}

window.onload = function() {
    loadBackground();
}

