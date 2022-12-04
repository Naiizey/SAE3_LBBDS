-- ajout des droits superuser pour pouvoir ensuite supprimer les triggers de vérification de contraintes d'intégrité
ALTER USER <utilisateur> WITH SUPERUSER;


SET SCHEMA 'sae3';


BEGIN TRANSACTION;

-- 1ERE ETAPE : on désactive toutes les contraintes pour toutes les tables
DO $$
DECLARE
    r RECORD;
BEGIN
    FOR r IN (SELECT tablename FROM pg_tables WHERE schemaname = current_schema()) LOOP
        EXECUTE 'ALTER TABLE ' || quote_ident(r.tablename) || ' DISABLE TRIGGER ALL';
    END LOOP;
END;
$$;

-- 2EME ETAPE : on vide toutes les tables
DO $$
DECLARE
    r RECORD;
BEGIN
    FOR r IN (SELECT tablename FROM pg_tables WHERE schemaname = current_schema()) LOOP
        EXECUTE 'TRUNCATE TABLE ' || quote_ident(r.tablename) || ' CASCADE';
    END LOOP;
END;
$$;

-- 3EME ETAPE : on réactive toutes les contraintes pour toutes les tables
DO $$
DECLARE
    r RECORD;
BEGIN
    FOR r IN (SELECT tablename FROM pg_tables WHERE schemaname = current_schema()) LOOP
        EXECUTE 'ALTER TABLE ' || quote_ident(r.tablename) || ' ENABLE TRIGGER ALL';
    END LOOP;
END;
$$;

COMMIT;