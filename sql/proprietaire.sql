USE pethouse;

CREATE TABLE IF NOT EXISTS proprietaire (
    id MEDIUMINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    prenom CHAR(30) NOT NULL,
    nom CHAR(30) NOT NULL,
    sexe ENUM('F','M','N') DEFAULT 'N',
    ddn DATE,
    adresse VARCHAR(60),
    tel VARCHAR(20),
    mail VARCHAR(60),
    photo LONGBLOB
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci
;