//Fonctions pour le changement d'images lors du hover sur le profil
//Affecte la nouvelle image lorsque la souris survole l'élément
function passageDeLaSouris(element) {
    element.setAttribute('src', './images/header/profil_hover.png');
    }

//Affecte l'image de départ lorsque la souris ne survole plus l'élément
function departDeLaSouris(element) {
    element.setAttribute('src', './images/header/profil.png');
}