--@block 
CREATE TABLE utilisateur(
    id_user INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    nom VARCHAR(50) NOT NULL ,
    prenom VARCHAR(50) NOT NULL,
    email VARCHAR(190) NOT NULL UNIQUE,
    mot_de_passe char(255) NOT NULL,
    url_photo VARCHAR(255),
    adresse VARCHAR(20)
);

--@block
CREATE TABLE commentaire(
    id_comment INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    contenu TEXT NOT NULL,
    id_user INT,
   CONSTRAINT FK_USER FOREIGN KEY (id_user) REFERENCES utilisateur(id_user)
);
--@block
CREATE TABLE likes(
    id_like INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    id_user INT,
    CONSTRAINT FK_L_USER FOREIGN KEY (id_user) REFERENCES utilisateur(id_user)
);
--@block
CREATE TABLE avis(
    id_avis INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    contenu TEXT NOT NULL,
    photo_url VARCHAR(255) ,
    id_user INT,
    id_comment INT,
    id_like INT,
    CONSTRAINT FK_COMMENT FOREIGN KEY (id_comment) REFERENCES commentaire(id_comment),
    CONSTRAINT FK_LIKE FOREIGN KEY (id_like) REFERENCES likes(id_like),
    CONSTRAINT FK_A_USER FOREIGN KEY (id_user) REFERENCES utilisateur(id_user)
);
--@block
ALTER TABLE commentaire 
ADD COLUMN id_avis INT, 
ADD CONSTRAINT FK_AVIS 
FOREIGN KEY (id_avis) 
REFERENCES avis(id_avis) ;
