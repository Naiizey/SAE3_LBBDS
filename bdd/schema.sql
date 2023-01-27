DROP SCHEMA IF EXISTS sae3 CASCADE;
CREATE SCHEMA sae3;
SET SCHEMA 'sae3';


/*
TODO: Contrainte -> bloquer un numéro de compte même si le compte relié est supprimé (attendre maj UML)
TODO: Contraintes current_panier(voir UML) à revoir (mineur)
*/
/* -----------------------------------------------------------
-                    Classes                                 -
-                                                            -
--------------------------------------------------------------*/



CREATE TABLE _tva
(
    cat_tva INT PRIMARY KEY,
    taux_tva float NOT NULL
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
    --code_tarif_liv INTEGER NOT NULL,
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
    numero_rue INT NOT NULL,
    nom_rue VARCHAR(50) NOT NULL,
    code_postal INT NOT NULL,
    ville VARCHAR(50) NOT NULL,
    comp_a1 VARCHAR(150) NULL,
    comp_a2 VARCHAR(150) NULL
);


CREATE TABLE _adresse_livraison(
    id_adresse_livr SERIAL PRIMARY KEY,
    infos_comp VARCHAR,
    id_a INT NOT NULL--dans_adresse
);

CREATE TABLE _adresse_facturation(
    id_adresse_fact SERIAL PRIMARY KEY,
    id_a INT NOT NULL--dans_adresse
);

CREATE TABLE _recevoir_commande(
    num_compte INT,
    id_adresse_livr INT PRIMARY KEY,
    CONSTRAINT  fk_recevoir_commande_compte FOREIGN KEY (num_compte) REFERENCES _compte(num_compte),
    CONSTRAINT  fk_recevoir_commande_adresse FOREIGN KEY (id_adresse_livr) REFERENCES _adresse_livraison(id_adresse_livr)
);

CREATE TABLE _recevoir_facture(
    num_compte INT,
    id_adresse_fact INT PRIMARY KEY,
    CONSTRAINT  fk_recevoir_commande_compte FOREIGN KEY (num_compte) REFERENCES _compte(num_compte),
    CONSTRAINT  fk_recevoir_commande_adresse FOREIGN KEY (id_adresse_fact) REFERENCES _adresse_facturation(id_adresse_fact)
);



CREATE TABLE _panier
(
    num_panier SERIAL PRIMARY KEY
);

CREATE TABLE _panier_client
(
    num_panier INT NOT NULL,
    num_compte INT NOT NULL UNIQUE
);



CREATE TABLE _panier_visiteur
(
    num_panier INT NOT NULL,
    date_suppression DATE NOT NULL,
    token_cookie VARCHAR(60) NOT NULL
);



CREATE TABLE _commande
(

    num_commande VARCHAR(50) UNIQUE NOT NULL PRIMARY KEY ,
    date_commande DATE NOT NULL,
    date_expedition DATE,
    date_plateformeReg DATE,
    date_plateformeLoc DATE,
    date_arriv DATE,
    id_a INT NOT NULL, --attendu_a
    num_compte INT NOT NULL, --fait_par
    id_reduction INT --reduction

) ;



CREATE TABLE _produit
(
    id_prod SERIAL PRIMARY KEY,
    intitule_prod VARCHAR(50) UNIQUE NOT NULL,
    prix_ht FLOAT NOT NULL,
    prix_ttc FLOAT NOT NULL,
    description_prod VARCHAR UNIQUE NOT NULL,
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
    num_commande varchar NOT NULL --renvoie
);

CREATE TABLE _note
(
    id_note SERIAL UNIQUE,
    id_prod INT NOT NULL,--recoit
    num_compte INT NOT NULL,--donne
    note_prod FLOAT NOT NULL,
    CONSTRAINT _note_pk PRIMARY KEY (id_prod,num_compte)


);

CREATE TABLE _avis(
    num_avis SERIAL PRIMARY KEY ,
    contenu_av VARCHAR NOT NULL,
    date_av DATE NOT NULL,
    id_note INT NOT NULL --est_detaille_par
);

CREATE TABLE _image_avis(
    num_image SERIAL PRIMARY KEY,
    lien_image_avis VARCHAR NOT NULL,
    num_avis INT NOT NULL
);

CREATE TABLE _promotion(
    id_promo SERIAL PRIMARY KEY ,
    texte_promo text NOT NULL ,
    banniere VARCHAR(50) NOT NULL,
    remise int NOT NULL ,
    id_duree INT NOT NULL
);

CREATE TABLE _code_reduction(
    id_reduction SERIAL PRIMARY KEY,
    code_reduction VARCHAR(50) UNIQUE NOT NULL,
    montant_reduction FLOAT NOT NULL,
    pourcentage_reduction FLOAT NOT NULL,
    id_duree INT NOT NULL
);

CREATE TABLE _duree(
    id_duree SERIAL PRIMARY KEY,
    date_debut DATE NOT NULL,
    heure_debut TIME NOT NULL,
    date_fin DATE NOT NULL,
    heure_fin TIME NOT NULL
);

CREATE TABLE _sanction_temporaire(
    id_sanction SERIAL PRIMARY KEY,
    raison VARCHAR(50) NOT NULL,
    id_duree INT NOT NULL,
    num_compte INT NOT NULL
);

CREATE TABLE _image_prod(
    id_prod int,
    num_image int,
    lien_image varchar(500),
    estInterne boolean DEFAULT false,

    CONSTRAINT pk_image_prod PRIMARY KEY (id_prod, num_image),
    CONSTRAINT fk_image_prod FOREIGN KEY (id_prod) REFERENCES _produit(id_prod)


);


/* -----------------------------------------------------------
-                  Classes association                        -
-                                                            -
--------------------------------------------------------------*/

--Classe association
-- entre _panier 1 - * et _code_reduction qui se nomme _reduire

CREATE TABLE _reduire(
    num_panier INT NOT NULL,
    id_reduction INT NOT NULL,
    CONSTRAINT _reduire_pk PRIMARY KEY (num_panier),
    CONSTRAINT _reduire_panier_fk FOREIGN KEY (num_panier) REFERENCES _panier(num_panier),
    CONSTRAINT _reduire_reduction_fk FOREIGN KEY (id_reduction) REFERENCES _code_reduction(id_reduction)
);



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


CREATE TABLE _refere_commande
(
    id_prod int not null,
    num_commande varchar NOT NULL,
    qte_panier INT NOT NULL,
    prix_fixeeTTC FLOAT not null,
    CONSTRAINT _refere_commande_pk PRIMARY KEY (id_prod, num_commande),


    CONSTRAINT _refere_commande_fk FOREIGN KEY (num_commande) REFERENCES _commande(num_commande),
    CONSTRAINT _refere_commande_produit_fk FOREIGN KEY (id_prod) REFERENCES _produit(id_prod)
);



CREATE TABLE _est_en_remise_sous
(
    id_prod INT,
    id_promo INT,

    CONSTRAINT  _est_en_remise_sous_pk primary key (id_prod,id_promo),
    CONSTRAINT  _prod_en_remise_fk foreign key (id_prod) REFERENCES _produit(id_prod),
    CONSTRAINT  _remise_de_prod_fk foreign key (id_prod) REFERENCES _promotion(id_promo)

);

CREATE TABLE _signalement
(
    id_signal SERIAL PRIMARY KEY,
    raison VARCHAR NOT NULL
);

CREATE TABLE _reponse
(

    num_avis INT NOT NULL PRIMARY KEY ,
    contenu_rep VARCHAR NOT NULL,
    date_rep DATE NOT NULL,

    CONSTRAINT _est_reponse_de foreign key (num_avis) references _avis(num_avis)

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



--Association 1..* entre _adresse et _commande ✅ (attendu_a)
ALTER TABLE _commande ADD CONSTRAINT _commande_adresse_fk FOREIGN KEY (id_a) REFERENCES _adresse(id_a);

--Association 1..* entre _commande et _retour (rembourse) ✅
ALTER TABLE _retour ADD CONSTRAINT _retour_commande_fk FOREIGN KEY (num_commande) REFERENCES _commande(num_commande);

--Association 1..* entre _compte et _avoirs () ✅
ALTER TABLE _avoirs ADD CONSTRAINT _avoirs_compte_fk FOREIGN KEY (num_compte) REFERENCES _compte(num_compte);



--Association 1..* entre _compte et _adresse_facturation (possedeF) ✅
--ALTER TABLE _adresse_facturation ADD CONSTRAINT _adresse_facturation_compte_fk FOREIGN KEY (num_compte) REFERENCES _compte(num_compte);


--Association 1..* entre _compte et _adresse_livraison ✅
--ALTER TABLE _adresse_livraison ADD CONSTRAINT _adresse_facturation_compte_fk FOREIGN KEY (num_compte) REFERENCES _compte(num_compte);



-- Association *..1 entre _compte et _avis (est_detaille_par) ✅
-- ALTER TABLE _avis ADD CONSTRAINT _avis_pk PRIMARY KEY (id_prod,num_compte);
ALTER TABLE _avis ADD CONSTRAINT _avis_note_fk FOREIGN KEY (id_note) REFERENCES _note(id_note);

-- Association *..1 entre catégorie et catégorie (sous) ✅
ALTER TABLE _sous_categorie ADD CONSTRAINT _sous_categorie_categorie_code_cat_fk FOREIGN KEY (code_cat) REFERENCES _categorie(code_cat);

-- Association *..1 entre adresse_livraison et commande ✅
ALTER TABLE _commande ADD CONSTRAINT _commande_adresse_livraison_fk FOREIGN KEY (id_a) REFERENCES _adresse_livraison(id_adresse_livr);

--Association * -- 1 entre _commande et _compte
ALTER TABLE _commande ADD CONSTRAINT fk_commande_compte FOREIGN KEY (num_compte) REFERENCES _compte(num_compte);

-- Association 1..0.3 entre avis et image_avis
ALTER TABLE _image_avis ADD CONSTRAINT _image_avis_avis_fk FOREIGN KEY (num_avis) REFERENCES _avis(num_avis);

-- contrainte entre _adresse et _adresse_facturation ✅
ALTER TABLE _adresse_facturation
ADD CONSTRAINT _adresse_facturation_id_a_fk FOREIGN KEY (id_a) REFERENCES _adresse(id_a);

-- contrainte entre _adresse et _adresse_livraison ✅
ALTER TABLE _adresse_livraison
ADD CONSTRAINT _adresse_livraison_id_a_fk FOREIGN KEY (id_a) REFERENCES _adresse(id_a);

ALTER TABLE _note
    --containte avec _produit (recoit)
    ADD CONSTRAINT _note_produit_fk FOREIGN KEY (id_prod) REFERENCES _produit(id_prod),
    --contrainte avec _compte (donne)
    ADD CONSTRAINT _note_client_fk FOREIGN KEY (num_compte) REFERENCES _compte(num_compte);



-- association entre _panier et _panier_visiteur
ALTER TABLE _panier_visiteur ADD CONSTRAINT _panier_visiteur_fk FOREIGN KEY (num_panier) REFERENCES _panier(num_panier);
ALTER TABLE _panier_visiteur ADD CONSTRAINT _panier_visiteur_pk PRIMARY KEY (num_panier);

-- association entre _panier et _panier_client
ALTER TABLE _panier_client ADD CONSTRAINT _panier_client_fk FOREIGN KEY (num_panier) REFERENCES _panier(num_panier);
ALTER TABLE _panier_client ADD CONSTRAINT _panier_client_pk PRIMARY KEY (num_panier);



-- association entre _promotion et _duree
ALTER TABLE _promotion ADD CONSTRAINT _promotion_duree_fk FOREIGN KEY (id_duree) REFERENCES _duree(id_duree);

-- association entre _code_reduction et _duree
ALTER TABLE _code_reduction ADD CONSTRAINT _code_reduction_duree_fk FOREIGN KEY (id_duree) REFERENCES _duree(id_duree);

-- association entre _sanction_temporaire et _duree
ALTER TABLE _sanction_temporaire ADD CONSTRAINT _sanction_temporaire_duree_fk FOREIGN KEY (id_duree) REFERENCES _duree(id_duree);

-- asociation entre _sanction_temporaire et _compte
ALTER TABLE _sanction_temporaire ADD CONSTRAINT _sanction_temporaire_compte_fk FOREIGN KEY (num_compte) REFERENCES _compte(num_compte);

-- Association *..1 entre avis et signalement 
ALTER TABLE _signalement ADD COLUMN num_avis INT NOT NULL;
ALTER TABLE _signalement ADD CONSTRAINT _signalement_avis_fk FOREIGN KEY (num_avis) REFERENCES _avis(num_avis);

-- Association *..1 entre _signalement et _compte
ALTER TABLE _signalement ADD COLUMN num_compte INT NOT NULL;
ALTER TABLE _signalement ADD CONSTRAINT _signalement_compte_fk FOREIGN KEY (num_compte) REFERENCES _compte(num_compte);

/* -----------------------------------------------------------
-                  TRIGGER DE CONTRAINTES:                   -
   TRIGGER PERMETTANT DE FAIRE RESPECTER UNE CONTRAINTE                       -
-                                                            -
--------------------------------------------------------------*/


-- ajout d'un check : un compte ne peut pas mettre un pouce à son propre avis ✅
CREATE OR REPLACE FUNCTION pouce_check() RETURNS TRIGGER AS
$$
BEGIN
    PERFORM num_compte FROM _avis natural join _note inner join _pouce on _note.num_compte = new.num_compte WHERE _avis.num_avis = new.num_avis;
    IF FOUND THEN
        RAISE EXCEPTION 'IMPOSSIBLE DE S''AUTO LIKE';
    END IF;
    return new;
END
$$
LANGUAGE PLPGSQL;
CREATE tRIGGER beforeInsert_pouce BEFORE INSERT ON _pouce FOR EACH ROW EXECUTE PROCEDURE pouce_check() ;





CREATE OR REPLACE FUNCTION creerPremierPanier() RETURNS TRIGGER AS
    $$

    BEGIN

        Insert Into sae3._panier_client (num_compte) VALUES (new.num_compte);
        return new;
    end;
    $$ language plpgsql;
CREATE tRIGGER afterInsertClient AFTER INSERT ON _compte FOR EACH ROW EXECUTE PROCEDURE creerPremierPanier ();


CREATE OR REPLACE FUNCTION creerPanier() RETURNS TRIGGER AS
    $$

    BEGIN

        INSERT INTO sae3._panier DEFAULT VALUES;
        new.num_panier = CURRVAL('sae3._panier_num_panier_seq');

        return new;
    end;
    $$ language plpgsql;
CREATE tRIGGER beforeInsertPanierCli BEFORE INSERT ON _panier_client FOR EACH ROW EXECUTE PROCEDURE creerPanier ();
CREATE tRIGGER beforeInsertPanierVis BEFORE INSERT ON _panier_visiteur FOR EACH ROW EXECUTE PROCEDURE creerPanier ();


CREATE OR REPLACE FUNCTION limiteImageProd() RETURNS TRIGGER AS
    $$
    DECLARE
        compteur int;
    BEGIN
        SELECT count(num_image) into compteur from sae3._image_prod natural join sae3._produit where new.id_prod=sae3._produit.id_prod;
        IF compteur < 4 THEN
            return new;
        ELSE
            raise exception 'Limite d''images atteinte';
        end if;


end
$$ language plpgsql;
CREATE TRIGGER nouvelleImageProd BEFORE INSERT ON _image_prod FOR EACH ROW EXECUTE PROCEDURE limiteImageProd();


CREATE OR REPLACE FUNCTION  frozenPrix() RETURNS TRIGGER AS
    $$
        BEGIN
            IF (new.prix_fixeettc != old.prix_fixeettc) THEN
                raise notice 'Tentative de changer un valeur constante ';
                new.prix_fixeettc = old.prix_fixeettc;
            end if;
        return new;
end
    $$ language plpgsql;

CREATE TRIGGER update_frozen BEFORE UPDATE ON _refere_commande FOR EACH ROW EXECUTE PROCEDURE frozenPrix();



