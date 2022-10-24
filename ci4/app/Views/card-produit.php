<?php
$prod=array('lien'=>'rien','contenu'=>"ddddddddd", 'prix'=>3.90);
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

    $prod['prix']=number_format($prod['prix'],5);
    

    
}

function notationEtoile(){
    return "⭐⭐⭐⭐⭐";
}

function cardProduit($prod){ 
    ob_start(); ?>
    <div class="card-produit-ext">
    <div class="card-produit">
        <div class="image-card"><?= $prod['lien']?></div>
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