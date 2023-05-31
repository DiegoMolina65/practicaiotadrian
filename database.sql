CREATE DATABASE jugadores;

USE jugadores;

CREATE TABLE jugadores (
    id INT(11) NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    edad INT(11) NOT NULL,
    posicion VARCHAR(50) NOT NULL,
    equipo VARCHAR(100) NOT NULL,
    nacionalidad VARCHAR(50) NOT NULL,
    PRIMARY KEY (id)
);

