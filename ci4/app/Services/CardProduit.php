<?php namespace App\Services;


class cardProduit
{
    private function normalize(\App\Entities\Produit $prod){
        if (str_contains($prod->intitule,"\n"))
        {
        if(str_contains($prod->intitule,"\n"))
        {
        $exploded=explode("\n",$prod->intitule,4);
        if (sizeof($exploded)===4 && strlen($exploded[3])!==0){
            
            $prod->intitule= $exploded[0].$exploded[1].$exploded[2]."...";

        }else{
            $prod->intitule=implode("\n",$exploded);
        }
        }

        if($prod->intitule>51){
            $prod->intitule=str_split($prod->intitule,51)."...";  
        }

        }
        $prod->prixttc
        =sprintf("%5.2f",floor($prod->prixttc*100)/100); 

    }


    private function notationEtoile($note){
        $retour="";
        for($i=1;$i<6;$i++){
            if($note >= $i)
            {
                $retour.="<img class='star' src='".base_url()."/images/Star-full.svg'/>";
            }
            else if($note+0.5 >= $i)
            {
                $retour.="<img class='star' src='".base_url()."/images/Star-half.svg'/>";
            }
            else
            {
                $retour.="<img class='star' src='".base_url()."/images/Star-empty.svg'/>";
            }

        }
        return $retour;
    }

    private function cardProduit($prod){ 
        ob_start(); ?>
        <div class="card-produit-ext">
        <div class="card-produit">
    
            <div class="image-card" style="background-image: url(<?= base_url().'/'.$prod->lienimage
    ?>);"></div>
    
            <div class="notation-card"><?= $this->notationEtoile($prod->moyenneNote) ?></div>
            <div class="contain-libelle"><p class="libelle"><?= $prod->intitule?></p></div>
            <p class="prix-card"><?= $prod->prixttc?>€</p>
    
        </div>
        </div>
        <?php return ob_get_clean();
    }

    public function display($prod){
        $this->normalize($prod);
        return $this->cardProduit($prod);
    }
    


}