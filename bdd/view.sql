SET SCHEMA 'sae3';





CREATE OR REPLACE VIEW produit_catalogue AS
    WITH moyenne AS (SELECT id_prod,avg(note_prod) as moyenneNote FROM _produit natural join _note  group by id_prod)
    SELECT id_prod  id, intitule_prod intitule, prix_ttc prixTTC,lien_image_prod lienImage,publication_prod  isAffiche, libelle_cat categorie, code_cat codeCategorie FROM _produit NATURAL JOIN moyenne NATURAL JOIN _categorie c;

CREATE OR REPLACE VIEW client AS
    SELECT num_compte numero, nom_compte nom, prenom_compte prenom, email, pseudo identifiant, mot_de_passe motDePasse FROM _compte;


CREATE OR REPLACE VIEW produit_detail AS
    WITH moyenne AS (SELECT id_prod,avg(note_prod) as moyenneNote FROM _produit natural join _note  group by id_prod)
    SELECT id_prod  id, intitule_prod intitule, prix_ttc prixTTC,lien_image_prod lienImage,publication_prod  isAffiche, libelle_cat categorie, code_cat codeCategorie,description_prod description, stock_prod stock FROM _produit NATURAL JOIN moyenne NATURAL JOIN _categorie c;
