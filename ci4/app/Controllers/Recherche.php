<?php namespace App\Controllers;

use CodeIgniter\CodeIgniter;

class Recherche extends BaseController
{
    public function indice_recherche($article, $champ) {
        $indice = substr_count($article->intitule, $champ)*0.6 + substr_count($article->isaffiche, $champ)*0.4;
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
        $produits = model("\App\Models\ProduitCatalogue")->findAll();
        $data['categories']=model("\App\Models\CategorieModel")->findAll();
        $indices = [];
        foreach ($produits as $cle=>$prod) {
            $indice = $this->indice_recherche($prod, $champ);
            if ($indice > 0.1) { 
                $indices[$cle] = ["score"=>$indice,"produit"=>$prod];
            }
        }
        $resultats = array_column($this->tri($indices),'produit');
        $data["prods"] = $resultats;

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