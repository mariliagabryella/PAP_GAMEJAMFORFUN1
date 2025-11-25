function toggleMenu() {
    var menu = document.querySelector(".menu-links");
    if (menu.style.display === "block") {
        menu.style.display = "none";
    } else {
        menu.style.display = "block";
    }
}



function mostrarCampos() {
    var numParticipantes = document.getElementById("num_participantes").value;

    document.getElementById("participante1").style.display = "block";
    document.getElementById("participante2").style.display = numParticipantes >= 2 ? "block" : "none";
    document.getElementById("participante3").style.display = numParticipantes == 3 ? "block" : "none";
}


document.querySelectorAll('.menu-links a').forEach(link => {
    link.addEventListener('click', function(event) {
        if (this.getAttribute('href').startsWith("#")) {
            event.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            target.scrollIntoView({ behavior: 'smooth' });
        }
    });
});


let slideIndex = 0;
function mudarSlide(n) {
    let slides = document.querySelectorAll(".slides img");
    slides[slideIndex].style.display = "none";
    slideIndex = (slideIndex + n + slides.length) % slides.length;
    slides[slideIndex].style.display = "block";
}




let slideidi = 0;
function mudarSlide(n) {
    let slides = document.querySelectorAll(".slides img");
    slides[slideIndex].style.display = "none";
    slideIndex = (slideIndex + n + slides.length) % slides.length;
    slides[slideIndex].style.display = "block";
}





function toggleEscreverLinguagem(selectElement) {
    const inputDiv = document.getElementById("outra-linguagem");
    if (selectElement.value === "Outra") {
        inputDiv.style.display = "block"; // Mostra o campo de texto
    } else {
        inputDiv.style.display = "none"; // Esconde o campo de texto
    }
}