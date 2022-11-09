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
        DELETE FROM sae3._refere where id_prod=old.id and num_panier=old.current_panier;
        RETURN OLD;

    end;
    $$ language plpgsql;
CREATE OR REPLACE TRIGGER insteadOfDelete_produit_panier INSTEAD OF DELETE ON produit_panier_compte FOR EACH ROW EXECUTE PROCEDURE deleteProduitPanier();

CREATE OR REPLACE FUNCTION insertProduitPanier() RETURNS TRIGGER AS
    $$
    DECLARE
        current_panier int;
    BEGIN
        select max(num_panier) into current_panier from sae3._panier_client where num_compte=new.num_client group by num_compte;
        Insert into sae3._refere (id_prod, num_panier, qte_panier) VALUES (new.id,current_panier,new.quantite);

        RETURN OLD;

    end;
    $$ language plpgsql;
CREATE OR REPLACE TRIGGER insteadOfInsert_produit_panier INSTEAD OF INSERT ON produit_panier_compte FOR EACH ROW EXECUTE PROCEDURE insertProduitPanier ();

