CREATE DATABASE listepresence;

USE listepresence;

CREATE TABLE participant (
    id_participant INT AUTO_INCREMENT PRIMARY KEY,
    nom TEXT,
    prenom TEXT,
    telephone INT(10),
    email TEXT
);

CREATE TABLE activite (
    id_activite INT AUTO_INCREMENT PRIMARY KEY,
    intitule TEXT,
    jour DATE,
    formateur TEXT
);

CREATE TABLE inscription (
  id_inscription INT AUTO_INCREMENT PRIMARY KEY,
  id_participant INT,
  id_activite INT,
  FOREIGN KEY (id_participant) REFERENCES participant(id_participant),
  FOREIGN KEY (id_activite) REFERENCES activite(id_activite)
);


-- Ajout de la contrainte d'unicité sur la combinaison id_participant et id_activite
ALTER TABLE inscription
ADD CONSTRAINT UC_inscription UNIQUE (id_participant, id_activite);


/*
  //BD localhost
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "listepresence";
//
//
//
//  
  //BD db4free
        $servername = "db4free.net";
        $username = "japhet";
        $password = "jesuisjaphet";
        $dbname = "listepresence";
//
//
//
//  
  //BD 000webhost
        $servername = "databases.000webhost.com";
        $username = "id20855573_japhet";
        $password = "M@maman123";
        $dbname = "id20855573_japhet";


  
*/