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

