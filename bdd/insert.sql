SET SCHEMA 'sae3';

insert into sae3._compte ( pseudo,email, mot_de_passe) values ( 'testMotDePasseVisible', 'test@tst.de', '$2y$12$B.A15SakaoA9qzAV8bIHwefQyJ0LOQrH2HfJX0cT712w7jkxfkI6y');

-- trois insertions d'adresses
INSERT INTO _adresse (nom_a, prenom_a, numero_rue, nom_rue, code_postal, ville, comp_a1, comp_a2) VALUES ('Doe', 'John', 1, 'rue de la paix', 75000, 'Paris', 'Batiment A', 'Etage 1');
INSERT INTO _adresse (nom_a, prenom_a, numero_rue, nom_rue, code_postal, ville, comp_a1, comp_a2) VALUES ('Doe', 'Jane', 2, 'rue de la paix', 75000, 'Paris', 'Batiment B', 'Etage 2');
INSERT INTO _adresse (nom_a, prenom_a, numero_rue, nom_rue, code_postal, ville, comp_a1, comp_a2) VALUES ('hiller', 'adolphe', 3, 'rue de la guerre', 70000, 'lille', 'Batiment C', 'Etage 3');

INSERT INTO _compte (pseudo, email, mot_de_passe) VALUES ( 'test', 'test@gmail.com', 'test152687');
INSERT INTO _compte ( pseudo, email, mot_de_passe) VALUES ('nassima_illoutchine', 'nassima@gmail.com', 'test152687');
INSERT INTO _compte ( pseudo, email, mot_de_passe) VALUES ('taniamoigne666999', 'temoigne@gmail.com', 'test152687');

INSERT INTO _compte ( pseudo, email, mot_de_passe) VALUES ('COBREC_0', 'cobrec@alizon.net', '$2y$12$B.A15SakaoA9qzAV8bIHwefQyJ0LOQrH2HfJX0cT712w7jkxfkI6y');

INSERT INTO _client(num_compte,nom_compte, prenom_compte) VALUES (1,'MonMDPcest', 'NEk5aHqcPYz3Ff5');
INSERT INTO _client(num_compte,nom_compte, prenom_compte) VALUES (2,'toast', 'deburn');
INSERT INTO _client(num_compte,nom_compte, prenom_compte) VALUES (3,'illoutchine', 'nassima');
INSERT INTO _client(num_compte,nom_compte, prenom_compte) VALUES (4,'moigne', 'tania');

INSERT INTO _vendeur  VALUES (5, '123456789', 'FR50123456789"', 'Bonjour, nous sommes la COBREC', 3, 'https://logo-marque.com/wp-content/uploads/2021/09/Hot-Wheels-Logo.png', currval('sae3._adresse_id_a_seq'));


INSERT INTO _tva VALUES (1,0.20);
INSERT INTO _tva VALUES (2,0.50);
INSERT INTO _tva VALUES (3,0.15);
/*
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
*/
INSERT INTO _categorie(code_cat,libelle_cat, cat_tva) VALUES (123,'Alimentaire',2);
INSERT INTO _sous_categorie(code_sous_cat,libelle_cat, code_cat) VALUES (131,'Fruits',123);
INSERT INTO _sous_categorie(code_sous_cat,libelle_cat, code_cat) VALUES (132,'Légumes',123);
INSERT INTO _sous_categorie(code_sous_cat,libelle_cat, code_cat) VALUES (133,'Boissons',123);
INSERT INTO _sous_categorie(code_sous_cat,libelle_cat, code_cat) VALUES (134,'Epicerie',123);

INSERT INTO _categorie(code_cat,libelle_cat, cat_tva) VALUES (124,'Vêtements',1);
INSERT INTO _sous_categorie(code_sous_cat,libelle_cat, code_cat) VALUES (135,'Chaussures',124);
INSERT INTO _sous_categorie(code_sous_cat,libelle_cat, code_cat) VALUES (136,'Vêtements',124);
INSERT INTO _sous_categorie(code_sous_cat,libelle_cat, code_cat) VALUES (137,'Accessoires',124);

INSERT INTO _categorie(code_cat,libelle_cat, cat_tva) VALUES (125,'Electronique',2);
INSERT INTO _sous_categorie(code_sous_cat,libelle_cat, code_cat) VALUES (138,'Informatique',125);
INSERT INTO _sous_categorie(code_sous_cat,libelle_cat, code_cat) VALUES (139,'Télephonie',125);
INSERT INTO _sous_categorie(code_sous_cat,libelle_cat, code_cat) VALUES (140,'Audiovisuel',125);

INSERT INTO _categorie(code_cat,libelle_cat, cat_tva) VALUES (126,'Loisir',1);
INSERT INTO _sous_categorie(code_sous_cat,libelle_cat, code_cat) VALUES (141,'Sport',126);
INSERT INTO _sous_categorie(code_sous_cat,libelle_cat, code_cat) VALUES (142,'Loisir',126);
INSERT INTO _sous_categorie(code_sous_cat,libelle_cat, code_cat) VALUES (148,'Jeux',126);

INSERT INTO _categorie(code_cat,libelle_cat, cat_tva) VALUES (127,'Jardinage',2);
INSERT INTO _sous_categorie(code_sous_cat,libelle_cat, code_cat) VALUES (143,'Jardinage',127);
INSERT INTO _sous_categorie(code_sous_cat,libelle_cat, code_cat) VALUES (144,'Bricolage',127);

INSERT INTO _categorie(code_cat,libelle_cat, cat_tva) VALUES (128,'Beauté',3);
INSERT INTO _sous_categorie(code_sous_cat,libelle_cat, code_cat) VALUES (145,'Beauté',128);
INSERT INTO _sous_categorie(code_sous_cat,libelle_cat, code_cat) VALUES (146,'Hygiène',128);

INSERT INTO _categorie(code_cat,libelle_cat, cat_tva) VALUES (130,'Autres',3);
INSERT INTO _sous_categorie(code_sous_cat,libelle_cat, code_cat) VALUES (149,'Artisanat',130);

--à partir de là, SANS PRODUIT

INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod,  publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod,num_compte)
VALUES (133,'Cola x6',5,6,'Nouvelle boisson bretonne au cola, issue de d''une agrigulture bio éthique, bio responsable, bio consciente.', true, 15, 4.5, 5, true,5);
INSERT INTO _image_prod(id_prod, lien_image,num_image)
VALUES (currval('sae3._produit_id_prod_seq'), 'https://images.pexels.com/photos/8879617/pexels-photo-8879617.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',0);
INSERT INTO _image_prod(id_prod, lien_image,num_image)
VALUES (currval('sae3._produit_id_prod_seq'), 'https://cdn.pixabay.com/photo/2017/09/20/18/00/ice-cubes-2769457_960_720.jpg',1);
INSERT INTO _image_prod(id_prod, lien_image,num_image)
VALUES (currval('sae3._produit_id_prod_seq'), 'https://cdn.pixabay.com/photo/2017/09/12/04/42/soft-drink-2741251_960_720.jpg',2);

INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod,  publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod,num_compte)
VALUES (133,'Vin rouge',10,15,'Ensemble de vins dans une boite en bois qui agrémentera vos soirées ou repas.', true, 10, 4.5, 5, true, 5);
INSERT INTO _image_prod(id_prod, lien_image,num_image)
VALUES (currval('sae3._produit_id_prod_seq'), 'https://images.pexels.com/photos/5086617/pexels-photo-5086617.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',0);
INSERT INTO _image_prod(id_prod, lien_image,num_image)
VALUES (currval('sae3._produit_id_prod_seq'), 'https://cdn.pixabay.com/photo/2016/07/26/16/16/wine-1543170_960_720.jpg',1);
INSERT INTO _image_prod(id_prod, lien_image,num_image)
VALUES (currval('sae3._produit_id_prod_seq'), 'https://fotomelia.com/wp-content/uploads/edd/2016/02/banque-d-images-gratuites-libre-de-droits-du-domaine-public-haute-d%C3%A9finition-164-1560x2224.jpg',2);

INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod,  publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod,num_compte)
VALUES (133,'Vin blanc',10,15,'Elaboré à partir de nos raisons blancs bretons, ce vin blanc est idéal pour vos dîner.', true, 10, 4.5, 5, true, 5);
INSERT INTO _image_prod(id_prod, lien_image, num_image)
VALUES (currval('sae3._produit_id_prod_seq'), 'https://images.pexels.com/photos/1123260/pexels-photo-1123260.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',0);
INSERT INTO _image_prod(id_prod, lien_image, num_image)
VALUES (currval('sae3._produit_id_prod_seq'), 'https://cdn.pixabay.com/photo/2017/09/26/16/44/wine-2789265_960_720.jpg',1);
INSERT INTO _image_prod(id_prod, lien_image, num_image)
VALUES (currval('sae3._produit_id_prod_seq'), 'https://cdn.pixabay.com/photo/2018/10/10/21/06/after-work-3738337_960_720.jpg',2);

INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod,  publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod,num_compte)
VALUES (134,'Fines herbes',5,6,'Herbes pour aggrémenter les plats comestibles. Accompagne très bien une côte de boeuf avec un verre de rouge.',  true, 17, 4.5, 5, true,5);
VALUES (133,'Vin blanc',10,15,'Elaboré à partir de nos raisons blancs bretons, ce vin blanc est idéal pour vos dîner.', true, 10, 4.5, 5, true, 5);
INSERT INTO _image_prod(id_prod, lien_image, num_image)
VALUES (currval('sae3._produit_id_prod_seq'), 'https://images.pexels.com/photos/105863/pexels-photo-105863.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',0);
INSERT INTO _image_prod(id_prod, lien_image, num_image)
VALUES (currval('sae3._produit_id_prod_seq'), 'https://fotomelia.com/wp-content/uploads/edd/2015/08/banque-d-images-et-photos-gratuites-libres-de-droits19-1560x1040.jpg',1);
INSERT INTO _image_prod(id_prod, lien_image, num_image)
VALUES (currval('sae3._produit_id_prod_seq'), 'https://fotomelia.com/wp-content/uploads/edd/2015/08/photo-libre-de-droit33-1560x1050.jpg',2);

INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod,  publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod,num_compte)
VALUES (134,'Herbe à chat',10,12,'Issue de nos cultures locales, ce produit rendra fou votre chat. Chat non fourni.', true, 10, 4.5, 5, true, 5);
INSERT INTO _image_prod(id_prod, lien_image, num_image)
VALUES (currval('sae3._produit_id_prod_seq'), 'https://static.vecteezy.com/system/resources/previews/008/118/057/non_2x/beautiful-adorable-leopard-color-cat-sleeping-on-the-grass-free-photo.jpg',0);
INSERT INTO _image_prod(id_prod, lien_image, num_image)
VALUES (currval('sae3._produit_id_prod_seq'), 'https://fotomelia.com/wp-content/uploads/2016/05/photos-gratuites-libres-de-droits-92-1560x975.jpg',1);
INSERT INTO _image_prod(id_prod, lien_image, num_image)
VALUES (currval('sae3._produit_id_prod_seq'), 'https://fotomelia.com/wp-content/uploads/edd/2016/02/banque-d-images-et-photos-gratuites-libres-de-droits-t%C3%A9l%C3%A9chargement-gratuits-85-1560x1040.jpg',2);

INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod,  publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod,num_compte)
VALUES (135,'Néo balances',60,72,'Chaussures de sport et de villes parfaites pour toutes les situations. Imppecable pour se balader.', true, 10, 4.5, 5, true, 5);
INSERT INTO _image_prod(id_prod, lien_image, num_image)
VALUES (currval('sae3._produit_id_prod_seq'), 'https://cdn.pixabay.com/photo/2020/01/06/13/24/womens-shoes-4745347_960_720.jpg',0);

INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod,  publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod,num_compte)
VALUES (137,'Canard',10,12,'Statue de jardin pour tous les adeptes de la collection des nains de jardin, agrémente efficacement tout type de jardin.', true, 10, 4.5, 5, true, 5);
INSERT INTO _image_prod(id_prod, lien_image, num_image)
VALUES (currval('sae3._produit_id_prod_seq'),'https://static.vecteezy.com/system/resources/previews/005/543/922/non_2x/decorative-decoration-in-the-form-of-a-duck-and-duckling-in-our-garden-free-photo.jpeg',0 );

INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod,  publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod,num_compte)
VALUES (140,'Breizhphone 1',200,240,'Tout premier téléphone breton tactile, attention produit assez fragile et disposant d''une batterie limitée', true, 10, 4.5, 5, true, 5);
INSERT INTO _image_prod(id_prod, lien_image, num_image)
VALUES (currval('sae3._produit_id_prod_seq'), 'https://static.vecteezy.com/system/resources/previews/002/078/414/non_2x/blank-phone-on-orange-free-photo.jpg',0);
INSERT INTO _image_prod(id_prod, lien_image, num_image)
VALUES (currval('sae3._produit_id_prod_seq'), 'https://fotomelia.com/wp-content/uploads/2017/11/images-gratuites-libres-de-droits-sur-le-site-fotomelia-16-1560x878.jpg',1);
INSERT INTO _image_prod(id_prod, lien_image, num_image)
VALUES (currval('sae3._produit_id_prod_seq'), 'https://fotomelia.com/wp-content/uploads/2019/05/smartphone-1560x1040.jpg',2);

INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod,  publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod,num_compte)
VALUES (134,'Crêpes froment artisanales x12',3,3.6,'Lot de 12 crêpes froment artisanales, sans conservateurs. Provenance : Douarnenez', true, 15, 4.5, 5, true, 5);
INSERT INTO _image_prod(id_prod, lien_image,num_image)
VALUES (currval('sae3._produit_id_prod_seq'), 'https://images.pexels.com/photos/10248807/pexels-photo-10248807.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',0);
INSERT INTO _image_prod(id_prod, lien_image,num_image)
VALUES (currval('sae3._produit_id_prod_seq'), 'https://fotomelia.com/wp-content/uploads/2022/06/20220604_180020-1560x878.jpg',1);
INSERT INTO _image_prod(id_prod, lien_image,num_image)
VALUES (currval('sae3._produit_id_prod_seq'), 'https://fotomelia.com/wp-content/uploads/edd/2016/01/banque-d-images-et-photos-gratuites-libres-de-droits-t%C3%A9l%C3%A9chargement-gratuits-144-336-1560x1261.jpg',2);

INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod,  publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod,num_compte)
VALUES (134,'Kouign-amann',5,6,'Plât emblématique de la bretagne, Kouign-amann 100% beurre idéal pour toute la famille. Provenance : Douarnenez', true, 10, 4.5, 5, true, 5);
INSERT INTO _image_prod(id_prod, lien_image,num_image)
VALUES (currval('sae3._produit_id_prod_seq'),'https://upload.wikimedia.org/wikipedia/commons/thumb/8/85/Kouignamann.JPG/1067px-Kouignamann.JPG?20080104141720',0 );
INSERT INTO _image_prod(id_prod, lien_image,num_image)
VALUES (currval('sae3._produit_id_prod_seq'),'https://fotomelia.com/wp-content/uploads/edd/2015/08/free-picture-creative-commons-download15-1560x1038.jpg',1);

INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod,  publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod,num_compte)
VALUES (136,'T-shirt marinière',10,12,'Classique et intemporel, ce t-shirt toujours à la mode s''accordera avec toutes vos tenues. Provenance : Brest', true, 17, 4.5, 5, true, 5);
INSERT INTO _image_prod(id_prod, lien_image,num_image)
VALUES (currval('sae3._produit_id_prod_seq'),'https://images.pexels.com/photos/10059111/pexels-photo-10059111.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',0);

INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod,  publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod,num_compte)
VALUES (134,'Palet breton',10,15,'Biscuits traditionnels bretons, des gâteaux parfaits pour vos pauses café. Provenance : Pont-Aven',  true, 10, 4.5, 5, true, 5);
INSERT INTO _image_prod(id_prod, lien_image,num_image)
VALUES (currval('sae3._produit_id_prod_seq'), 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg',0);

INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod,  publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod,num_compte)
VALUES (136,'Vareuse',40,48,'Veste bretonne issue de voiles de bateau. Provenance: Ouessant',true, 10, 4.5, 5, true, 5);
INSERT INTO _image_prod(id_prod, lien_image,num_image)
VALUES (currval('sae3._produit_id_prod_seq'), 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg',0);

INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod,  publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod,num_compte)
VALUES (136,'Ciret jaune',100,120,'Parfait pour vous protéger du vent et de la pluie en bretagne, ce ciret sera votre meilleur compagnon pour vos jours en Bretagne. Provenance : Trégunc', true, 10, 4.5, 5, true, 5);
INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod, num_compte)
VALUES (136,'Ciré jaune',100,120,'Parfait pour vous protéger du vent et de la pluie en bretagne, ce ciret sera votre meilleur compagnon pour vos jours en Bretagne. Provenance : Trégunc', true, 10, 4.5, 5, true, 5);
INSERT INTO _image_prod(id_prod, lien_image,num_image)
VALUES (currval('sae3._produit_id_prod_seq'),  'https://images.pexels.com/photos/11421665/pexels-photo-11421665.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',0);

INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod,  publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod,num_compte)
VALUES (136,'Drapeau Breton',5,6,'Cet indispensable que vous pourrez le porter fièrement à n''importe quel évènement. Provenance : Pontivy',true, 10, 4.5, 5, true, 5);
INSERT INTO _image_prod(id_prod, lien_image,num_image)
VALUES (currval('sae3._produit_id_prod_seq'),'https://cdn.pixabay.com/photo/2016/11/20/08/22/breton-1842173_960_720.jpg' , 0);

INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod,  publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod,num_compte)
VALUES (137,'Hameçon',1,1.2,'Parfait pour vos après midi à la pèche, ces hameçon sont prévu exprès pour les gros spécimen de poisson. Provenance : Morlaix', true, 10, 4.5, 5, true, 5);
INSERT INTO _image_prod(id_prod, lien_image ,num_image)
VALUES (currval('sae3._produit_id_prod_seq'), 'https://images.pexels.com/photos/4822289/pexels-photo-4822289.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1', 0);
INSERT INTO _image_prod(id_prod, lien_image ,num_image)
VALUES (currval('sae3._produit_id_prod_seq'), 'https://images.pexels.com/photos/4822295/pexels-photo-4822295.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1', 1);

INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod,  publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod,num_compte)
VALUES (137,'Parapluie',10,12,'Indispensable pour vos séjours en Bretagne. Provenance : Rennes', true, 10, 4.5, 5, true, 5);
INSERT INTO _image_prod(id_prod, lien_image,num_image)
VALUES (currval('sae3._produit_id_prod_seq'), 'https://cdn.pixabay.com/photo/2015/07/15/13/42/umbrella-846185_960_720.jpg' ,0);

INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod,  publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod,num_compte)
VALUES (140,'Ecran de cinéma',1000,1200,'Ecran géant cathodique qui permet de faire des diffusions de cassettes vhs.', true, 10, 4.5, 5, true, 5);
INSERT INTO _image_prod(id_prod, lien_image,num_image)
VALUES (currval('sae3._produit_id_prod_seq'),'https://images.pexels.com/photos/7513421/pexels-photo-7513421.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',0 );

INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod,  publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod,num_compte)
VALUES (141,'Tongues bretonnes',50,60,'Idéal pour la plage, ces tongues 100% bretonnes vous permettront d''éviter le sable dans les chaussures.', true, 10, 4.5, 5, true, 5);
INSERT INTO _image_prod(id_prod, lien_image,num_image)
VALUES (currval('sae3._produit_id_prod_seq'), 'https://cdn.pixabay.com/photo/2014/05/12/17/36/sandals-342672_960_720.jpg',0);

INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod,  publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod,num_compte)
VALUES (142,'Strap',5,6,'Petit scotch pour tenir n''importe quel objet sur toutes les surfaces', true, 10, 4.5, 5, true, 5);
INSERT INTO _image_prod(id_prod, lien_image,num_image)
VALUES (currval('sae3._produit_id_prod_seq'),  'https://static.vecteezy.com/system/resources/previews/007/789/648/non_2x/white-sport-tape-isolated-on-white-background-athletic-taping-porous-adhesive-tape-medical-tape-multipurpose-porous-tape-for-wound-care-and-sprain-first-aid-medical-supplies-sport-bandage-free-photo.jpg',0);

INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod,num_compte)
VALUES (142,'Plantes carnivores attrape mouches',2,2.4,'Vous êtes ennuyé par les mouches, cet lot de plantes carnivores est fait pour vous !', true, 10, 4.5, 5, true, 5);
INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod,  publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod,num_compte)
VALUES (142,'Plante carnivore attrape mouches',2,2.4,'Vous êtes ennuyé par les mouches, cet plante est faite pour vous !', true, 10, 4.5, 5, true, 5);
INSERT INTO _image_prod(id_prod, lien_image,num_image)
VALUES (currval('sae3._produit_id_prod_seq'), 'https://images.pexels.com/photos/2483389/pexels-photo-2483389.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1', 0);

INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod,  publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod,num_compte)
VALUES (143,'Anti nuisible',10,12,'Outil fumigène écologique pour se débarrasser des insectes qui attaquent les légumes du jardin.', true, 10, 4.5, 5, true, 5);
INSERT INTO _image_prod(id_prod, lien_image,num_image)
VALUES (currval('sae3._produit_id_prod_seq'),'https://static.vecteezy.com/system/resources/previews/006/588/373/non_2x/field-with-dry-grass-reeds-and-power-line-burns-with-a-strong-fire-free-photo.jpg', 0 );

INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod,  publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod,num_compte)
VALUES (143,'Rateau',10,12,'Outil de jardinage pour permettre de récolter les feuilles du jardin.', true, 10, 4.5, 5, true, 5);
INSERT INTO _image_prod(id_prod, lien_image,num_image)
VALUES (currval('sae3._produit_id_prod_seq'), 'https://static.vecteezy.com/system/resources/previews/008/200/211/non_2x/black-plastic-leaf-rake-on-green-grass-or-lawn-free-photo.jpg', 0);

INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod,  publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod,num_compte)
VALUES (144,'Bêche',10,12,'Outil de jardinage qui va permettre de labourer son potager d''une manière efficace.', true, 10, 4.5, 5, true, 5);
INSERT INTO _image_prod(id_prod, lien_image ,num_image)
VALUES (currval('sae3._produit_id_prod_seq'),'https://greensquare.fr/1160-large_default/fourche-beche-kent-and-stowe.jpge.jpg', 0);

INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod,  publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod,num_compte)
VALUES (144,'Fraiseuse',10,12,'Outil breton parfait pour enlever tige d''une fraise qui rappelons le, n''est pas comestible.', true, 10, 4.5, 5, true, 5);
INSERT INTO _image_prod(id_prod, lien_image ,num_image)
VALUES (currval('sae3._produit_id_prod_seq'), 'https://static.vecteezy.com/system/resources/previews/008/820/294/non_2x/cnc-milling-machine-with-metallic-end-mill-carbide-in-industrial-manufacture-factory-professional-cutting-tools-cutting-metal-technology-lathe-workshop-of-automotive-industry-for-auto-parts-free-photo.jpg', 0);

INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod,  publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod,num_compte)
VALUES (145,'Pilon',10,12,'Petit outil efficace pour faire de la cuisine ou des tisanes, parfait pour écraser soi-même ses feuilles de thé. Issu de granite de Perros-Guirec', true, 10, 4.5, 5, true, 5);
INSERT INTO _image_prod(id_prod, lien_image ,num_image)
VALUES (currval('sae3._produit_id_prod_seq'), 'https://static.vecteezy.com/system/resources/previews/011/041/405/non_2x/rock-mortar-and-pestle-on-white-background-free-photo.jpg', 0);

INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod,  publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod,num_compte)
VALUES (145,'Chadior',10,12,'Produit plutôt inconnu du grand public mais qui en fait est incroyable.', true, 10, 4.5, 5, true, 5);
INSERT INTO _image_prod(id_prod, lien_image ,num_image)
VALUES (currval('sae3._produit_id_prod_seq'), 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg',0);

INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod,  publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod,num_compte)
VALUES (146,'Oréa',4,4.8,'Produit dérivé et revisité du célèbre biscuit oréo mais revisité à la bretonne.',  true, 10, 4.5, 5, true, 5);
INSERT INTO _image_prod(id_prod, lien_image,num_image)
VALUES (currval('sae3._produit_id_prod_seq'), 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg', 0);

INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod,  publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod,num_compte)
VALUES (142,'Saut à pied non joint',10,12,'Manuel sportif traditionnel de bretagne. Déja 12000 ventes dans le finistère à Quimper.', true, 10, 4.5, 5, true, 5);
INSERT INTO _image_prod(id_prod, lien_image,num_image)
VALUES (currval('sae3._produit_id_prod_seq'), 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg',0);

INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod,  publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod,num_compte)
VALUES (148,'Piquets de jardin',100,120, 'Très bon piquet pour arrêter des lapins, attention à usage unique, provenance : Bretagne.', true, 10, 4.5, 5, true, 5);
INSERT INTO _image_prod(id_prod, lien_image, estinterne,num_image)
VALUES (currval('sae3._produit_id_prod_seq'), 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg', true,0);

INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod,  publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod,num_compte)
VALUES (148,'Tarte campagnarde',8,9.6,'Carrotes, fromage, jambon, champigons. Produit incroyablement bon qui fond très bien en bouche.',  true, 10, 4.5, 5, true, 5);
INSERT INTO _image_prod(id_prod, lien_image,num_image)
VALUES (currval('sae3._produit_id_prod_seq'), 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg',0);

INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod,  publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod,num_compte)
VALUES (149,'Galets bretons',1000,1200,'Galets de fabrique bretonne, configuration : quartz 12%, calcaire 5%, granite 83%; galet certifié de provenance d''une plage de Perros-Guirec.',  true, 10, 4.5, 5, true, 5);
INSERT INTO _image_prod(id_prod, lien_image,num_image)
VALUES (currval('sae3._produit_id_prod_seq'),'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg',0 );

-- (note_prod, id_prod, num_compte) VALUES (5, 18, 1);
INSERT INTO _note (note_prod, id_prod, num_compte) VALUES (3, 14, 1);
INSERT INTO _note (note_prod, id_prod, num_compte) VALUES (5, 12, 2);
INSERT INTO _note (note_prod, id_prod, num_compte) VALUES (3, 13, 1);

INSERT INTO _avis (contenu_av,id_note, date_av) VALUES ('Qualité moyenne, à revoir...',2, current_date);
INSERT INTO _avis (contenu_av,id_note,date_av) VALUES ('Performant mais a parfois des difficultés.',1, current_date);
INSERT INTO _reponse(contenu_rep,num_avis, date_rep) VALUES ('Qualité moyenne, à revoir...',1, current_date);


INSERT INTO _image_avis (num_avis, lien_image_avis) VALUES (1, 'https://floriangll.fr/Humour/Dark/Masterclass/Masterclass.gif');
INSERT INTO _image_avis (num_avis, lien_image_avis) VALUES (2, 'https://floriangll.fr/Humour/Light/Masterclass/Masterclass.gif');


-- INSERT INTO _panier (num_compte) VALUES (1);

INSERT INTO _panier_visiteur (num_panier,date_suppression, token_cookie) VALUES (1,'2021-05-01', 'nqndbzuiodzb');
INSERT INTO _panier_visiteur (num_panier,date_suppression, token_cookie) VALUES (2,'2021-05-01', 'jdolzdqdbuzo');

-- INSERT INTO _commande (num_commande, date_dep, date_arriv, etat_livraison, num_compte, id_a, id_adresse) VALUES ('12486','2022-10-23', '2022-10-30', 1, 2, 2, 2);

INSERT INTO _refere (qte_panier, id_prod, num_panier) VALUES (5, 18, 1);
INSERT INTO _refere (qte_panier, id_prod, num_panier) VALUES (1, 17, 1);
INSERT INTO _refere (qte_panier, id_prod, num_panier) VALUES (5, 18, 2);
INSERT INTO _refere (qte_panier, id_prod, num_panier) VALUES (3, 17, 5);



INSERT INTO _liste_souhait (id_prod, num_compte) VALUES (18, 1);
INSERT INTO _liste_souhait ( id_prod, num_compte) VALUES (17, 1);
INSERT INTO _liste_souhait ( id_prod, num_compte) VALUES (18, 2);
INSERT INTO _liste_souhait (id_prod, num_compte) VALUES (17, 2);
-- INSERT INTO _liste_souhait (etat_stock, id_prod, num_compte) VALUES (false, 18, 1);

-- 3 insertions d'adresses de livraison
INSERT INTO _adresse_livraison (infos_comp, id_a) VALUES ('infos complémentaires', 1);
INSERT INTO _adresse_livraison (infos_comp, id_a) VALUES ('infos complémentaires', 2);
INSERT INTO _adresse_livraison (infos_comp, id_a) VALUES ('infos complémentaires', 3);


-- 3 insertions d'adresses de facturation
INSERT INTO _adresse_facturation (id_a) VALUES ( 1);
INSERT INTO _adresse_facturation (id_a) VALUES ( 2);
INSERT INTO _adresse_facturation (id_a) VALUES ( 3);

INSERT INTO _recevoir_commande VALUES (1,1);
INSERT INTO _recevoir_commande VALUES (2,2);

INSERT INTO  _recevoir_facture VALUES (1, 1);
INSERT INTO  _recevoir_facture VALUES (2, 3);
INSERT INTO  _recevoir_facture VALUES (3, 2);




INSERT INTO _refere (qte_panier, id_prod, num_panier) VALUES (2, 32, CURRVAL('sae3._panier_num_panier_seq'));

--10 insertions dans _commande (num_compte, num_commande, date_commande, date_expedition, date_plateformereg, date_plateformeloc, date_arriv, id_a, id_adresse)
INSERT INTO _commande(num_compte, num_commande, date_commande, date_expedition, date_plateformereg, date_plateformeloc, date_arriv, id_a, id_reduction) VALUES (1,'1', '2023-02-01', null, null, null, null, 1, 3);
INSERT INTO _commande(num_compte, num_commande, date_commande, date_expedition, date_plateformereg, date_plateformeloc, date_arriv, id_a,id_reduction) VALUES (1,'2', '2022-12-01', '2022-12-02', '2022-12-05', null, null, 2, 2);
INSERT INTO _commande(num_compte, num_commande, date_commande, date_expedition, date_plateformereg, date_plateformeloc, date_arriv, id_a) VALUES (1,'3', '2022-07-22', '2022-07-23', '2022-07-27', '2022-07-29', '2022-07-30', 3);
INSERT INTO _commande(num_compte, num_commande, date_commande, date_expedition, date_plateformereg, date_plateformeloc, date_arriv, id_a,id_reduction) VALUES (1,'4', '2022-05-01', '2022-05-02', '2022-05-04', '2022-05-06', '2022-05-07', 1, 1);


INSERT INTO _refere_commande (qte_panier, id_prod, num_commande, prix_fixeettc) VALUES (5, 18, '1',12);
INSERT INTO _refere_commande (qte_panier, id_prod, num_commande, prix_fixeettc) VALUES (5, 18, '2',12);
INSERT INTO _refere_commande (qte_panier, id_prod, num_commande, prix_fixeettc) VALUES (1, 17, '3',1.2);
INSERT INTO _refere_commande (qte_panier, id_prod, num_commande, prix_fixeettc) VALUES (3, 17, '4',1.2);

-- 2 insertions dans _duree (date_debut, heure_debut, date_fin, heure_fin)
INSERT INTO _duree (date_debut, heure_debut, date_fin, heure_fin)
    VALUES  ('2022-01-01', '00:00:00', '2023-12-31', '23:59:59'),
        ('2022-11-25', '00:00:00', '2022-11-29','23:59:59');

--10 insertions dans _code_reduction
INSERT INTO _code_reduction (code_reduction, montant_reduction, pourcentage_reduction, id_duree)
    VALUES  ('10EUROS!!!', 10, 0, 1),
            ('SOULEVE2EMETITRE', 0, 20, 1),
        ('5REDUC!!!', 5, 0, 1),
        ('ACHE2ETPAIE1', 0, 50, 1),
        ('EUROSREDUIT', 4, 0, 1),
        ('20PERCENT', 0, 20, 1),
        ('REDUIT10', 10, 0, 1),
        ('5EUROS', 5, 0, 1),
        ('25POURCENT', 0, 25, 1),
        ('10POURCEN', 0, 10, 1);

INSERT INTO commentaires(id_prod,num_compte,note_prod,contenu_av) VALUES (18,1,3,'Pas fou');
INSERT INTO commentaires(id_prod,num_compte,note_prod,contenu_av) VALUES (17,2,1,'Je n''ai pas reçu mon produit...');
INSERT INTO commentaires(id_prod,num_compte,note_prod,contenu_av) VALUES (17,1,1,'Nul, ne fonctionne pas !');

INSERT INTO _signalement (raison, num_avis, num_compte) VALUES ('Cet avis n''apporte rien du tout, il ne justifie pas sa note.', 4, 1);
INSERT INTO _signalement (raison, num_avis, num_compte) VALUES ('Cet avis ne parle pas du produit', 5, 2);
    
 -- jusqu'ici

INSERT INTO _quidi VALUES (DEFAULT,1,5);