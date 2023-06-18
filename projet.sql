
CREATE DATABASE projet_examen;
USE projet_examen;

-- Table pour les étudiants
CREATE TABLE etudiant (
  id_etudiant INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(50),
  firstname VARCHAR(50),
  email VARCHAR(100),
  password CHAR(255),
  validated ENUM('approved', 'pending')
);


-- Table pour les professeurs
CREATE TABLE profs (
  id_prof INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(50),
  firstname VARCHAR(50),
  email VARCHAR(100),
  password VARCHAR(100),
  validated ENUM('approved', 'pending')
);

-- Table pour les modules
CREATE TABLE modules (
  id_module INT PRIMARY KEY AUTO_INCREMENT,
  nom VARCHAR(100),
  id_prof INT,
  FOREIGN KEY (id_prof) REFERENCES profs(id_prof)

);

-- Table pour les notes
CREATE TABLE notes (
  id_note INT PRIMARY KEY AUTO_INCREMENT,
  id_etudiant INT,
  id_module INT,
  note DECIMAL(4, 2),
  FOREIGN KEY (id_etudiant) REFERENCES etudiants(id_etudiant),
  FOREIGN KEY (id_module) REFERENCES modules(id_module)

);

-- Table pour l'emploi du temps
CREATE TABLE emploi_du_temps (
  id_emploi INT PRIMARY KEY AUTO_INCREMENT,
  id_module INT,
  salle VARCHAR(50),
  jour DATE,
  heure_debut TIME,
  heure_fin TIME,
  FOREIGN KEY (id_module) REFERENCES modules(id_module)

);

--session etudiants
CREATE TABLE session_etudiants (
    id_session_etudiant CHAR(255) PRIMARY KEY,
    id_etudiant,
    FOREIGN KEY (id_etudiant) REFERENCES etudiants(id_etudiant)
)

--session Profs
CREATE TABLE session_profs (
    id_session_prof CHAR(255) PRIMARY KEY,
    id_prof INT,
    FOREIGN KEY (id_prof) REFERENCES profs(id_prof)
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