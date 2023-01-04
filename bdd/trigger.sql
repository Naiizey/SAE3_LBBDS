SET SCHEMA 'sae3';

CREATE OR REPLACE FUNCTION csvImport() RETURNS TRIGGER AS
$$
BEGIN
    INSERT INTO _produit SELECT * FROM old;
END
$$
language plpgsql;
--DROP TRIGGER csvImport ON produitCSV;
/* CREATE tRIGGER csvImport INSTEAD OF INSERT ON produitcsv FOR EACH ROW EXECUTE PROCEDURE csvImport();*/

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

    BEGIN

        INSERT INTO sae3._commande(num_commande, date_commande, id_a,num_compte) VALUES (new.num_commande, current_date,new.id_a,new.num_compte);


        PERFORM num_panier FROM sae3._panier_client natural join sae3._refere where num_compte=new.num_compte;
        if found then


            for row in (SELECT id_prod, num_panier, qte_panier,  prix_ht+(prix_ht*taux_tva) prix_fixeeTTC FROM sae3._refere
            natural join sae3._panier_client natural join sae3._produit natural join sae3._sous_categorie inner join sae3._categorie on _categorie.code_cat=_sous_categorie.code_cat natural join sae3._tva
            where num_compte=new.num_compte) loop

                    INSERT INTO sae3._refere_commande(id_prod, num_commande, qte_panier, prix_fixeettc) VALUES (row.id_prod,new.num_commande,row.qte_panier, row.prix_fixeeTTC);
                    delete from sae3._refere where num_panier in (select num_panier from sae3._panier_client where num_compte=new.num_compte) and id_prod=row.id_prod;

            end loop;


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
    INSERT INTO sae3._compte (nom_compte, prenom_compte, email, pseudo, mot_de_passe) VALUES (NEW.nom, NEW.prenom, NEW.email, NEW.identifiant, NEW.motDePasse);
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
    UPDATE sae3._compte SET nom_compte = NEW.nom, prenom_compte = NEW.prenom, email = NEW.email, pseudo = NEW.identifiant, mot_de_passe = NEW.motDePasse WHERE num_compte = OLD.numero;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER update_client
    INSTEAD OF UPDATE ON sae3.client
    FOR EACH ROW
    EXECUTE PROCEDURE update_client();



CREATE OR REPLACE FUNCTION insert_sanction_temporaire() RETURNS TRIGGER AS $$
BEGIN
    INSERT INTO sae3._duree (date_debut, heure_debut, date_fin, heure_fin) VALUES (NEW.date_debut, NEW.heure_debut, NEW.date_fin, NEW.heure_fin);
    INSERT INTO sae3._sanction_temporaire (raison, num_compte) VALUES (NEW.raison, NEW.id_compte);
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER insert_sanction_temporaire
    INSTEAD OF INSERT ON sae3.sanction_temporaire
    FOR EACH ROW
    EXECUTE PROCEDURE insert_sanction_temporaire();


--

CREATE OR REPLACE FUNCTION insert_commentaire() RETURNS TRIGGER AS
$$
    BEGIN
        Insert Into sae3._note(id_prod, num_compte, note_prod) VALUES (new.id_prod, new.num_compte, new.note_prod);
        Insert Into sae3._avis(contenu_av, date_av, id_note) VALUES (new.contenu_av, current_date, currval('sae3._note_id_note_seq'));

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
        delete from sae3._avis where num_avis=old.num_avis;
        delete from sae3._note where id_note=old.id_note;

        --coir a delete réponse du vendeur aussi
        return old;
    end;
$$ language plpgsql;

CREATE TRIGGER when_delete_commentaire INSTEAD OF DELETE ON commentaires FOR EACH ROW EXECUTE PROCEDURE delete_commentaire();

