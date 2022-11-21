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
if (carouselContainer)//verifi si il existe
{



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

}
/*
┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃                                   DragNDrop                                     ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛
*/


let target = document.getElementById('dropzone');
let body = document.body;
let fileInput = document.getElementById("file");

if(target){
    target.addEventListener('dragover', (e) => {
        e.preventDefault();
        body.classList.add('dragging');
      });
      
      target.addEventListener('dragleave', () => {
        body.classList.remove('dragging');
      });
      
      target.addEventListener('drop', (e) => {
        e.preventDefault();
        body.classList.remove('dragging');
        
        fileInput.files = e.dataTransfer.files;
      });
}


//TODO: voir et cacher le mot de passe avec un bouton (un neuil) dans l'<input>


/*
┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃                                   XML                                           ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛
*/

function requeteDynamHTTP(url="") {

    this.http = new XMLHttpRequest();
    

    this.url=url;
    

    this.put = function(listValue,callback) {
        
        urlToUse=listValue.reduce((url,value) => url.concat("/",value),this.url);

        this.http.open('PUT', urlToUse, true);
    
      
        let self = this;

        this.http.onload = function() {
   
            callback(null, self.http.responseText);
        }
    
       
        this.http.send(null);
        
        
  }
  this.get = function(object) {
    urlToUse=listValue.reduce((url,value) => url.concat("/",value),this.url);
    this.http.open('GET', urlToUse, true);
    this.http.setRequestHeader("Content-type",'application/json;charset=UTF-8');

    /* Par exemple pour le cas des filtres
    object={
        page: ,
        filters: []

    }
    */

    this.http.send(object)
    
  }
}



    function reqUpdateQuantite(url,howGetSelect,howGetId,callback){
        
        let requete = new requeteDynamHTTP(url);
        for (elem of howGetSelect())
        {
            elem.addEventListener("change",(event) =>{
                let listValue= [
                    howGetId(event.target),
                    event.target.value
                ]
                requete.put(listValue,callback);
                
            })
        }
    }
            


 
   
    
/*
┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃                                Update prix                                      ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛
*/

function updatePricePanier() {
    let quantites = document.getElementsByTagName("select");
    let nbArticleTab = document.getElementsByClassName("nbArt");
    let prixTab = document.getElementsByClassName("prixTtc");
    let prixTabHt = document.getElementsByClassName("prixHt");
    let quant, prix, quantTot = 0;

    for (let ind = 0; ind < quantites.length; ind++) {
        quant = quantites[ind].value;
        quantTot += parseInt(quant);

        prix = prixTab[ind].getAttribute("prix");
        prixTab[ind].textContent = (prix * quant) + '€';
    
        prix = prixTabHt[ind].getAttribute("prix");
        prixTabHt[ind].textContent = (prix * quant) + '€';
    }

    nbArticleTab[0].textContent = quantTot;
    nbArticleTab[1].textContent = quantTot;
    nbArticleTab[2].textContent = quantTot;
}

function updatePriceTotal() {
    let prixTab = document.getElementsByClassName("prixTtc");
    let prixTabHt = document.getElementsByClassName("prixHt");
    let sommeTot = 0;

    let prixTotTab = document.getElementsByClassName("totalTtc");
    let prixTotTabHt = document.getElementsByClassName("totalHt");
    let sommeTotHt = 0;
    
    let prix;

    for (let ind = 0; ind < prixTab.length; ind++) {
        prix = prixTab[ind].textContent.replace('€','');
        sommeTot += parseFloat(prix);
        prix = prixTabHt[ind].textContent.replace('€','');
        sommeTotHt += parseFloat(prix);
        console.log(prix);
    }

    prixTotTab[0].textContent = sommeTot;
    prixTotTab[1].textContent = sommeTot;

    console.log(sommeTotHt);
    prixTotTabHt[0].textContent = sommeTotHt;
    //prixTotTabHt[1].textContent = sommeToHt;
}

/*
┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃                           Liens aux lignes de lstCommandes                          ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛
*/

var lignes=document.getElementsByClassName("lignesCommandes");
var numCommandes=document.getElementsByClassName("numCommandes");

for (let numLigne of lignes) {
    var ligneA=lignes.item(numLigne);
    var commandeA=numCommandes[numLigne];
    ligneA.addEventListener("click", lienLigne);
}
/*
function lienLigne(element) {
    window.location.href = `/commande/${(commandeA.textContent)}`;
}
*/


/*
┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃                                      CGU                                        ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛
*/
var lienCGU = document.getElementsByClassName("lienCGU");
lienCGU[0].addEventListener("click", test);

/*document.querySelector(".mentionLegales > p").style.color = "red";*/

function test(event) {
    event.preventDefault();    
}
//TODO:Desactiver les event listners quand le fond est blur (rendre la navigation impossible)

/*
┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃                                  Espace Client                                  ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛
*/

var inputsCli = document.querySelectorAll(".divInputEtLien input");
var lienModifsCli = document.querySelectorAll(".divInputEtLien a");


for (let i = 0; i < lienModifsCli.length; i++) 
{
    lienModifsCli[i].addEventListener("click", function(event) 
    {
        event.preventDefault();
        inputsCli[i].disabled = false;
        inputsCli[i].focus();
    });
}


/*
┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃                                   Catalogue                                     ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛
*/

function boutonCliquable(bouton,action){
    
    bouton.addEventListener("click",action);
}

function switchEtatFiltre(list){
    for (n of list){
        n.classList.toggle("est-filtre-ouvert");
    }
}