<?php
$prod=array('lien'=>'ressources/images.jpg','contenu'=>"ddddddddd", 'prix'=>3.90);
if (str_contains($prod['contenu'],"\n"))
{
    if(str_contains($prod['contenu'],"\n"))
    {
        $exploded=explode("\n",$prod['contenu'],4);
        if (sizeof($exploded)===4 && strlen($exploded[3])!==0){
            
            $prod['contenu']= $exploded[0].$exploded[1].$exploded[2]."...";

        }else{
            $prod['contenu']=implode("\n",$exploded);
        }
    }

    if($prod['contenu']>51){
        $prod['contenu']=str_split($prod['contenu'],51)."...";  
    }

}
$prod['prix']=sprintf("%5.2f",floor($prod['prix']*100)/100); 

function notationEtoile(){
    $retour="";
    for($i=0;$i<5;$i++){
        $retour.="<img class='star' src='".base_url()."/images/Star-empty.svg'/>";
    }
    return $retour;
}

function cardProduit($prod){ 
    ob_start(); ?>
    <div class="card-produit-ext">
    <div class="card-produit">

        <div class="image-card" style="background-image: url(<?= base_url().'/'.$prod['lien']?>);"></div>

        <div class="notation-card"><?= notationEtoile() ?></div>
        <div class="contain-libelle"><p class="libelle"><?= $prod['contenu']?></p></div>
        <p class="prix-card"><?= $prod['prix']?>€</p>

    </div>
    </div>
    <?php return ob_get_clean();
}?>

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

echo cardProduit($prod);
?>