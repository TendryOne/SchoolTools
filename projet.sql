
CREATE DATABASE projet_examen;
USE projet_examen;

-- Table pour les étudiants
CREATE TABLE `etudiants` (
  `id_etudiant` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` char(255) DEFAULT NULL,
  `validated` enum('approved','pending') DEFAULT NULL,
  `level` char(10) DEFAULT NULL,
  PRIMARY KEY (`id_etudiant`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) 


-- Table pour les professeurs
CREATE TABLE profs (
  id_prof INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(50),
  firstname VARCHAR(50),
  email VARCHAR(100),
  password VARCHAR(100),
  validated ENUM('approved', 'pending')
);

-- Table pour les module
CREATE TABLE `module` (
  `id_module` char(10) NOT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `id_prof` int DEFAULT NULL,
  PRIMARY KEY (`id_module`),
  UNIQUE KEY `id_module_UNIQUE` (`id_module`),
  KEY `id_prof` (`id_prof`),
  CONSTRAINT `module_ibfk_1` FOREIGN KEY (`id_prof`) REFERENCES `profs` (`id_prof`)
) 

-- Table pour les notes
CREATE TABLE `notes` (
  `id_note` int NOT NULL AUTO_INCREMENT,
  `id_etudiant` int DEFAULT NULL,
  `id_module` char(10) DEFAULT NULL,
  `note` decimal(4,2) DEFAULT NULL,
  PRIMARY KEY (`id_note`),
  UNIQUE KEY `uc_etudiant_module` (`id_etudiant`,`id_module`),
  KEY `fk_notes_module` (`id_module`),
  CONSTRAINT `fk_notes_etudiant` FOREIGN KEY (`id_etudiant`) REFERENCES `etudiants` (`id_etudiant`),
  CONSTRAINT `fk_notes_module` FOREIGN KEY (`id_module`) REFERENCES `module` (`id_module`)
) 

-- Table pour l'emploi du temps
CREATE TABLE `emploi_du_temps` (
  `id_emploi` int NOT NULL AUTO_INCREMENT,
  `id_module` char(10) DEFAULT NULL,
  `jour` date DEFAULT NULL,
  `heure_debut` time DEFAULT NULL,
  `heure_fin` time DEFAULT NULL,
  `salle` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_emploi`),
  KEY `id_module` (`id_module`),
  CONSTRAINT `emploi_du_temps_ibfk_1` FOREIGN KEY (`id_module`) REFERENCES `module` (`id_module`)
)

--session etudiants
CREATE TABLE `sessions_etudiants` (
  `id_session_etudiant` char(255) NOT NULL,
  `id_etudiant` int DEFAULT NULL,
  PRIMARY KEY (`id_session_etudiant`),
  KEY `id_etudiant` (`id_etudiant`),
  CONSTRAINT `sessions_etudiants_ibfk_1` FOREIGN KEY (`id_etudiant`) REFERENCES `etudiants` (`id_etudiant`)
) 

--session Profs
CREATE TABLE `profs` (
  `id_prof` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` char(255) DEFAULT NULL,
  `validated` enum('approved','pending') DEFAULT NULL,
  PRIMARY KEY (`id_prof`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) 

--Creation de la table admin
CREATE TABLE `admin` (
  `id_admin` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` char(255) DEFAULT NULL,
  `role` enum('admin','moderator','superadmin') DEFAULT NULL,
  PRIMARY KEY (`id_admin`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) 


CREATE TABLE `admin_session` (
  `id_session_admin` char(255) NOT NULL,
  `id_admin` int DEFAULT NULL,
  PRIMARY KEY (`id_session_admin`),
  KEY `id_admin` (`id_admin`),
  CONSTRAINT `admin_session_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`)
)