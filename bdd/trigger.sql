SET SCHEMA 'sae3';

CREATE OR REPLACE FUNCTION csvImport() RETURNS TRIGGER AS
$$
BEGIN
    INSERT INTO _produit SELECT * FROM old;
END
$$
language plpgsql;
--DROP TRIGGER csvImport ON produitCSV;
/* CREATE tRIGGER csvImport INSTEAD OF INSERT ON produitcsv FOR EACH ROW EXECUTE PROCEDURE csvImport();*/

CREATE OR REPLACE FUNCTION deleteProduitPanier() RETURNS TRIGGER AS
    $$
    BEGIN
        DELETE FROM sae3._refere where id_prod=old.id_prod and num_panier=old.current_panier;
        RETURN OLD;

    end;
    $$ language plpgsql;
CREATE tRIGGER insteadOfDelete_produit_panier INSTEAD OF DELETE ON produit_panier_compte FOR EACH ROW EXECUTE PROCEDURE deleteProduitPanier();
CREATE tRIGGER insteadOfDelete_produit_panier INSTEAD OF DELETE ON produit_panier_visiteur FOR EACH ROW EXECUTE PROCEDURE deleteProduitPanier();


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
CREATE tRIGGER insteadOfInsert_produit_panier INSTEAD OF INSERT ON produit_panier_compte FOR EACH ROW EXECUTE PROCEDURE insertProduitPanier ();

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
CREATE tRIGGER insteadOfInsert_produit_visiteur INSTEAD OF INSERT ON produit_panier_visiteur FOR EACH ROW EXECUTE PROCEDURE insertProduitPanierVisiteur ();

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
CREATE tRIGGER updateOfInsert_produit_panier INSTEAD OF UPDATE ON produit_panier_compte FOR EACH ROW EXECUTE PROCEDURE updateProduitPanier ();

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
CREATE tRIGGER updateOfInsert_produit_panier_visiteur INSTEAD OF UPDATE ON produit_panier_visiteur FOR EACH ROW EXECUTE PROCEDURE updateProduitPanierVisiteur ();
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

CREATE OR REPLACE FUNCTION insertAdresseLivraison() RETURNS TRIGGER AS
    $$
    BEGIN
        INSERT INTO sae3._adresse(nom_a,prenom_a, numero_rue, nom_rue, code_postal, ville, comp_a1, comp_a2) VALUES (new.nom,new.prenom,new.numero_rue,new.nom_rue,new.code_postal,new.ville,new.comp_a1,new.comp_a2);
        INSERT INTO sae3._adresse_livraison(infos_comp, id_a) VALUES (new.infos_comp,currval('sae3._adresse_id_a_seq'));

        return new;
    end
$$ language plpgsql;
CREATE TRIGGER insteadOfInsert_adresse_livraison INSTEAD OF INSERT ON adresse_livraison FOR EACH ROW EXECUTE PROCEDURE insertadresselivraison();

CREATE OR REPLACE FUNCTION insertAdresseFacture() RETURNS TRIGGER AS
    $$
    BEGIN
        INSERT INTO sae3._adresse(nom_a,prenom_a, numero_rue, nom_rue, code_postal, ville, comp_a1, comp_a2) VALUES (new.nom_a,new.prenom_a,new.numero_rue,new.nom_rue,new.code_postal,new.ville,new.comp_a1,new.comp_a2);
        INSERT INTO sae3._adresse_livraison(id_a) VALUES (currval('sae3._adresse_id_a_seq'));

        return new;
    end
$$ language plpgsql;
CREATE TRIGGER insteadOfInsert_adresse_facture INSTEAD OF INSERT ON adresse_facturation FOR EACH ROW EXECUTE PROCEDURE insertAdresseFacture();


CREATE OR REPLACE FUNCTION insertInsertCommande() RETURNS TRIGGER AS
    $$
    DECLARE
        current_panier integer;
    BEGIN
        select max(num_panier) into current_panier from sae3._panier_client where num_compte=new.num_compte group by num_compte;
        INSERT INTO sae3._commande(num_panier, num_commande, date_commande, id_a) VALUES (current_panier,new.num_commande, current_date,new.id_a);
        RETURN NEW;
    end
$$ language plpgsql;
CREATE TRIGGER insteadOfInsert_insertCommande INSTEAD OF INSERT ON insert_commande FOR EACH ROW EXECUTE PROCEDURE insertInsertCommande();

-- vérification que num panier n'as pas déja un code de réduction dans la table _reduire
-- CREATE OR REPLACE FUNCTION verif_reduc_panier() RETURNS TRIGGER AS
--     $$
--     BEGIN
--         IF EXISTS (SELECT * FROM _reduire WHERE num_panier=NEW.num_panier) THEN
--             RAISE EXCEPTION 'Le panier % a déja un code de réduction', NEW.num_panier;
--         ELSE
--             INSERT INTO _reduire VALUES (NEW.num_panier, NEW.id_reduction);
--         END IF;
--         RETURN NEW;
--     END;
--     $$ language plpgsql;
    
-- CREATE TRIGGER verif_reduc_panier INSTEAD OF INSERT ON sae3.reduc_panier FOR EACH ROW EXECUTE PROCEDURE verif_reduc_panier();