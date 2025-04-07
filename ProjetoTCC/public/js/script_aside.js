const barranav = document.querySelector(".aside_barra");
const barranavAlternativo = document.querySelector(".barra_nav_alternativo");

barranavAlternativo.addEventListener("click", () =>{
    barranav.classList.toggle("collapsed");
});