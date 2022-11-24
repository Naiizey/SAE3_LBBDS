<?php namespace App\Controllers;

use CodeIgniter\CodeIgniter;

class Recherche extends BaseController
{
    public function indice_recherche($article, $champ) {
        $indice = (substr_count(strtolower($article->intitule), strtolower($champ))*0.6)/(.1+strpos($article->intitule, $champ)) + substr_count(strtolower($article->description_prod), strtolower($champ))*0.4;
        return $indice;
    }

    public function tri($tab) {
        array_multisort(array_column($tab,'score'), SORT_DESC, $tab);
        return $tab;
    }

    private const NBPRODSPAGECATALOGUE = 18;

    public function rechercher($page=null) {
        $champ = $this->request->getGet()["search"];
        $data['controller'] = "recherche";
        $data['cardProduit']=service("cardProduit");
        $data['vide'] = false;
        $produits = model("\App\Models\ProduitCatalogue")->like('intitule', $champ)->orLike('description_prod', $champ)->findAll();
        $data['categories']=model("\App\Models\CategorieModel")->findAll();
        //TODO: Proposer uniquement des filtres qui collent aux articles de la recherches
        //TODO: correcteur de fautes
        if ($produits == null) {
            $data['vide'] = true;
            $data['prods'] = model("\App\Models\ProduitCatalogue")->findAll();
        } else {
            $indices = [];
            foreach ($produits as $cle=>$prod) {
                $indice = $this->indice_recherche($prod, $champ);
                $indices[$cle] = ["score"=>$indice,"produit"=>$prod];
            }
            $resultats = array_column($this->tri($indices),'produit');
            $data["prods"] = $resultats;
        }
        if ($data["prods"] != null) {
            $data['nombreMaxPages']=intdiv(sizeof($data['prods']),self::NBPRODSPAGECATALOGUE)
            + ((sizeof($data['prods']) % self::NBPRODSPAGECATALOGUE==0)?0:1);
        } else {
            $data['nombreMaxPages'] = 1;
        }

        if(is_null($page) || $page==0)
        {
            $data['minProd']=0;
            $data['maxProd']=self::NBPRODSPAGECATALOGUE;
            $data['page']=1;
        }
        else
        {
            if($data['nombreMaxPages']>=$page)
            {
                $data['page']=$page;

                $data['minProd']=self::NBPRODSPAGECATALOGUE*($page-1);
                $data['maxProd']=self::NBPRODSPAGECATALOGUE*$page;
                
            }
            else return view('errors/html/error_404.php', array('message' => "Page trop haute: pas assez de produit"));
        }
        return view("catalogue.php",$data);
    }
}