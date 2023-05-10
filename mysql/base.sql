CREATE TABLE
    IF NOT EXISTS 
    fichier (
        id INT NOT NULL ,
        obsw VARCHAR(100),
        bds VARCHAR(75),
        tv VARCHAR(50),
        dte VARCHAR(75),
        nomFic VARCHAR(75),
        PRIMARY KEY (id) 
    );
DROP TABLE IF EXISTS fichier;
DROP TABLE IF EXISTS trames;

CREATE TABLE
    IF NOT EXISTS trames(
        idTrame INT NOT NULL AUTO_INCREMENT,
        idFichier INT,
        dteT VARCHAR(75),
        b3 VARCHAR(50),
        b5 VARCHAR(50),
        size VARCHAR(50),
        macSource VARCHAR(20),
        macDest VARCHAR(20),
        f1 VARCHAR(50),
        f2 VARCHAR(50),
        f3 VARCHAR(50),
        f4 VARCHAR(50),
        f5 VARCHAR(50),
        f6 VARCHAR(50),
        f7 VARCHAR(50),
        macSender VARCHAR(20),
        ipSender VARCHAR(20),
        macTarget VARCHAR(20),
        ipTarget VARCHAR(20),
        ipSource VARCHAR(20),
        ipDest VARCHAR(20),
        f9 VARCHAR(50),
        f10 VARCHAR(50),
        f11 VARCHAR(50),
        f12 VARCHAR(50),
        f14 VARCHAR(50),
        f16 VARCHAR(50),
        f17 VARCHAR(50),
        f18 VARCHAR(50),
        f20 VARCHAR(50),
        f21 VARCHAR(50),
        f23 VARCHAR(50),
        f25 VARCHAR(50),
        f26 VARCHAR(50),
        f27 VARCHAR(50),
        f28 VARCHAR(50),
        f29 VARCHAR(50),
        f30 VARCHAR(50),
        f32 VARCHAR(50),
        pkDte VARCHAR(50),
        ft_6 VARCHAR(50),
        PRIMARY KEY (idTrame),
        FOREIGN KEY (idFichier) REFERENCES fichier(id)
);