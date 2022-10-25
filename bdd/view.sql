SET SCHEMA 'sae3';



CREATE OR REPLACE VIEW produit_catalogue AS
    WITH moyenne AS (SELECT id_prod,avg(note_prod) as moyenneNote FROM _produit natural join _note  group by id_prod)
    SELECT id_prod  id, intitule_prod intitule, prix_ttc prixTTC,lien_image_prod lienImage,publication_prod  isAffiche FROM _produit NATURAL JOIN moyenne;

