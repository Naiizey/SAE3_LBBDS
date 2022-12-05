SET SCHEMA 'sae3';

insert into sae3._compte ( nom_compte, prenom_compte, pseudo, email, mot_de_passe) values ('MonMDPcest', 'NEk5aHqcPYz3Ff5', 'testMotDePasseVisible', 'test@tst.de', '$2y$12$B.A15SakaoA9qzAV8bIHwefQyJ0LOQrH2HfJX0cT712w7jkxfkI6y');


INSERT INTO _compte (nom_compte, prenom_compte, pseudo, email, mot_de_passe) VALUES ('toast', 'deburn', 'test', 'test@gmail.com', 'test152687');
INSERT INTO _compte (nom_compte, prenom_compte, pseudo, email, mot_de_passe) VALUES ('illoutchine','nassima','nassima_illoutchine', 'nassima@gmail.com', 'test152687');
INSERT INTO _compte (nom_compte, prenom_compte, pseudo, email, mot_de_passe) VALUES ('moigne','tania','taniamoigne666999', 'temoigne@gmail.com', 'test152687');

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
INSERT INTO _categorie(code_cat,libelle_cat, cat_tva) VALUES (123,'alimentaire',2);
INSERT INTO _sous_categorie(code_sous_cat,libelle_cat, code_cat) VALUES (131,'fruit',123);
INSERT INTO _sous_categorie(code_sous_cat,libelle_cat, code_cat) VALUES (132,'legumes',123);
INSERT INTO _sous_categorie(code_sous_cat,libelle_cat, code_cat) VALUES (133,'boissons',123);
INSERT INTO _sous_categorie(code_sous_cat,libelle_cat, code_cat) VALUES (134,'epicerie',123);

INSERT INTO _categorie(code_cat,libelle_cat, cat_tva) VALUES (124,'vetement',1);
INSERT INTO _sous_categorie(code_sous_cat,libelle_cat, code_cat) VALUES (135,'chaussures',124);
INSERT INTO _sous_categorie(code_sous_cat,libelle_cat, code_cat) VALUES (136,'vetements',124);
INSERT INTO _sous_categorie(code_sous_cat,libelle_cat, code_cat) VALUES (137,'accessoires',124);

INSERT INTO _categorie(code_cat,libelle_cat, cat_tva) VALUES (125,'electronique',2);
INSERT INTO _sous_categorie(code_sous_cat,libelle_cat, code_cat) VALUES (138,'informatique',125);
INSERT INTO _sous_categorie(code_sous_cat,libelle_cat, code_cat) VALUES (139,'telephonie',125);
INSERT INTO _sous_categorie(code_sous_cat,libelle_cat, code_cat) VALUES (140,'audiovisuel',125);

INSERT INTO _categorie(code_cat,libelle_cat, cat_tva) VALUES (126,'loisir',1);
INSERT INTO _sous_categorie(code_sous_cat,libelle_cat, code_cat) VALUES (141,'sport',126);
INSERT INTO _sous_categorie(code_sous_cat,libelle_cat, code_cat) VALUES (142,'loisir',126);
INSERT INTO _sous_categorie(code_sous_cat,libelle_cat, code_cat) VALUES (148,'jeux',126);

INSERT INTO _categorie(code_cat,libelle_cat, cat_tva) VALUES (127,'jardinage',2);
INSERT INTO _sous_categorie(code_sous_cat,libelle_cat, code_cat) VALUES (143,'jardinage',127);
INSERT INTO _sous_categorie(code_sous_cat,libelle_cat, code_cat) VALUES (144,'bricolage',127);

INSERT INTO _categorie(code_cat,libelle_cat, cat_tva) VALUES (128,'beaute',3);
INSERT INTO _sous_categorie(code_sous_cat,libelle_cat, code_cat) VALUES (145,'beaute',128);
INSERT INTO _sous_categorie(code_sous_cat,libelle_cat, code_cat) VALUES (146,'hygiene',128);

INSERT INTO _categorie(code_cat,libelle_cat, cat_tva) VALUES (130,'autre',3);
INSERT INTO _sous_categorie(code_sous_cat,libelle_cat, code_cat) VALUES (149,'artisanat',130);


INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (133,'Breizh cola x6',5,6,'Nouvelle boisson bretonne au cola, issue de d''une agrigulture bio éthique, bio responsable, bio consciente.', 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg', true, 15, 4.5, 5, true);
INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (133,'Vins',10,15,'Ensemble de vins dans une boite en bois qui agrémentera vos soirées ou repas.', '../ci4/public/image/produit/vins.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (134,'Fines herbes',5,6,'Herbes pour aggrémenter les plats comestibles. Accompagne très bien une côte de boeuf avec un verre de rouge.', 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg', true, 17, 4.5, 5, true);
INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (134,'Herbe à chat',10,12,'Cultivé localement, produits de nos terroirs', 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (135,'Néo balances',60,72,'Chaussures de sport et de villes parfaites pour toutes les situation. Imppecable pour se balader.', 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (137,'Canard',10,12,'Statue de jardin pour tous les adeptes de la collection des nains de jardin, agrémente efficacement tout type de jardin.', '../ci4/public/images/produit/canard.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (140,'Breizhphone 1',200,240,'Tout premier téléphone breton tactile, attention produit assez fragile et disposant d''une batterie limitée', 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (134,'Crêpes froment artisanales x12',3,3.6,'Lot de 12 crêpes froment artisanales, sans conservateurs. Provenance : Douarnenez', 'https://images.pexels.com/photos/10248807/pexels-photo-10248807.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1', true, 15, 4.5, 5, true);
INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (134,'Kouign-amann',5,6,'Plât emblématique de la bretagne, Kouign-amann 100% beurre idéal pour toute la famille. Provenance : Douarnenez', 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (136,'T-shirt marinière',10,12,'Classique et intemporel, ce t-shirt toujours à la mode s''accordera avec toutes vos tenues. Provenance : Brest', 'https://images.pexels.com/photos/10059111/pexels-photo-10059111.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1', true, 17, 4.5, 5, true);
INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (134,'Palet breton',10,15,'Biscuits traditionnels bretons, des gâteaux parfait pour vos pauses café. Provenance : Pont-Aven', 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (136,'Vareuse',40,48,'Veste bretonne issue de voiles de bateau. Provenance: Ouessant', 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (136,'Ciret jaune',100,120,'Parfait pour vous protéger du vent et de la pluie en bretagne, ce ciret sera votre meilleur compagnon pour vos jours en Bretagne. Provenance : Trégunc', 'https://images.pexels.com/photos/11421665/pexels-photo-11421665.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (136,'Drapeau Breton',5,6,'Avec cet indispensable pour tout Breton, vous pourrez le porter fièrement à n''importe quel évènement. Provenance : Pontivy', 'https://cdn.pixabay.com/photo/2016/11/20/08/22/breton-1842173_960_720.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (137,'Autocollant Bidouden',1,1.2,'Ce sticker à coller n''importe où comme sur votre voiture ou votre ordinateur est parfait pour partager votre passion pour la Bretagne. Provenance : Morlaix', 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.la-boutique-de-bretagne.fr%2Fautocollant-sticker-l-aise-breizh-noir-la-boutique-de-bretagne__p274819.html&psig=AOvVaw0OlcNuD6MZIG2qTZf9e-d6&ust=1670188558182000&source=images&cd=vfe&ved=0CBAQjRxqFwoTCLiF0K-v3vsCFQAAAAAdAAAAABAE', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (137,'Parapluie',10,12,'Indispensable pour vos séjours en Bretagne. Provenance : Rennes', 'https://cdn.pixabay.com/photo/2015/07/15/13/42/umbrella-846185_960_720.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (140,'Ecran de cinéma',1000,1200,'Ecran géant catodique qui permet de faire des diffusions de cassetes vhs.', '../ci4/public/images/produit/ecran_cinema.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (141,'JBL PRO',300,360,'Enceinte et audio player qui contient une compiliation des meilleurs passage de biniou lors des breizh fests.', 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (141,'Running gag shoes',50,60,'Chaussures farce et atrappes qui gènérent des son exotiques lors de leur utilisation.', 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (142,'Strap',5,6,'Petit scotch pour tenir n''importe quel objet sur toutes les surfaces', 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (142,'Attrape mouches',2,2.4,'Vous êtes ennuyé par les mouches, cet outil est fait pour vous !! Grace à ceci les insectes vont se pieger dedans avant de s''endormir pour un long sommeil.', 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (143,'Anti nuisible',10,12,'Outil fumigène écologique pour se débarrasser des insect qui attaquent les légumes du jardin.','https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (143,'Rateau',10,12,'Outil de jardinage pour permettre de récolter les feuilles du jardin.', '../ci4/public/images/produit/rateau.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (144,'Bêche',10,12,'Outil de jardinage qui va permettre de labourer son potager d''une manière efficace.','https://greensquare.fr/1160-large_default/fourche-beche-kent-and-stowe.jpge.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (144,'Fraiseuse',10,12,'Outil breton parfait pour enlever tige d''une fraise qui rappelons le n''est pas comestible.', 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (145,'Pilon',10,12,'Petit outil efficace pour faire de la cuisine ou des tisanes, parfait pour écraser soit même ses feuilles de thé.', 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (145,'Chadior',10,12,'Lorem ipsum, produit plutot inconnu du grand public mais qui en fait est incroyable.', 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (146,'Oréa',4,4.8,'Produit dérivé et revisité du célèbre buiscuit oréo mais revisité à la bretonne.', 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (142,'Saut à pied non joint',10,12,'Manuel sportif traditionnel de bretagne. Déja 12000 vente dans le finistère à Quimper.', 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (148,'Piquets de jardin',100,120, 'Très bon piquet pour arrêter des lapins, attention à usage unique, provenance : Bretagne.','../ci4/public/images/produit/missile_javelin.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (148,'Tarte campagnarde',8,9.6,'Carrotes, fromage, jambon, champigons. Produit incroyablement bon qui fond très bien en bouche.', 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (149,'Galets bretons',1000,1200,'Galets de fabrique bretonne, configuration : quarz 12%, calcaire 5%, granite 83%; galet certifié de provenance d''une plage de Perros Guirrec.', '../ci4/public/images/produit/helicoptere_apache.jpg', true, 10, 4.5, 5, true);


INSERT INTO _avis (contenu_av,id_prod,num_compte) VALUES ('franchement j''en suis très satisfait, rien à redire cde produit est vraiment très bien, j adore',30,1);
INSERT INTO _avis (contenu_av,id_prod,num_compte) VALUES ('qualité moyenne, à revoir',32,2);
INSERT INTO _avis (contenu_av,id_prod,num_compte) VALUES ('Performant mais à parfois des difficultés',30,1);


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

INSERT INTO _note (note_prod, id_prod, num_compte) VALUES (5, 18, 1);
INSERT INTO _note (note_prod, id_prod, num_compte) VALUES (3.75, 17, 1);
INSERT INTO _note (note_prod, id_prod, num_compte) VALUES (5, 18, 2);
-- INSERT INTO _note (note_prod, id_prod, num_compte) VALUES (3, 17, 1);

INSERT INTO _liste_souhait (id_prod, num_compte) VALUES (18, 1);
INSERT INTO _liste_souhait ( id_prod, num_compte) VALUES (17, 1);
INSERT INTO _liste_souhait ( id_prod, num_compte) VALUES (18, 2);
INSERT INTO _liste_souhait (id_prod, num_compte) VALUES (17, 2);
-- INSERT INTO _liste_souhait (etat_stock, id_prod, num_compte) VALUES (false, 18, 1);

-- trois insertions d'adresses
INSERT INTO _adresse (nom_a, prenom_a, numero_rue, nom_rue, code_postal, ville, comp_a1, comp_a2) VALUES ('Doe', 'John', 1, 'rue de la paix', 75000, 'Paris', 'Batiment A', 'Etage 1');
INSERT INTO _adresse (nom_a, prenom_a, numero_rue, nom_rue, code_postal, ville, comp_a1, comp_a2) VALUES ('Doe', 'Jane', 2, 'rue de la paix', 75000, 'Paris', 'Batiment B', 'Etage 2');
INSERT INTO _adresse (nom_a, prenom_a, numero_rue, nom_rue, code_postal, ville, comp_a1, comp_a2) VALUES ('hiller', 'adolphe', 3, 'rue de la guerre', 70000, 'lille', 'Batiment C', 'Etage 3');

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



INSERT INTO _panier_client (num_panier,num_compte) values (null,1);
INSERT INTO _refere (qte_panier, id_prod, num_panier) VALUES (2, 32, CURRVAL('sae3._panier_num_panier_seq'));

--10 insertions dans _commande (num_panier, num_commande, date_commande, date_expedition, date_plateformereg, date_plateformeloc, date_arriv, id_a, id_adresse)
INSERT INTO _commande VALUES (1,'1', '2018-01-01', null, null, null, null, 1);
INSERT INTO _commande VALUES (2,'2', '2018-01-01', '2018-01-01', '2018-01-01', null, null, 2);
INSERT INTO _commande VALUES (3,'3', '2018-01-01', '2018-01-01', '2018-01-01', '2018-01-01', '2018-01-01', 3);
INSERT INTO _commande VALUES (4,'4', '2018-01-01', '2018-01-01', '2018-01-01', '2018-01-01', '2018-01-01', 1);

--10 insertions dans _code_reduction
INSERT INTO _code_reduction (code_reduction, montant_reduction, pourcentage_reduction, date_debut, heure_debut, date_fin, heure_fin)
    VALUES  ('10EUROS!!!', 10, 0, '2022-01-01', '00:00:00', '2023-12-31', '23:59:59'),
            ('SOULEVE2EMETITRE', 0, 20, '2022-01-01', '00:00:00', '2023-12-31', '23:59:59'),
        ('5REDUC!!!', 5, 0, '2022-01-01', '00:00:00', '2023-12-31', '23:59:59'),
        ('ACHE2ETPAIE1', 0, 50, '2022-01-01', '00:00:00', '2023-12-31', '23:59:59'),
        ('EUROSREDUIT', 4, 0, '2022-01-01', '00:00:00', '2023-12-31', '23:59:59'),
        ('20PERCENT', 0, 20, '2022-01-01', '00:00:00', '2023-12-31', '23:59:59'),
        ('REDUIT10', 10, 0, '2022-01-01', '00:00:00', '2023-12-31', '23:59:59'),
        ('5EUROS', 5, 0, '2022-01-01', '00:00:00', '2023-12-31', '23:59:59'),
        ('25POURCENT', 0, 25, '2022-01-01', '00:00:00', '2023-12-31', '23:59:59'),
        ('10POURCEN', 0, 10, '2022-01-01', '00:00:00', '2023-12-31', '23:59:59');
