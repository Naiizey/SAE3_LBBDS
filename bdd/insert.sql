Set schema 'sae3';


insert into sae3._compte ( nom_compte, prenom_compte, pseudo, email, mot_de_passe) values ('MonMDPcest', 'NEk5aHqcPYz3Ff5', 'testMotDePasseVisible', 'test@tst.de', '$2y$12$B.A15SakaoA9qzAV8bIHwefQyJ0LOQrH2HfJX0cT712w7jkxfkI6y');


INSERT INTO _compte (nom_compte, prenom_compte, pseudo, email, mot_de_passe) VALUES ('toast', 'deburn', 'test', 'test@gmail.com', 'test152687');
INSERT INTO _compte (nom_compte, prenom_compte, pseudo, email, mot_de_passe) VALUES ('illoutchine','nassima','nassima_illoutchine', 'nassima@gmail.com', 'test152687');
INSERT INTO _compte (nom_compte, prenom_compte, pseudo, email, mot_de_passe) VALUES ('moigne','tania','taniamoigne666999', 'temoigne@gmail.com', 'test152687');

INSERT INTO _adresse_facturation (nom_a, prenom_a, numero_rue, nom_rue, code_postal, ville, num_compte) VALUES ('Carpadies', 'Jean', 15, 'Rue de la paix', 75000, 'Paris', 1);
INSERT INTO _adresse_livraison (nom_a, prenom_a, numero_rue, nom_rue, code_postal, ville, infos_comp, num_compte) VALUES ('Carpadies', 'Jean', 15, 'Rue de la paix', 75000, 'Paris', 'Sous la poubelle bleue', 1);

INSERT INTO _tva VALUES (1);
INSERT INTO _tva VALUES (2);
INSERT INTO _tva VALUES (3);
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
VALUES (133,'coke',100,150,'carottes mures et bien juteuses provenant de la provance, excellent légume typiquement francais. Provenance: gouadeloupe', 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (133,'vins',10,15,'arottes mures et bien juteuses provenant de la provance, excellent légume typiquement francais. Provenance: gouadeloupe', '../ci4/public/image/produit/vins.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (134,'fines herbes',10,15,'rottes mures et bien juteuses provenant de la provance, excellent légume typiquement francais. Provenance: gouadeloupe', 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (134,'cannabis',10,15,'cultivé localement, produits de nos terroirs', 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (135,'nike',10,15,'ottes mures et bien juteuses provenant de la provance, excellent légume typiquement francais. Provenance: gouadeloupe', 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (135,'néo balances',10,15,'ttes mures et bien juteuses provenant de la provance, excellent légume typiquement francais. Provenance: gouadeloupe', 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (136,'gucchivenchi',10,15,'tes mures et bien juteuses provenant de la provance, excellent légume typiquement francais. Provenance: gouadeloupe', 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (136,'le coq pas sportif',10,15,'es mures et bien juteuses provenant de la provance, excellent légume typiquement francais. Provenance: gouadeloupe', 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (137,'canard',10,15,'s mures et bien juteuses provenant de la provance, excellent légume typiquement francais. Provenance: gouadeloupe', '../ci4/public/images/produit/canard.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (137,'33 tonnes',10,15,'mures et bien juteuses provenant de la provance, excellent légume typiquement francais. Provenance: gouadeloupe', 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (138,'RTX9090ti',10,15,'ures et bien juteuses provenant de la provance, excellent légume typiquement francais. Provenance: gouadeloupe', 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (138,'Ryzen -6000RX',10,15,'res et bien juteuses provenant de la provance, excellent légume typiquement francais. Provenance: gouadeloupe', 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (139,'cSamsung S22 (SS22)',10,15,'es et bien juteuses provenant de la provance, excellent légume typiquement francais. Provenance: gouadeloup', 'https://pbs.twimg.com/media/C3tBUxtUMAAgTPO?format=jpg&name=900x900e.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (140,'iphone 1',10,15,'s et bien juteuses provenant de la provance, excellent légume typiquement francais. Provenance: gouadeloupe', 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (140,'écran de cinéma',10,15,'et bien juteuses provenant de la provance, excellent légume typiquement francais. Provenance: gouadeloupe', '../ci4/public/images/produit/ecran_cinema.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (141,'JBL PRO',10,15,'t bien juteuses provenant de la provance, excellent légume typiquement francais. Provenance: gouadeloupe', 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (141,'running gag shoes',10,15,'bien juteuses provenant de la provance, excellent légume typiquement francais. Provenance: gouadeloupe', 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (142,'strap',10,15,'ien juteuses provenant de la provance, excellent légume typiquement francais. Provenance: gouadeloupe', 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (142,'péripatéticienne',10,15,'en juteuses provenant de la provance, excellent légume typiquement francais. Provenance: gouadeloup', 'https://media.sudouest.fr/2136676/1000x500/entree-bitche.jpg?v=1618309579e.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (143,'claymore',10,15,'n juteuses provenant de la provance, excellent légume typiquement francais. Provenance: gouadeloup','https://upload.wikimedia.org/wikipedia/commons/thumb/c/c1/US_M18a1_claymore_mine.jpg/280px-US_M18a1_claymore_mine.jpge.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (143,'rateau',10,15,'juteuses provenant de la provance, excellent légume typiquement francais. Provenance: gouadeloupe', '../ci4/public/images/produit/rateau.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (144,'bêche',10,15,'uteuses provenant de la provance, excellent légume typiquement francais. Provenance: gouadeloup','https://greensquare.fr/1160-large_default/fourche-beche-kent-and-stowe.jpge.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (144,'fraiseuse',10,15,'teuses provenant de la provance, excellent légume typiquement francais. Provenance: gouadeloupe', 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (145,'pilon',10,15,'euses provenant de la provance, excellent légume typiquement francais. Provenance: gouadeloupe', 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (145,'chadior',10,15,'uses provenant de la provance, excellent légume typiquement francais. Provenance: gouadeloupe', 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (146,'oréo',10,15,'ses provenant de la provance, excellent légume typiquement francais. Provenance: gouadeloupe', 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (146,'mousse anti vax',10,15,'es provenant de la provance, excellent légume typiquement francais. Provenance: gouadeloupe', 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (142,'détartreur pour dentition',10,15,'s provenant de la provance, excellent légume typiquement francais. Provenance: gouadeloupe', 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (142,'saut à pied non joint',10,15,'provenant de la provance, excellent légume typiquement francais. Provenance: gouadeloupe', 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (148,'missile javelin',1000,1500, 'très bon missile pour arrêter un T72, Attention à usage unique, provenance: ukraine','../ci4/public/images/produit/missile_javelin.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (148,'jour',10,15,'rovenant de la provance, excellent légume typiquement francais. Provenance: gouadeloupe', 'https://www.cdiscount.com/pdt2/3/0/1/1/700x700/auc1280000011013/rw/fraise.jpg', true, 10, 4.5, 5, true);
INSERT INTO _produit (code_sous_cat, intitule_prod, prix_ht, prix_ttc, description_prod, lien_image_prod, publication_prod, stock_prod,moyenne_note_prod,seuil_alerte_prod,alerte_prod)
VALUES (149,'hélicoptère apache',10000,15000,'héliocptère de fabrique américaine, configuration : 16 missiles hellfire, 1200 obus 30mm, Hydra 70 missile air sol (attention s''épuise très vite à l''usage): contact SAV', '../ci4/public/images/produit/helicoptere_apache.jpg', true, 10, 4.5, 5, true);


INSERT INTO _avis (contenu_av,id_prod,num_compte) VALUES ('franchement j''en suis très satisfait, rien à redire le missile fonctionne très bien, néammoins attention à la prénétration sur du blindage réactif: on sent bien la limite du produit car il explose à la surface en ne faisant que très peu de dégats',30,1);
INSERT INTO _avis (contenu_av,id_prod,num_compte) VALUES ('Je suis déçu, à chaque fois que je veux aller faire les courses avec mon produit le rotor se bloque à cause d''un manque de préchauffage, pas très pratique au quotidien',32,2);
INSERT INTO _avis (contenu_av,id_prod,num_compte) VALUES ('Performant mais a parfois des difficultés',30,1);


INSERT INTO _image_avis (num_avis, lien_image_avis) VALUES (1, 'https://floriangll.fr/Humour/Dark/Masterclass/Masterclass.gif');
INSERT INTO _image_avis (num_avis, lien_image_avis) VALUES (2, 'https://floriangll.fr/Humour/Light/Masterclass/Masterclass.gif');


-- INSERT INTO _panier (num_compte) VALUES (1);

INSERT INTO _panier_visiteur (date_suppression, token_cookie) VALUES ('2021-05-01', 'nqndbzuiodzb');
INSERT INTO _panier_visiteur (date_suppression, token_cookie) VALUES ('2021-05-01', 'jdolzdqdbuzo');

-- INSERT INTO _commande (num_commande, date_dep, date_arriv, etat_livraison, num_compte, id_a, id_adresse) VALUES ('12486','2022-10-23', '2022-10-30', 1, 2, 2, 2);

INSERT INTO _refere (qte_panier, id_prod, num_panier) VALUES (5, 18, 1);
INSERT INTO _refere (qte_panier, id_prod, num_panier) VALUES (1, 17, 1);
INSERT INTO _refere (qte_panier, id_prod, num_panier) VALUES (5, 18, 2);
INSERT INTO _refere (qte_panier, id_prod, num_panier) VALUES (5, 17, 2);

INSERT INTO _note (note_prod, id_prod, num_compte) VALUES (5, 18, 1);
INSERT INTO _note (note_prod, id_prod, num_compte) VALUES (3.75, 17, 1);
INSERT INTO _note (note_prod, id_prod, num_compte) VALUES (5, 18, 2);
-- INSERT INTO _note (note_prod, id_prod, num_compte) VALUES (3, 17, 1);

INSERT INTO _liste_souhait (id_prod, num_compte) VALUES (18, 1);
INSERT INTO _liste_souhait ( id_prod, num_compte) VALUES (17, 1);
INSERT INTO _liste_souhait ( id_prod, num_compte) VALUES (18, 2);
INSERT INTO _liste_souhait (id_prod, num_compte) VALUES (17, 2);
-- INSERT INTO _liste_souhait (etat_stock, id_prod, num_compte) VALUES (false, 18, 1);