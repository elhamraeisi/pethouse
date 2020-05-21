USE PetHouse;

CREATE TABLE IF NOT EXISTS animal (
    id MEDIUMINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_proprietaire MEDIUMINT NOT NULL,
    id_generique MEDIUMINT NOT NULL,
    nom CHAR(32) NOT NULL,
    photo LONGBLOB,
    sexe ENUM('M','F'),
    ddn DATE,
    couleur CHAR(30),
    poids INT,
    vaccine TINYINT(1),
    identifie TINYINT(1),
    prix DECIMAL(10,2),
    disponibilite DATE,
    description VARCHAR(2048),
    insert_date DATE NOT NULL DEFAULT current_timestamp(),
    FOREIGN KEY (id_proprietaire) REFERENCES proprietaire(id) ON DELETE CASCADE,
    FOREIGN KEY (id_generique) REFERENCES generique(id) ON DELETE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
