
/*
┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃                                    Footer                                       ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛
*/
function footer(){
    const footerLiList = document.querySelectorAll('footer li');
    const burger = footerLiList[footerLiList.length-1];
    const menu = document.querySelector('.mentionsLegales + div');

    burger.addEventListener('click', () => {
        if(menu.classList.contains('menu')){
            menu.classList.remove('menu');menu.style['display']='none'}
            else{menu.classList.add('menu');menu.style['display']='flex'}
        });
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

/*
┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃                                  PreviewCSV                                     ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛
*/

/**
 * Fonction qui va récupérer à l'aide du controlleur Import.php la première ligne du fichier CSV
 * @returns {array} tableau contenant les entêtes du fichier CSV
 */
function getentete(){

    let map = new Map([
        ["intitule_prod", "varchar(50)"],
        ["prix_ht","float8"],
        ["prix_ttc", "float8"],
        ["description_prod", "varchar"],
        ["lien_image_prod", "varchar"],
        ["publication_prod", "boolean"],
        ["stock_prod", "integer"],//
        ["moyenne_note_prod", "float8"],
        ["seuil_alerte_prod", "integer"],
        ["alerte_prod", "boolean"],
        ["code_sous_cat", "integer"]
    ]);

    

    return map;
}


/**
 * Fonction qui permet de prévisualiser un fichier CSV
 * @returns {void}
 */
function previewCSV(){
    let preview = document.getElementById("preview");
    
    //ajout d'un event listener sur le changement de fichier
    document.getElementById("file").addEventListener("change", function (e) {
        preview.innerHTML = " chargement du fichier...";
        //récupération du fichier
        let file = e.target.files[0];
        //création d'un objet FileReader
        let reader = new FileReader();
        //lecture du fichier
        //prend l'en-tête du fichier et l'ajoute au tableau
        let entete = getentete();
        
        

        reader.readAsText(file);
        //ajout d'un event listener sur le chargement du fichier
        reader.addEventListener("load", function () {
            preview.innerHTML = "<br><h3>Prévisualisation</h3><br>";
            //si la longueur de entete est > longueur de la première ligne
            var table = document.createElement("table");
            let csv = reader.result;
            //création du tableau
            let lines = csv.split("\n");
            for (let i = 0; i < 10 && i < lines.length; i++) {
                let line = lines[i];
                let cells = line.split(";");
                if (entete.size > cells.length)
                {
                    //on ajoute une ligne en rouge
                    console.log("ligne non valide");
                    preview.innerHTML = "nombre de colonnes invalide";
                    preview.style.color = "red";
                    //on centre le texte
                    preview.style.textAlign = "center";
                    
                }
                else
                {
                    if (i == 0)
                    {
                        //on ajoute une 1ère ligne fusionnée
                        console.log("ligne valide");
                        preview.innerHTML = "nombre de colonnes valide :";
                        console.log(cells);
                        preview.style.color = "green";
                        //on centre le texte
                        preview.style.textAlign = "center";
                        document.getElementById("submit").disabled = false;
                    }

                }
                let row = table.insertRow(-1);
                if (i === 0) {
                    for(let j = 0; j < cells.length; j++){
                        //si l'entête n'est pas dans les clés de entete
                        if (!(entete.has(cells[j].trim()))){
                            console.log("entete");
                            console.log(entete);
                            console.log("cell non valide:" + cells[j] + "|");
                            cells[j] = "<span style='color:red'>" + cells[j] + "</span>";
                        }
                        else{
                            cells[j] = "<span style='color:green'>" + cells[j] + "</span>";
                        }
                        let cell = row.insertCell(-1);
                        cell.innerHTML = cells[j];
                    }
                }
                else
                {
                    for (let j = 0; j < cells.length; j++) {
                        if (cells[j].length > 20) {
                            cells[j] = cells[j].substring(0, 20) + "...";
                        }
                        let cell = row.insertCell(-1);
                        cell.style.color = "black";
                        cell.innerHTML = cells[j];
                    }
                }   
            }
            preview.appendChild(table);
       });
    });
}





//TODO: voir et cacher le mot de passe avec un bouton (un neuil) dans l'<input>

/*
┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃                                Spécifier quantité                               ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛
*/

var tabQuant= document.querySelector("#tabQuant")

if (tabQuant){
    tabQuant.addEventListener("change", (event) => {
        if (event.target.value == "10+"){
            console.log(event.target);
            event.target.parentNode.classList.toggle("plus-10");
            document.querySelector(".input-option-plus-10").addEventListener("keypress", (event) => {
              
                if(event.keyCode < 48 || event.keyCode > 57){
                    event.preventDefault();
    
                }
                
            })
            document.querySelector(".input-option-plus-10").addEventListener("blur", (event) => {
                if(event.target.value > event.target.max){
                    event.value = event.target.max;
                }
                
            })
        }
    })
}



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

        this.howGetId=howGetId;

        var process = (event,value=null) => {
            let listValue= [
                this.howGetId(event.target),
                (value===null)?event.target.value:value
            ]
         
            requete.put(listValue,callback);
        }
        
        let requete = new requeteDynamHTTP(url);
        for (elem of howGetSelect())
        {
           
            elem.addEventListener("change",(event) =>{
                
                if(!isNaN(event.target.value))
                {
                    if(parseInt(event.target.value) > event.target.max){
                        event.target.value=event.target.max;
                    }
                    process(event);
                    
                }
        
               
                
            });
            elem.addEventListener("keypress", (event) => {
              
                if(event.keyCode < 48 || event.keyCode > 57){
                    event.preventDefault();
    
                }
                else if(parseInt(event.target.value+String.fromCharCode(event.keyCode)) > event.target.max){
                    event.preventDefault();
                    
                    event.target.value=event.target.max;
                    process(event); 
                    
                }
                else{
                    console.log(event.target.value+String.fromCharCode(event.keyCode));
                    process(event,event.target.value+String.fromCharCode(event.keyCode)); 
                }
                    
                
                
            });

        }
    }
            


 
    

    

/*
┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃                            Update prix et quant                                 ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛
*/

function updatePricePanier() {
    let quantites = document.querySelectorAll(".divQuantite input");
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
    Array.from(nbArticleTab).forEach(nbArt => nbArt.textContent = quantTot);
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
    }

    //Récupération et application du code de réduction 
    let reduc = document.querySelector(".bloc-erreurs .paragraphe-valid span");
   

    if (reduc && reduc.length !== 0)
    {
        reduc = reduc.innerHTML;

            //Si le code réduit de xx.xx%
        if (reduc.includes("%")) {
            reduc = parseFloat(reduc.substring(0, reduc.length - 1));
            prixTotTab[0].textContent = sommeTot * (1 - reduc / 100);
            prixTotTab[2].textContent = sommeTot * (1 - reduc / 100);
        }
        //Si le code réduit de xx.xx€
        else {
            reduc = parseFloat(reduc.substring(0, reduc.length - 1));

            prixTotTab[2].textContent = sommeTot - reduc;
        }
        console.log(prixTotTab[1]);
        prixTotTab[0].textContent = sommeTot;
        prixTotTab[1].textContent = sommeTot;
        prixTotTabHt[0].textContent = sommeTotHt;
    }
    else
    {
        prixTotTab[0].textContent = (sommeTot.toFixed(1).toString().replace(/^0+/,''));
        prixTotTab[2].textContent = (sommeTot.toFixed(1).toString().replace(/^0+/,''));
    }
    
    prixTotTabHt[0].textContent = (sommeTotHt.toFixed(1).toString().replace(/^0+/,'')); 
    
}

function updateQuantite() {
    let baliseQuant = document.getElementsByClassName("quantPanier")[0];
    let nbArt = document.getElementsByClassName("nbArt")[0].textContent;
    if(nbArt > 100)
        baliseQuant.textContent = "+99";
    else
        baliseQuant.textContent = nbArt;

}

/*
┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃                           Liens aux lignes de lstCommandes                          ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛
*/
function lstCommandes(){
    // Récupération de toutes les lignes de la liste des commandes
    var lignes=document.getElementsByClassName("lignesCommandes");
    // Récupération de tous les numéros de commandes
    var numCommandes=document.getElementsByClassName("numCommandes");

    for (let numLigne=0; numLigne<lignes.length; numLigne++){
        let ligneA=lignes.item(numLigne);
        let commandeA=numCommandes.item(numLigne).textContent;
        // Ajout à la ligne actuelle du parcours, d'un lien vers la page de détail de la commande récupérée juste avant
        ligneA.addEventListener("click", () => {window.location.href = `${base_url}/commandes/detail/${commandeA}`;});
    }
}

function lstCommandesVendeur(){
    // Récupération de toutes les lignes de la liste des commandes
    var lignes=document.getElementsByClassName("lignesCommandes");
    // Récupération de tous les numéros de commandes
    var numCommandes=document.getElementsByClassName("numCommandes");

    for (let numLigne=0; numLigne<lignes.length; numLigne++){
        let ligneA=lignes.item(numLigne);
        let commandeA=numCommandes.item(numLigne).textContent;
        // Ajout à la ligne actuelle du parcours, d'un lien vers la page de détail de la commande récupérée juste avant, en tant que vendeur
        ligneA.addEventListener("click", () => {window.location.href = `${base_url}/vendeur/commandesCli/detail/${commandeA}`;});
    }
}

/*
┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃                        Liens aux lignes de lstSignalements                          ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛
*/
function lstSignalements(nbSignalements)
{
    //Récupération de toutes les lignes de la liste des signalements
    var lignes = document.getElementsByClassName("lignesSignalements");

    //Récupération de tous les numéros de produit associés au signalement et donc à l'avis
    var numProduit = document.getElementsByClassName("numProduit");
    var numAvis = document.getElementsByClassName("numAvis");

    for (let numLigne = 0; numLigne < lignes.length; numLigne++)
    {
        let ligneA = lignes.item(numLigne);
        let idProduit = numProduit.item(numLigne).textContent;
        let idAvis = numAvis.item(numLigne).textContent;

        //Ajout à la ligne actuelle du parcours, d'un lien vers la page de détail du produit associé au signalement (ancre avis pour accéder à l'avis directement)
        ligneA.addEventListener("click", () => {window.location.href = `${base_url}/produit/${idProduit}/${idAvis}#avis`;});
    }
}

/*
┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃                    Liens aux lignes de lstClients && sanctions                            ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛
*/

function lstClients(){
    // Récupération de toutes les lignes de la liste des clients
    var lignes=document.getElementsByClassName("lignesClients");
    // Récupération de tous les numéros de clients
    var numClients=document.getElementsByClassName("numClients");
    // Récupération de tous les boutons de la liste des clients
    var buttons=document.getElementsByClassName("buttonSanction");

    for (let numLigne=0; numLigne<lignes.length; numLigne++){
        var clientA=numClients.item(numLigne).textContent;
        lignes.item(numLigne).clientA=clientA;
        // Ajout à la ligne actuelle du parcours, d'un lien vers la page de détail du client récupéré juste avant
        lignes.item(numLigne).addEventListener("click", liensLstClients);
        let buttonA=buttons.item(numLigne);
        // Ajout au bouton actuel du parcours, d'un lien vers l'alerte de sanctions du client récupéré juste avant
        if(bannir){
            buttonA.addEventListener("click", () => {
                // supprime le lien de la ligne, pour ne pas cliquer dessus à la place du bouton
                lignes.item(numLigne).removeEventListener("click", liensLstClients);
    
                document.getElementsByClassName("titreSanction")[0].innerHTML = `Bannir le client n°${lignes.item(numLigne).clientA} ?`;
                afficherSanctions();
    
                document.getElementById("timeout").addEventListener("click", () => {
                    cacherSanctions();
                    afficherTimeout(lignes.item(numLigne).clientA);
                    lignes.item(numLigne).addEventListener("click", liensLstClients);
                })
    
                document.getElementById("fermer").addEventListener("click", () => {
                    cacherSanctions();
                    lignes.item(numLigne).addEventListener("click", liensLstClients);
                })
            })
        }
    }

    // fonction qui met le lien vers l'espace du client de la ligne
    function liensLstClients(event){
        event.cancelBubble = true;
        window.location.assign(`${base_url}/admin/espaceClient/${event.currentTarget.clientA}`);
    }

    // fonction qui affiche la div de choix de sanctions
    function afficherSanctions(){
        let sur_alerte = document.getElementsByClassName("sur-alerteSanctions")[0];
        let page = document.querySelectorAll("main, header, footer");
        page.forEach(element => element.style.filter="blur(4px)");
        page.forEach(element => element.style.pointerEvents = "none");
        if(sur_alerte.style.display!="flex"){
            sur_alerte.style.display="flex";
        }
    }

    // fonction qui cache la div de choix de sanctions
    function cacherSanctions(){
        let sur_alerte = document.getElementsByClassName("sur-alerte")[0];
        let page = document.querySelectorAll("main, header, footer");
        page.forEach(element => element.style.filter="blur(0px)");
        page.forEach(element => element.style.pointerEvents = "auto");
        if(sur_alerte.style.display=="flex"){
            sur_alerte.style.display="none";
        }
    }

    // fonction qui affiche la div pour bannir temporairement un client
    function afficherTimeout(clientA){
        document.getElementById("numClient").value = clientA;
        document.getElementsByClassName("titreSanction")[1].innerHTML = `Bannir temporairement le client n°${clientA} ?`;
        let sur_alerteTimeout = document.getElementsByClassName("sur-alerteTimeout")[0];
        let page = document.querySelectorAll("main, header, footer");
        page.forEach(element => element.style.filter="blur(4px)");
        page.forEach(element => element.style.pointerEvents = "none");
        if(sur_alerteTimeout.style.display!="flex"){
            sur_alerteTimeout.style.display="flex";
        }

        document.getElementById("fermerTimeout").addEventListener("click", cacherTimeout)
    }

    // fonction qui cache la div pour bannir temporairement un client
    function cacherTimeout(){
        let sur_alerteTimeout = document.getElementsByClassName("sur-alerteTimeout")[0];
        let page = document.querySelectorAll("main, header, footer");
        page.forEach(element => element.style.filter="blur(0px)");
        page.forEach(element => element.style.pointerEvents = "auto");
        if(sur_alerteTimeout.style.display=="flex"){
            sur_alerteTimeout.style.display="none";
        }
    }
}

/*
┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃                                      CGU                                        ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛
*/
// Fonction permettant d'afficher les CGU lors du clic sur le lien des mentions légales dans le footer
function cgu(){
    var lienCGU = document.getElementsByClassName("lienCGU"); // Lien des mentions légales
    
    // Pour tout les éléments disposant de la classes
    for(button of lienCGU){
        button.addEventListener("click", affichageCGU); // Ajout de l'écouteur pour effectuer les actions
    }
    
    var mentionsLegales = document.getElementsByClassName("mentionsLegales")[0]; // La div des CGU qui s'affichera

    // Fonction d'affichage des CGU lors du clic sur le lienCGU
    function affichageCGU(event) {
        event.preventDefault(); // Empêche le refresh de la page lors du clic sur le lienCGU
        let flou = document.querySelectorAll("main>*, header>*, footer>*"); // Tout l'arrière plan
        let page = document.querySelector("html"); // Toute la page

        // Si les CGU ne sont pas affichées
        if (mentionsLegales.style.display == "none") {
            mentionsLegales.style.display = "block"; // Fait apparaitre la div des CGU
            page.style.overflow = "hidden"; // Empêche le scroll sur le reste de la page
            page.style.pointerEvents = "none"; // Empêche le clic sur le reste de la page
            window.scrollTo({top: 0, behavior: 'smooth'}); // Scroll jusqu'en haut de la page
            mentionsLegales.scrollTo({top: 0, behavior: 'auto'}); // Scroll jusqu'en haut de la div des CGU

            // Pour tout les éléments de l'arrière plan
            for (let index = 0; index < flou.length; index++) {
                flou[index].style.filter = "blur(4px)"; // Définit un flou
                mentionsLegales.style.filter = "blur(0)"; // Retire le flou sur la div des CGU
            }
            document.getElementsByClassName("fermerCGU").addEventListener("blur", affichageCGU); // Ferme les CGU lors du clic sur la croix en haut à droite de la div CGU
        }
    }

    let boutonML = document.getElementsByClassName("remonterCGU")[0]; // Bouton pour remonter les CGU

    // Quand on clic le bouton
    boutonML.addEventListener("click", function(e) {
        mentionsLegales.scrollTo({top: 0, behavior: 'smooth'}); // Scrool tout en haut de la div des CGU
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

//FIXME : problème après suppression filtre
function cataloguePrice(){
    //On récupère les inputs de type range
    const rangeInput = document.querySelectorAll(".range-input input"),
    //On récupère les inputs de prix (tous les inputs à l'exception des inputs de type range)
    priceInput = document.querySelectorAll(".price-range input:not(.range-input input)"),
    //On récupère la barre de progression
    range = document.querySelector(".slider .progress");
    //Gestion de la différence maximale entre les prix dans le slider
    let priceGap = 1;

    //Event listeners sur les inputs de type range et de prix
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

    //Fonctions de gestion des prix
    function fctPriceInput(e){
        //Récupère les valeurs des inputs de prix pour obtenir le min et le max
        let minPrice = parseInt(priceInput[0].value),
        maxPrice = parseInt(priceInput[1].value);
        //Vérification que  la différence entre les prix est supérieure au gap et inférieure ou égale à la valeur maximale du slider 
        if (maxPrice - minPrice >= priceGap && maxPrice <= rangeInput[1].max) {
            //Si la target a pour ID prix_min alors on modifie la valeur de l'input du minimum du slider
            if (e.target.id === "prix_min") {
                rangeInput[0].value = minPrice;
                range.style.left = (minPrice / rangeInput[0].max) * 100 + "%";
                console.log(minPrice + " | " + maxPrice);
            }
            //Si la target a pour ID prix_max alors on modifie la valeur de l'input du maximum du slider 
            else if(e.target.id === "prix_max") {
                rangeInput[1].value = maxPrice;
                range.style.right = 100 - (maxPrice / rangeInput[1].max) * 100 + "%";
            }
        }
    }

    //Fonction de gestion du slider
    function fctRangeInput(e){
        //Récupère les valeurs des inputs de slider pour obtenir le min et le max
        let minVal = parseInt(rangeInput[0].value),
        maxVal = parseInt(rangeInput[1].value) + 1;
        //Vérification que la différence entre les prix est inférieur au gap
        if (maxVal - minVal < priceGap) {
            //Si la target a pour classe range-min alors on modifie la valeur de l'input du minimum du slider
            if (e.target.className === "range-min") {
                rangeInput[0].value = maxVal - priceGap;
            }
            //Sinon on modifie la valeur de l'input du maximum du slider
            else {
                rangeInput[1].value = minVal + priceGap;
            }
        
        }
        //Si la différence entre les prix est supérieure ou égale au gap alors on modifie les valeurs des inputs de prix pour les inverser 
        else {
            priceInput[0].value = minVal;
            priceInput[1].value = maxVal;
            range.style.left = (minVal / rangeInput[0].max) * 100 + "%";
            range.style.right = 100 - (maxVal / rangeInput[1].max) * 100 + "%";
        }
    }
}

//Click bouton filtre media query
function boutonCliquable(bouton,action){
    if(screen.width < 1200){
        bouton.addEventListener("click",action);
    }
    else if(screen.width >= 1200 && bouton.classList.contains("bulle-ouvrir-filtres")){
        bouton.addEventListener("click", () => {
            document.querySelector(".partie-filtre").style.display = "block"
            document.querySelector(".bulle-ouvrir-filtres").style.display = "none"
            localStorage.setItem("open", true);
        })
    }
    else if(screen.width >= 1200 && bouton.classList.contains("fermer-filtre")){
        bouton.addEventListener("click", () => {
            document.querySelector(".partie-filtre").style.display = "none"
            document.querySelector(".bulle-ouvrir-filtres").style.display = "block"
            localStorage.setItem("open", false);
        })
    }
}

function loadFilters(){
    window.addEventListener("load", () => {
        if(localStorage.getItem("open") === "true"){
            document.querySelector(".partie-filtre").style.display = "block"
            document.querySelector(".bulle-ouvrir-filtres").style.display = "none"
        }
        else if(localStorage.getItem("open") === "false"){
            document.querySelector(".partie-filtre").style.display = "none"
            document.querySelector(".bulle-ouvrir-filtres").style.display = "block"
        }
    });
}

//Ajout de la classe "est-filtre-ouvert" au filtre
function switchEtatFiltre(list){
    for (n of list){
        n.classList.toggle("est-filtre-ouvert");
    }
}

//Tout sélectionner sélectionne toutes les sous catégories
function selectAll(){
    //Attrape toutes les checkboxes "Tout sélectionner"
    let boxes = document.querySelectorAll(".bouton-selectionner-tout > input");

    //Pour chaque checkbox
    for(let box of boxes){
        //Lors du coche ou décoche de la checkbox 
        box.addEventListener("change", (e) => {
            //Récupère toutes les sous catégories en partant du parent de la target
            let sousCats = document.querySelectorAll("." + getParentNodeTilClass(e.target).getAttribute("class") + "~ .sous-categorie");
            let checkboxes = [];
            //Pour chaque sous catégorie ajoute sa checkbox dans le tableau checkboxes
            for(let sousCat of sousCats){
                checkboxes.push(sousCat.querySelector("input"));
            }
            //Chaque checkbox du tableau checkboxes prend la valeur de la checkbox "Tout sélectionner"
            for(let checkbox of checkboxes){
                checkbox.checked = box.checked;
            }
        });
    }
}

//Fonction qui récupère le parent d'un élément jusqu'à ce qu'il ait la classe "enTete-'Sousatégorie'"
function getParentNodeTilClass(element){
    //Parent prend la valeur de l'élément passé en paramètre 
    let parent = element;
    //Regex de correspondance à la classe "enTete-'Sousatégorie'"
    let reg = /^enTete\-(.*)/;

    //Le parent prend la valeur de son parent tant que la classe ne correspond pas au regex
    while(!(parent.getAttribute('class').match(reg))){
        parent = parent.parentNode;
    }

    return parent;
}

var filterUpdate = function(formFilter,champRecherche,listeProduit,suppressionFiltre,voirPlus) {
    this.form = formFilter;
    this.erroBloc=document.querySelector("div.bloc-erreur-liste-produit");
    this.champRecherche = champRecherche;
    this.listeProduit=listeProduit
    this.suppressionFiltre=suppressionFiltre;
    this.voirPlus=voirPlus;
    this.currPage = 1//parseInt(document.querySelector("#catalogue-current-page").textContent);
    //Permet d'éviter les problèmes de scope
    var self = this;
 
        this.send = async (replace=true) => {
        //Récupère les valeurs des filtres et transformation en string de type url à laquelle ajoute la recherche
        var champsGet= new URLSearchParams(new FormData(self.form));
        console.log(champsGet.toString());
        if(!self.champRecherche.value==""){
            champsGet.append("search",self.champRecherche.value);
        }
        //FIXME: problème de précison avec min et max. arrondir pour éviter les problèmes ?
        if(self.form.elements["prix_min"].value===self.form.elements["prix_min"].min && self.form.elements["prix_max"].value===self.form.elements["prix_max"].max){
           
            champsGet.delete("prix_min");
            champsGet.delete("prix_max");
        }
        
        champsGet=champsGet.toString();
        if(champsGet.length!=0){
            champsGet="?"+champsGet;
            //champsGet="";
        }
        console.log("http://localhost/Alizon/ci4/public/produits/page/"+((replace)?1:self.currPage)+champsGet);
         
       //fetch avec un await pour récuperer la réponse asynchrones (de manière procédurale)
        try{
            const md= await fetch(base_url + "/produits/page/"+((replace)?1:self.currPage)+champsGet);
            var result= await md.json();
            
            //vérifie si la réponse n'est pas une erreur
            if (md.ok){
                if(replace){
                    self.currPage=1;
                    self.listeProduit.innerHTML="";    
                }
                if(result["estDernier"]){
                    self.voirPlus.classList.add("hidden");
                }else{
                    self.voirPlus.classList.remove("hidden");
                }
                result["resultat"].forEach(produit => self.listeProduit.innerHTML += produit);
                self.erroBloc.classList.add("hidden");
                //reexe, afin que le listener revienne sur les cartes
                clickProduit();
            }else{
             
                self.erroBloc.classList.remove("hidden");
                self.voirPlus.classList.add("hidden");
                self.listeProduit.innerHTML="";
                self.erroBloc.children[0].innerHTML=result["message"];
               
                
            }
            window.history.pushState({page:1},"Filtres",champsGet);
    
        }catch(e){
            //Les erreurs 404 ne passent pas ici, ce sont les erreurs lié à la fonction et au réseau qui sont catch ici
            console.log("Oups !, quelque chose s'est mal passé...");
        }
        
        
    }

    
    Array.from(this.form.elements).forEach((el) => {
        //if(el.nodeName!=="BUTTON"){
            el.addEventListener("change", () => this.send());
        //}
    });

    this.suppressionFiltre.addEventListener('click', (event) => {
        event.preventDefault();
        this.form.reset();
        this.form.elements["prix_min"].value=this.form.elements["prix_min"].min;
        this.form.elements["prix_max"].value=this.form.elements["prix_max"].max;
        document.querySelector(".range-min").value=this.form.elements["prix_min"].min;
        document.querySelector(".range-max").value=this.form.elements["prix_max"].max;
        this.send();
        
    });

    this.voirPlus.addEventListener('click', (event) => {
        this.currPage++;
        this.send(false);
    });

    /*
    Array.from(document.querySelectorAll(".fleche-page")).forEach((el) => {
        if(el.classList.contains("disponible"))
        {
            el.addEventListener("click", (event) => {

                event.preventDefault()
                this.send(self.currPage + (event.target.classList.contains("fleche-page-gauche") ? -1 : 1))
            });
        }
    });
    */


}

/*  
┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃                               Detail commande                                   ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛
*/
// Gestion de la barre de progression (pas adaptative en fonction du nombre de points)
function barreProgression() {
    let pointProgress = document.getElementsByClassName("pointProgress"); // Les points de la barre de progression
    let preuveLivraison = document.querySelector(".preuveLivraison"); // Le dernier point qui valide la livraison
    let progressBar = document.querySelector(".progress-bar-ok"); // La barre de progression

    // Calcule du pourcentage de la barre de progression en fonction de l'état
    if (progressBar.value < 5) { // Nombre de points sur la barre de progression
        progressBar.value = (progressBar.value - 1)*25 + 12,5; // Formule pour que les états 1 = 12,5% ; 2 = 37,5 ; 3 = 62,5 ; 4 = 87,5
    } else {
        progressBar.value = 100; // Si l'état = 5 (max), la barre est à 100%
    }

    // Définit la couleur des points en fonction du pourcentage
    for (let index = 0; index < 5; index++) { // Pour les 5
        if (index*25 <= progressBar.value) { // Point vert si le pourcentage est supérieur au numéro du point multiplié par 25
            pointProgress[index].classList.add("point-ok"); // Classe point vert
        } else {
            pointProgress[index].classList.add("point-ko"); // Classe point rouge
        }
    }
    if (pointProgress[4].classList.contains("point-ko")) { // Si le dernier point est rouge
        // Le bouton de la preuve de livraison est grisé et non cliquable
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
var seekPositionErreur = function(forNom){

    return document.querySelector(`.position-erreur[for=${forNom}]`);
}

var formAdresseConstructor = function(){
    this.form=document.forms["form_adresse"];
    var self =this;
    this.actionAfterFetch= new Object();


    this.nomEtPrenom =[
        this.form.elements["nom"],
        this.form.elements["prenom"]    
    ];
    //Suggestions dés le clique
    this.form.elements["ville"].addEventListener("mousedown",function(event){
        if( document.activeElement == this )return;
      
        event.target.focus();
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

    
    //Vérifications des champs requis
    Array.from(this.form.elements)
    .filter(elem => {
        return elem.required && !Array.from(elem.parentNode.parentNode.classList).includes("nomPrenom")
    })
    .forEach(elemRequired => {
        elemRequired.addEventListener("blur", (event) => {
        selfTarget=event.target;
        if(selfTarget.validity.valueMissing){
            this.creerErreur(seekPositionErreur(selfTarget.name),"Champ vide");
            this.estRempli[selfTarget.name]=false;
        }
        else{
            this.estRempli[selfTarget.name]=true;
            this.supprimerErreur(seekPositionErreur(selfTarget.name));
           
        }
        })
    })

    this.afterVille = function(response){
    
        this.codePostal.value = response.features[0].properties.postcode;
        this.supprimerErreur(seekPositionErreur(selfTarget.name));
         
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
            this.creerErreur(document.querySelector(`.position-erreur[for=${selfTarget.name}]`),"Ne correspond à aucun code postal");
           
        }
        else if(!this.codePostal.validity.valueMissing){
           
            this.supprimerErreur(seekPositionErreur(selfTarget.name));
        
            
            
            
            fetch("https://api-adresse.data.gouv.fr/search/?q="+selfTarget.value+"&postcode="+selfTarget.value+"&type=municipality")
            .then(response => response.json())
            .then(response => self.afterCodePostal(response))
            .catch(error => {console.error('Error:', error)});   
                
            
           
        }
        else{
            this.supprimerErreur(seekPositionErreur(selfTarget.name));
            
           
        }    
    };
    this.codePostal.addEventListener("blur", this.chercherVilleParCodePostal);
 
}
 

/*
┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃                                     Errors                                      ┃
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
    
        this.etoilet = function () {
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
    
    (new Shuffle(document.getElementById('error_text'))).etoilet();
    
    window.setTimeout(function () {
        document.getElementById('details').classList.remove('hidden');
    }, 550);
}

/*
┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃                                   Recherche                                     ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛
*/
/* Ne sert à rien de tout façon
document.addEventListener('invalid', (function () {
    return function (e) {
        e.preventDefault();
        document.getElementById("name").focus();
    };
})(), true);
*/
/*
┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃                                  Card Produit                                   ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛
*/

function parentTilCard(element){
    let card = element;
    //get the parent node of the element until the card
    while(card.getAttribute('value') == null){
        card = card.parentNode;
    }
    return card
}
function clickProduit(){
    //Select all cards
    let cards = document.querySelectorAll(".card-produit");
    for(card of cards){
        //Redirection while clicking on products
        card.addEventListener("click", (e) =>{window.location.href=  base_url +  "/produit/" + parentTilCard(e.target).getAttribute('value');});
    }
}
//Only if at least one card in the page
if(document.querySelector(".card-produit") != null){
    clickProduit();
}
/*
┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃                                 hoverConnexion                                  ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛
*/
// Gestion de l'apparition du menu contextuel au niveau lors du passage de la souris sur l'icône de profil à droite du header
function menuCredit() {
    let divHoverConnexion = document.querySelector(".divHoverConnexion"); // Div contenant le menu contextuel
    let lienConnexion = document.querySelector(".lienConnexion"); // Icône du profil
    let hover = false; // Booléen pour savoir si la souris est sur l'un des 2 élément ci dessus

    // Si la souris est sur l'icône de profil
    lienConnexion.addEventListener("mouseover", () => {
        divHoverConnexion.style.display = "flex"; // Le menu contextuel apparait
        hover = true;
    })

    // Si la souris quitte de l'icône de profil
    lienConnexion.addEventListener("mouseout", () => { 
        setTimeout(function(){ // Attente d'une seconde
            if (hover == false) { // verifie si le booléen est faux (ce qui veut dire que la souris n'est ni sur l'icône du profil ni sur le menu contextuel)
                divHoverConnexion.style.display = "none"; // Dans ce cas, le menu contextuel est masqué
            }
        }, 1400);
        hover = false;
    })

    // Si la souris est sur le menu contextuel
    divHoverConnexion.addEventListener("mouseover", () => { 
        divHoverConnexion.style.display = "flex"; // Le menu contextuel apparait (ou reste si il est déjà affiché)
        hover = true;
    })

    // Si la souris quitte le menu contextuel
    divHoverConnexion.addEventListener("mouseout", () => {
        divHoverConnexion.style.display = "none"; // Le menu contextuel disparait
        hover = false;
    })
}
/*
┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃                                 Paiement                                        ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛
*/
function setUpPaiment(){
    
    document.querySelector("[type='submit']").addEventListener("click", (e) => {
        e.preventDefault(); 
        let forms= [
            document.forms["form_adresse"],
            document.forms["form_paiement"]
        ]
        var theForm= document.createElement("form");    
    
        let isValid=Array.from(forms).every(form => {
            
            if(form.reportValidity ()){
                for (var elem of form.elements) {
                    theForm.appendChild(elem.cloneNode(true));
                }
               return true;
            }
            else{
                return false;
            }
        });
        if (isValid){
            theForm.method= "POST";
            theForm.action= base_url + "/paiement";
            theForm.style.display= "none";
            document.body.appendChild(theForm);
            console.log(theForm);
            theForm.submit();
        }
        
    
        
    })
}


/*
┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃                                 Alerte                                          ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛
*/

class AlerteAlizon{
    
    constructor(titre,destination,message="Une alerte survient",method="GET"){
        this.titre=titre;
        this.display=null;
        this.message=message;
        this.destination=destination;
        this.form=document.createElement("form");
        this.form.action=destination;
        this.form.method=method;
    }
    

    ajouterBouton(intitule,classe,nomForm=intitule){
        let bouton=document.createElement("button");
        bouton.name=nomForm;
        bouton.className=classe;
        bouton.innerHTML=intitule;
        bouton.value=1;
        this.form.appendChild(bouton);
    }
    
    affichage=(message=this.message) => {
        document.querySelectorAll("main, header, footer").forEach(element => element.style.filter="blur(4px)");
        this.display = document.createElement("div");
        this.display.classList.add("sur-alerte");
        this.display.innerHTML= `
      
            <div class="alerte">
                <h2>${this.titre}</h2>
                <hr>
                <p class="message-alerte">${message}</p>
                <div class="alerte-footer">
                    <hr>
                    <div class="espace-interraction">
                        ${this.form.outerHTML}
                    </div>
                </div>
            </div>
   
        `;
        document.body.appendChild(this.display);
    }

    
}

/*
┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃                            Changement image produit                             ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛
*/

function changeImageProduit(e) 
{
    e.preventDefault();

    let image = e.currentTarget.getElementsByTagName("img")[0];
    let divImagePrincipale = document.getElementsByClassName("zoom")[0];
    let imagePrincipale = divImagePrincipale.getElementsByTagName("img")[0];
    
    //Change l'image principale par l'image cliquée
    imagePrincipale.src = image.src;
    divImagePrincipale.style.backgroundImage = "url("+image.src+")";
}

/*
┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃                                 Zoom Produit                                    ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛
*/

function zoomProduit(e) {
    var zoomer = e.currentTarget;
    e.offsetX ? offsetX = e.offsetX : offsetX = e.touches[0].pageX
    e.offsetY ? offsetY = e.offsetY : offsetX = e.touches[0].pageX
    x = offsetX/zoomer.offsetWidth*100
    y = offsetY/zoomer.offsetHeight*100
    zoomer.style.backgroundPosition = x + '% ' + y + '%';
}


/*
┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃                                 Avis Produit                                    ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛
*/
function avisProduit() 
{
    //Mise en valeur d'un avis avec une box-shadow
    var bgopacity = 1.0;
    var bgfade = function() 
    {
        var avisEnValeur = document.getElementById("avisEnValeur");
        bgopacity -= 0.015
        if (avisEnValeur != null) {
            avisEnValeur.style.boxShadow = "0 0 10px rgba(0, 0, 0, " + bgopacity + ")";
            avisEnValeur.style.borderRadius = "5px";
        }

        if (bgopacity >= 0) 
        {
            setTimeout(bgfade, 30);
        }
        else
        {
            //On retire le #avis à la fin de l'url quand l'animation est finie c'est plus propre
            //window.history.pushState({}, document.title, window.location.pathname);

            //Malheureusement ça reload la page mais c'est d'une puissance ce truc
            //On retire l'avis en valeur de l'url
            //window.location.href = window.location.href.replace(/\/[0-9]$/, "");
        }
    }

    bgfade();
    //printing the current url
    //console.log(window.location.href);

    let tabAvis = document.querySelectorAll(".divAvisCommentaire p"); // séléctionne les avis
    
    // seulement si il y a des avis
    if (tabAvis.length != 0) {
        let moyennes = [0, 0, 0, 0, 0]; // tableau des moyennes pour chaque étoile
        // définit le nombre d'avis correspondant à telle étoile
        tabAvis.forEach(element => {
            for (let index = 0; index < 5; index++) {
                // si note contenue entre 1 et 1.99 ; 2 et 2.99 ; ...
                if ((parseInt(element.innerHTML.substring(0, element.innerHTML.length - 2)) >= (index+1)) && (parseInt(element.innerHTML.substring(0, element.innerHTML.length - 2)) < (index + 2))) {
                    moyennes[index] = moyennes[index] + 1; // ajoute 1 à l'étoile correspondante à l'avis
                }
            }
        });

        let lesBarres = document.querySelectorAll(".barreAvis"); // séléctionne les barres de progression 
        // définit le max et la valeur pour chaque barre de progression
        for (let index = (lesBarres.length-1); index > -1; index--) {
            lesBarres[lesBarres.length-index-1].max = tabAvis.length; // max pour les barres de progression (nombre total d'avis)
            lesBarres[lesBarres.length-index-1].value = moyennes[index];
        }

        let pourcentages = [0, 0, 0, 0, 0]; // tableau des pourcentages
        let lesP = document.querySelectorAll(".pAvis"); // les p pour faire y ajouter les pourcentages afin de les faire apparaitre sur la page
        // définit les pourcentages d'avis correspondant à tel nombre d'étoiles
        for (let index = 0; index < moyennes.length; index++) {
            pourcentages[index] = moyennes[index] / tabAvis.length * 100; //divise le nb d'avis par étoile par le nombre total d'avis afin d'avoir le pourcentage
        }

        let count = moyennes.length - 1; // index pour parcourir le tableau dans l'autre sens car l'index 0 des pourcentages correspond à l'index 4 des barres de progression
        // place les pourcentages en parcourant le tableau 
        for (let index = 0; index < moyennes.length; index++) {
            lesP[index].textContent = pourcentages[count].toFixed(0) + "%"; // ajoute au p le pourcentage
            count = count - 1; // continue de parcourir le tableau dans l'autre sens 
            if (count == -1) {
                count = moyennes.length - 1; // réinitialise au cas où
            }
        }   
    }

    // écouteurs sur les étoiles pour noter un produit
    let etoiles = document.querySelectorAll(".divEtoilesComment svg path");
    etoiles.forEach(etoile => {
        etoile.addEventListener('mouseover', hoveretoile);
        etoile.addEventListener('mouseout', outetoile);
    });

    document.querySelector(".divProfilText input").addEventListener("input", function() {
        document.querySelector(".divBoutonsComment").style.display = "flex";
    });

    document.querySelector(".divBoutonsComment button").addEventListener("click", function(){
        etoiles.forEach(element => {
            element.removeAttribute("class");
            document.querySelector(".divBoutonsComment").style.display = "none";
            document.querySelector(".divEtoilesComment p").textContent = "_/5";
            if (document.querySelector(".bloc-erreurs") != null) {
                document.querySelector(".bloc-erreurs").style.display = "none";
            }
        });
    });

    // met en jaune l'étoile sur laquelle on est ainsi que les précédentes    
    function hoveretoile() {
        // pour toutes les etoiles
        for(let i=0; i< etoiles.length; ++i) {
            etoiles[i].classList.add('etoileActive'); // ajoute une classe qui met en jaune

            // jusqu'à ce quon arrive à l'étoile sur laquelle on est 
            if(etoiles[i] === this) {
                return;
            }
        }
    }

    // quand on quitte les etoiles
    function outetoile() {
        for (let index = 0; index < etoiles.length; index++) {
            etoiles[index].classList.remove('etoileActive'); // remet tout en gris
        }
    }

    // pareil qu'au dessus, mais cette fois bloque la couleur et fait quelques autres trucs (détaillés plus loin)
    etoiles.forEach(etoile => {
        etoile.addEventListener('click', validerEtoile);
    });

    function validerEtoile() {
        for(let i=0; i< etoiles.length; ++i) {
            etoiles[i].classList.add('etoilesValide'); 
             
            if(etoiles[i] === this) {
                document.querySelector(".divEtoilesComment p").textContent = (i + 1) + "/5"; // écrit le numéro de la note à coté des étoiles
                document.querySelector(".inputInvisible").value = (i + 1);

                document.querySelector(".divBoutonsComment div").style.cursor = "auto"
                document.querySelector(".divBoutonsComment").style.display = "flex";
                btnPoster = document.querySelector(".divBoutonsComment input");
                btnPoster.style.cursor = "pointer";
                btnPoster.style.background = "#24a064";
                btnPoster.style.color = "white";
                btnPoster.style.pointerEvents = "auto";
                
                // retire le jaune des suivantes au cas ou on clique plusieurs fois
                while (i+1 != 5) {
                    etoiles[i+1].classList.remove('etoilesValide'); 
                    i = i +1;
                }
                return;
            }
        }
    }
}