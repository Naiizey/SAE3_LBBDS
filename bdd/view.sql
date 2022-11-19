SET SCHEMA 'sae3';






CREATE OR REPLACE VIEW produit_catalogue AS
    WITH moyenne AS (SELECT id_prod id,avg(note_prod) as moyenneNote FROM _produit natural join _note  group by id_prod)
    SELECT id_prod  id, intitule_prod intitule, prix_ttc prixTTC,lien_image_prod lienImage,publication_prod  isAffiche, libelle_cat categorie, moyenneNote  FROM _produit NATURAL JOIN _sous_categorie LEFT JOIN moyenne on _produit.id_prod = moyenne.id;

CREATE OR REPLACE VIEW client AS
    SELECT num_compte numero, nom_compte nom, prenom_compte prenom, email, pseudo identifiant, mot_de_passe motDePasse FROM _compte;


CREATE OR REPLACE VIEW produit_detail AS
    WITH moyenne AS (SELECT id_prod id,avg(note_prod) as moyenneNote FROM _produit natural join _note  group by id_prod)
    SELECT id_prod  id, intitule_prod intitule, prix_ttc prixTTC, prix_ht prixHT, lien_image_prod lienImage,publication_prod  isAffiche, libelle_cat categorie, code_cat codeCategorie,description_prod description, stock_prod stock FROM _produit LEFT JOIN moyenne on _produit.id_prod = moyenne.id NATURAL JOIN _categorie c;


CREATE OR REPLACE VIEW produit_panier_compte AS
    SELECT concat(id_prod,'£',num_panier) id,id_prod, intitule_prod intitule,stock_prod stock, prix_ttc prixTTC,prix_ht, lien_image_prod lienImage, description_prod description, qte_panier quantite,num_compte num_client,num_panier current_panier
    FROM _produit NATURAL JOIN _refere NATURAL JOIN _panier_client
    ORDER BY id;

CREATE OR REPLACE VIEW produit_panier_visiteur AS
    SELECT concat(id_prod,'£',num_panier) id,id_prod, intitule_prod intitule,stock_prod stock, prix_ttc prixTTC,prix_ht, lien_image_prod lienImage, description_prod description, qte_panier quantite,token_cookie,num_panier current_panier FROM _produit NATURAL JOIN _refere NATURAL JOIN _panier_visiteur
    ORDER BY id;

CREATE OR REPLACE VIEW categorie AS
    SELECT code_cat,libelle_cat libelle FROM _categorie;

CREATE OR REPLACE VIEW sous_categorie AS
    SELECT code_cat code_sur_cat ,libelle_cat libelle FROM _sous_categorie;

CREATE OR REPLACE VIEW produitCSV AS
    SELECT * from _produit;

CREATE OR REPLACE VIEW client_mail AS
    SELECT num_compte, email from _compte;

CREATE OR REPLACE VIEW adresse_facturation AS
    SELECT num_compte, nom_a, prenom_a, numero_rue, nom_rue, code_postal, ville FROM _adresse_facturation NATURAL JOIN _adresse;

CREATE OR REPLACE VIEW adresse_livraison AS
    SELECT num_compte, nom_a, prenom_a, numero_rue, nom_rue, code_postal, ville FROM _adresse_livraison NATURAL JOIN _adresse;

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

CREATE OR REPLACE FUNCTION csvImport() RETURNS TRIGGER AS
$$
BEGIN
    INSERT INTO _produit SELECT * FROM old;
END
$$
language plpgsql;
--DROP TRIGGER csvImport ON produitCSV;
/* CREATE OR REPLACE TRIGGER csvImport INSTEAD OF INSERT ON produitcsv FOR EACH ROW EXECUTE PROCEDURE csvImport();*/

CREATE OR REPLACE FUNCTION deleteProduitPanier() RETURNS TRIGGER AS
    $$
    BEGIN
        DELETE FROM sae3._refere where id_prod=old.id_prod and num_panier=old.current_panier;
        RETURN OLD;

    end;
    $$ language plpgsql;
CREATE OR REPLACE TRIGGER insteadOfDelete_produit_panier INSTEAD OF DELETE ON produit_panier_compte FOR EACH ROW EXECUTE PROCEDURE deleteProduitPanier();
CREATE OR REPLACE TRIGGER insteadOfDelete_produit_panier INSTEAD OF DELETE ON produit_panier_visiteur FOR EACH ROW EXECUTE PROCEDURE deleteProduitPanier();


CREATE OR REPLACE FUNCTION insertProduitPanier() RETURNS TRIGGER AS
    $$
    DECLARE
        current_panier int;
    BEGIN
        select max(num_panier) into current_panier from sae3._panier_client where num_compte=new.num_client group by num_compte;
        Insert into sae3._refere (id_prod, num_panier, qte_panier) VALUES (new.id_prod,current_panier,new.quantite);

        RETURN OLD;

    end;
    $$ language plpgsql;
CREATE OR REPLACE TRIGGER insteadOfInsert_produit_panier INSTEAD OF INSERT ON produit_panier_compte FOR EACH ROW EXECUTE PROCEDURE insertProduitPanier ();

CREATE OR REPLACE FUNCTION insertProduitPanierVisiteur() RETURNS TRIGGER AS
    $$
    DECLARE
        current_panier int;
    BEGIN
        select num_panier into current_panier from sae3._panier_visiteur where token_cookie=new.token_cookie;
        Insert into sae3._refere (id_prod, num_panier, qte_panier) VALUES (new.id_prod,current_panier,new.quantite);

        RETURN OLD;

    end;
    $$ language plpgsql;
CREATE OR REPLACE TRIGGER insteadOfInsert_produit_visiteur INSTEAD OF INSERT ON produit_panier_visiteur FOR EACH ROW EXECUTE PROCEDURE insertProduitPanierVisiteur ();

CREATE OR REPLACE FUNCTION updateProduitPanier() RETURNS TRIGGER AS
    $$
    DECLARE
        current_panier int;
    BEGIN
        select max(num_panier) into current_panier from sae3._panier_client where num_compte=new.num_client group by num_compte;
        update sae3._refere SET  qte_panier=new.quantite where id_prod=new.id_prod and num_panier=current_panier;

        RETURN new;

    end;
    $$ language plpgsql;
CREATE OR REPLACE TRIGGER updateOfInsert_produit_panier INSTEAD OF UPDATE ON produit_panier_compte FOR EACH ROW EXECUTE PROCEDURE updateProduitPanier ();

CREATE OR REPLACE FUNCTION updateProduitPanierVisiteur() RETURNS TRIGGER AS
    $$
    DECLARE
        current_panier int;
    BEGIN
        select num_panier into current_panier from sae3._panier_visiteur where token_cookie=new.token_cookie;
        update sae3._refere SET  qte_panier=new.quantite where id_prod=new.id_prod and num_panier=current_panier;

        RETURN new;

    end;
    $$ language plpgsql;
CREATE OR REPLACE TRIGGER updateOfInsert_produit_panier_visiteur INSTEAD OF UPDATE ON produit_panier_visiteur FOR EACH ROW EXECUTE PROCEDURE updateProduitPanierVisiteur ();
/*
CREATE OR REPLACE FUNCTION transvasagePanier(entree_num_panier int, entree_num_compte int) RETURNS INT AS
    $$
     DECLARE
        current_panier int;
         row _refere%ROWTYPE;
    BEGIN
        PERFORM num_panier FROM sae3._panier_visiteur natural join _refere where num_panier=entree_num_panier;
        if found then

            select max(num_panier) into current_panier from sae3._panier_client where num_compte=entree_num_compte group by num_compte;
            for row in (SELECT * FROM sae3._refere natural join sae3._panier_visiteur where num_panier=entree_num_panier) loop
                INSERT INTO _refere VALUES (row.id_prod,current_panier,row.qte_panier);
                delete from _refere where num_panier=row.num_panier and id_prod=row.id_prod;
            end loop;


        else
            raise notice 'il n''y  pas de produits dans ce panier';
            RETURN 1;
        end if;
        RETURN 0;

    END;
    $$ language plpgsql;
*/
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
    SELECT num_commande,retourneEtatLivraison(num_commande),num_compte,intitule_prod,date_commande,date_arriv, prix_ht, prix_ttc, qte_panier FROM _commande NATURAL JOIN _panier NATURAL JOIN _refere NATURAL JOIN _produit NATURAL JOIN _panier_client;
    
SELECT * FROM commande_list_vendeur;

SELECT retourneEtatLivraison('1');