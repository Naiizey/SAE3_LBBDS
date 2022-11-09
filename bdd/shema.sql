
DROP SCHEMA IF EXISTS sae3 CASCADE;
CREATE SCHEMA sae3;
SET SCHEMA 'sae3';



/* -----------------------------------------------------------
-                    Classes                                 -
-                                                            -
--------------------------------------------------------------*/



CREATE TABLE _tva
(
    cat_tva INT PRIMARY KEY,
    taux_tva float
);

CREATE TABLE _categorie
(
    code_cat INT PRIMARY KEY,
    cat_tva INT NOT NULL,--dans_cat_tva
    libelle_cat VARCHAR(50) NOT NULL
);

CREATE TABLE _sous_categorie(
    code_sous_cat INT,
    libelle_cat VARCHAR(50) NOT NULL,

    code_cat INT,--sous

    CONSTRAINT _sous_categorie_pk PRIMARY KEY (code_sous_cat)
);



CREATE TABLE _compte
(
    num_compte SERIAL PRIMARY KEY,
    nom_compte VARCHAR(50) NOT NULL,
    prenom_compte VARCHAR(50) NOT NULL,
    pseudo VARCHAR(30) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    mot_de_passe VARCHAR(60) NOT NULL
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
     num_compte INT NOT NULL,
    infos_comp VARCHAR NOT NULL,
    CONSTRAINT _adresse_livraison_pk PRIMARY KEY (id_a)
)INHERITS (_adresse);

CREATE TABLE _adresse_facturation(
    num_compte INT NOT NULL,
    CONSTRAINT _adresse_facturation_pk PRIMARY KEY (id_a)
)INHERITS (_adresse);

CREATE TABLE _panier
(
    num_panier SERIAL PRIMARY KEY

);

CREATE TABLE _panier_client
(
    num_compte INT NOT NULL
)INHERITS (_panier);




CREATE TABLE _panier_visiteur
(
    date_suppression DATE NOT NULL,
    token_cookie VARCHAR(60) NOT NULL
)INHERITS (_panier);

CREATE TABLE _commande
(
    num_commande VARCHAR(50),
    date_dep DATE NOT NULL,
    date_arriv DATE NOT NULL,
    etat_livraison INT NOT NULL,
    id_a INT NOT NULL, --attendu_a
    id_adresse INT NOT NULL
)INHERITS (_panier_client);

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
    alerte_prod BOOLEAN NOT NULL,

    code_sous_cat INT NOT NULL--contenu_dans
);


CREATE TABLE _avoirs
(
    num_avoirs SERIAL PRIMARY KEY,
    montant_valid FLOAT NOT NULL,
    duree_valid DATE NOT NULL,
    num_compte INT NOT NULL
);

CREATE TABLE _retour(
    etiq_ret INT PRIMARY KEY,
    motif VARCHAR(50) NOT NULL,
    etat_remb BOOLEAN NOT NULL,
    conf_ret BOOLEAN NOT NULL,
    num_compte INT NOT NULL --rembourse
);

CREATE TABLE _avis(
    num_avis SERIAL PRIMARY KEY ,
    contenu_av VARCHAR NOT NULL,
    id_prod INT NOT NULL, -- sur,
    num_compte INT NOT NULL --auteur
);

CREATE TABLE _image_avis(
    num_image SERIAL PRIMARY KEY,
    lien_image_avis VARCHAR NOT NULL,
    num_avis INT NOT NULL
);

/* -----------------------------------------------------------
-                  Classes association                        -
-                                                            -
--------------------------------------------------------------*/
--Classe association entre _compte 1 - *_avis qui se nomme _pouce :white_check_mark: ✅

CREATE TABLE _pouce
(
    num_avis INT NOT NULL,
    num_compte INT NOT NULL,
    pouce_fav BOOLEAN NOT NULL,
    CONSTRAINT _pouce_pk PRIMARY KEY (num_avis, num_compte),

    CONSTRAINT _pouce_produit_fk FOREIGN KEY (num_avis) REFERENCES _avis(num_avis),
    CONSTRAINT _pouce_client_fk FOREIGN KEY (num_compte) REFERENCES _compte(num_compte)
);


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

CREATE OR REPLACE FUNCTION fixInheritance() RETURNS TRIGGER AS
$$
BEGIN
    INSERT INTO _panier (num_panier) VALUES (new.num_panier);
    return new;
END;
$$
LANGUAGE PLPGSQL;
CREATE OR REPLACE TRIGGER insteadOfInsert_panier AFTER INSERT ON _panier_client FOR EACH ROW EXECUTE PROCEDURE fixInheritance() ;
CREATE OR REPLACE TRIGGER insteadOfInsert_panier AFTER INSERT ON _panier_visiteur FOR EACH ROW EXECUTE PROCEDURE fixInheritance() ;


--Classe association entre _compte * - *_produit qui se nomme note ✅
CREATE TABLE _note
(
    id_prod INT NOT NULL,
    num_compte INT NOT NULL,
    note_prod FLOAT NOT NULL,
    CONSTRAINT _note_pk PRIMARY KEY (id_prod, num_compte),

    CONSTRAINT _note_produit_fk FOREIGN KEY (id_prod) REFERENCES _produit(id_prod),
    CONSTRAINT _note_client_fk FOREIGN KEY (num_compte) REFERENCES _compte(num_compte)
);


--Classe association entre _compte * - *_produit qui se nomme _liste_souhait ✅
CREATE TABLE _liste_souhait
(
    id_prod INT NOT NULL,
    num_compte INT NOT NULL,
    --etat_stock BOOLEAN NOT NULL
    CONSTRAINT _liste_souhait_pk PRIMARY KEY (id_prod, num_compte),

    CONSTRAINT _liste_souhait_produit_fk FOREIGN KEY (id_prod) REFERENCES _produit(id_prod),
    CONSTRAINT _liste_souhait_client_fk FOREIGN KEY (num_compte) REFERENCES _compte(num_compte)

);

--Classe association entre _panier * - * _produit qui se nomme _refere ✅
CREATE TABLE _refere
(
    id_prod INT NOT NULL,
    num_panier INT NOT NULL,
    qte_panier INT NOT NULL,
    CONSTRAINT _refere_pk PRIMARY KEY (id_prod, num_panier),


    CONSTRAINT _refere_panier_fk FOREIGN KEY (num_panier) REFERENCES _panier(num_panier),
    CONSTRAINT _refere_produit_fk FOREIGN KEY (id_prod) REFERENCES _produit(id_prod)
);

/* -----------------------------------------------------------
-                        Associations                        -
-                                                            -
--------------------------------------------------------------*/

--Association 1..* entre _pdt et _categorie ✅ (contenu_dans)
ALTER TABLE _produit ADD CONSTRAINT _produit_sous_categorie_fk FOREIGN KEY (code_sous_cat) REFERENCES _sous_categorie(code_sous_cat) ;

--Association 1..* entre _tva et _categorie ✅ (dans_cat_tva)
ALTER TABLE _categorie ADD CONSTRAINT _categorie_tva_fk FOREIGN KEY (cat_tva) REFERENCES _tva(cat_tva);


/*--Association 1..* entre _panier et _compte (possede) ✅
ALTER TABLE _compte ADD COLUMN num_panier INT;
ALTER TABLE _compte ADD CONSTRAINT _compte_panier_fk FOREIGN KEY (num_panier) REFERENCES _panier(num_panier);
*/

--Association 0.1..1.0 entre _panier et _compte (utilise) ✅

--ALTER TABLE _panier ADD CONSTRAINT _panier_pk PRIMARY KEY (num_compte);
ALTER TABLE _panier_client ADD CONSTRAINT _panier_compte_fk FOREIGN KEY (num_compte) REFERENCES _compte(num_compte);

-- PRIMARY KEY _panier_visiteur
--ALTER TABLE _panier_visiteur ADD CONSTRAINT _panier_visiteur_pk PRIMARY KEY (num_compte);

-- PRIMARY KEY _commande
ALTER TABLE _commande ADD CONSTRAINT _commande_pk PRIMARY KEY (num_compte);

--Association 1..* entre _adresse et _commande ✅ (attendu_a)
ALTER TABLE _commande ADD CONSTRAINT _commande_adresse_fk FOREIGN KEY (id_a) REFERENCES _adresse(id_a);

--Association 1..* entre _commande et _retour (rembourse) ✅
ALTER TABLE _retour ADD CONSTRAINT _retour_commande_fk FOREIGN KEY (num_compte) REFERENCES _commande(num_compte);

--Association 1..* entre _compte et _avoirs () ✅
ALTER TABLE _avoirs ADD CONSTRAINT _avoirs_compte_fk FOREIGN KEY (num_compte) REFERENCES _compte(num_compte);





--Association 1..* entre _compte et _adresse_facturation (possedeF) ✅
ALTER TABLE _adresse_facturation ADD CONSTRAINT _adresse_facturation_compte_fk FOREIGN KEY (num_compte) REFERENCES _compte(num_compte);


--Association 1..* entre _compte et _adresse_livraison ✅
ALTER TABLE _adresse_livraison ADD CONSTRAINT _adresse_facturation_compte_fk FOREIGN KEY (num_compte) REFERENCES _compte(num_compte);

--Association 1..* entre _produit et _avis (sur) ✅
ALTER TABLE _avis ADD CONSTRAINT _avis_produit_fk FOREIGN KEY (id_prod) REFERENCES _produit(id_prod);

-- Association *..1 entre _compte et _avis (auteur) ✅
-- ALTER TABLE _avis ADD CONSTRAINT _avis_pk PRIMARY KEY (id_prod,num_compte);
ALTER TABLE _avis ADD CONSTRAINT _avis_compte_fk FOREIGN KEY (num_compte) REFERENCES _compte(num_compte);

-- Association *..1 entre catégorie et catégorie (sous) ✅
ALTER TABLE _sous_categorie ADD CONSTRAINT _sous_categorie_categorie_code_cat_fk FOREIGN KEY (code_cat) REFERENCES _categorie(code_cat);

-- Association *..1 entre adresse_livraison et commande ✅
ALTER TABLE _commande ADD CONSTRAINT _commande_adresse_livraison_fk FOREIGN KEY (id_adresse) REFERENCES _adresse_livraison(id_a);


-- Association 1..0.3 entre avis et image_avis
ALTER TABLE _image_avis ADD CONSTRAINT _image_avis_avis_fk FOREIGN KEY (num_avis) REFERENCES _avis(num_avis);
