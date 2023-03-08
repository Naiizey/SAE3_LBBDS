<?php

namespace App\Models;

use CodeIgniter\Model;



/** 
 * Model de classe client qui permet de récuperer un client, ainsi qu'insérer et mettre à jour.
 * 
 * 
 * @see TutoCI/CI5_BDD
 * @return \App\Entities\Vendeur
 */
class Vendeur extends Compte
{
    protected $table      = 'sae3.vendeur';
    protected $primaryKey = 'numero';

    protected $useAutoIncrement = true;

    protected $returnType     = \App\Entities\Vendeur::class;
    protected $useSoftDeletes = false;

    protected $allowedFields = ["identifiant","motdepasse","email", 'texte_presentation', 'numero_siret', 'tva_intercommunautaire', 'note_vendeur', 'logo', 'numero_rue', 'nom_rue', 'code_postal', 'ville', 'comp_a1', 'comp_a2'];

    public function getVendeurByPseudo($identifiant, $motDePasse) : \App\Entities\Vendeur | null
    {
        $comptes = $this->where("identifiant",$identifiant);

        return parent::getCompteByCredentials($comptes, $motDePasse);
    }

    public function getVendeurByEmail($email, $motDePasse) : \App\Entities\Vendeur | null
    {
        $comptes = $this->where("email",$email);

        return parent::getCompteByCredentials($comptes, $motDePasse);
    }

    public function getVendeurById($id)
    {
        return parent::getCompteById($id);
    }

    public function saveVendeur(\App\Entities\Vendeur $vendeur)
    {
        parent::saveCompte($vendeur);
    }

    public function doesEmailExists($email) : bool
    {
        return model("\App\Model\Compte")->doesEmailExists($email);
    }

    public function doesPseudoExists($pseudo) : bool
    {
        return model("\App\Model\Compte")->doesPseudoExists($pseudo);
    }
}