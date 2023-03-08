SET SCHEMA 'sae3';


/**
  SOUS-VUES & FONCTIONS UTILISÉS DANS LES VUES

 */
 --SOUS-VUES
CREATE OR REPLACE VIEW soloImageProduit AS
    WITH min_image AS (SELECT min(num_image) num_image, id_prod FROM _image_prod  group by id_prod )
    SELECT id_prod, lien_image, estinterne FROM _image_prod WHERE _image_prod.num_image IN (SELECT num_image FROM min_image);

CREATE OR REPLACE VIEW moyenneProduit AS
        SELECT id_prod id,avg(note_prod)::numeric(4,2) as moyenneNote FROM _produit natural join _note  group by id_prod;

CREATE OR REPLACE VIEW autre_image AS
    WITH min_image AS (SELECT min(num_image) num_image, id_prod FROM _image_prod  group by id_prod )
    SELECT num_image,lien_image,id_prod FROM sae3._image_prod WHERE num_image NOT IN (SELECT num_image FROM min_image);

CREATE OR REPLACE VIEW compte_client AS
    SELECT num_compte numero, nom_compte, prenom_compte, pseudo, email, mot_de_passe FROM _client NATURAL JOIN _compte;

CREATE OR REPLACE VIEW compte_vendeur AS
    SELECT * FROM _vendeur NATURAL JOIN _compte;

CREATE OR REPLACE VIEW compte AS
    SELECT * FROM _compte;

CREATE OR REPLACE VIEW produit_global AS
    SELECT id_prod,
    intitule_prod,
    prix_ht,
    prix_ttc,
    description_prod,
    publication_prod,
    stock_prod,
    moyenne_note_prod,
    seuil_alerte_prod,
    alerte_prod,
    code_sous_cat
    FROM _produit;

--FONCTIONS
CREATE OR REPLACE FUNCTION retourneEtatLivraison(entree_num_commande varchar) RETURNS INT AS
    $$
    DECLARE
        row sae3._commande%ROWTYPE;
    BEGIN

        SELECT *  INTO row FROM sae3._commande where num_commande=entree_num_commande;

        IF row.date_expedition is null then
            return 1;
        end if;
        IF row.date_plateformeReg is null then
            return 2;
        end if;
        IF row.date_plateformeLoc is null then
            return 3;
        end if;
        IF row.date_arriv is null then
            return 4;
        end if;
        return 5;

    end;
    $$ language plpgsql;

/**
  VUES:
    -ADRESSE
    -CLIENT
    -COMMANDE
    -PRODUIT & CATEGORIE
    -PANIER
    -MODÉRATION & COMMENTAIRE
    -RÉDUCTION
    -VENDEUR


 */
--ADRESSE
CREATE OR REPLACE VIEW adresse_facturation_client AS
    SELECT num_compte, nom_a, prenom_a, numero_rue, nom_rue, code_postal, ville FROM _adresse_facturation NATURAL JOIN _adresse NATURAL JOIN _recevoir_facture;

CREATE OR REPLACE VIEW adresse_livraison_client AS
    SELECT num_compte, nom_a, prenom_a, numero_rue, nom_rue, code_postal, ville FROM _adresse_livraison NATURAL JOIN _adresse NATURAL JOIN _recevoir_commande;

CREATE OR REPLACE VIEW adresse_livraison AS
    SELECT _adresse.id_a, nom_a nom, prenom_a prenom, numero_rue, nom_rue, code_postal, ville, comp_a1, comp_a2, infos_comp, num_commande FROM _adresse NATURAL JOIN _adresse_livraison LEFT JOIN _commande c on _adresse.id_a = c.id_a ;
CREATE OR REPLACE VIEW adresse_facturation AS
    SELECT * FROM _adresse NATURAL JOIN _adresse_facturation;



 --CLIENT
CREATE OR REPLACE VIEW client AS
    WITH trouve_current_panier AS (select max(num_panier) current_panier,num_compte from sae3._panier_client group by num_compte)
    SELECT numero, nom_compte nom, prenom_compte prenom, email, pseudo identifiant, mot_de_passe as motDePasse, current_panier FROM compte_client NATURAL JOIN trouve_current_panier;

CREATE OR REPLACE VIEW client_mail AS
    SELECT numero, email from compte_client;





--COMMANDE
CREATE OR REPLACE VIEW commande_list_vendeur AS
    SELECT p.num_compte as num_vendeur,num_commande,c.num_compte,date_commande,date_arriv, round((sum(prix_ht*qte_panier))::numeric, 2 ) ht, round((sum(prix_ttc*qte_panier))::numeric, 2 ) ttc, retourneEtatLivraison(num_commande) etat FROM _commande c NATURAL JOIN _refere_commande INNER JOIN _produit p ON _refere_commande.id_prod = p.id_prod INNER JOIN _vendeur ON _vendeur.num_compte = p.num_compte group by num_vendeur, num_commande, c.num_compte,date_commande,date_arriv,etat;

CREATE OR REPLACE VIEW commande_list_client AS
    SELECT num_commande,c.num_compte,date_commande,date_arriv,round((sum(prix_ttc*qte_panier))::numeric, 2 ) prix_ttc,round((sum(prix_ht*qte_panier))::numeric, 2) prix_ht, retourneEtatLivraison(num_commande) etat, montant_reduction, pourcentage_reduction FROM _commande c LEFT JOIN _code_reduction ON c.id_reduction = _code_reduction.id_reduction NATURAL JOIN _refere_commande INNER JOIN _produit ON _refere_commande.id_prod = _produit.id_prod group by num_commande, c.num_compte,date_commande,date_arriv,etat, montant_reduction, pourcentage_reduction;

SELECT num_commande,c.num_compte,date_commande,date_arriv,sum(prix_ttc*qte_panier) prix_ttc,sum(prix_ht*qte_panier) prix_ht, retourneEtatLivraison(num_commande) etat, montant_reduction, pourcentage_reduction FROM _commande c LEFT JOIN _code_reduction ON c.id_reduction = _code_reduction.id_reduction NATURAL JOIN _refere_commande INNER JOIN _produit ON _refere_commande.id_prod = _produit.id_prod group by num_commande, c.num_compte,date_commande,date_arriv,etat, montant_reduction, pourcentage_reduction;

CREATE OR REPLACE VIEW commande_list_produits_client AS
    WITH min_image AS (SELECT min(num_image) num_image, id_prod FROM _image_prod  group by id_prod )
    SELECT num_commande,p.id_prod, intitule_prod, lien_image lienImage,description_prod,c.num_compte,date_commande,date_arriv,round(prix_fixeettc::numeric,2) prix_ttc,round((prix_fixeettc/(1+_tva.taux_tva))::numeric,2) prix_ht,qte_panier qte, retourneEtatLivraison(num_commande), montant_reduction, pourcentage_reduction FROM _commande c LEFT JOIN _code_reduction ON c.id_reduction = _code_reduction.id_reduction  NATURAL JOIN _image_prod NATURAL JOIN _refere_commande INNER JOIN _produit p ON _refere_commande.id_prod = p.id_prod   natural join sae3._sous_categorie inner join sae3._categorie on _categorie.code_cat=_sous_categorie.code_cat natural join sae3._tva --,, etat
    WHERE num_image IN (SELECT num_image FROM min_image);

CREATE OR REPLACE VIEW insert_commande AS
    SELECT num_commande,num_compte,id_a,id_reduction FROM _commande NATURAL JOIN _panier_client;




--PRODUIT & CATEGORIE
/*CREATE OR REPLACE VIEW produit_catalogue AS
    SELECT id_prod  id, intitule_prod intitule, prix_ht+(prix_ht*_tva.taux_tva) prixTTC,lien_image lienImage,publication_prod, description_prod, _sous_categorie.libelle_cat categorie, moyenneNote
    FROM _produit NATURAL JOIN _image_prod  NATURAL JOIN _sous_categorie INNER JOIN _categorie on _sous_categorie.code_cat = _categorie.code_cat NATURAL JOIN _tva
    LEFT JOIN moyenneProduit on _produit.id_prod = moyenneProduit.id NATURAL JOIN soloimageproduit;
*/
CREATE OR REPLACE VIEW produit_catalogue AS
    SELECT id_prod  id, intitule_prod intitule, prix_ht+(prix_ht*_tva.taux_tva) prixTTC,lien_image lienImage,publication_prod, description_prod, _sous_categorie.libelle_cat categorie, moyenneNote
    FROM _produit NATURAL JOIN _image_prod  NATURAL JOIN _sous_categorie INNER JOIN _categorie on _sous_categorie.code_cat = _categorie.code_cat NATURAL JOIN _tva
    LEFT JOIN moyenneProduit on _produit.id_prod = moyenneProduit.id NATURAL JOIN soloimageproduit;

CREATE OR REPLACE VIEW produit_detail AS
    SELECT id_prod  id, intitule_prod intitule, prix_ht+(prix_ht*taux_tva) prixTTC, prix_ht prixHT, lien_image lienImage,publication_prod  isAffiche, _sous_categorie.libelle_cat categorie, _sous_categorie.code_sous_cat codeCategorie,description_prod description, stock_prod stock,moyenneNote moyenne
    FROM _produit NATURAL JOIN _image_prod  NATURAL JOIN _sous_categorie INNER JOIN _categorie on _sous_categorie.code_cat = _categorie.code_cat NATURAL JOIN _tva
    LEFT JOIN moyenneProduit on _produit.id_prod = moyenneProduit.id NATURAL JOIN soloimageproduit;

CREATE OR REPLACE VIEW categorie AS
    SELECT code_cat,libelle_cat libelle FROM _categorie;

CREATE OR REPLACE VIEW sous_categorie AS
    SELECT code_cat code_sur_cat ,libelle_cat libelle FROM _sous_categorie;



--PANIER
CREATE OR REPLACE VIEW produit_panier_compte AS
    SELECT concat(id_prod,'£',num_panier) id,id_prod, intitule_prod intitule,stock_prod stock, prix_ht+(prix_ht*taux_tva) prixTTC,prix_ht, lien_image lienImage, description_prod description, qte_panier quantite,num_compte num_client,num_panier current_panier
    FROM produit_global NATURAL JOIN _refere NATURAL JOIN _panier_client  NATURAL JOIN _sous_categorie INNER JOIN _categorie on _sous_categorie.code_cat = _categorie.code_cat NATURAL JOIN _tva
    NATURAL JOIN soloimageproduit
    where num_panier IN (SELECT max(num_panier) FROM _panier_client group by num_compte)
    ORDER BY id;

CREATE OR REPLACE VIEW produit_panier_visiteur AS
    SELECT concat(id_prod,'£',num_panier) id,id_prod, intitule_prod intitule,stock_prod stock, prix_ht+(prix_ht*taux_tva) prixTTC,prix_ht, lien_image lienImage, description_prod description, qte_panier quantite,token_cookie,num_panier current_panier FROM produit_global NATURAL JOIN _image_prod NATURAL JOIN _refere NATURAL JOIN _panier_visiteur  NATURAL JOIN _sous_categorie INNER JOIN _categorie on _sous_categorie.code_cat = _categorie.code_cat NATURAL JOIN _tva
    NATURAL JOIN soloimageproduit
    ORDER BY id;


CREATE OR REPLACE VIEW produitCSV AS
    SELECT * from _produit;


--MODÉRATION & COMMENTAIRES
CREATE OR REPLACE VIEW commentaires AS
    WITH moyenne AS (SELECT id_prod id,avg(note_prod) as moyenneNote FROM _produit natural join _note  group by id_prod)
    SELECT num_avis, contenu_av, date_av, n.id_note, id_prod, numero num_compte, note_prod,c.pseudo, moyenneNote moyenne FROM _avis a  natural join _note n natural join compte_client c left join moyenne on n.id_prod = moyenne.id;

CREATE OR REPLACE VIEW sanction_temporaire AS
    SELECT id_sanction, raison, num_compte, date_debut, heure_debut, date_fin, heure_fin FROM _sanction_temporaire NATURAL JOIN _duree;

--REDUCTION
CREATE OR REPLACE VIEW code_reduction AS
    SELECT id_reduction, code_reduction, montant_reduction, pourcentage_reduction, date_debut, heure_debut, date_fin, heure_fin FROM _code_reduction NATURAL JOIN _duree;

CREATE OR REPLACE VIEW reduc_panier AS SELECT * FROM _reduire;

CREATE OR REPLACE VIEW signalement AS SELECT * FROM _signalement;


--VENDEUR
CREATE OR REPLACE VIEW vendeur AS
SELECT num_compte numero, email, pseudo identifiant, mot_de_passe motDePasse, numero_siret, tva_intercommunautaire, texte_presentation, note_vendeur, logo, numero_rue, nom_rue, code_postal, ville, comp_a1, comp_a2, id_adresse
FROM compte_vendeur INNER JOIN _adresse ON _adresse.id_a = compte_vendeur.id_adresse;

--GLOSSAIRE (ADMIN & VENDEUR)
CREATE OR REPLACE VIEW glossaire_admin AS
SELECT id_quidi,
num_compte,
intitule_prod, 
prix_ht, 
prix_ttc, 
description_prod,logo, 
note_vendeur, 
pseudo, 
numero_siret, 
TVA_intercommunautaire, 
Texte_presentation,
moyenne_note_prod, 
email, 
numero_rue,
nom_rue, 
code_postal, 
lien_image,
num_image,
ville  FROM _quidi NATURAL JOIN _produit NATURAL JOIN _vendeur NATURAL JOIN _compte LEFT JOIN _adresse ON _vendeur.id_adresse = _adresse.id_a LEFT JOIN _image_prod ON _produit.id_prod = _image_prod.id_prod  ;

CREATE OR REPLACE VIEW catalogueur_vendeur AS 
SELECT numero_rue,nom_rue,code_postal,ville,intitule_prod, prix_ht, prix_ttc, description_prod,pseudo,note_vendeur,numero_siret,tva_intercommunautaire,texte_presentation,logo,moyenne_note_prod FROM _quidi NATURAL JOIN _produit NATURAL JOIN _vendeur NATURAL JOIN _compte INNER JOIN _adresse  ON _vendeur.id_adresse = _adresse.id_a;

CREATE OR REPLACE VIEW produit_catalogue_vendeur AS
SELECT num_compte, id_prod  id, intitule_prod intitule, prix_ht+(prix_ht*_tva.taux_tva) prixTTC,lien_image lienImage,publication_prod, description_prod, _sous_categorie.libelle_cat categorie, moyenneNote
FROM _vendeur NATURAL JOIN _produit NATURAL JOIN _image_prod  NATURAL JOIN _sous_categorie INNER JOIN _categorie on _sous_categorie.code_cat = _categorie.code_cat NATURAL JOIN _tva
LEFT JOIN moyenneProduit on _produit.id_prod = moyenneProduit.id NATURAL JOIN soloimageproduit;

CREATE OR REPLACE VIEW glossaire_vendeur AS 
SELECT id_quidi,num_compte,numero_rue,nom_rue,code_postal,ville,intitule_prod, prix_ht, prix_ttc, description_prod,pseudo,note_vendeur,numero_siret,tva_intercommunautaire,texte_presentation,logo,moyenne_note_prod FROM _quidi NATURAL JOIN _produit NATURAL JOIN _vendeur NATURAL JOIN _compte INNER JOIN _adresse  ON _vendeur.id_adresse = _adresse.id_a;
