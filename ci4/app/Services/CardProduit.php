<?php namespace App\Services;

/**
 * Cette classe permet d'afficher une carte d'un produit
 * @method display
 * 
 */
class CardProduit
{
    private function normalize(\App\Entities\Produit $prod){
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

    private function cardProduit($prod){
        ob_start(); ?>
        <div class="card-produit-ext">
            <div class="card-produit" value=<?=$prod->id?>>
                <div class="image-card" style="background-image: url(<?= /*base_url().'/'.*/$prod->lienimage?>);"></div>
                <div class="notation-card"><?= $this->notationEtoile($prod->moyenneNote) ?></div>
                <div class="contain-libelle"><p class="libelle"><?= $prod->intitule?></p></div>
                <div class="contain-vendeur"><p class="vendeur"><a href="<?=base_url() . "/catalogue?" . $prod->num_compte . "=on"?>"><?= $prod->intitule_vendeur ?></a></p></div>
                <div class="bottom-card">
                    <p class="prix-card"><?= $prod->prixttc?>€</p>
                    <a href="<?= base_url().'/panier/ajouter/'.$prod->id.'/1' ?>" class="addPanier">
                        <?= file_get_contents(dirname(__DIR__, 2) . '/public/images/header/addPanier.svg');?>
                        <?= file_get_contents(dirname(__DIR__, 2) . '/public/images/vendeur/catalogue/checkmark.svg');?>
                    </a>
                </div>
            </div>
        </div>
        <?php return ob_get_clean();
    }

    public function display($prod){
        $this->normalize($prod);
        return $this->cardProduit($prod);
    }
}
?>