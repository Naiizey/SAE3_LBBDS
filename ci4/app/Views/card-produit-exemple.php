

<head>

<style>
    .card-produit{
        width: 219px;
        height: 300px;
        border-radius: 8.47px;
        border: solid 1px black;
        text-align: center;
        font-family: 'Montserrat-Medium';
        font-size: 19px ;
    }
    .image-card{
        width: 100%;
        height: 55%;
        border-radius: 8.47px 8.47px 0 0;
    }
    .notation-card{
        background-color: rgba(0, 0, 0, 61%);
        width: 100%;
        height: 25px;

    }
    .star{
        /*TODO: voir pour la couleur dans les étoiles*/
        margin: 0 1px;
    }
    .contain-libelle{
        min-height:85px;
        max-height:85px;
    }

    .contain-libelle, .notation-card, .prix-card{
        position: relative;
        top: -25px;
    }
    p.libelle{
        margin-top: 10px;
        width: 100%;
        margin-bottom: 0;
        word-wrap: break-word;
    }
    /*TODO: sauvegarder dans bdd position */
    div.image-card{
        
        background-position: 0;
    }
    /* Star 1 */



    .prix-card{
        text-align: center;
        font-size: 25px;
        margin: 0;
    }
</style>
</head>

<?php
$prod->lienimage = 'ressources/images.jpg';

echo $cardProduit->display($prod);
?>