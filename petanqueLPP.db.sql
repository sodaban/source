BEGIN TRANSACTION;
CREATE TABLE IF NOT EXISTS "adherents" (
	"id"	INTEGER,
	"nom"	TEXT,
	"prenom"	TEXT,
	"email"	TEXT,
	"date_inscription"	TEXT,
	"matricule"	INTEGER,
	PRIMARY KEY("id")
);
CREATE TABLE IF NOT EXISTS "tournois" (
	"id"	INTEGER,
	"nom"	TEXT,
	"date"	TEXT,
	"time"	TEXT,
	"nom_joueurs_max"	INT,
	"type"	TEXT,
	"etat"	INTEGER,
	PRIMARY KEY("id")
);
CREATE TABLE IF NOT EXISTS "participants" (
	"id"	INTEGER,
	"adherentId"	INTEGER,
	"tournoiId1"	INTEGER,
	"tournoiId2"	INTEGER,
	"tournoiId3"	INTEGER,
	"tournoiId4"	INTEGER,
	PRIMARY KEY("id")
);
INSERT INTO "adherents" VALUES (1,'Benaiche','Alexandre','','01/01/2024',1);
INSERT INTO "adherents" VALUES (2,'Benaiche','Tiffany','','01/01/2024',3);
INSERT INTO "adherents" VALUES (3,'Inthavong','Phone','','01/01/2024',58);
INSERT INTO "adherents" VALUES (4,'Perant','Patrick','','01/01/2024',44);
INSERT INTO "adherents" VALUES (5,'Prach','Olivier','','01/01/2024',59);
INSERT INTO "adherents" VALUES (6,'Zantinio','Joseph','','01/01/2024',88);
INSERT INTO "adherents" VALUES (7,'Di Tomaso','Leonard','','01/01/2024',87);
INSERT INTO "adherents" VALUES (8,'Terres','Philippe','','01/01/2024',22);
INSERT INTO "adherents" VALUES (9,'Blanchet','Martine','','01/01/2024',18);
INSERT INTO "adherents" VALUES (10,'Romero','Betty','','01/01/2024',2);
INSERT INTO "adherents" VALUES (11,'Croix','Rudy','','01/01/2024',5);
INSERT INTO "adherents" VALUES (12,'Tournier','Bernard','','01/01/2024',4);
INSERT INTO "adherents" VALUES (13,'Proietto','Antoine','','01/01/2024',19);
INSERT INTO "adherents" VALUES (14,'Lathierre','Georges','','01/01/2024',45);
INSERT INTO "adherents" VALUES (15,'Makni','Hamdi','','01/01/2024',53);
INSERT INTO "adherents" VALUES (16,'Dubar','Loïc','','01/01/2024',10);
INSERT INTO "adherents" VALUES (17,'Duez','Pierre','','01/01/2024',62);
INSERT INTO "adherents" VALUES (18,'Ferrand','Fabrice','','01/01/2024',12);
INSERT INTO "adherents" VALUES (19,'Guenot','Olivier','','01/01/2024',33);
INSERT INTO "adherents" VALUES (20,'Penicaud','Christophe','','01/01/2024',73);
INSERT INTO "adherents" VALUES (21,'André','Lysiane','','01/01/2024',36);
INSERT INTO "adherents" VALUES (22,'Dessain','Nobru','','01/01/2024',69);
INSERT INTO "adherents" VALUES (23,'Poisson','Jean-Michel','','01/01/2024',11);
INSERT INTO "adherents" VALUES (24,'Berthemet','Nicole','','01/01/2024',38);
INSERT INTO "adherents" VALUES (25,'Cheminet','Jean-Michel','','01/01/2024',49);
INSERT INTO "adherents" VALUES (26,'Fernandes','Maximiano','','01/01/2024',37);
INSERT INTO "adherents" VALUES (27,'Magnet','Emmanuel','','01/01/2024',50);
INSERT INTO "adherents" VALUES (28,'Audrain','Michel','','01/01/2024',83);
INSERT INTO "adherents" VALUES (29,'Millet','Caroline','','01/01/2024',52);
INSERT INTO "adherents" VALUES (30,'Daubord','Pascal','','01/01/2024',39);
INSERT INTO "adherents" VALUES (31,'Girardeau','Bruno','','01/01/2024',70);
INSERT INTO "adherents" VALUES (32,'Maquet','Nadine','','01/01/2024',13);
INSERT INTO "adherents" VALUES (33,'Ajay Coumar','Hiren','','01/01/2024',42);
INSERT INTO "adherents" VALUES (34,'Batmanian','joseph','','01/01/2024',6);
INSERT INTO "adherents" VALUES (35,'carrara','franco','','01/01/2024',7);
INSERT INTO "adherents" VALUES (36,'Cesaro','Jordan','','01/01/2024',8);
INSERT INTO "adherents" VALUES (37,'Besnard','Yves','','01/01/2024',9);
INSERT INTO "adherents" VALUES (38,'Lemoine','Alec','','01/01/2024',14);
INSERT INTO "adherents" VALUES (39,'Hulin','Richard','','01/01/2024',15);
INSERT INTO "adherents" VALUES (40,'Lathierre','Patrice','','01/01/2024',16);
INSERT INTO "adherents" VALUES (41,'Barrois','David','','01/01/2024',17);
INSERT INTO "adherents" VALUES (42,'Hennion Albert','Kim','','01/01/2024',20);
INSERT INTO "adherents" VALUES (43,'Defontaine','Michel','','01/01/2024',21);
INSERT INTO "adherents" VALUES (44,'Thorillon','Xavier','','01/01/2024',23);
INSERT INTO "adherents" VALUES (45,'Faulet','Franck','','01/01/2024',25);
INSERT INTO "adherents" VALUES (46,'Shapiro','Patricia','','01/01/2024',26);
INSERT INTO "adherents" VALUES (47,'Shapiro','Michael','','01/01/2024',27);
INSERT INTO "adherents" VALUES (48,'Voisin','Philippe','','01/01/2024',28);
INSERT INTO "adherents" VALUES (49,'Prot','Eric','','01/01/2024',29);
INSERT INTO "adherents" VALUES (50,'Armand De Lignon','Arny','','01/01/2024',30);
INSERT INTO "adherents" VALUES (51,'Delvert','Mthieu','','01/01/2024',31);
INSERT INTO "adherents" VALUES (52,'Loia','Jose','','01/01/2024',32);
INSERT INTO "adherents" VALUES (53,'Thibaud','Michele','','01/01/2024',34);
INSERT INTO "adherents" VALUES (54,'Tesson','Nicolas','','01/01/2024',35);
INSERT INTO "adherents" VALUES (55,'Castro','Manuel','','01/01/2024',40);
INSERT INTO "adherents" VALUES (56,'Gueguen','Valerie','','01/01/2024',41);
INSERT INTO "adherents" VALUES (57,'Le Ny','Sandrine','','01/01/2024',43);
INSERT INTO "adherents" VALUES (58,'THORILLON','Corinne','','01/01/2024',46);
INSERT INTO "adherents" VALUES (59,'Ruibal','Raphael','','01/01/2024',47);
INSERT INTO "adherents" VALUES (60,'Deniau','Genevieve','','01/01/2024',48);
INSERT INTO "adherents" VALUES (61,'Defontaine','Michel','','01/01/2024',51);
INSERT INTO "adherents" VALUES (62,'Malevre','Ludovic','','01/01/2024',54);
INSERT INTO "adherents" VALUES (63,'Legras','Laurence','','01/01/2024',55);
INSERT INTO "adherents" VALUES (64,'Lefevre','Romain','','01/01/2024',56);
INSERT INTO "adherents" VALUES (65,'Sliman','Samir','','01/01/2024',57);
INSERT INTO "adherents" VALUES (66,'Robert','Jean','','01/01/2024',60);
INSERT INTO "adherents" VALUES (67,'Cherie','Jean-claude','','01/01/2024',61);
INSERT INTO "adherents" VALUES (68,'Morand','Pascal','','01/01/2024',63);
INSERT INTO "adherents" VALUES (69,'Lubrano di ciccone','Christophe','','01/01/2024',64);
INSERT INTO "adherents" VALUES (70,'Decour','Eloise','','01/01/2024',65);
INSERT INTO "adherents" VALUES (71,'Di cufa','Franck','','01/01/2024',66);
INSERT INTO "adherents" VALUES (72,'Dembele','Siliman','','01/01/2024',67);
INSERT INTO "adherents" VALUES (73,'Comte-manager','Thierry','','01/01/2024',68);
INSERT INTO "adherents" VALUES (74,'Casteras','Jean-Francois','','01/01/2024',71);
INSERT INTO "adherents" VALUES (75,'Allard','Philippe','','01/01/2024',72);
INSERT INTO "adherents" VALUES (76,'Coulliais','Carole','','01/01/2024',74);
INSERT INTO "adherents" VALUES (77,'Pasquier','Eric','','01/01/2024',75);
INSERT INTO "adherents" VALUES (78,'Rognoni','Irani','','01/01/2024',76);
INSERT INTO "adherents" VALUES (79,'Marechal','thierry','','01/01/2024',77);
INSERT INTO "adherents" VALUES (80,'Periot','Guillaume','','01/01/2024',78);
INSERT INTO "adherents" VALUES (81,'Forget','Christophe','','01/01/2024',79);
INSERT INTO "adherents" VALUES (82,'Lluch','Marta','','01/01/2024',80);
INSERT INTO "adherents" VALUES (83,'Hatet','Estalle','','01/01/2024',81);
INSERT INTO "adherents" VALUES (84,'Dumoulin','Jean-claude','','01/01/2024',82);
INSERT INTO "adherents" VALUES (85,'Mangin','Pierre','','01/01/2024',84);
INSERT INTO "adherents" VALUES (86,'Bonnafous','Patrick','','01/01/2024',85);
INSERT INTO "adherents" VALUES (87,'Homp','Isabelle','','01/01/2024',89);
INSERT INTO "adherents" VALUES (88,'Shull','Eric','','01/01/2024',91);
INSERT INTO "adherents" VALUES (89,'Lack','Anne','','01/01/2024',92);
INSERT INTO "adherents" VALUES (90,'Beret','Fabyenn','','01/01/2024',93);
INSERT INTO "adherents" VALUES (91,'Raoult','Andrée','','01/01/2024',94);
INSERT INTO "adherents" VALUES (92,'Pin','Mathilde','','01/01/2024',95);
INSERT INTO "adherents" VALUES (93,'Senlis','Louis','','01/01/2024',96);
INSERT INTO "tournois" VALUES (1,'OLYMPIADES','22/09/2024','11h00',40,'Triplettes / Mélée',1);
INSERT INTO "tournois" VALUES (2,'OLYMPIADES','29/09/2024','14h00',30,'Triplettes / Mélée',1);
INSERT INTO "tournois" VALUES (4,'L''AUTOMNAL','13/10/2024','11h00',30,'Triplettes / Mélée',1);
INSERT INTO "tournois" VALUES (5,'TROPHEE DES CHAMPIONS','17/11/2024','11h00',20,'doublettes / Formée',0);
INSERT INTO "tournois" VALUES (6,'LIGUE DES CHAMPIONS','01/12/2024','11h00',30,'doubletes / Formée',0);
INSERT INTO "tournois" VALUES (7,'L''HIVERNAL','02/02/2025','11h00',30,'Triplettes / Mélée',0);
INSERT INTO "tournois" VALUES (8,'TROPHEE DES CHAMPIONS','16/03/2025','11h00',20,'doublettes / Formée',0);
INSERT INTO "tournois" VALUES (9,'LE PRINTANIER','06/04/2025','11h00',30,'Triplettes / Formée',0);
INSERT INTO "tournois" VALUES (10,'TROPHEE DES CHAMPIONS','18/05/2025','11h00',20,'doublettes / Formée',0);
INSERT INTO "tournois" VALUES (11,'L''ESTIVAL','15/06/2025','11h00',30,'Triplettes / Formée',0);
INSERT INTO "tournois" VALUES (12,'LE BONHEUR DES DAMES','06/07/2025','11h00',30,'Triplettes / Formée',0);
INSERT INTO "tournois" VALUES (13,'TROPHEE DES CHAMPIONS','07/09/2025','11h00',20,'doublettes / Formée',0);
INSERT INTO "tournois" VALUES (14,'L''AUTOMNAL','12/10/2025','11h00',30,'Triplettes / Mélée',0);
INSERT INTO "tournois" VALUES (15,'TROPHEE DES CHAMPIONS','16/11/2025','11h00',20,'doublettes / Formée',0);
INSERT INTO "tournois" VALUES (16,'LIGUE DES CHAMPIONS','07/12/2025','11h00',30,'doubletes / Formée',0);
COMMIT;
