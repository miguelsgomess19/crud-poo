<?php

class Serie
{
    private $titulo;
    private $genero;
    private $temporadas;
    private $plataforma;

    public function __construct($titulo, $genero, $temporadas, $plataforma)
    {
        $this->titulo = $titulo;
        $this->genero = $genero;
        $this->temporadas = $temporadas;
        $this->plataforma = $plataforma;
    }

    public function getTitulo()
    {
        return $this->titulo;
    }

    public function getGenero()
    {
        return $this->genero;
    }

    public function getTemporadas()
    {
        return $this->temporadas;
    }

    public function getPlataforma()
    {
        return $this->plataforma;
    }
}
