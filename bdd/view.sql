-- Active: 1655031515408@@127.0.0.1@5432@postgres
SET SCHEMA 'sae3';






CREATE OR REPLACE VIEW produit_catalogue AS
    WITH moyenne AS (SELECT id_prod id,avg(note_prod) as moyenneNote FROM _produit natural join _note  group by id_prod)
    SELECT id_prod  id, intitule_prod intitule, prix_ht+(prix_ht*_tva.taux_tva) prixTTC,lien_image_prod lienImage,publication_prod, description_prod, _sous_categorie.libelle_cat categorie, moyenneNote  FROM _produit NATURAL JOIN _sous_categorie INNER JOIN _categorie on _sous_categorie.code_cat = _categorie.code_cat NATURAL JOIN _tva LEFT JOIN moyenne on _produit.id_prod = moyenne.id;

CREATE OR REPLACE VIEW client AS
    WITH trouve_current_panier AS (select max(num_panier) current_panier,num_compte from sae3._panier_client group by num_compte)
    SELECT num_compte numero, nom_compte nom, prenom_compte prenom, email, pseudo identifiant, mot_de_passe motDePasse, current_panier FROM _compte NATURAL JOIN trouve_current_panier;


CREATE OR REPLACE VIEW produit_detail AS
    WITH moyenne AS (SELECT id_prod id,avg(note_prod) as moyenneNote FROM _produit natural join _note  group by id_prod)
    SELECT id_prod  id, intitule_prod intitule, prix_ht+(prix_ht*taux_tva) prixTTC, prix_ht prixHT, lien_image_prod lienImage,publication_prod  isAffiche, _sous_categorie.libelle_cat categorie, _sous_categorie.code_sous_cat codeCategorie,description_prod description, stock_prod stock FROM _produit LEFT JOIN moyenne on _produit.id_prod = moyenne.id  NATURAL JOIN _sous_categorie INNER JOIN _categorie on _sous_categorie.code_cat = _categorie.code_cat NATURAL JOIN _tva;


CREATE OR REPLACE VIEW produit_panier_compte AS
    SELECT concat(id_prod,'£',num_panier) id,id_prod, intitule_prod intitule,stock_prod stock, prix_ht+(prix_ht*taux_tva) prixTTC,prix_ht, lien_image_prod lienImage, description_prod description, qte_panier quantite,num_compte num_client,num_panier current_panier
    FROM _produit NATURAL JOIN _refere NATURAL JOIN _panier_client  NATURAL JOIN _sous_categorie INNER JOIN _categorie on _sous_categorie.code_cat = _categorie.code_cat NATURAL JOIN _tva where num_panier IN (SELECT max(num_panier) FROM _panier_client group by num_compte) 
    ORDER BY id;

CREATE OR REPLACE VIEW produit_panier_visiteur AS
    SELECT concat(id_prod,'£',num_panier) id,id_prod, intitule_prod intitule,stock_prod stock, prix_ht+(prix_ht*taux_tva) prixTTC,prix_ht, lien_image_prod lienImage, description_prod description, qte_panier quantite,token_cookie,num_panier current_panier FROM _produit NATURAL JOIN _refere NATURAL JOIN _panier_visiteur  NATURAL JOIN _sous_categorie INNER JOIN _categorie on _sous_categorie.code_cat = _categorie.code_cat NATURAL JOIN _tva
    ORDER BY id;

CREATE OR REPLACE VIEW categorie AS
    SELECT code_cat,libelle_cat libelle FROM _categorie;

CREATE OR REPLACE VIEW sous_categorie AS
    SELECT code_cat code_sur_cat ,libelle_cat libelle FROM _sous_categorie;

CREATE OR REPLACE VIEW produitCSV AS
    SELECT * from _produit;

CREATE OR REPLACE VIEW client_mail AS
    SELECT num_compte, email from _compte;

CREATE OR REPLACE VIEW adresse_facturation_client AS
    SELECT num_compte, nom_a, prenom_a, numero_rue, nom_rue, code_postal, ville FROM _adresse_facturation NATURAL JOIN _adresse NATURAL JOIN _recevoir_facture;

CREATE OR REPLACE VIEW adresse_livraison_client AS
    SELECT num_compte, nom_a, prenom_a, numero_rue, nom_rue, code_postal, ville FROM _adresse_livraison NATURAL JOIN _adresse NATURAL JOIN _recevoir_commande;

CREATE OR REPLACE FUNCTION retourneEtatLivraison(entree_num_panier int) RETURNS INT AS
    $$
    DECLARE
        row sae3._commande%ROWTYPE;
    BEGIN
        SELECT date_expedition, date_plateformeReg, date_plateformeLoc, date_arriv  INTO row FROM sae3._commande where num_panier=entree_num_panier;

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

SET SCHEMA 'sae3';


CREATE OR REPLACE FUNCTION retourneEtatLivraison(entree_num_panier varchar) RETURNS INT AS
    $$
    DECLARE
        row sae3._commande%ROWTYPE;
    BEGIN

        SELECT *  INTO row FROM sae3._commande where num_commande=entree_num_panier;

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


--SELECT * FROM _commande NATURAL JOIN _panier NATURAL JOIN _refere NATURAL JOIN _produit;
CREATE OR REPLACE VIEW commande_list_vendeur AS
    SELECT num_commande,num_compte,date_commande,date_arriv, sum(prix_ht*qte_panier) ht, sum(prix_ttc*qte_panier) ttc, retourneEtatLivraison(num_commande) etat FROM _commande NATURAL JOIN _panier NATURAL JOIN _refere NATURAL JOIN _produit NATURAL JOIN _panier_client group by num_commande, num_compte,date_commande,date_arriv,etat;
    
SELECT * FROM commande_list_vendeur;

CREATE OR REPLACE VIEW commande_list_client AS
    SELECT num_commande,num_compte,date_commande,date_arriv,sum(prix_ttc*qte_panier) prix_ttc,sum(prix_ht*qte_panier) prix_ht, retourneEtatLivraison(num_commande) etat FROM _commande NATURAL JOIN _panier NATURAL JOIN _refere NATURAL JOIN _produit NATURAL JOIN _panier_client group by num_commande, num_compte,date_commande,date_arriv,etat;
SELECT * FROM commande_list_client;

CREATE OR REPLACE VIEW commande_list_produits_client AS
    SELECT num_commande,id_prod, intitule_prod, lien_image_prod,description_prod,num_compte,date_commande,date_arriv,(prix_ttc*qte_panier) prix_ttc,(prix_ttc*qte_panier) prix_ht,qte_panier qte, retourneEtatLivraison(num_commande) etat FROM _commande NATURAL JOIN _panier NATURAL JOIN _refere NATURAL JOIN _produit NATURAL JOIN _panier_client;

CREATE OR REPLACE VIEW insert_commande AS
    SELECT num_commande,num_compte,id_a FROM _commande NATURAL JOIN _panier_client;

CREATE OR REPLACE VIEW adresse_facturation AS
    SELECT * FROM _adresse NATURAL JOIN _adresse_facturation;

CREATE OR REPLACE VIEW adresse_livraison AS
    SELECT _adresse.id_a, nom_a nom, prenom_a prenom, numero_rue, nom_rue, code_postal, ville, comp_a1, comp_a2, infos_comp, num_commande FROM _adresse NATURAL JOIN _adresse_livraison LEFT JOIN _commande c on _adresse.id_a = c.id_a ;


CREATE OR REPLACE VIEW code_reduction AS
    SELECT * FROM _code_reduction;

CREATE OR REPLACE VIEW reduc_panier AS SELECT * FROM _reduire;