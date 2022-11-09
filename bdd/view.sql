SET SCHEMA 'sae3';





CREATE OR REPLACE VIEW produit_catalogue AS
    WITH moyenne AS (SELECT id_prod id,avg(note_prod) as moyenneNote FROM _produit natural join _note  group by id_prod)
    SELECT id_prod  id, intitule_prod intitule, prix_ttc prixTTC,lien_image_prod lienImage,publication_prod  isAffiche, libelle_cat categorie, moyenneNote  FROM _produit NATURAL JOIN _sous_categorie LEFT JOIN moyenne on _produit.id_prod = moyenne.id;

CREATE OR REPLACE VIEW client AS
    SELECT num_compte numero, nom_compte nom, prenom_compte prenom, email, pseudo identifiant, mot_de_passe motDePasse FROM _compte;


CREATE OR REPLACE VIEW produit_detail AS
    WITH moyenne AS (SELECT id_prod id,avg(note_prod) as moyenneNote FROM _produit natural join _note  group by id_prod)
    SELECT id_prod  id, intitule_prod intitule, prix_ttc prixTTC,lien_image_prod lienImage,publication_prod  isAffiche, libelle_cat categorie, code_sous_cat codeCategorie,description_prod description, stock_prod stock FROM _produit NATURAL JOIN _sous_categorie c LEFT JOIN moyenne on _produit.id_prod = moyenne.id;

CREATE OR REPLACE VIEW categorie AS
    SELECT code_cat,libelle_cat libelle,cat_tva FROM _categorie;

CREATE OR REPLACE VIEW sous_categorie AS
    SELECT code_sous_cat code_cat, libelle_cat libelle, code_cat code_sur_cat FROM _sous_categorie;


SELECT * From sous_categorie inner join categorie c on sous_categorie.code_sur_cat = c.code_cat;