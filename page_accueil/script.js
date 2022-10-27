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
let nbSlide = slides.length;
const carouselContainer = document.getElementById("carousel");
const nextSlide = document.querySelector(".btn-suiv");
let windowWidth = Math.round(carouselContainer.offsetWidth);
const prevSlide = document.querySelector(".btn-prev");
let scrollValue = (carouselContainer.scrollLeft-40);
var autoScrollCar = setInterval(autoScroll, 5000);

function scrollToSlide(slide) {
    windowWidth = Math.round(carouselContainer.offsetWidth);
    carouselContainer.scroll((windowWidth) * slide, 0);
}

// Ajout d'un event listener au clic du bouton afin de déplacer les images vers la droite
nextSlide.addEventListener("click", function () {
    clearInterval(autoScrollCar);
    autoScrollCar = setInterval(autoScroll, 5000);
    curSlide++;
    scrollToSlide(curSlide);
});

// selection de la slide précedente

// Ajout d'un event listener au clic du bouton afin de déplacer les images vers la gauche
prevSlide.addEventListener("click", function () {
    clearInterval(autoScrollCar);
    autoScrollCar = setInterval(autoScroll, 5000);
    curSlide--; 
    scrollToSlide(curSlide);
});

// ajout d'un event listener au scroll dans le carousel
carouselContainer.addEventListener("scroll", (event) => {
    scrollValue = (carouselContainer.scrollLeft-40);
    windowWidth = Math.round(carouselContainer.offsetWidth);
    curSlide = Math.round(scrollValue/windowWidth);
    if (curSlide === 0) {
        prevSlide.style.display = "none";
    } else if (curSlide === (nbSlide-1)){
        nextSlide.style.display = "none";
    } else {
        prevSlide.style.display = "inline";
        nextSlide.style.display = "inline";
    }
});


function autoScroll() {
    if (curSlide === (nbSlide-1)) {
        scrollToSlide(0);
    } else {
        curSlide++;
        scrollToSlide(curSlide);
    }
}