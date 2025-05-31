    document.addEventListener("DOMContentLoaded", function () {
        const navMenu = document.getElementById("nav-menu");
        const navToggle = document.getElementById("nav-toggle");
        const navClose = document.getElementById("nav-close");

        // Abre o menu
        if (navToggle) {
            navToggle.addEventListener("click", () => {
                navMenu.classList.add("show");
            });
        }

        // Fecha o menu
        if (navClose) {
            navClose.addEventListener("click", () => {
                navMenu.classList.remove("show");
            });
        }

        // Fecha o menu ao clicar em um link
        document.querySelectorAll(".nav__link").forEach(link => {
            link.addEventListener("click", () => {
                navMenu.classList.remove("show");
            });
        });
    });