<?php

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Serie.php';
require_once __DIR__ . '/../interfaces/RepositoryInterface.php';

class SerieRepository implements RepositoryInterface
{
    private $conn;

    public function __construct()
    {
        $this->conn = Database::conectar();
    }

    public function criar($objeto)
    {
        $sql = "INSERT INTO series (titulo, genero, temporadas, plataforma) VALUES (:t, :g, :temp, :p)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':t' => $objeto->getTitulo(),
            ':g' => $objeto->getGenero(),
            ':temp' => $objeto->getTemporadas(),
            ':p' => $objeto->getPlataforma()
        ]);
    }

    public function listar()
    {
        $stmt = $this->conn->query("SELECT * FROM series ORDER BY id");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM series WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizar($id, $objeto)
    {
        $sql = "UPDATE series SET titulo = :t, genero = :g, temporadas = :temp, plataforma = :p WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':t' => $objeto->getTitulo(),
            ':g' => $objeto->getGenero(),
            ':temp' => $objeto->getTemporadas(),
            ':p' => $objeto->getPlataforma(),
            ':id' => $id
        ]);
    }

    public function excluir($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM series WHERE id = :id");
        $stmt->execute([':id' => $id]);
    }
}
