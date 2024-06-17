#source D:/script18.sql;
/*          Folositi pentru cale simbolul "/", NU "\"         */ 
#source D:/TEODORA/ETTI AN 4/SEMESTRUL 1/BD/Proiect/PARTEA 1/de trimis/FINAL/script18.sql;

/*#############################################################*/
/*        PARTEA 1 - STERGEREA SI RECREAREA BAZEI DE DATE      */


#CREATE DATABASE hotelDB;
#USE hotelDB;

/*#############################################################*/




/*#############################################################*/
/*                  PARTEA 2 - CREAREA TABELELOR              */

CREATE TABLE tblClienti (
    IdClient SMALLINT(5) UNSIGNED PRIMARY KEY,
    numeClient VARCHAR(50),
    emailClient VARCHAR(50),
    nrTelClient VARCHAR(10)
);

CREATE TABLE tblRezervari (
    IdRezervare SMALLINT(5) UNSIGNED PRIMARY KEY,
    IdClientR SMALLINT(5) UNSIGNED, #cheia straina din tabelul Rezervari.
									#Aceasta refera la cheia primara IdClient a tabelului Clienti
    statusPlata VARCHAR(20), #statusul platii poate fi: "da", "nu", "in efectuare" 
    dataCheck_in DATETIME,
    dataCheck_out DATETIME,
    nrPersoane SMALLINT(3) UNSIGNED, #numarul de persoane pentru care se face rezervarea
    CONSTRAINT fk_IdClientR FOREIGN KEY (IdClientR) 
		REFERENCES tblClienti(IdClient)  ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE tblCamere (
    IdCamera SMALLINT(5) UNSIGNED PRIMARY KEY,
    seif VARCHAR(2), #am ales varchar 2 pt. ca putem specifica prin "DA" sau "NU" 
					 #daca intr-o camera exista sau nu un seif
	#aceleasi justificari si pt atributele AC(aer conditionat), TV(televizor),WiFi,minibar,balcon 				 
    AC VARCHAR(2),
    TV VARCHAR(2),
    WiFi VARCHAR(2),
    minibar VARCHAR(2),
	balcon VARCHAR(2),
    tipCamera VARCHAR(10),#tipul camerei va fi una din variantele: single,double,apartament
    pretCurentCamera DECIMAL(10, 2),
    disponibilitate VARCHAR(2)#camera disponibila -> "DA"; nedisponibila -> "NU"
);

CREATE TABLE tblServicii (
    IdServiciu SMALLINT(5) UNSIGNED PRIMARY KEY,
    numeServiciu VARCHAR(20), #serviciul poate fi:restaurant,piscina,sala de Fitness,curatenie,sala de conferinte,room service,spa,teren de tenis, jocuri pentru copii,transfer aeroport
    pretCurentServiciu DECIMAL(10, 2)
);

CREATE TABLE tblDepartamente (
    IdDepartament SMALLINT(5) PRIMARY KEY,
    tipDepartament VARCHAR(20)#departamentele sunt:Bucatarie,Servire Clienti,Pool oversight,Instructaj fitness,Curatenie,Management,Receptie,Wellness,
	#Paza teren de tenis, Divertisment
);


CREATE TABLE tblSalariati (
    IdSalariat SMALLINT(5) UNSIGNED PRIMARY KEY,
	numeSalariat VARCHAR(50),
	nrTelSalariat VARCHAR(10),
    departament SMALLINT(5),
    CONSTRAINT fk_dep FOREIGN KEY (departament) 
		REFERENCES tblDepartamente(IdDepartament) ON DELETE CASCADE ON UPDATE CASCADE
);


CREATE TABLE tblAsociere_Rezervari_Camere (
    IdRezervare_ARC SMALLINT(5) UNSIGNED,
    IdCamera_ARC SMALLINT(5) UNSIGNED,
    pretPerNoapte DECIMAL(10, 2),
    CONSTRAINT fk_idRezervArc FOREIGN KEY (IdRezervare_ARC) 
		REFERENCES tblRezervari(IdRezervare)ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_idCamArc FOREIGN KEY (IdCamera_ARC) 
		REFERENCES tblCamere(IdCamera)ON DELETE CASCADE ON UPDATE CASCADE,
    PRIMARY KEY (IdRezervare_ARC, IdCamera_ARC)
);

CREATE TABLE tblAsociereTripla (
    IdRezervare_Asoc_tripla SMALLINT(5) UNSIGNED,
    IdCamera_Asoc_tripla SMALLINT(5) UNSIGNED,
    IdServiciu_Asoc_tripla SMALLINT(5) UNSIGNED,
	pretPlatit DECIMAL(10, 2),
    CONSTRAINT fk_constr_asoc_tripla_1 FOREIGN KEY (IdRezervare_Asoc_tripla, IdCamera_Asoc_tripla) 
		REFERENCES tblAsociere_Rezervari_Camere(IdRezervare_ARC, IdCamera_ARC)ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_constr_asoc_tripla_2 FOREIGN KEY (IdServiciu_Asoc_tripla) 
		REFERENCES tblServicii(IdServiciu)ON DELETE CASCADE ON UPDATE CASCADE,
    PRIMARY KEY (IdRezervare_Asoc_tripla, IdCamera_Asoc_tripla, IdServiciu_Asoc_tripla)
);

CREATE TABLE tblOferite_De (
    IdServiciu_oferit SMALLINT(5) UNSIGNED,
    IdSalariat_oferit SMALLINT(5) UNSIGNED,
    CONSTRAINT fk_serviciu_oferit FOREIGN KEY (IdServiciu_oferit) 
		REFERENCES tblServicii(IdServiciu)ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT fk_salariat_oferit FOREIGN KEY (IdSalariat_oferit) 
		REFERENCES tblSalariati(IdSalariat)ON DELETE CASCADE ON UPDATE CASCADE,
    PRIMARY KEY (IdServiciu_oferit, IdSalariat_oferit)
);
/*#############################################################*/




/*#############################################################*/
/*         PARTEA 3 - INSERAREA INREGISTRARILOR IN TABELE      */

#pentru tblClienti sunt introduse urmatoarele inregistrari:

INSERT INTO tblClienti VALUES(1,"Geo Dumitrescu","geo.dumitrescu@gmail.com","0770699365");
INSERT INTO tblClienti VALUES(2,"Teodora Oprea","teodora.oprea@gmail.com","0770675363");
INSERT INTO tblClienti VALUES(3,"Ana Dobroiu","ana.dobroiu@gmail.com","0770899264");
INSERT INTO tblClienti VALUES(4,"Andrei Anghel","andrei.anghel@gmail.com","0723100162");
INSERT INTO tblClienti VALUES(5,"Oana Milea","oana.milea@gmail.com","0745104168");
INSERT INTO tblClienti VALUES(6,"Denisa Iordache","denisa.iordache@gmail.com","0785258350");
INSERT INTO tblClienti VALUES(7,"Tudor Branet","tudor.branet@gmail.com","0727255147");
INSERT INTO tblClienti VALUES(8,"Alexandra Bobocu","alexandra.bobocu@gmail.com","0755987456");
INSERT INTO tblClienti VALUES(9,"Dorin Manea","dorin.manea@gmail.com","0770728523");
INSERT INTO tblClienti VALUES(10,"Teodor Guluta","teodor.guluta@gmail.com","0752288196");
INSERT INTO tblClienti VALUES(11,"Amina Suciu","amina.suciu@gmail.com","0734442141");
INSERT INTO tblClienti VALUES(12,"Elena Cadar","elena.cadar@gmail.com","0747656946");
INSERT INTO tblClienti VALUES(13,"Alexandra Hriscu","alexandra.hriscu@gmail.com","0770300155");
INSERT INTO tblClienti VALUES(14,"Alina Duschina","alina.duschina@gmail.com","0729884241");
INSERT INTO tblClienti VALUES(15,"Ionela Tomuta","ionela.tomuta@gmail.com","0729884241");
INSERT INTO tblClienti VALUES(16,"Anca Ciolpan","anca.ciolpan@gmail.com","0777309100");
INSERT INTO tblClienti VALUES(17,"Cosmina Florescu","cosmina.florescu@gmail.com","0720973873");
INSERT INTO tblClienti VALUES(18,"Iulia Meisan","iulia.meisan@gmail.com","0723875105");
INSERT INTO tblClienti VALUES(19,"Francesca Constantinescu","francesca.constantinescu@gmail.com","0711300117");
INSERT INTO tblClienti VALUES(20,"Stefania Dicu","stefania.dicu@gmail.com","0790180444");


#pentru tblRezervari sunt introduse urmatoarele inregistrari:


INSERT INTO tblRezervari VALUES(1,1,"da","2023-10-29 14:00:00","2023-10-30 12:00:00",1);
INSERT INTO tblRezervari VALUES(2,1,"da","2023-12-05 15:30:00","2023-12-07 12:00:00",3);
INSERT INTO tblRezervari VALUES(3,2,"da","2023-11-01 18:00:00","2023-11-04 12:00:00",3);
INSERT INTO tblRezervari VALUES(4,3,"da","2023-11-29 18:00:00","2023-12-04 12:00:00",2);
INSERT INTO tblRezervari VALUES(5,2,"da","2024-03-02 14:30:00","2023-03-05 12:00:00",1);
INSERT INTO tblRezervari VALUES(6,4,"da","2024-03-07 19:00:00","2023-03-09 09:00:00",2);
INSERT INTO tblRezervari VALUES(7,5,"da","2024-04-30 17:00:00","2023-05-02 12:00:00",3);
INSERT INTO tblRezervari VALUES(8,6,"da","2023-12-22 15:00:00","2023-12-27 11:00:00",5);
INSERT INTO tblRezervari VALUES(9,7,"da","2023-12-30 15:00:00","2024-01-02 12:00:00",2);
INSERT INTO tblRezervari VALUES(10,7,"in efectuare","2024-02-25 14:00:00","2024-02-28 11:00:00",1);
INSERT INTO tblRezervari VALUES(11,8,"da","2024-04-25 20:30:00","2024-04-26 12:00:00",4);
INSERT INTO tblRezervari VALUES(12,9,"da","2024-06-01 17:15:00","2024-06-02 09:00:00",2);
INSERT INTO tblRezervari VALUES(13,8,"da","2024-07-12 14:00:00","2024-07-20 12:00:00",3);
INSERT INTO tblRezervari VALUES(14,10,"da","2024-04-01 15:45:00","2024-04-03 10:30:00",1);
INSERT INTO tblRezervari VALUES(15,11,"da","2024-09-19 16:30:00","2024-09-23 11:00:00",1);
INSERT INTO tblRezervari VALUES(16,12,"da","2024-10-05 16:00:00","2024-10-12 12:00:00",2);
INSERT INTO tblRezervari VALUES(17,8,"in efectuare","2024-08-17 15:00:00","2024-08-20 10:00:00",2);
INSERT INTO tblRezervari VALUES(18,13,"da","2024-11-18 14:00:00","2024-11-20 12:00:00",3);
INSERT INTO tblRezervari VALUES(19,14,"da","2024-12-05 16:40:00","2024-12-07 11:30:00",4);
INSERT INTO tblRezervari VALUES(20,15,"da","2024-12-30 16:00:00","2025-01-02 12:00:00",5);
INSERT INTO tblRezervari VALUES(21,16,"nu","2024-06-30 14:00:00","2024-07-01 12:00:00",1);
INSERT INTO tblRezervari VALUES(22,17,"da","2023-12-15 18:00:00","2023-12-17 12:00:00",1);
INSERT INTO tblRezervari VALUES(23,18,"in efectuare","2024-01-15 17:45:00","2024-01-17 11:00:00",3);
INSERT INTO tblRezervari VALUES(24,19,"da","2024-03-29 14:00:00","2024-03-30 09:00:00",2);
INSERT INTO tblRezervari VALUES(25,20,"da","2024-09-01 15:00:00","2024-09-19 12:00:00",3);
#INSERT INTO tblRezervari VALUES(26,1,"da","2025-09-01 15:00:00","2025-09-19 12:00:00",3);


#pentru tblCamere sunt introduse urmatoarele inregistrari:


INSERT INTO tblCamere VALUES(1,"DA","DA","DA","DA","DA","DA","single",300.00,"DA");
INSERT INTO tblCamere VALUES(2,"DA","DA","DA","DA","DA","NU","single",280.00,"DA");
INSERT INTO tblCamere VALUES(3,"DA","DA","DA","NU","DA","DA","single",290.00,"DA");
INSERT INTO tblCamere VALUES(4,"NU","DA","DA","DA","DA","DA","single",285.00,"DA");
INSERT INTO tblCamere VALUES(5,"DA","DA","DA","NU","DA","NU","single",270.00,"DA");
INSERT INTO tblCamere VALUES(6,"NU","DA","DA","DA","DA","NU","single",265.00,"DA");
INSERT INTO tblCamere VALUES(7,"NU","DA","DA","NU","DA","DA","single",275.00,"DA");

INSERT INTO tblCamere VALUES(8,"DA","DA","DA","DA","DA","DA","single",300.00,"NU");
INSERT INTO tblCamere VALUES(9,"DA","DA","DA","DA","DA","NU","single",280.00,"NU");
INSERT INTO tblCamere VALUES(10,"DA","DA","DA","NU","DA","DA","single",290.00,"NU");
INSERT INTO tblCamere VALUES(11,"NU","DA","DA","DA","DA","DA","single",285.00,"NU");
INSERT INTO tblCamere VALUES(12,"DA","DA","DA","NU","DA","NU","single",270.00,"NU");
INSERT INTO tblCamere VALUES(13,"NU","DA","DA","DA","DA","NU","single",265.00,"NU");
INSERT INTO tblCamere VALUES(14,"NU","DA","DA","NU","DA","DA","single",275.00,"NU");

INSERT INTO tblCamere VALUES(15,"DA","DA","DA","DA","DA","DA","double",450.00,"DA");
INSERT INTO tblCamere VALUES(16,"DA","DA","DA","DA","DA","NU","double",430.00,"DA");
INSERT INTO tblCamere VALUES(17,"DA","DA","DA","NU","DA","DA","double",440.00,"DA");
INSERT INTO tblCamere VALUES(18,"NU","DA","DA","DA","DA","DA","double",435.00,"DA");
INSERT INTO tblCamere VALUES(19,"DA","DA","DA","NU","DA","NU","double",420.00,"DA");
INSERT INTO tblCamere VALUES(20,"NU","DA","DA","DA","DA","NU","double",415.00,"DA");
INSERT INTO tblCamere VALUES(21,"NU","DA","DA","NU","DA","DA","double",425.00,"DA");

INSERT INTO tblCamere VALUES(22,"DA","DA","DA","DA","DA","DA","double",450.00,"NU");
INSERT INTO tblCamere VALUES(23,"DA","DA","DA","DA","DA","NU","double",430.00,"NU");
INSERT INTO tblCamere VALUES(24,"DA","DA","DA","NU","DA","DA","double",440.00,"NU");
INSERT INTO tblCamere VALUES(25,"NU","DA","DA","DA","DA","DA","double",435.00,"NU");
INSERT INTO tblCamere VALUES(26,"DA","DA","DA","NU","DA","NU","double",420.00,"NU");
INSERT INTO tblCamere VALUES(27,"NU","DA","DA","DA","DA","NU","double",415.00,"NU");
INSERT INTO tblCamere VALUES(28,"NU","DA","DA","NU","DA","DA","double",425.00,"NU");

INSERT INTO tblCamere VALUES(29,"DA","DA","DA","DA","DA","DA","apartament",560.00,"DA");
INSERT INTO tblCamere VALUES(30,"DA","DA","DA","DA","DA","NU","apartament",540.00,"DA");
INSERT INTO tblCamere VALUES(31,"DA","DA","DA","NU","DA","DA","apartament",550.00,"DA");
INSERT INTO tblCamere VALUES(32,"NU","DA","DA","DA","DA","DA","apartament",545.00,"DA");
INSERT INTO tblCamere VALUES(33,"DA","DA","DA","NU","DA","NU","apartament",530.00,"DA");
INSERT INTO tblCamere VALUES(34,"NU","DA","DA","DA","DA","NU","apartament",525.00,"DA");
INSERT INTO tblCamere VALUES(35,"NU","DA","DA","NU","DA","DA","apartament",535.00,"DA");

INSERT INTO tblCamere VALUES(36,"DA","DA","DA","DA","DA","DA","apartament",560.00,"NU");
INSERT INTO tblCamere VALUES(37,"DA","DA","DA","DA","DA","NU","apartament",540.00,"NU");
INSERT INTO tblCamere VALUES(38,"DA","DA","DA","NU","DA","DA","apartament",550.00,"NU");
INSERT INTO tblCamere VALUES(39,"NU","DA","DA","DA","DA","DA","apartament",545.00,"NU");
INSERT INTO tblCamere VALUES(40,"DA","DA","DA","NU","DA","NU","apartament",530.00,"NU");
INSERT INTO tblCamere VALUES(41,"NU","DA","DA","DA","DA","NU","apartament",525.00,"NU");
INSERT INTO tblCamere VALUES(42,"NU","DA","DA","NU","DA","DA","apartament",535.00,"NU");


#pentru tblServicii sunt introduse urmatoarele inregistrari:


INSERT INTO tblServicii VALUES(1,"Restaurant",120.00);
INSERT INTO tblServicii VALUES(2,"Piscina",80.00);
INSERT INTO tblServicii VALUES(3,"Sala de Fitness",50.00);
INSERT INTO tblServicii VALUES(4,"Curatenie",40.00);
INSERT INTO tblServicii VALUES(5,"Sala de conferinte",200.00);
INSERT INTO tblServicii VALUES(6,"Room service",30.00);
INSERT INTO tblServicii VALUES(7,"Spa",150.00);
INSERT INTO tblServicii VALUES(8,"Teren de tenis",70.00);
INSERT INTO tblServicii VALUES(9,"Jocuri pentru copii",50.00);
INSERT INTO tblServicii VALUES(10,"Transfer aeroport",60.00);


#pentru tblDepartamente sunt introduse urmatoarele inregistrari:


INSERT INTO tblDepartamente(IdDepartament,tipDepartament) VALUES(1,"Bucatarie");
INSERT INTO tblDepartamente(IdDepartament,tipDepartament) VALUES(2,"Servire clienti");
INSERT INTO tblDepartamente(IdDepartament,tipDepartament) VALUES(3,"Pool oversight");#Supraveghere piscina
INSERT INTO tblDepartamente(IdDepartament,tipDepartament) VALUES(4,"Instructaj fitness");
INSERT INTO tblDepartamente(IdDepartament,tipDepartament) VALUES(5,"Curatenie");
INSERT INTO tblDepartamente(IdDepartament,tipDepartament) VALUES(6,"Management");
INSERT INTO tblDepartamente(IdDepartament,tipDepartament) VALUES(7,"Receptie");
INSERT INTO tblDepartamente(IdDepartament,tipDepartament) VALUES(8,"Wellness");
INSERT INTO tblDepartamente(IdDepartament,tipDepartament) VALUES(9,"Paza teren de tenis");
INSERT INTO tblDepartamente(IdDepartament,tipDepartament) VALUES(10,"Divertisment");


#pentru tblSalariati sunt introduse urmatoarele inregistrari:


INSERT INTO tblSalariati VALUES(1,"Ioana Vlad","0770687463",1);
INSERT INTO tblSalariati VALUES(2,"Bianca Negoescu","0770688121",1);
INSERT INTO tblSalariati VALUES(3,"Catalina Braniste","0720123234",1);
INSERT INTO tblSalariati VALUES(4,"Costin Dumitrescu","0724199604",2);
INSERT INTO tblSalariati VALUES(5,"Serban Toma","0723641217",2);
INSERT INTO tblSalariati VALUES(6,"George Staiu","0723699213",2);
INSERT INTO tblSalariati VALUES(7,"Adrian Enache","0793131217",2);
INSERT INTO tblSalariati VALUES(8,"Bianca Vaduva","0773220100",3);
INSERT INTO tblSalariati VALUES(9,"Bogdan Vlad","0793654120", 4);
INSERT INTO tblSalariati VALUES(10,"Diana Vlasceanu","0733128239",5);
INSERT INTO tblSalariati VALUES(11,"Madalina Trifu","0711564009",5);
INSERT INTO tblSalariati VALUES(12,"Teodora Ghemu","0770699361",6);
INSERT INTO tblSalariati VALUES(13,"Cristi Radulescu","0746311239",7);
INSERT INTO tblSalariati VALUES(14,"Elena Radu","0795126331",7);
INSERT INTO tblSalariati VALUES(15,"Ana Ghincea","0793588972",8);
INSERT INTO tblSalariati VALUES(16,"Jean Popescu","0744533972",9);
INSERT INTO tblSalariati VALUES(17,"Magda Ionescu","0755533912",10);



#pentru tblAsociere_Rezervari_Camere sunt introduse urmatoarele inregistrari:


INSERT INTO tblAsociere_Rezervari_Camere(IdRezervare_ARC, IdCamera_ARC, pretPerNoapte) VALUES(1,1,300);
INSERT INTO tblAsociere_Rezervari_Camere(IdRezervare_ARC, IdCamera_ARC, pretPerNoapte) VALUES(2,29,610);
INSERT INTO tblAsociere_Rezervari_Camere(IdRezervare_ARC, IdCamera_ARC, pretPerNoapte) VALUES(3,30,540);
INSERT INTO tblAsociere_Rezervari_Camere(IdRezervare_ARC, IdCamera_ARC, pretPerNoapte) VALUES(4,15,550);
INSERT INTO tblAsociere_Rezervari_Camere(IdRezervare_ARC, IdCamera_ARC, pretPerNoapte) VALUES(5,1,300);
INSERT INTO tblAsociere_Rezervari_Camere(IdRezervare_ARC, IdCamera_ARC, pretPerNoapte) VALUES(6,15,500);
INSERT INTO tblAsociere_Rezervari_Camere(IdRezervare_ARC, IdCamera_ARC, pretPerNoapte) VALUES(7,29,610);
INSERT INTO tblAsociere_Rezervari_Camere(IdRezervare_ARC, IdCamera_ARC, pretPerNoapte) VALUES(8,29,710);
INSERT INTO tblAsociere_Rezervari_Camere(IdRezervare_ARC, IdCamera_ARC, pretPerNoapte) VALUES(9,15,550);
INSERT INTO tblAsociere_Rezervari_Camere(IdRezervare_ARC, IdCamera_ARC, pretPerNoapte) VALUES(10,2,280);
INSERT INTO tblAsociere_Rezervari_Camere(IdRezervare_ARC, IdCamera_ARC, pretPerNoapte) VALUES(11,31,540);
INSERT INTO tblAsociere_Rezervari_Camere(IdRezervare_ARC, IdCamera_ARC, pretPerNoapte) VALUES(12,15,500);
INSERT INTO tblAsociere_Rezervari_Camere(IdRezervare_ARC, IdCamera_ARC, pretPerNoapte) VALUES(13,35,535);
INSERT INTO tblAsociere_Rezervari_Camere(IdRezervare_ARC, IdCamera_ARC, pretPerNoapte) VALUES(14,7,275);
INSERT INTO tblAsociere_Rezervari_Camere(IdRezervare_ARC, IdCamera_ARC, pretPerNoapte) VALUES(15,6,265);
INSERT INTO tblAsociere_Rezervari_Camere(IdRezervare_ARC, IdCamera_ARC, pretPerNoapte) VALUES(16,16,430);
INSERT INTO tblAsociere_Rezervari_Camere(IdRezervare_ARC, IdCamera_ARC, pretPerNoapte) VALUES(17,21,425);
INSERT INTO tblAsociere_Rezervari_Camere(IdRezervare_ARC, IdCamera_ARC, pretPerNoapte) VALUES(18,34,525);
INSERT INTO tblAsociere_Rezervari_Camere(IdRezervare_ARC, IdCamera_ARC, pretPerNoapte) VALUES(19,29,610);
INSERT INTO tblAsociere_Rezervari_Camere(IdRezervare_ARC, IdCamera_ARC, pretPerNoapte) VALUES(20,29,710);
INSERT INTO tblAsociere_Rezervari_Camere(IdRezervare_ARC, IdCamera_ARC, pretPerNoapte) VALUES(21,5,270);
INSERT INTO tblAsociere_Rezervari_Camere(IdRezervare_ARC, IdCamera_ARC, pretPerNoapte) VALUES(22,4,285);
INSERT INTO tblAsociere_Rezervari_Camere(IdRezervare_ARC, IdCamera_ARC, pretPerNoapte) VALUES(23,32,545);
INSERT INTO tblAsociere_Rezervari_Camere(IdRezervare_ARC, IdCamera_ARC, pretPerNoapte) VALUES(24,18,435);
INSERT INTO tblAsociere_Rezervari_Camere(IdRezervare_ARC, IdCamera_ARC, pretPerNoapte) VALUES(25,33,530);
#INSERT INTO tblAsociere_Rezervari_Camere(IdRezervare_ARC, IdCamera_ARC, pretPerNoapte) VALUES(26,33,530);


#pentru tblAsociereTripla sunt introduse urmatoarele inregistrari:


INSERT INTO tblAsociereTripla(IdRezervare_Asoc_tripla,IdCamera_Asoc_tripla,IdServiciu_Asoc_tripla,pretPlatit) VALUES(1,1,1,120);
INSERT INTO tblAsociereTripla(IdRezervare_Asoc_tripla,IdCamera_Asoc_tripla,IdServiciu_Asoc_tripla,pretPlatit) VALUES(1,1,4,40);

INSERT INTO tblAsociereTripla(IdRezervare_Asoc_tripla,IdCamera_Asoc_tripla,IdServiciu_Asoc_tripla,pretPlatit) VALUES(2,29,1,140);
INSERT INTO tblAsociereTripla(IdRezervare_Asoc_tripla,IdCamera_Asoc_tripla,IdServiciu_Asoc_tripla,pretPlatit) VALUES(2,29,4,60);
INSERT INTO tblAsociereTripla(IdRezervare_Asoc_tripla,IdCamera_Asoc_tripla,IdServiciu_Asoc_tripla,pretPlatit) VALUES(2,29,9,70);

INSERT INTO tblAsociereTripla(IdRezervare_Asoc_tripla,IdCamera_Asoc_tripla,IdServiciu_Asoc_tripla,pretPlatit) VALUES(3,30,1,120);
INSERT INTO tblAsociereTripla(IdRezervare_Asoc_tripla,IdCamera_Asoc_tripla,IdServiciu_Asoc_tripla,pretPlatit) VALUES(3,30,4,40);
INSERT INTO tblAsociereTripla(IdRezervare_Asoc_tripla,IdCamera_Asoc_tripla,IdServiciu_Asoc_tripla,pretPlatit) VALUES(3,30,5,200);

INSERT INTO tblAsociereTripla(IdRezervare_Asoc_tripla,IdCamera_Asoc_tripla,IdServiciu_Asoc_tripla,pretPlatit) VALUES(4,15,1,140);
INSERT INTO tblAsociereTripla(IdRezervare_Asoc_tripla,IdCamera_Asoc_tripla,IdServiciu_Asoc_tripla,pretPlatit) VALUES(4,15,4,60);
INSERT INTO tblAsociereTripla(IdRezervare_Asoc_tripla,IdCamera_Asoc_tripla,IdServiciu_Asoc_tripla,pretPlatit) VALUES(4,15,6,50);
INSERT INTO tblAsociereTripla(IdRezervare_Asoc_tripla,IdCamera_Asoc_tripla,IdServiciu_Asoc_tripla,pretPlatit) VALUES(4,15,7,170);

INSERT INTO tblAsociereTripla(IdRezervare_Asoc_tripla,IdCamera_Asoc_tripla,IdServiciu_Asoc_tripla,pretPlatit) VALUES(5,1,1,120);
INSERT INTO tblAsociereTripla(IdRezervare_Asoc_tripla,IdCamera_Asoc_tripla,IdServiciu_Asoc_tripla,pretPlatit) VALUES(5,1,4,40);

INSERT INTO tblAsociereTripla(IdRezervare_Asoc_tripla,IdCamera_Asoc_tripla,IdServiciu_Asoc_tripla,pretPlatit) VALUES(6,15,1,140);
INSERT INTO tblAsociereTripla(IdRezervare_Asoc_tripla,IdCamera_Asoc_tripla,IdServiciu_Asoc_tripla,pretPlatit) VALUES(6,15,4,60);
INSERT INTO tblAsociereTripla(IdRezervare_Asoc_tripla,IdCamera_Asoc_tripla,IdServiciu_Asoc_tripla,pretPlatit) VALUES(6,15,7,170);

INSERT INTO tblAsociereTripla(IdRezervare_Asoc_tripla,IdCamera_Asoc_tripla,IdServiciu_Asoc_tripla,pretPlatit) VALUES(7,29,1,140);
INSERT INTO tblAsociereTripla(IdRezervare_Asoc_tripla,IdCamera_Asoc_tripla,IdServiciu_Asoc_tripla,pretPlatit) VALUES(7,29,6,50);
INSERT INTO tblAsociereTripla(IdRezervare_Asoc_tripla,IdCamera_Asoc_tripla,IdServiciu_Asoc_tripla,pretPlatit) VALUES(7,29,8,90);

INSERT INTO tblAsociereTripla(IdRezervare_Asoc_tripla,IdCamera_Asoc_tripla,IdServiciu_Asoc_tripla,pretPlatit) VALUES(8,29,1,140);
INSERT INTO tblAsociereTripla(IdRezervare_Asoc_tripla,IdCamera_Asoc_tripla,IdServiciu_Asoc_tripla,pretPlatit) VALUES(8,29,4,60);
INSERT INTO tblAsociereTripla(IdRezervare_Asoc_tripla,IdCamera_Asoc_tripla,IdServiciu_Asoc_tripla,pretPlatit) VALUES(8,29,6,50);

INSERT INTO tblAsociereTripla(IdRezervare_Asoc_tripla,IdCamera_Asoc_tripla,IdServiciu_Asoc_tripla,pretPlatit) VALUES(9,15,1,140);
INSERT INTO tblAsociereTripla(IdRezervare_Asoc_tripla,IdCamera_Asoc_tripla,IdServiciu_Asoc_tripla,pretPlatit) VALUES(9,15,6,50);
INSERT INTO tblAsociereTripla(IdRezervare_Asoc_tripla,IdCamera_Asoc_tripla,IdServiciu_Asoc_tripla,pretPlatit) VALUES(9,15,10,80);

INSERT INTO tblAsociereTripla(IdRezervare_Asoc_tripla,IdCamera_Asoc_tripla,IdServiciu_Asoc_tripla,pretPlatit) VALUES(10,2,4,40);

INSERT INTO tblAsociereTripla(IdRezervare_Asoc_tripla,IdCamera_Asoc_tripla,IdServiciu_Asoc_tripla,pretPlatit) VALUES(11,31,4,40);

INSERT INTO tblAsociereTripla(IdRezervare_Asoc_tripla,IdCamera_Asoc_tripla,IdServiciu_Asoc_tripla,pretPlatit) VALUES(12,15,1,140);
INSERT INTO tblAsociereTripla(IdRezervare_Asoc_tripla,IdCamera_Asoc_tripla,IdServiciu_Asoc_tripla,pretPlatit) VALUES(12,15,9,70);

INSERT INTO tblAsociereTripla(IdRezervare_Asoc_tripla,IdCamera_Asoc_tripla,IdServiciu_Asoc_tripla,pretPlatit) VALUES(13,35,1,120);
INSERT INTO tblAsociereTripla(IdRezervare_Asoc_tripla,IdCamera_Asoc_tripla,IdServiciu_Asoc_tripla,pretPlatit) VALUES(13,35,2,80);

INSERT INTO tblAsociereTripla(IdRezervare_Asoc_tripla,IdCamera_Asoc_tripla,IdServiciu_Asoc_tripla,pretPlatit) VALUES(14,7,1,120);

INSERT INTO tblAsociereTripla(IdRezervare_Asoc_tripla,IdCamera_Asoc_tripla,IdServiciu_Asoc_tripla,pretPlatit) VALUES(15,6,4,40);

INSERT INTO tblAsociereTripla(IdRezervare_Asoc_tripla,IdCamera_Asoc_tripla,IdServiciu_Asoc_tripla,pretPlatit) VALUES(16,16,1,120);

INSERT INTO tblAsociereTripla(IdRezervare_Asoc_tripla,IdCamera_Asoc_tripla,IdServiciu_Asoc_tripla,pretPlatit) VALUES(17,21,4,40);
INSERT INTO tblAsociereTripla(IdRezervare_Asoc_tripla,IdCamera_Asoc_tripla,IdServiciu_Asoc_tripla,pretPlatit) VALUES(17,21,2,80);

INSERT INTO tblAsociereTripla(IdRezervare_Asoc_tripla,IdCamera_Asoc_tripla,IdServiciu_Asoc_tripla,pretPlatit) VALUES(18,34,1,120);
INSERT INTO tblAsociereTripla(IdRezervare_Asoc_tripla,IdCamera_Asoc_tripla,IdServiciu_Asoc_tripla,pretPlatit) VALUES(18,34,3,50);

INSERT INTO tblAsociereTripla(IdRezervare_Asoc_tripla,IdCamera_Asoc_tripla,IdServiciu_Asoc_tripla,pretPlatit) VALUES(19,29,1,140);
INSERT INTO tblAsociereTripla(IdRezervare_Asoc_tripla,IdCamera_Asoc_tripla,IdServiciu_Asoc_tripla,pretPlatit) VALUES(19,29,4,60);
INSERT INTO tblAsociereTripla(IdRezervare_Asoc_tripla,IdCamera_Asoc_tripla,IdServiciu_Asoc_tripla,pretPlatit) VALUES(19,29,9,70);

INSERT INTO tblAsociereTripla(IdRezervare_Asoc_tripla,IdCamera_Asoc_tripla,IdServiciu_Asoc_tripla,pretPlatit) VALUES(20,29,1,140);
INSERT INTO tblAsociereTripla(IdRezervare_Asoc_tripla,IdCamera_Asoc_tripla,IdServiciu_Asoc_tripla,pretPlatit) VALUES(20,29,6,50);
INSERT INTO tblAsociereTripla(IdRezervare_Asoc_tripla,IdCamera_Asoc_tripla,IdServiciu_Asoc_tripla,pretPlatit) VALUES(20,29,10,80);

INSERT INTO tblAsociereTripla(IdRezervare_Asoc_tripla,IdCamera_Asoc_tripla,IdServiciu_Asoc_tripla,pretPlatit) VALUES(21,5,1,120);

INSERT INTO tblAsociereTripla(IdRezervare_Asoc_tripla,IdCamera_Asoc_tripla,IdServiciu_Asoc_tripla,pretPlatit) VALUES(22,4,4,40);

INSERT INTO tblAsociereTripla(IdRezervare_Asoc_tripla,IdCamera_Asoc_tripla,IdServiciu_Asoc_tripla,pretPlatit) VALUES(23,32,4,40);

INSERT INTO tblAsociereTripla(IdRezervare_Asoc_tripla,IdCamera_Asoc_tripla,IdServiciu_Asoc_tripla,pretPlatit) VALUES(24,18,1,120);

INSERT INTO tblAsociereTripla(IdRezervare_Asoc_tripla,IdCamera_Asoc_tripla,IdServiciu_Asoc_tripla,pretPlatit) VALUES(25,33,4,40);
#INSERT INTO tblAsociereTripla(IdRezervare_Asoc_tripla,IdCamera_Asoc_tripla,IdServiciu_Asoc_tripla,pretPlatit) VALUES(26,33,4,40);

#pentru tblOferite_De sunt introduse urmatoarele inregistrari:


INSERT INTO tblOferite_De VALUES(1,1);
INSERT INTO tblOferite_De VALUES(1,4);
INSERT INTO tblOferite_De VALUES(1,2);#Seriviciul Restaurant poate fi prestat atat de Ioana Vlad, cat si de Costin Dumitrescu si Bianca Negoescu

INSERT INTO tblOferite_De VALUES(10,12);
INSERT INTO tblOferite_De VALUES(5,12);#Teodora Ghemu, managerul hotelului se ocupa de serviciile intitulate Transfer aeroport si Sala de conferinte

INSERT INTO tblOferite_De VALUES(2,8);#salariatul Bianca Vaduva, apartinand departamentului Pool oversight, presteaza serviciul numit Piscina
#Cu alte cuvinte, ea se ocupa cu supravegherea piscinei

INSERT INTO tblOferite_De VALUES(3,9);#Bogdan Vlad este un angajat ce se ocupa cu instructajul pt Fitness

INSERT INTO tblOferite_De VALUES(4,10);
INSERT INTO tblOferite_De VALUES(4,11);#Diana Vlasceanu si Madalina Trifu se ocupa de curatenia in hotel

INSERT INTO tblOferite_De VALUES(6,13);#Cristi Radulescu din departamentul Receptie ofera serviciul Room service
INSERT INTO tblOferite_De VALUES(6,14);#Elena Radu din departamentul Receptie ofera serviciul Room service 

INSERT INTO tblOferite_De VALUES(7,15);#Ana Ghincea din departamentul Wellness ofera servicii Spa
INSERT INTO tblOferite_De VALUES(8,16);#Jean Popescu din departamentul Paza teren de tenis ofera serviciul Teren de tenis
INSERT INTO tblOferite_De VALUES(9,17);#Magda Ionescu din departamentul Divertisment ofera serviciul Jocuri pentru copii


/*#############################################################*/



/*#############################################################*/
/*  PARTEA 4 - VIZUALIZAREA STUCTURII BD SI A INREGISTRARILOR  */

DESCRIBE tblClienti;
DESCRIBE tblRezervari;
DESCRIBE tblCamere;
DESCRIBE tblServicii;
DESCRIBE tblDepartamente;
DESCRIBE tblSalariati;
DESCRIBE tblAsociere_Rezervari_Camere;
DESCRIBE tblAsociereTripla;
DESCRIBE tblOferite_De;


SELECT * FROM tblClienti;
SELECT * FROM tblRezervari;
SELECT * FROM tblCamere;
SELECT * FROM tblServicii;
SELECT * FROM tblDepartamente;
SELECT * FROM tblSalariati;
SELECT * FROM tblAsociere_Rezervari_Camere;
SELECT * FROM tblAsociereTripla;
SELECT * FROM tblOferite_De;


/*#############################################################*/




/* 
- Nu stergeti comentariile de mai sus

- REDENUMITI FISIERUL  scriptXX.sql astfel incat XX sa coincida cu numarul echipei de BD. Ex: script07.sql

- SCRIPTUL AR TREBUI SA POATA FI RULAT FARA NICI O EROARE!

- ATENTIE LA CHEILE STRAINE! Nu uitati sa modificati motorul de stocare pentru tabele, la InnoDB, pentru a functiona constrangerile de cheie straina (vezi laborator 1, pagina 16 - Observatie)

*/

/*
ALTER TABLE tblCamere
Add constraint check_seif CHECK(seif IN ('DA','NU')),
Add constraint check_AC CHECK(AC IN ('DA','NU')),
add constraint check_TV check(TV in ('DA','NU')),
add constraint check_WiFi check(WiFi in ('DA','NU')),
add constraint check_minibar check(minibar in ('DA','NU')),
add constraint check_balcon check(balcon in ('DA','NU')),
add constraint check_tipCamera check(tipCamera in ('single','double','apartament')),
add constraint check_disponibilitate check(disponibilitate in ('DA','NU'));

ALTER TABLE tblDepartamente
add constraint check_departament CHECK(tipDepartament IN('Bucatarie','Servire clienti','Pool oversight','Instructaj fitness','Curatenie','Management','Receptie','Wellness','Paza teren de tenis','Divertisment'));
 
ALTER TABLE tblRezervari
add constraint check_statusPlata check(statusPlata IN('da','nu','in efectuare'));
*/





SELECT * FROM tblRezervari WHERE IdClientR = 1;

#Selectarea detaliilor legate de rezervarile facute de catre clientul logat:

SELECT 
	tblClienti.numeClient,
	tblClienti.emailClient,
	tblClienti.nrTelClient,
    tblRezervari.statusPlata,
	tblRezervari.dataCheck_in,
	tblRezervari.dataCheck_out,	
	tblRezervari.nrPersoane,
    tblAsociere_Rezervari_Camere.pretPerNoapte, 
	tblCamere.seif,
	tblCamere.AC,
	tblCamere.TV,
	tblCamere.WiFi,
	tblCamere.minibar,
	tblCamere.balcon,
	tblCamere.tipCamera,
    tblCamere.pretCurentCamera, 
    tblCamere.disponibilitate, 
    tblAsociereTripla.pretPlatit, 
	tblServicii.numeServiciu,
    tblServicii.pretCurentServiciu
FROM tblRezervari 
JOIN tblAsociere_Rezervari_Camere ON tblRezervari.IdRezervare = tblAsociere_Rezervari_Camere.IdRezervare_ARC
JOIN tblCamere ON tblAsociere_Rezervari_Camere.IdCamera_ARC = tblCamere.IdCamera
JOIN tblAsociereTripla ON tblRezervari.IdRezervare = tblAsociereTripla.IdRezervare_Asoc_tripla
JOIN tblServicii ON tblAsociereTripla.IdServiciu_Asoc_tripla = tblServicii.IdServiciu
JOIN tblClienti ON tblRezervari.IdClientR = tblClienti.IdClient

WHERE tblRezervari.IdClientR = 1;


#TRIGGER pentru a avea un singur manager al hotelului, iar acela sa fie Teodora Ghemu

DELIMITER //

CREATE TRIGGER restrict_management_salaries 
BEFORE INSERT ON tblSalariati
FOR EACH ROW
BEGIN
    DECLARE dept_name VARCHAR(20);
    SELECT tipDepartament INTO dept_name 
    FROM tblDepartamente 
    WHERE IdDepartament = NEW.departament;
    
    IF dept_name = 'Management' AND NEW.numeSalariat != 'Teodora Ghemu' THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Nu poti adauga salariati in afara de Teodora Ghemu in departamentul de Management';
    END IF;
END;
//

DELIMITER ;

#Daca incerc sa scriu comanda de mai jos, o sa obtin o eroare deoarece managerul pe care vreau sa il inserez este diferit de Teodora Ghemu:
#INSERT INTO tblSalariati VALUES(18,"Ada Ion","0255533912",6);



#Pun INAINTE DE TRIGGER niste inserari care AR TREBUI SA MEARGA INSERATE, deoarece CAMERA ESTE DISPONIBILA:

INSERT INTO tblRezervari VALUES(26,1,"da","2025-09-01 15:00:00","2025-09-19 12:00:00",3);
SELECT * FROM tblRezervari;

INSERT INTO tblAsociere_Rezervari_Camere(IdRezervare_ARC, IdCamera_ARC, pretPerNoapte) VALUES(26,33,530);
SELECT * FROM tblAsociere_Rezervari_Camere;

INSERT INTO tblAsociereTripla(IdRezervare_Asoc_tripla,IdCamera_Asoc_tripla,IdServiciu_Asoc_tripla,pretPlatit) VALUES(26,33,4,40);
SELECT * FROM tblAsociereTripla;	
		



#Actualizarea disponibilitatii camerei pe baza rezervarilor existente:


UPDATE tblCamere 
JOIN tblAsociere_Rezervari_Camere ON tblCamere.IdCamera = tblAsociere_Rezervari_Camere.IdCamera_ARC
SET tblCamere.disponibilitate = 'NU';



		
#TRIGGER PENTRU tblRezervari, ca sa nu se suprapuna rezervarile ca perioada:

DELIMITER //

CREATE TRIGGER Prevenire_suprapunere_intervale_de_timp_pt_rezervari
BEFORE INSERT ON tblRezervari
FOR EACH ROW
BEGIN
    DECLARE nr_suprapuneri INT;

    SELECT COUNT(*) INTO nr_suprapuneri
    FROM tblRezervari
    WHERE (NEW.dataCheck_in BETWEEN dataCheck_in AND dataCheck_out
           OR NEW.dataCheck_out BETWEEN dataCheck_in AND dataCheck_out
           OR NEW.dataCheck_in <= dataCheck_in AND NEW.dataCheck_out >= dataCheck_out);

    IF nr_suprapuneri > 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Exista deja o rezervare care se suprapune cu aceasta perioada.';
    END IF;
END;
//

DELIMITER ;


DELIMITER //

CREATE TRIGGER Actualizare_disponibilitate_camera
AFTER INSERT ON tblAsociere_Rezervari_Camere
FOR EACH ROW
BEGIN
    UPDATE tblCamere
    SET disponibilitate = 'NU'
    WHERE IdCamera = NEW.IdCamera_ARC;
END;
//

DELIMITER ;





#Pun DUPA TRIGGER niste inserari care AR TREBUI SA MEARGA INSERATE, deoarece CAMERA ESTE DISPONIBILA:

INSERT INTO tblRezervari VALUES(27,1,"da","2025-08-01 15:00:00","2025-08-19 12:00:00",3);
SELECT * FROM tblRezervari;


INSERT INTO tblAsociere_Rezervari_Camere(IdRezervare_ARC, IdCamera_ARC, pretPerNoapte) VALUES(27,33,530);
SELECT * FROM tblAsociere_Rezervari_Camere;

##interogarea folosita pentru a vedea daca s-a modificat cum trebuie disponibilitatea camerei, adica daca functioneaza corect triggerul Actualizare_disponibilitate_camera :

SELECT tblAsociere_Rezervari_Camere.IdRezervare_ARC, tblAsociere_Rezervari_Camere.IdCamera_ARC, tblCamere.disponibilitate
FROM tblAsociere_Rezervari_Camere
JOIN tblCamere ON tblAsociere_Rezervari_Camere.IdCamera_ARC = tblCamere.IdCamera
WHERE tblAsociere_Rezervari_Camere.IdRezervare_ARC = 27;

/*
INSERT INTO tblAsociereTripla(IdRezervare_Asoc_tripla,IdCamera_Asoc_tripla,IdServiciu_Asoc_tripla,pretPlatit) VALUES(27,33,4,40);
SELECT * FROM tblAsociereTripla;
*/

/*
INSERT INTO tblAsociere_Rezervari_Camere(IdRezervare_ARC, IdCamera_ARC, pretPerNoapte) VALUES(27,33,530);
SELECT * FROM tblAsociere_Rezervari_Camere;
*/


/*
INSERT INTO tblAsociereTripla(IdRezervare_Asoc_tripla,IdCamera_Asoc_tripla,IdServiciu_Asoc_tripla,pretPlatit) VALUES(27,33,4,40);
SELECT * FROM tblAsociereTripla;	
*/


#Pun DUPA TRIGGER niste inserari care NU AR TREBUI SA MEARGA INSERATE, deoarece CAMERA ESTE INDISPONIBILA:

INSERT INTO tblRezervari VALUES(28,1,"da","2025-09-01 15:00:00","2025-09-19 12:00:00",3);
SELECT * FROM tblRezervari;#aici observam ca tblRezervari a ramas ca anterior, deoarece rezervarea cu IdRezervare=28 nu a fost introdusa


/*INSERT INTO tblAsociere_Rezervari_Camere(IdRezervare_ARC, IdCamera_ARC, pretPerNoapte) VALUES(28,33,530);
SELECT * FROM tblAsociere_Rezervari_Camere;
*/


INSERT INTO tblRezervari VALUES(29,1,"da","2025-09-02 15:00:00","2025-09-14 12:00:00",3);
SELECT * FROM tblRezervari;


INSERT INTO tblRezervari VALUES(30,1,"da","2025-08-01 15:00:00","2025-08-19 12:00:00",3);#asta e la fel cu 27-le
SELECT * FROM tblRezervari;





