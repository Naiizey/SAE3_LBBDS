/*
┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃                                    Footer                                       ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛
*/
const footerLiList = document.querySelectorAll('footer li');
const burger = footerLiList[footerLiList.length-1];
const menu = document.querySelector('footer ul > div');

burger.addEventListener('click', () => {if(menu.classList.contains('menu')){menu.classList.remove('menu');menu.style['display']='none'}else{menu.classList.add('menu');menu.style['display']='flex'}});

/*
┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃                                   Caroussel                                     ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛
*/
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
    carouselContainer.scroll((windowWidth) * slide, 0)
}

// Ajout d'un event listener au clic du bouton afin de déplacer les images vers la droite
nextSlide.addEventListener("click", function () {
    clearInterval(autoScrollCar);
    autoScrollCar = setInterval(autoScroll, 5000);
    if (curSlide === (nbSlide-1)) {
        scrollToSlide(0);
    } else {
        curSlide++;
        scrollToSlide(curSlide);
    }
});

// selection de la slide précedente

// Ajout d'un event listener au clic du bouton afin de déplacer les images vers la gauche
prevSlide.addEventListener("click", function () {
    clearInterval(autoScrollCar);
    autoScrollCar = setInterval(autoScroll, 5000);
    if (curSlide === 0) {
        scrollToSlide(nbSlide-1);
    } else {
        curSlide--;
        scrollToSlide(curSlide);
    }
});

// ajout d'un event listener au scroll dans le carousel
carouselContainer.addEventListener("scroll", (event) => {
    scrollValue = (carouselContainer.scrollLeft-40);
    windowWidth = Math.round(carouselContainer.offsetWidth);
    curSlide = Math.round(scrollValue/windowWidth);
});


function autoScroll() {
    if (curSlide === (nbSlide-1)) {
        scrollToSlide(0);
    } else {
        curSlide++;
        scrollToSlide(curSlide);
    }
}