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
CREATE OR REPLACE TRIGGER insteadOfDelete_produit_panier INSTEAD OF DELETE ON produit_panier FOR EACH ROW EXECUTE PROCEDURE deleteProduitPanier();
