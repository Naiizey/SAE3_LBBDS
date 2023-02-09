SET SCHEMA 'sae3';

/**
  TRIGGER CRUD

 */

CREATE OR REPLACE FUNCTION csvImport() RETURNS TRIGGER AS
$$


BEGIN
    

    --vérifie dans la table _sous_categorie si le code_sous_cat qui provient de l'appelant existe et on range le résultat dans une variable
    PERFORM * FROM sae3._sous_categorie WHERE code_sous_cat = NEW.code_sous_cat;
    -- si le code_sous_cat n'existe pas dans la table _sous_categorie
    IF NOT FOUND THEN

        -- si la catégorie 190 n'existe pas
        IF NOT EXISTS (SELECT * FROM sae3._categorie WHERE code_cat = 190) THEN
            --on créer une nouvelle catégorie
            INSERT INTO sae3._categorie(code_cat,libelle_cat, cat_tva) VALUES (190,'Inconnue',1);
        END IF;
        -- si la sous catégorie NEW.code_sous_cat n'existe pas
        IF NOT EXISTS (SELECT * FROM sae3._sous_categorie WHERE code_sous_cat = NEW.code_sous_cat) THEN
            --on créer une nouvelle sous catégorie
            INSERT INTO sae3._sous_categorie(code_sous_cat,libelle_cat, code_cat) VALUES (NEW.code_sous_cat,'Inconnue sous cat',190);
        END IF;
        --on créer un nouveau produit


        --on créer un nouveau produit

    END IF;
    INSERT INTO sae3._produit(code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod) VALUES (NEW.code_sous_cat, NEW.intitule_prod, NEW.prix_ht, NEW.prix_ttc, NEW.description_prod, NEW.publication_prod, NEW.stock_prod,NEW.moyenne_note_prod,NEW.seuil_alerte_prod,NEW.alerte_prod);

    -- on retourne le résultat
    RETURN NEW;

END
$$
language plpgsql;
-- INSERT INTO _produit SELECT * FROM old;
--DROP TRIGGER csvImport ON produitCSV;
CREATE tRIGGER csvImport INSTEAD OF INSERT ON produitcsv FOR EACH ROW EXECUTE PROCEDURE csvImport();

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

CREATE OR REPLACE FUNCTION transvasagePanier(entree_token_panier varchar, entree_num_compte int) RETURNS INT AS
    $$
     DECLARE
        current_panier int;
        row sae3._refere%ROWTYPE;
        stock int;

    BEGIN
        PERFORM num_panier FROM sae3._panier_visiteur natural join sae3._refere where token_cookie=entree_token_panier;
        if found then

            select max(num_panier) into current_panier from sae3._panier_client where num_compte=entree_num_compte group by num_compte;
            for row in (SELECT id_prod, num_panier, qte_panier FROM sae3._refere natural join sae3._panier_visiteur where token_cookie=entree_token_panier) loop
                Perform * FROM sae3._refere WHERE num_panier=current_panier and id_prod=row.id_prod;
                If FOUND THEN
                    SELECT stock_prod INTO stock FROM sae3._produit natural join sae3._refere where id_prod=row.id_prod and num_panier=current_panier;

                    UPDATE sae3._refere SET qte_panier=qte_panier+row.qte_panier WHERE num_panier=current_panier and id_prod=row.id_prod and stock >= row.qte_panier+qte_panier;

                    UPDATE sae3._refere SET qte_panier=stock WHERE num_panier=current_panier and id_prod=row.id_prod and stock < row.qte_panier+qte_panier;



                ELSE
                    INSERT INTO sae3._refere(id_prod, num_panier, qte_panier) VALUES (row.id_prod,current_panier,row.qte_panier);

                end if;


                delete from sae3._refere where num_panier=row.num_panier and id_prod=row.id_prod;

            end loop;


        else
            raise notice 'il n''y  pas de produits dans ce panier';
            RETURN 1;
        end if;
        RETURN 0;

    END;
    $$ language plpgsql;



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

        row sae3._refere_commande%ROWTYPE;
        id_reduction_temp int;
    BEGIN
        SELECT id_reduction fROM sae3._reduire WHERE num_panier = (SELECT num_panier FROM sae3._panier_client WHERE  num_compte = new.num_compte) into id_reduction_temp;
        
    
        INSERT INTO sae3._commande(num_commande, date_commande, id_a,num_compte,id_reduction) VALUES (new.num_commande, current_date,new.id_a,new.num_compte,id_reduction_temp); -- changer new.id_reduction (trouver le client puis l'id de réduction qui est associé au panier)


        PERFORM num_panier FROM sae3._panier_client natural join sae3._refere where num_compte=new.num_compte;
        if found then


            for row in (SELECT id_prod, num_panier, qte_panier,  prix_ht+(prix_ht*taux_tva) prix_fixeeTTC FROM sae3._refere
            natural join sae3._panier_client natural join sae3.produit_global natural join sae3._sous_categorie inner join sae3._categorie on _categorie.code_cat=_sous_categorie.code_cat natural join sae3._tva
            where num_compte=new.num_compte) loop

                    INSERT INTO sae3._refere_commande(id_prod, num_commande, qte_panier, prix_fixeettc) VALUES (row.id_prod,new.num_commande,row.qte_panier, row.prix_fixeeTTC);
                    delete from sae3._refere where num_panier in (select num_panier from sae3._panier_client where num_compte=new.num_compte) and id_prod=row.id_prod;

            end loop;
            
            -- insertion du code de réduction dans _commande et supression de _refere 

        else
            raise exception 'il n''y  pas de produits dans ce panier';
        end if;

        RETURN NEW;
    end
$$ language plpgsql;
CREATE TRIGGER insteadOfInsert_insertCommande INSTEAD OF INSERT ON sae3.insert_commande FOR EACH ROW EXECUTE PROCEDURE insertInsertCommande();

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

-- trigger insertion dans _compte instead of insert à partir de la vue client

CREATE OR REPLACE FUNCTION insert_client() RETURNS trigger AS $$
BEGIN
    INSERT INTO sae3._compte (email, pseudo, mot_de_passe) VALUES (NEW.email, NEW.identifiant, NEW.motDePasse);
    Insert Into sae3._client(num_compte, nom_compte, prenom_compte)  VALUES (currval('sae3._compte_num_compte_seq'),NEW.nom, NEW.prenom);
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER insert_client
    INSTEAD OF INSERT ON sae3.client
    FOR EACH ROW
    EXECUTE PROCEDURE insert_client();

-- trigger insertion dans _compte instead of update à partir de la vue client

CREATE OR REPLACE FUNCTION update_client() RETURNS trigger AS $$
BEGIN
    --on récupère tous les champs qui sont contenus dans l'update
    UPDATE sae3._compte SET email = NEW.email, pseudo = NEW.identifiant, mot_de_passe = NEW.motDePasse WHERE num_compte = OLD.numero;
    UPDATE sae3._client SET nom_compte = NEW.nom, prenom_compte = NEW.prenom  WHERE num_compte = OLD.numero;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER update_client
    INSTEAD OF UPDATE ON sae3.client
    FOR EACH ROW
    EXECUTE PROCEDURE update_client();


CREATE OR REPLACE FUNCTION insert_vendeur() RETURNS trigger AS $$
BEGIN
    INSERT INTO sae3._compte (email, pseudo, mot_de_passe) VALUES (NEW.email, NEW.identifiant, NEW.motDePasse);
    INSERT INTO sae3._adresse (nom_a, prenom_a, numero_rue, nom_rue, code_postal, ville, comp_a1, comp_a2) VALUES ('','', NEW.numero_rue,NEW.nom_rue, NEW.code_postal, NEW.ville, NEW.comp_a1, NEW.comp_a2);
    Insert Into sae3._vendeur VALUES (currval('sae3._compte_num_compte_seq'), NEW.numero_siret, NEW.tva_intercommunautaire, NEW.texte_presentation, NEW.note_vendeur, NEW.logo, currval('sae3._adresse_id_a_seq'));
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;
/*
CREATE TRIGGER insert_vendeur
    INSTEAD OF INSERT ON sae3.vendeur
    FOR EACH ROW
    EXECUTE PROCEDURE insert_vendeur();

 */

-- trigger insertion dans _compte instead of update à partir de la vue client

CREATE OR REPLACE FUNCTION update_vendeur() RETURNS trigger AS $$
BEGIN
    --on récupère tous les champs qui sont contenus dans l'update
    UPDATE sae3._compte SET email = NEW.email, pseudo = NEW.identifiant, mot_de_passe = NEW.motDePasse WHERE num_compte = OLD.numero;
    UPDATE sae3._vendeur SET numero_siret= NEW.numero_siret,tva_intercommunautaire= NEW.tva_intercommunautaire, note_vendeur= NEW.note_vendeur,logo= new.logo WHERE num_compte=OLD.numero;
    UPDATE sae3._adresse SET numero_rue=NEW.numero_rue, nom_rue= NEW.nom_rue, code_postal=NEW.code_postal, ville=NEW.ville WHERE id_a=OLD.id_adresse;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;
/*
CREATE TRIGGER update_vendeur
    INSTEAD OF UPDATE ON vendeur
    FOR EACH ROW
    EXECUTE PROCEDURE update_vendeur();

*/


CREATE OR REPLACE FUNCTION insert_sanction_temporaire() RETURNS TRIGGER AS $$
BEGIN
    INSERT INTO sae3._duree (date_debut, heure_debut, date_fin, heure_fin) VALUES (NEW.date_debut, NEW.heure_debut, NEW.date_fin, NEW.heure_fin);
    INSERT INTO sae3._sanction_temporaire (raison, num_compte, id_duree) VALUES (NEW.raison, NEW.num_compte, CURRVAL('sae3._duree_id_duree_seq'));
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER insert_sanction_tempo
    INSTEAD OF INSERT ON sae3.sanction_temporaire
    FOR EACH ROW
    EXECUTE PROCEDURE insert_sanction_temporaire();


CREATE OR REPLACE FUNCTION delete_sanction_temporaire() RETURNS TRIGGER AS $$
BEGIN
    DELETE FROM sae3._sanction_temporaire WHERE id_sanction = OLD.id_sanction;
    RETURN OLD;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER delete_sanction_tempo
    INSTEAD OF DELETE ON sae3.sanction_temporaire
    FOR EACH ROW
    EXECUTE PROCEDURE delete_sanction_temporaire();

--

CREATE OR REPLACE FUNCTION insert_commentaire() RETURNS TRIGGER AS
$$
    BEGIN
        Insert Into sae3._note(id_prod, num_compte, note_prod) VALUES (new.id_prod, new.num_compte, new.note_prod);
        IF new.contenu_av is not null and new.contenu_av > '' THEN
                Insert Into sae3._avis(contenu_av, date_av, id_note) VALUES (new.contenu_av, current_date, currval('sae3._note_id_note_seq'));
        end if;

        return new;
    end;
$$ language plpgsql;
CREATE TRIGGER when_insert_commentaire INSTEAD OF INSERT ON commentaires FOR EACH ROW EXECUTE PROCEDURE insert_commentaire();

CREATE OR REPLACE FUNCTION update_commentaire() RETURNS TRIGGER AS
$$
    BEGIN
        update sae3._note set note_prod=new.note_prod where id_note=old.id_note;
        update sae3._avis set contenu_av=new.contenu_av where num_avis=old.num_avis;

        return new;
    end;
$$ language plpgsql;

--CREATE TRIGGER when_update_commentaire INSTEAD OF UPDATE ON commentaires FOR EACH ROW EXECUTE PROCEDURE update_commentaire();

CREATE OR REPLACE FUNCTION delete_commentaire() RETURNS TRIGGER AS
$$
    BEGIN
        delete from sae3._reponse where num_avis=old.num_avis;
        delete from sae3._signalement where num_avis=old.num_avis;
        delete from sae3._image_avis where num_avis=old.num_avis;
        delete from sae3._avis where num_avis=old.num_avis;
        delete from sae3._note where id_note=old.id_note;

        --coir a delete réponse du vendeur aussi
        return old;
    end;
$$ language plpgsql;

CREATE TRIGGER when_delete_commentaire INSTEAD OF DELETE ON commentaires FOR EACH ROW EXECUTE PROCEDURE delete_commentaire();

