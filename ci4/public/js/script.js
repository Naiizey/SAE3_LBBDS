/*
┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃                                    Footer                                       ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛
*/
function footer(){
    const footerLiList = document.querySelectorAll('footer li');
    const burger = footerLiList[footerLiList.length-1];
    const menu = document.querySelector('footer ul > div');

    burger.addEventListener('click', () => {if(menu.classList.contains('menu')){menu.classList.remove('menu');menu.style['display']='none'}else{menu.classList.add('menu');menu.style['display']='flex'}});
}
/*
┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃                           Carrousel                                ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛
*/
function carrousel(){
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
}
/*
┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃                                   DragNDrop                                     ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛
*/

function dragNDrop(){
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
        //console.log(prix);
    }

    prixTotTab[0].textContent = sommeTot;
    prixTotTab[1].textContent = sommeTot;

    //console.log(sommeTotHt);
    prixTotTabHt[0].textContent = sommeTotHt;
    //prixTotTabHt[1].textContent = sommeToHt;
}

/*
┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃                           Liens aux lignes de lstCommandes                          ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛
*/
function lstCommandes(){
    var lignes=document.getElementsByClassName("lignesCommandes");
    var numCommandes=document.getElementsByClassName("numCommandes");

    for (let numLigne=0; numLigne<lignes.length; numLigne++){
        let ligneA=lignes.item(numLigne);
        let commandeA=numCommandes.item(numLigne).textContent;
        ligneA.addEventListener("click", () => {window.location.href = `${base_url}/commandes/detail/${commandeA}`;});
    }
}

/*
┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃                                      CGU                                        ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛
*/
function cgu(){
    var lienCGU = document.getElementsByClassName("lienCGU");
    lienCGU[0].addEventListener("click", affichageCGU);
    var mentionsLegales = document.getElementsByClassName("mentionsLegales")[0];

    function affichageCGU(event) {
        event.preventDefault();
        let flou = document.querySelectorAll("main>*, header>*, footer>*");
        let page = document.querySelector("html");

        if (mentionsLegales.style.display == "none") {
            mentionsLegales.style.display = "block";
            page.style.overflow = "hidden";
            page.style.pointerEvents = "none";
            window.scrollTo({top: 0, behavior: 'smooth'});
            mentionsLegales.scrollTo({top: 0, behavior: 'auto'});

            for (let index = 0; index < flou.length; index++) {
                flou[index].style.filter = "blur(4px)";
                mentionsLegales.style.filter = "blur(0)";
            }
            document.getElementsByClassName("fermerCGU").addEventListener("blur", affichageCGU);
        }
    }

    var boutonML = document.getElementsByClassName("remonterCGU")[0];
    boutonML.addEventListener("click", function(e) {
        mentionsLegales.scrollTo({top: 0, behavior: 'smooth'});
    });
    //TODO : bouton scroll back en sticky en bas à gauche du bloc    
}    

/*
┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃                                  Espace Client                                  ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛
*/
function espaceCli(role)
{
    this.form = document.forms["formClient"];
    var self = this;
    var lienModif;
    var labelModifsCli = document.querySelectorAll(".mainEspaceCli label");
    var ancienMdp = document.getElementsByClassName("labelAncienMdp")[0];
    ancienMdp.innerHTML = "Votre mot de passe :";
    
    for (let i = 0; i < this.form.elements.length; i++)
    {
        lienModif = this.form.elements[i].parentNode.getElementsByTagName("a")[0];
        
        //On sélectionne tous les inputs qui ne sont ni le bouton enregistrer ni les inputs cachés 
        if (this.form.elements[i].type != "submit" && typeof lienModif !== 'undefined')
        {
            lienModif.addEventListener("click", function (event) {
                event.preventDefault();

                if (self.form.elements[i].disabled == true) 
                {
                    self.form.elements[i].disabled = false;
                    self.form.elements[i].required = true;
                    self.form.elements[i].focus();

                    //Si on parle de l'input mot de passe
                    if (self.form.elements[i].type == "password") 
                    {
                        self.form.elements[i].value = "";

                        //Si je suis un client alors je vais devoir renseigner des champs en plus pour changer mon mot de passe
                        if (role == "client")
                        {
                            ancienMdp.innerHTML = "Entrez votre ancien mot de passe";
                            let divCacheModifsCli = document.getElementsByClassName("cacheModifMdp");

                            //On découvre les inputs confirmezAncienMdp, nouveauMdp ainsi que leurs labels et divs
                            while (divCacheModifsCli.length) {
                                divCacheModifsCli[0].classList.remove("cacheModifMdp");
                            }

                            self.form.elements[i + 1].required = true;
                            self.form.elements[i + 2].required = true;
                        }
                    }
                }
                else
                {
                    self.form.elements[i].disabled = true;
                    self.form.elements[i].required = false;

                    //Si on parle de l'input mot de passe
                    if (self.form.elements[i].type == "password") 
                    {
                        if (role == "client") 
                        {
                            ancienMdp.innerHTML = "Votre mot de passe :";
                            self.form.elements[i].value = "motDePassemotDePasse";

                            //Inputs confirmezAncienMdp et nouveauMdp
                            self.form.elements[i + 1].value = "";
                            self.form.elements[i + 1].classList.add("cacheModifMdp");
                            self.form.elements[i + 2].value = "";
                            self.form.elements[i + 2].classList.add("cacheModifMdp");

                            labelModifsCli[5].classList.add("cacheModifMdp");
                            labelModifsCli[6].classList.add("cacheModifMdp");

                            self.form.elements[i + 1].parentNode.classList.add("cacheModifMdp");
                            self.form.elements[i + 2].parentNode.classList.add("cacheModifMdp");

                            self.form.elements[i + 1].required = false;
                            self.form.elements[i + 2].required = false;
                        }
                    }
                }
            });
        }
    }
}

/*
┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃                                 Catalogue                                       ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛
*/
function cataloguePrice(){
    const rangeInput = document.querySelectorAll(".range-input input"),
    priceInput = document.querySelectorAll(".price-range input:not(.range-input input)"),
    range = document.querySelector(".slider .progress");
    let priceGap = 100;

    priceInput.forEach(() => {
        window.addEventListener("load", fctPriceInput);
    });
    rangeInput.forEach(() => {
        window.addEventListener("load", fctRangeInput);
    });

    priceInput.forEach((input) => {
        input.addEventListener("input", fctPriceInput);
    });
    rangeInput.forEach((input) => {
        input.addEventListener("input", fctRangeInput);
    });

    function fctPriceInput(e){
        let minPrice = parseInt(priceInput[0].value),
        maxPrice = parseInt(priceInput[1].value);
        if (maxPrice - minPrice >= priceGap && maxPrice <= rangeInput[1].max) {
            if (e.target.id === "prix_min") {
                rangeInput[0].value = minPrice;
                range.style.left = (minPrice / rangeInput[0].max) * 100 + "%";
                console.log(minPrice + " | " + maxPrice);
            } else if(e.target.id === "prix_max") {
                rangeInput[1].value = maxPrice;
                range.style.right = 100 - (maxPrice / rangeInput[1].max) * 100 + "%";
            }
        }
    }

    function fctRangeInput(e){
        let minVal = parseInt(rangeInput[0].value),
        maxVal = parseInt(rangeInput[1].value);
        if (maxVal - minVal < priceGap) {
        if (e.target.className === "range-min") {
            rangeInput[0].value = maxVal - priceGap;
        } else {
            rangeInput[1].value = minVal + priceGap;
        }
        } else {
            priceInput[0].value = minVal;
            priceInput[1].value = maxVal;
            range.style.left = (minVal / rangeInput[0].max) * 100 + "%";
            range.style.right = 100 - (maxVal / rangeInput[1].max) * 100 + "%";
        }
    }
}


function boutonCliquable(bouton,action){
    
    bouton.addEventListener("click",action);
}

function switchEtatFiltre(list){
    for (n of list){
        n.classList.toggle("est-filtre-ouvert");
    }
}

/*
┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃                               Detail commande                                   ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛
*/

function barreProgression() {
    let pointProgress = document.getElementsByClassName("pointProgress");
    let preuveLivraison = document.querySelector(".preuveLivraison");
    let progressBar = document.querySelector(".progress-bar-ok");

    if (progressBar.value < 5) {
        progressBar.value = (progressBar.value - 1)*25 + 12,5;
    } else {
        progressBar.value = 100;
    }

    for (let index = 0; index < 5; index++) {
        if (index*25 <= progressBar.value) {
            pointProgress[index].classList.add("point-ok");
        } else {
            pointProgress[index].classList.add("point-ko");
        }
    }
    if (pointProgress[4].classList.contains("point-ko")) {
        preuveLivraison.style.backgroundColor = "#BDBFBB";
        preuveLivraison.style.color = "#164F57";
        preuveLivraison.style.cursor = "not-allowed";
    }
}
/*
┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃                                   formAdresse                                   ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛
*/


var formAdresseConstructor = function(){
    this.form=document.forms["form_adresse"];
    var self =this;
    this.actionAfterFetch= new Object();

    this.nomEtPrenom =[
        this.form.elements["nom"],
        this.form.elements["prenom"]    
    ];

    this.form.elements["ville"].addEventListener("mousedown",function(){
        if( document.activeElement == this )return;
        document.querySelector(this).focus();
       });
    
    this.estRempli = new Array();
    Array.from(this.form.elements).forEach(elem => {
        this.estRempli[elem.name]=elem.value.length>0;
    });

    this.codePostal=this.form.elements["code_postal"];
    this.ville=this.form.elements["ville"];

    this.utiliserProfil =  (event) => {
        selfTarget=event.target;
        this.nomEtPrenom.map(elem => {
            
            elem.classList.toggle("blocked-and-completed");
            if (Array.from(elem.classList).includes("blocked-and-completed")){
                elem.setAttribute("readOnly","readOnly");
                
                elem.dejaMis=elem.value;
                elem.value=elem.getAttribute("sauvegardee");
            }
            else{
                elem.removeAttribute("readOnly");
                elem.value=elem.dejaMis;
                
                
            }
        });
        this.supprimerErreur(selfTarget.parentNode.parentNode);
    }
    this.form.elements["utilise_nom_profil"].addEventListener('change', this.utiliserProfil );



    

    this.creerErreur =function(destination,message){
        
        if(Array.from(destination.children).filter(
            child => Array.from(child.classList).includes("paragraphe-erreur") && child.textContent==message
            ).length==0){

            let p=document.createElement('p');
            p.classList.add("paragraphe-erreur");
            p.innerText=message
            destination.appendChild(p)
          
        }
        
    }

    

    this.supprimerErreur =function(destination){

        Array.from(destination.children)
        .filter(child => Array.from(child.classList).includes("paragraphe-erreur"))
        .forEach(child => destination.removeChild(child))
            
        
    }

    this.verifierNomEtPrenom =  (event) => {
        selfTarget=event.target;
        if(selfTarget.validity.valueMissing){
            this.creerErreur(selfTarget.parentNode.parentNode.parentNode,"Attention champ(s) vide(s)");
        }
        else{
            
            this.supprimerErreur(selfTarget.parentNode.parentNode.parentNode);
        }
    };
    this.nomEtPrenom.map(elem => 
        elem.addEventListener("blur", this.verifierNomEtPrenom));

    

    Array.from(this.form.elements)
    .filter(elem => {
        return elem.required && !Array.from(elem.parentNode.parentNode.classList).includes("nomPrenom")
    })
    .forEach(elemRequired => {
        elemRequired.addEventListener("blur", (event) => {
        selfTarget=event.target;
        if(selfTarget.validity.valueMissing){
            this.creerErreur(selfTarget.parentNode,"Champ vide");
            this.estRempli[selfTarget.name]=false;
        }
        else{
            this.estRempli[selfTarget.name]=true;
            this.supprimerErreur(selfTarget.parentNode);
           
        }
        })
    })

    this.afterVille = function(response){
    
       this.codePostal.value = response.features[0].properties.postcode;
       this.supprimerErreur(this.codePostal.parentNode);
        
    }

    this.afterCodePostal = function(response){
        let datalist= document.getElementById("ville_trouvee");
        datalist.innerHTML="";
        response.features.forEach(feature => {
            console.log(feature.properties.city)
            let option = document.createElement("option");
            option.value=feature.properties.city;
            datalist.appendChild(option);
        });   
    }


    this.chercheCodePostalVille =  (event) => {
        selfTarget=event.target;
      
        if(selfTarget.value.length > 3){
            
            fetch("https://api-adresse.data.gouv.fr/search/?q="+selfTarget.value+"&type=municipality")
            .then(response => response.json())
            .then(response => self.afterVille(response))
            .catch(error => console.error('Error:', error));   
            
        }
    }

    this.ville.addEventListener("blur",this.chercheCodePostalVille);

    this.chercherVilleParCodePostal= (event) => {
        selfTarget=event.target;
        if(this.codePostal.validity.patternMismatch){
            this.creerErreur(selfTarget.parentNode,"Ne correspond à aucun code postal");
           
        }
        else if(!this.codePostal.validity.valueMissing){
            console.log("Bonsoir, non");
            this.supprimerErreur(selfTarget.parentNode);
            
            
            
            fetch("https://api-adresse.data.gouv.fr/search/?q="+selfTarget.value+"&postcode="+selfTarget.value+"&type=municipality")
            .then(response => response.json())
            .then(response => self.afterCodePostal(response))
            .catch(error => {console.error('Error:', error)});   
                
            
           
        }
        else{
            this.supprimerErreur(selfTarget.parentNode);
            this.creerErreur(selfTarget.parentNode,"Champ vide");
        }    
    };
    this.codePostal.addEventListener("blur", this.chercherVilleParCodePostal);
 
}
 

/*
┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃                          Errors                                   ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛
*/
function errors(){
    const Shuffle = function ($el) {
        const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890-=+<>,./?[{()}]!@#$%^&*~`\|'.split(''),
            $source = $el.querySelector('.source'), $target = $el.querySelector('.target');
    
        let cursor = 0, scrambleInterval = undefined, cursorDelayInterval = undefined, cursorInterval = undefined;
    
        const getRandomizedString = function (len) {
            let s = '';
    
            for (let i = 0; i < len; i++) {
                s += chars[Math.floor(Math.random() * chars.length)];
            }
    
            return s;
        };
    
        this.start = function () {
            $source.style.display = 'none';
            $target.style.display = 'block';
    
            scrambleInterval = window.setInterval(() => {
                if (cursor <= $source.innerText.length) {
                    $target.innerText = $source.innerText.substring(0, cursor) + getRandomizedString($source.innerText.length - cursor);
                }
            }, 450 / 30);
    
            cursorDelayInterval = window.setTimeout(() => {
                cursorInterval = window.setInterval(() => {
                    if (cursor > $source.innerText.length - 1) {
                        this.stop();
                    }
    
                    cursor++;
                }, 70);
            }, 350);
        };
    
        this.stop = function () {
            $source.style.display = 'block';
            $target.style.display = 'none';
            $target.innerText = '';
            cursor = 0;
    
            if (scrambleInterval !== undefined) {
                window.clearInterval(scrambleInterval);
                scrambleInterval = undefined;
            }
    
            if (cursorInterval !== undefined) {
                window.clearInterval(cursorInterval);
                cursorInterval = undefined;
            }
    
            if (cursorDelayInterval !== undefined) {
                window.clearInterval(cursorDelayInterval);
                cursorDelayInterval = undefined;
            }
        };
    };
    
    (new Shuffle(document.getElementById('error_text'))).start();
    
    window.setTimeout(function () {
        document.getElementById('details').classList.remove('hidden');
    }, 550);
}