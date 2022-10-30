-- SQLBook: Code
DROP SCHEMA IF EXISTS sae3 CASCADE;
CREATE SCHEMA sae3; 
SET SCHEMA 'sae3';

DROP TABLE IF EXISTS _tva CASCADE;
DROP TABLE IF EXISTS _categorie CASCADE;
DROP TABLE IF EXISTS _note CASCADE;
DROP TABLE IF EXISTS _compte CASCADE;
DROP TABLE IF EXISTS _adresse CASCADE;
DROP TABLE IF EXISTS _commande CASCADE;
DROP TABLE IF EXISTS _panier CASCADE;
DROP TABLE IF EXISTS _panier_visiteur CASCADE;
DROP TABLE IF EXISTS _refere CASCADE;
DROP TABLE IF EXISTS _produit CASCADE;
DROP TABLE IF EXISTS _liste_souhait CASCADE;
DROP TABLE IF EXISTS _pouce CASCADE;
DROP TABLE IF EXISTS _enregistre CASCADE;
DROP TABLE IF EXISTS _sous_categorie CASCADE;
DROP TABLE IF EXISTS _avis CASCADE;
DROP TABLE IF EXISTS _image_avis CASCADE;

/* -----------------------------------------------------------
-                                                            -
-                                                            -
--------------------------------------------------------------*/

CREATE TABLE _tva
(
    cat_tva INT PRIMARY KEY
);

CREATE TABLE _categorie
(
    code_cat INT PRIMARY KEY,
    libelle_cat VARCHAR(50) NOT NULL
);

CREATE TABLE _sous_categorie(
    code_cat INT,
    code_sous_cat INT,
    CONSTRAINT _sous_categorie_pk PRIMARY KEY (code_cat, code_sous_cat)
);

CREATE TABLE _note
(
    note_prod FLOAT NOT NULL
);

CREATE TABLE _compte
(
    num_compte SERIAL PRIMARY KEY,
    nom_compte VARCHAR(50) NOT NULL,
    prenom_compte VARCHAR(50) NOT NULL,
    pseudo VARCHAR(30) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    mot_de_passe VARCHAR(30) NOT NULL
);

CREATE TABLE _adresse
(
    id_a SERIAL PRIMARY KEY,
    nom_a VARCHAR(50) NOT NULL,
    prenom_a VARCHAR(50) NOT NULL,
    num_rue INT NOT NULL,
    nom_rue VARCHAR(50) NOT NULL,
    code_postal INT NOT NULL,
    ville VARCHAR(50) NOT NULL,
    comp_a1 VARCHAR(150) NULL,
    comp_a2 VARCHAR(150) NULL
);

CREATE TABLE _adresse_livraison(
    infos_comp VARCHAR NOT NULL,
    CONSTRAINT _adresse_livraison_pk PRIMARY KEY (id_a)
)INHERITS (_adresse);

CREATE TABLE _adresse_facturation(
    CONSTRAINT _adresse_facturation_pk PRIMARY KEY (id_a)
)INHERITS (_adresse);

CREATE TABLE _panier
(
    num_panier SERIAL
);

CREATE TABLE _panier_visiteur 
(
    date_suppression DATE NOT NULL
)INHERITS (_panier);

CREATE TABLE _commande
(
    num_commande VARCHAR(50),
    date_dep DATE NOT NULL,
    date_arriv DATE NOT NULL,
    etat_livraison INT NOT NULL
)INHERITS (_panier);


CREATE TABLE _refere 
(
    qte_panier INT NOT NULL
);

CREATE TABLE _produit
(
    id_prod SERIAL PRIMARY KEY,
    intitule_prod VARCHAR(50) UNIQUE NOT NULL,
    prix_ht FLOAT NOT NULL,
    prix_ttc FLOAT NOT NULL,
    description_prod VARCHAR UNIQUE NOT NULL,
    lien_image_prod VARCHAR NOT NULL,
    publication_prod BOOLEAN NOT NULL,
    stock_prod INT NOT NULL,
    moyenne_note_prod FLOAT NOT NULL,
    seuil_alerte_prod INT,
    alerte_prod BOOLEAN NOT NULL
);

CREATE TABLE _liste_souhait
(
    etat_stock BOOLEAN NOT NULL
);

CREATE TABLE _pouce
(
    pouce_fav BOOLEAN NOT NULL
);

CREATE TABLE _avoirs
(
    num_avoirs SERIAL PRIMARY KEY,
    montant_valid FLOAT NOT NULL,
    duree_valid DATE NOT NULL
);

CREATE TABLE _retour(
    etiq_ret INT PRIMARY KEY,
    motif VARCHAR(50) NOT NULL,
    etat_remb BOOLEAN NOT NULL,
    conf_ret BOOLEAN NOT NULL
);

CREATE TABLE _avis(
    num_avis SERIAL,
    contenu_av VARCHAR NOT NULL
);

CREATE TABLE _image_avis(
    num_image SERIAL PRIMARY KEY,
    lien_image_avis VARCHAR NOT NULL
);

/* -----------------------------------------------------------
-                                                            -
-                                                            -
--------------------------------------------------------------*/

--Classe association entre _compte * - *_produit qui se nomme note ✅
ALTER TABLE _note ADD COLUMN id_prod INT NOT NULL;
ALTER TABLE _note ADD COLUMN num_compte INT NOT NULL;
ALTER TABLE _note ADD CONSTRAINT _note_produit_fk FOREIGN KEY (id_prod) REFERENCES _produit(id_prod);
ALTER TABLE _note ADD CONSTRAINT _note_client_fk FOREIGN KEY (num_compte) REFERENCES _compte(num_compte);
ALTER TABLE _note ADD CONSTRAINT _note_pk PRIMARY KEY (id_prod, num_compte);

--Classe association entre _compte * - *_produit qui se nomme _liste_souhait ✅
ALTER TABLE _liste_souhait ADD COLUMN id_prod INT NOT NULL;
ALTER TABLE _liste_souhait ADD COLUMN num_compte INT NOT NULL;
ALTER TABLE _liste_souhait ADD CONSTRAINT _liste_souhait_produit_fk FOREIGN KEY (id_prod) REFERENCES _produit(id_prod);
ALTER TABLE _liste_souhait ADD CONSTRAINT _liste_souhait_client_fk FOREIGN KEY (num_compte) REFERENCES _compte(num_compte);
ALTER TABLE _liste_souhait ADD CONSTRAINT _liste_souhait_pk PRIMARY KEY (id_prod, num_compte);

--Association 1..* entre _pdt et _categorie ✅ (contenu_dans)
ALTER TABLE _produit ADD COLUMN code_cat INT NOT NULL;
ALTER TABLE _produit ADD CONSTRAINT _produit_categorie_fk FOREIGN KEY (code_cat) REFERENCES _categorie(code_cat);

--Association 1..* entre _tva et _categorie ✅ (dans_cat_tva)
ALTER TABLE _categorie ADD COLUMN cat_tva INT NOT NULL;
ALTER TABLE _categorie ADD CONSTRAINT _categorie_tva_fk FOREIGN KEY (cat_tva) REFERENCES _tva(cat_tva);


/*--Association 1..* entre _panier et _compte (possede) ✅
ALTER TABLE _compte ADD COLUMN num_panier INT;
ALTER TABLE _compte ADD CONSTRAINT _compte_panier_fk FOREIGN KEY (num_panier) REFERENCES _panier(num_panier);
*/

--Association 0.1..1.0 entre _panier et _compte (utilise) ✅
ALTER TABLE _panier ADD COLUMN num_compte INT NOT NULL;
ALTER TABLE _panier ADD CONSTRAINT _panier_pk PRIMARY KEY (num_compte);
ALTER TABLE _panier ADD CONSTRAINT _panier_compte_fk FOREIGN KEY (num_compte) REFERENCES _compte(num_compte);

-- PRIMARY KEY _panier_visiteur
ALTER TABLE _panier_visiteur ADD CONSTRAINT _panier_visiteur_pk PRIMARY KEY (num_compte);

-- PRIMARY KEY _commande
ALTER TABLE _commande ADD CONSTRAINT _commande_pk PRIMARY KEY (num_compte);

--Association 1..* entre _adresse et _commande ✅ (attendu_a)
ALTER TABLE _commande ADD COLUMN id_a INT NOT NULL;
ALTER TABLE _commande ADD CONSTRAINT _commande_adresse_fk FOREIGN KEY (id_a) REFERENCES _adresse(id_a);

--Association 1..* entre _commande et _retour (rembourse) ✅
ALTER TABLE _retour ADD COLUMN num_compte INT NOT NULL;
ALTER TABLE _retour ADD CONSTRAINT _retour_commande_fk FOREIGN KEY (num_compte) REFERENCES _commande(num_compte);

--Association 1..* entre _compte et _avoirs () ✅
ALTER TABLE _avoirs ADD COLUMN num_compte INT NOT NULL;
ALTER TABLE _avoirs ADD CONSTRAINT _avoirs_compte_fk FOREIGN KEY (num_compte) REFERENCES _compte(num_compte);

--Classe association entre _panier * - * _produit qui se nomme _refere ✅
ALTER TABLE _refere ADD COLUMN id_prod INT NOT NULL;
ALTER TABLE _refere ADD COLUMN num_compte INT NOT NULL;
ALTER TABLE _refere ADD CONSTRAINT _refere_panier_fk FOREIGN KEY (num_compte) REFERENCES _panier(num_compte);
ALTER TABLE _refere ADD CONSTRAINT _refere_produit_fk FOREIGN KEY (id_prod) REFERENCES _produit(id_prod);
ALTER TABLE _refere ADD CONSTRAINT _refere_pk PRIMARY KEY (id_prod, num_compte);
--Association 1..* entre _compte et _adresse_facturation (possedeF) ✅
ALTER TABLE _adresse_facturation ADD COLUMN num_compte INT NOT NULL;
ALTER TABLE _adresse_facturation ADD CONSTRAINT _adresse_facturation_compte_fk FOREIGN KEY (num_compte) REFERENCES _compte(num_compte);
--Association 1..* entre _compte et _adresse_livraison ✅
ALTER TABLE _adresse_livraison ADD COLUMN num_compte INT NOT NULL;
ALTER TABLE _adresse_livraison ADD CONSTRAINT _adresse_facturation_compte_fk FOREIGN KEY (num_compte) REFERENCES _compte(num_compte);

--Association 1..* entre _produit et _avis (sur) ✅
ALTER TABLE _avis ADD COLUMN id_prod INT NOT NULL;
ALTER TABLE _avis ADD CONSTRAINT _avis_produit_fk FOREIGN KEY (id_prod) REFERENCES _produit(id_prod);

-- Association *..1 entre _compte et _avis (auteur) ✅
ALTER TABLE _avis ADD COLUMN num_compte INT NOT NULL;
-- ALTER TABLE _avis ADD CONSTRAINT _avis_pk PRIMARY KEY (id_prod,num_compte);
ALTER TABLE _avis ADD CONSTRAINT _avis_pk PRIMARY KEY (num_avis);
ALTER TABLE _avis ADD CONSTRAINT _avis_compte_fk FOREIGN KEY (num_compte) REFERENCES _compte(num_compte);

-- Association *..1 entre catégorie et catégorie ✅
ALTER TABLE _sous_categorie ADD CONSTRAINT _sous_categorie_categorie_code_cat_fk FOREIGN KEY (code_cat) REFERENCES _categorie(code_cat);
ALTER TABLE _sous_categorie ADD CONSTRAINT sous_categorie_categorie_code_sous_cat_fk FOREIGN KEY (code_sous_cat) REFERENCES _categorie(code_cat); 

-- Association *..1 entre adresse_livraison et commande ✅
ALTER TABLE _commande ADD COLUMN id_adresse INT NOT NULL;
ALTER TABLE _commande ADD CONSTRAINT _commande_adresse_livraison_fk FOREIGN KEY (id_adresse) REFERENCES _adresse_livraison(id_a);

--Classe association entre _compte 1 - *_avis qui se nomme _pouce :white_check_mark: ✅
ALTER TABLE _pouce ADD COLUMN num_avis INT NOT NULL;
ALTER TABLE _pouce ADD COLUMN num_compte INT NOT NULL;
ALTER TABLE _pouce ADD CONSTRAINT _pouce_produit_fk FOREIGN KEY (num_avis) REFERENCES _avis(num_avis);
ALTER TABLE _pouce ADD CONSTRAINT _pouce_client_fk FOREIGN KEY (num_compte) REFERENCES _compte(num_compte);
ALTER TABLE _pouce ADD CONSTRAINT _pouce_pk PRIMARY KEY (num_avis, num_compte);

-- ajout d'un check : un compte ne peut pas mettre un pouce à son propre avis ✅
CREATE OR REPLACE FUNCTION pouce_check() RETURNS TRIGGER AS
$$
BEGIN
    PERFORM num_compte FROM _avis inner join _pouce on _avis.num_compte = _pouce.num_compte WHERE _avis.num_avis = _pouce.num_avis;
    IF FOUND THEN
        RAISE EXCEPTION 'IMPOSSIBLE DE S''AUTO LIKE CLOCHARD VA';
    END IF;
    return new;
END
$$
LANGUAGE PLPGSQL;

-- Association 1..0.3 entre avis et image_avis
ALTER TABLE _image_avis ADD COLUMN num_avis INT NOT NULL;
ALTER TABLE _image_avis ADD CONSTRAINT _image_avis_avis_fk FOREIGN KEY (num_avis) REFERENCES _avis(num_avis);

/* -----------------------------------------------------------
-                                                            -
-                                                            -
--------------------------------------------------------------*/

INSERT INTO _compte (nom_compte, prenom_compte, pseudo, email, mot_de_passe) VALUES ('toast', 'deburn', 'test', 'test@gmail.com', 'test152687');
INSERT INTO _compte (nom_compte, prenom_compte, pseudo, email, mot_de_passe) VALUES ('illoutchine','nassima','nassima_illoutchine', 'nassima@gmail.com', 'test152687');
INSERT INTO _compte (nom_compte, prenom_compte, pseudo, email, mot_de_passe) VALUES ('moigne','tania','taniamoigne666999', 'temoigne@gmail.com', 'test152687');

INSERT INTO _adresse_facturation (nom_a, prenom_a, num_rue, nom_rue, code_postal, ville, num_compte) VALUES ('Carpadies', 'Jean', 15, 'Rue de la paix', 75000, 'Paris', 1);
INSERT INTO _adresse_livraison (nom_a, prenom_a, num_rue, nom_rue, code_postal, ville, infos_comp, num_compte) VALUES ('Carpadies', 'Jean', 15, 'Rue de la paix', 75000, 'Paris', 'Sous la poubelle bleue', 1);

INSERT INTO _tva VALUES (1);
INSERT INTO _tva VALUES (2);
INSERT INTO _tva VALUES (3);

INSERT INTO _categorie(code_cat,libelle_cat, cat_tva) VALUES (123,'alimentaire',2);
INSERT INTO _categorie(code_cat,libelle_cat, cat_tva) VALUES (124,'vetement',1);
INSERT INTO _categorie(code_cat,libelle_cat, cat_tva) VALUES (125,'electronique',2);
INSERT INTO _categorie(code_cat,libelle_cat, cat_tva) VALUES (126,'sport',1);
INSERT INTO _categorie(code_cat,libelle_cat, cat_tva) VALUES (127,'jardinage',2);
INSERT INTO _categorie(code_cat,libelle_cat, cat_tva) VALUES (128,'beaute',3);
INSERT INTO _categorie(code_cat,libelle_cat, cat_tva) VALUES (129,'loisir',3);
INSERT INTO _categorie(code_cat,libelle_cat, cat_tva) VALUES (130,'artisanat',3);
INSERT INTO _categorie(code_cat,libelle_cat, cat_tva) VALUES (131,'fruits',3);
INSERT INTO _categorie(code_cat,libelle_cat, cat_tva) VALUES (132,'legumes',3);
INSERT INTO _categorie(code_cat,libelle_cat, cat_tva) VALUES (133,'boissons',3);
INSERT INTO _categorie(code_cat,libelle_cat, cat_tva) VALUES (134,'epicerie',3);
INSERT INTO _categorie(code_cat,libelle_cat, cat_tva) VALUES (135,'chaussures',3);
INSERT INTO _categorie(code_cat,libelle_cat, cat_tva) VALUES (136,'vetements',3);
INSERT INTO _categorie(code_cat,libelle_cat, cat_tva) VALUES (137,'accessoires',3);
INSERT INTO _categorie(code_cat,libelle_cat, cat_tva) VALUES (138,'informatique',3);
INSERT INTO _categorie(code_cat,libelle_cat, cat_tva) VALUES (139,'telephonie',3);
INSERT INTO _categorie(code_cat,libelle_cat, cat_tva) VALUES (140,'audiovisuel',3);
INSERT INTO _categorie(code_cat,libelle_cat, cat_tva) VALUES (141,'sport',3);
INSERT INTO _categorie(code_cat,libelle_cat, cat_tva) VALUES (142,'loisir',3);
INSERT INTO _categorie(code_cat,libelle_cat, cat_tva) VALUES (143,'jardinage',3);
INSERT INTO _categorie(code_cat,libelle_cat, cat_tva) VALUES (144,'bricolage',3);
INSERT INTO _categorie(code_cat,libelle_cat, cat_tva) VALUES (145,'beaute',3);
INSERT INTO _categorie(code_cat,libelle_cat, cat_tva) VALUES (146,'hygiene',3);
INSERT INTO _categorie(code_cat,libelle_cat, cat_tva) VALUES (147,'loisir',3);
INSERT INTO _categorie(code_cat,libelle_cat, cat_tva) VALUES (148,'jeux',3);
INSERT INTO _categorie(code_cat,libelle_cat, cat_tva) VALUES (149,'autre',3);


INSERT INTO _sous_categorie(code_cat,code_sous_cat) VALUES (123,132);
INSERT INTO _sous_categorie(code_cat,code_sous_cat) VALUES (123,133);
INSERT INTO _sous_categorie(code_cat,code_sous_cat) VALUES (123,134);
INSERT INTO _sous_categorie(code_cat,code_sous_cat) VALUES (123,131);
INSERT INTO _sous_categorie(code_cat,code_sous_cat) VALUES (124,135);
INSERT INTO _sous_categorie(code_cat,code_sous_cat) VALUES (124,136);
INSERT INTO _sous_categorie(code_cat,code_sous_cat) VALUES (124,137);
INSERT INTO _sous_categorie(code_cat,code_sous_cat) VALUES (125,138);
INSERT INTO _sous_categorie(code_cat,code_sous_cat) VALUES (125,139);
INSERT INTO _sous_categorie(code_cat,code_sous_cat) VALUES (125,140);
INSERT INTO _sous_categorie(code_cat,code_sous_cat) VALUES (126,141);
INSERT INTO _sous_categorie(code_cat,code_sous_cat) VALUES (126,142);
INSERT INTO _sous_categorie(code_cat,code_sous_cat) VALUES (127,143);
INSERT INTO _sous_categorie(code_cat,code_sous_cat) VALUES (127,144);
INSERT INTO _sous_categorie(code_cat,code_sous_cat) VALUES (128,145);
INSERT INTO _sous_categorie(code_cat,code_sous_cat) VALUES (128,146);
INSERT INTO _sous_categorie(code_cat,code_sous_cat) VALUES (129,147);
INSERT INTO _sous_categorie(code_cat,code_sous_cat) VALUES (129,148);
INSERT INTO _sous_categorie(code_cat,code_sous_cat) VALUES (130,149);


INSERT INTO _produit (code_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (133,'coke',100,150,'carottes mures et bien juteuses provenant de la provance, excellent légume typiquement francais. Provenance: gouadeloupe', 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (133,'vins',10,15,'arottes mures et bien juteuses provenant de la provance, excellent légume typiquement francais. Provenance: gouadeloupe', 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (134,'fines herbes',10,15,'rottes mures et bien juteuses provenant de la provance, excellent légume typiquement francais. Provenance: gouadeloupe', 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (134,'cannabis',10,15,'cultivé localement, produits de nos terroirs', 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (135,'nike',10,15,'ottes mures et bien juteuses provenant de la provance, excellent légume typiquement francais. Provenance: gouadeloupe', 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (135,'néo balances',10,15,'ttes mures et bien juteuses provenant de la provance, excellent légume typiquement francais. Provenance: gouadeloupe', 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (136,'gucchivenchi',10,15,'tes mures et bien juteuses provenant de la provance, excellent légume typiquement francais. Provenance: gouadeloupe', 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (136,'le coq pas sportif',10,15,'es mures et bien juteuses provenant de la provance, excellent légume typiquement francais. Provenance: gouadeloupe', 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (137,'canard',10,15,'s mures et bien juteuses provenant de la provance, excellent légume typiquement francais. Provenance: gouadeloupe', 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (137,'33 tonnes',10,15,'mures et bien juteuses provenant de la provance, excellent légume typiquement francais. Provenance: gouadeloupe', 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (138,'RTX9090ti',10,15,'ures et bien juteuses provenant de la provance, excellent légume typiquement francais. Provenance: gouadeloupe', 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (138,'Ryzen -6000RX',10,15,'res et bien juteuses provenant de la provance, excellent légume typiquement francais. Provenance: gouadeloupe', 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (139,'cSamsung S22 (SS22)',10,15,'es et bien juteuses provenant de la provance, excellent légume typiquement francais. Provenance: gouadeloup', 'https://pbs.twimg.com/media/C3tBUxtUMAAgTPO?format=jpg&name=900x900e.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (140,'iphone 1',10,15,'s et bien juteuses provenant de la provance, excellent légume typiquement francais. Provenance: gouadeloupe', 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (140,'écran de cinéma',10,15,'et bien juteuses provenant de la provance, excellent légume typiquement francais. Provenance: gouadeloupe', 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (141,'JBL PRO',10,15,'t bien juteuses provenant de la provance, excellent légume typiquement francais. Provenance: gouadeloupe', 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (141,'running gag shoes',10,15,'bien juteuses provenant de la provance, excellent légume typiquement francais. Provenance: gouadeloupe', 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (142,'strap',10,15,'ien juteuses provenant de la provance, excellent légume typiquement francais. Provenance: gouadeloupe', 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (142,'péripatéticienne',10,15,'en juteuses provenant de la provance, excellent légume typiquement francais. Provenance: gouadeloup', 'https://media.sudouest.fr/2136676/1000x500/entree-bitche.jpg?v=1618309579e.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (143,'claymore',10,15,'n juteuses provenant de la provance, excellent légume typiquement francais. Provenance: gouadeloup','https://upload.wikimedia.org/wikipedia/commons/thumb/c/c1/US_M18a1_claymore_mine.jpg/280px-US_M18a1_claymore_mine.jpge.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (143,'rateau',10,15,'juteuses provenant de la provance, excellent légume typiquement francais. Provenance: gouadeloupe', 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (144,'bêche',10,15,'uteuses provenant de la provance, excellent légume typiquement francais. Provenance: gouadeloup','https://greensquare.fr/1160-large_default/fourche-beche-kent-and-stowe.jpge.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (144,'fraiseuse',10,15,'teuses provenant de la provance, excellent légume typiquement francais. Provenance: gouadeloupe', 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (145,'pilon',10,15,'euses provenant de la provance, excellent légume typiquement francais. Provenance: gouadeloupe', 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (145,'chadior',10,15,'uses provenant de la provance, excellent légume typiquement francais. Provenance: gouadeloupe', 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (146,'oréo',10,15,'ses provenant de la provance, excellent légume typiquement francais. Provenance: gouadeloupe', 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (146,'mousse anti vax',10,15,'es provenant de la provance, excellent légume typiquement francais. Provenance: gouadeloupe', 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (147,'détartreur pour dentition',10,15,'s provenant de la provance, excellent légume typiquement francais. Provenance: gouadeloupe', 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (147,'saut à pied non joint',10,15,'provenant de la provance, excellent légume typiquement francais. Provenance: gouadeloupe', 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (148,'missile javelin',1000,1500, 'très bon missile pour arrêter un T72, Attention à usage unique, provenance: ukraine','https://gagadget.com/media/post_big/Javelin_imXLcav.jpge.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (148,'jour',10,15,'rovenant de la provance, excellent légume typiquement francais. Provenance: gouadeloupe', 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod) 
VALUES (149,'hélicoptère apache',10000,15000,'héliocptère de fabrique américaine, configuration : 16 missiles hellfire, 1200 obus 30mm, Hydra 70 missile air sol (attention s''épuise très vite à l''usage): contact SAV', 'https://www.defense.govlouphttps://www.helicopassion.com/images/AH64/USArmy/NS11T3574h.jpge.jpg', true, 10, 4.5, 5, true);


INSERT INTO _avis (contenu_av,id_prod,num_compte) VALUES ('franchement j''en suis très satisfait, rien à redire le missile fonctionne très bien, néammoins attention à la prénétration sur du blindage réactif: on sent bien la limite du produit car il explose à la surface en ne faisant que très peu de dégats',30,1);
INSERT INTO _avis (contenu_av,id_prod,num_compte) VALUES ('Je suis déçu, à chaque fois que je veux aller faire les courses avec mon produit le rotor se bloque à cause d''un manque de préchauffage, pas très pratique au quotidien',32,2);
INSERT INTO _avis (contenu_av,id_prod,num_compte) VALUES ('Performant mais a parfois des difficultés',30,1);


INSERT INTO _image_avis (num_avis, lien_image_avis) VALUES (1, 'https://floriangll.fr/Humour/Dark/Masterclass/Masterclass.gif');
INSERT INTO _image_avis (num_avis, lien_image_avis) VALUES (2, 'https://floriangll.fr/Humour/Light/Masterclass/Masterclass.gif');

INSERT INTO _panier (num_compte) VALUES (1);
INSERT INTO _panier (num_compte) VALUES (2);
-- INSERT INTO _panier (num_compte) VALUES (1);

INSERT INTO _panier_visiteur (date_suppression, num_compte) VALUES ('2021-05-01', 1);
INSERT INTO _panier_visiteur (date_suppression, num_compte) VALUES ('2021-05-01', 2);

-- INSERT INTO _commande (num_commande, date_dep, date_arriv, etat_livraison, num_compte, id_a, id_adresse) VALUES ('12486','2022-10-23', '2022-10-30', 1, 2, 2, 2);

INSERT INTO _refere (qte_panier, id_prod, num_compte) VALUES (5, 18, 1);
INSERT INTO _refere (qte_panier, id_prod, num_compte) VALUES (1, 17, 1);
INSERT INTO _refere (qte_panier, id_prod, num_compte) VALUES (5, 18, 2);
INSERT INTO _refere (qte_panier, id_prod, num_compte) VALUES (5, 17, 2);

INSERT INTO _note (note_prod, id_prod, num_compte) VALUES (5, 18, 1);
INSERT INTO _note (note_prod, id_prod, num_compte) VALUES (5, 17, 1);
INSERT INTO _note (note_prod, id_prod, num_compte) VALUES (5, 18, 2);
-- INSERT INTO _note (note_prod, id_prod, num_compte) VALUES (3, 17, 1);

INSERT INTO _liste_souhait (etat_stock, id_prod, num_compte) VALUES (true, 18, 1);
INSERT INTO _liste_souhait (etat_stock, id_prod, num_compte) VALUES (true, 17, 1);
INSERT INTO _liste_souhait (etat_stock, id_prod, num_compte) VALUES (false, 18, 2);
INSERT INTO _liste_souhait (etat_stock, id_prod, num_compte) VALUES (true, 17, 2);
-- INSERT INTO _liste_souhait (etat_stock, id_prod, num_compte) VALUES (false, 18, 1);