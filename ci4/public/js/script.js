//Fonctions pour le changement d'images lors du hover sur le profil
//Affecte la nouvelle image lorsque la souris survole l'élément
function passageDeLaSouris(element) {
    element.setAttribute("src", "./images/header/profil_hover.png");
}

//Affecte l'image de départ lorsque la souris ne survole plus l'élément
function departDeLaSouris(element) {
    element.setAttribute("src", "./images/header/profil.png");
}

// Variable qui stock l'index de l'image
let curSlide = 0;
const slides = document.querySelectorAll(".slide");
const carouselContainer = document.getElementById("carousel-container");
// selection de la slide suivante
const nextSlide = document.querySelector(".btn-suiv");

// Ajout d'un event listener au clic du bouton afin de déplacer les images vers la droite
nextSlide.addEventListener("click", function () {
    curSlide++;
    carouselContainer.scroll(2000 * curSlide, 0);
    if (curSlide == slides.length - 1) {
        nextSlide.style.display = "none";
    } else {
        prevSlide.style.display = "inline";
        nextSlide.style.display = "inline";
    }
});

// selection de la slide précedente
const prevSlide = document.querySelector(".btn-prev");

// Ajout d'un event listener au clic du bouton afin de déplacer les images vers la gauche
prevSlide.addEventListener("click", function () {
    curSlide--;
    carouselContainer.scroll(2000 * curSlide, 0);
    if (curSlide == 0) {
        prevSlide.style.display = "none";
    } else {
        nextSlide.style.display = "inline";
        prevSlide.style.display = "inline";
    }
});

// ajout d'un event listener au scroll dans le carousel
carouselContainer.addEventListener("scroll", (event) => {
  console.log(carouselContainer.scrollLeft);
});
