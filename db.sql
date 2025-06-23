-- 1. GÉOGRAPHIE

CREATE TABLE Pays (
    id_pays INT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL
);

CREATE TABLE Region (
    id_region INT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    id_pays INT NOT NULL,
    FOREIGN KEY (id_pays) REFERENCES Pays(id_pays)
);

CREATE TABLE Departement (
    id_dep INT PRIMARY KEY,
    nom VARCHAR(100),
    code VARCHAR(10),
    id_region INT NOT NULL,
    FOREIGN KEY (id_region) REFERENCES Region(id_region)
);

CREATE TABLE Ville (
    id_ville INT PRIMARY KEY,
    nom VARCHAR(100),
    code_postal VARCHAR(10),
    id_dep INT NOT NULL,
    FOREIGN KEY (id_dep) REFERENCES Departement(id_dep)
);

-- 2. CLIENTS & AUTHENTIFICATION

CREATE TABLE Client (
    id_client INT PRIMARY KEY,
    nom VARCHAR(100),
    prenom VARCHAR(100),
    genre CHAR(1),
    adresse VARCHAR(200),
    id_ville INT NOT NULL,
    FOREIGN KEY (id_ville) REFERENCES Ville(id_ville)
);

CREATE TABLE Utilisateur (
    id_utilisateur INT PRIMARY KEY,
    id_client INT UNIQUE NOT NULL,
    username VARCHAR(50) UNIQUE NOT NULL,
    mot_de_passe VARCHAR(255) NOT NULL,
    role VARCHAR(20) DEFAULT 'client',
    actif BOOLEAN DEFAULT TRUE,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_client) REFERENCES Client(id_client)
);

-- 3. RÉSERVATIONS & PASSAGERS

CREATE TABLE Reservation (
    id_reservation INT PRIMARY KEY,
    date_reservation DATE,
    assurance_annulation BOOLEAN,
    chambre_supplementaire BOOLEAN,
    id_client INT NOT NULL,
    FOREIGN KEY (id_client) REFERENCES Client(id_client)
);


CREATE TABLE Passager (
    id_passager INT PRIMARY KEY,
    nom VARCHAR(100),
    prenom VARCHAR(100),
    telephone VARCHAR(20),
    id_reservation INT NOT NULL,
    FOREIGN KEY (id_reservation) REFERENCES Reservation(id_reservation)
);

-- 4. TRANSPORT 


CREATE TABLE TypeAutocar (
    id_type INT PRIMARY KEY,
    nom_type VARCHAR(100),
    description TEXT
);

CREATE TABLE Autocar (
    id_autocar INT PRIMARY KEY,
    immatriculation VARCHAR(50),
    id_type INT NOT NULL,
    FOREIGN KEY (id_type) REFERENCES TypeAutocar(id_type)
);

CREATE TABLE Emplacement (
    id_emplacement INT PRIMARY KEY,
    numero INT NOT NULL,
    id_autocar INT NOT NULL,
    FOREIGN KEY (id_autocar) REFERENCES Autocar(id_autocar)
);

ALTER TABLE Passager
ADD id_emplacement INT NOT NULL,
ADD FOREIGN KEY (id_emplacement) REFERENCES Emplacement(id_emplacement);

-- 5. HÔTELLERIE

CREATE TABLE Hotel (
    id_hotel INT PRIMARY KEY,
    nom VARCHAR(100),
    adresse VARCHAR(200),
    id_ville INT,
    FOREIGN KEY (id_ville) REFERENCES Ville(id_ville)
);

-- 6. VOYAGES

CREATE TABLE Voyage (
    id_voyage INT PRIMARY KEY,
    libelle VARCHAR(100),
    type_voyage VARCHAR(50), -- Ex: séjour, circuit
    pension VARCHAR(20), -- demi-pension ou pension complète
    id_hotel INT NOT NULL,
    FOREIGN KEY (id_hotel) REFERENCES Hotel(id_hotel)
);

-- 7. PROGRAMMATIONS

CREATE TABLE Programmation (
    id_programmation INT PRIMARY KEY,
    date_depart DATE,
    date_retour DATE,
    prix_base DECIMAL(10,2),
    id_voyage INT NOT NULL,
    FOREIGN KEY (id_voyage) REFERENCES Voyage(id_voyage)
);

CREATE TABLE Programmation_Autocar (
    id_programmation INT,
    id_autocar INT,
    PRIMARY KEY (id_programmation, id_autocar),
    FOREIGN KEY (id_programmation) REFERENCES Programmation(id_programmation),
    FOREIGN KEY (id_autocar) REFERENCES Autocar(id_autocar)
);

-- 8. POINTS DE DÉPART

CREATE TABLE PointDepart (
    id_point_depart INT PRIMARY KEY,
    lieu VARCHAR(100),
    id_ville INT NOT NULL,
    FOREIGN KEY (id_ville) REFERENCES Ville(id_ville)
);

CREATE TABLE Programmation_PointDepart (
    id_programmation INT,
    id_point_depart INT,
    PRIMARY KEY (id_programmation, id_point_depart),
    FOREIGN KEY (id_programmation) REFERENCES Programmation(id_programmation),
    FOREIGN KEY (id_point_depart) REFERENCES PointDepart(id_point_depart)
);
