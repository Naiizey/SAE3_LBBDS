<?php namespace App\Services;

use App\Entities\ProduitQuidi;
use PhpParser\Node\Expr\FuncCall;

/**
 * Cette classe permet d'afficher une carte d'un produit
 * @method display
 * 
 */
class CardProduit
{
    const CLIENT = "client";
    const ADMIN = "client";
    const VENDEUR = "vendeur";
    const AJOUT_OU_SUPPRIMER = [
        true => "plus",
        false => "minus"
    ];
    private function normalize(\App\Entities\Produit | ProduitQuidi $prod){
        if (str_contains($prod->intitule, "\n")) {
            if (str_contains($prod->intitule, "\n")) {
                $exploded=explode("\n", $prod->intitule, 4);
                if (sizeof($exploded)===4 && strlen($exploded[3])!==0) {
                    
                    $prod->intitule= $exploded[0].$exploded[1].$exploded[2]."...";
                
                }else {
                    $prod->intitule=implode("\n", $exploded);
                }
            }

            if ($prod->intitule>51) {
                $prod->intitule=str_split($prod->intitule, 51)."...";
            }
        }
        $prod->prixttc
        =sprintf("%5.2f", floor($prod->prixttc*100)/100);

    }


    public function notationEtoile($note){
        $retour="";
        for ($i=1; $i<6; $i++) {
            if ($note >= $i) {
                $retour.="<img class='star' src='".base_url()."/images/Star-full.svg'/>";
            }elseif ($note+0.5 >= $i) {
                $retour.="<img class='star' src='".base_url()."/images/Star-half.svg'/>";
            }else {
                $retour.="<img class='star' src='".base_url()."/images/Star-empty.svg'/>";
            }

        }
        return $retour;
    }



    private function cardProduit($prod, $context=self::CLIENT, $siAjout=false){
        ob_start(); ?>
        <div class="card-produit-ext filled">
            <div class="card-produit context-<?= $context;?>" value=<?=$prod->id?>>
                <div class="image-card" style="background-image: url(<?= /*base_url().'/'.*/$prod->lienimage?>);"></div>
                <div class="notation-card"><?= $this->notationEtoile($prod->moyenneNote) ?></div>
                <div class="contain-libelle"><p class="libelle"><?= $prod->intitule?></p></div>
                <div class="contain-vendeur"><p class="vendeur"><a href="<?=base_url() . "/catalogue?" . $prod->num_compte . "=on"?>"><?= $prod->intitule_vendeur ?></a></p></div>
                <div class="bottom-card">
                    <p class="prix-card"><?= $prod->prixttc?>€</p>  
                    <a href="<?= base_url().'/panier/ajouter/'.$prod->id.'/1' ?>" class="addPanier <?=$prod->id?> <?=($siAjout)?"est-ajout":""?>">
                        <?= file_get_contents(dirname(__DIR__, 2) . '/public/images/header/addPanier.svg');?>
                        <?= file_get_contents(dirname(__DIR__, 2) . "/public/images/vendeur/catalogue/plus.svg");?>
                        <?= file_get_contents(dirname(__DIR__, 2) . "/public/images/vendeur/catalogue/minus.svg");?>

                    
                    </a>
                </div>
            </div>
        </div>
        <?php return ob_get_clean();
    }

    public function display(\App\Entities\Produit | ProduitQuidi $prod, $context=self::CLIENT, $estAjout=false){
        $this->normalize($prod);
        return $this->cardProduit($prod, $context, $estAjout);
    }
}
?>