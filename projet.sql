CREATE DATABASE projet_examen;
USE projet_examen;


-- Table pour les étudiants



CREATE TABLE etudiants (
  id_etudiant INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(50),
  firstname VARCHAR(50),
  email VARCHAR(100),
  password CHAR(255),
  validated ENUM('approved', 'pending'),
  level CHAR(10),
  UNIQUE KEY email_UNIQUE (email)
);

-- Table pour les professeurs
CREATE TABLE profs (
  id_prof INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(50),
  firstname VARCHAR(50),
  email VARCHAR(100),
  password VARCHAR(100),
  validated ENUM('approved', 'pending')
);

-- Table pour les modules
CREATE TABLE modules (
  id_module CHAR(10) NOT NULL,
  nom VARCHAR(255),
  id_prof INT,
  PRIMARY KEY (id_module),
  UNIQUE KEY id_module_UNIQUE (id_module),
  KEY id_prof (id_prof),
  CONSTRAINT module_ibfk_1 FOREIGN KEY (id_prof) REFERENCES profs (id_prof)
);

-- Table pour les notes
CREATE TABLE notes (
  id_note INT AUTO_INCREMENT PRIMARY KEY,
  id_etudiant INT,
  id_module CHAR(10),
  note DECIMAL(4,2),
  CONSTRAINT fk_notes_etudiant FOREIGN KEY (id_etudiant) REFERENCES etudiants (id_etudiant),
  CONSTRAINT fk_notes_module FOREIGN KEY (id_module) REFERENCES modules (id_module),
  CONSTRAINT uc_etudiant_module UNIQUE (id_etudiant, id_module)
);

-- Table pour l'emploi du temps
CREATE TABLE emploi_du_temps (
  id_emploi INT AUTO_INCREMENT PRIMARY KEY,
  id_module CHAR(10),
  jour DATE,
  heure_debut TIME,
  heure_fin TIME,
  salle VARCHAR(255),
  KEY id_module (id_module),
  CONSTRAINT emploi_du_temps_ibfk_1 FOREIGN KEY (id_module) REFERENCES modules (id_module)
);

-- Table pour les sessions étudiants
CREATE TABLE sessions_etudiants (
  id_session_etudiant CHAR(255) NOT NULL,
  id_etudiant INT,
  PRIMARY KEY (id_session_etudiant),
  KEY id_etudiant (id_etudiant),
  CONSTRAINT sessions_etudiants_ibfk_1 FOREIGN KEY (id_etudiant) REFERENCES etudiants (id_etudiant)
);

-- Table pour les sessions profs
CREATE TABLE sessions_profs (
  id_session_prof CHAR(255) NOT NULL,
  id_prof INT,
  PRIMARY KEY (id_session_prof),
  KEY id_prof (id_prof),
  CONSTRAINT sessions_profs_ibfk_1 FOREIGN KEY (id_prof) REFERENCES profs (id_prof)
);


--Creation de la table admin
CREATE TABLE admin (
  id_admin INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50),
  email VARCHAR(100),
  password CHAR(255),
  role ENUM('admin', 'moderator', 'superadmin')
);

CREATE TABLE admin_session(
  id_session_admin CHAR(255) PRIMARY KEY,
  id_admin INT,
  FOREIGN KEY (id_admin) REFERENCES admin (id_admin)
)