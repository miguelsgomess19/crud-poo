CREATE DATABASE crud_series;

\connect crud_series

CREATE TABLE IF NOT EXISTS series (
    id SERIAL PRIMARY KEY,
    titulo VARCHAR(150) NOT NULL,
    genero VARCHAR(100) NOT NULL,
    temporadas INT NOT NULL,
    plataforma VARCHAR(100) NOT NULL
);
