function showFull(src) {
    const splash = document.getElementById("splash");
    const img = document.getElementById("fullImage");
    splash.style.display = "flex";
    img.src = src;
}

function hideFull() {
    document.getElementById("splash").style.display = "none";
    document.getElementById("fullImage").src = "";
}

// splashscreen — уже есть

// hamburger toggle
document.addEventListener("DOMContentLoaded", () => {
    const hamburger = document.getElementById("hamburger");
    const menu = document.getElementById("menu");

    hamburger.addEventListener("click", () => {
        menu.classList.toggle("show");
    });
});
