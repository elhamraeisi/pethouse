USE PetHouse;

CREATE TABLE IF NOT EXISTS utilisateur (
    id MEDIUMINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    prenom CHAR(30) NOT NULL,
    nom CHAR(30) NOT NULL,
    pass VARCHAR(50) NOT NULL,
    mail VARCHAR(60) NOT NULL,
    role INT DEFAULT(0)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci
;