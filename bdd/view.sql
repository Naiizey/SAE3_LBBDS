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
    SELECT num_compte, nom_a, prenom_a, numero_rue, nom_rue, code_postal, ville FROM _adresse_facturation;

CREATE OR REPLACE VIEW adresse_livraison AS
    SELECT num_compte, nom_a, prenom_a, numero_rue, nom_rue, code_postal, ville FROM _adresse_livraison;