<?php

/**
 * Classe pour stocker les animaux crée dans notre base MySQL.
 * Elle implémente AnimalStorage et enregistre les animaux dans la base. 
 */

class AnimalStorageMySQL implements AnimalStorage {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function read($id) {
        $requete = "SELECT * FROM animals WHERE id = :id";
        $stmt = $this->pdo->prepare($requete);
        $stmt->bindValue(':id',$id);
        $stmt->execute();

        $ligne = $stmt->Fetch(PDO::FETCH_ASSOC);
        if($ligne) {
            $animal = new Animal($ligne['name'],$ligne['species'], $ligne['age'], $ligne['image_path']);
            return $animal;
        } else{
            return null;
        }   
    }

    public function readAll() {
        try {
            $animals = [];

            $requete = "SELECT * FROM animals";
            $stmt = $this->pdo->query($requete);

            while($ligne = $stmt->Fetch(PDO::FETCH_ASSOC)) {
                $animal = new Animal(htmlspecialchars($ligne['name']),htmlspecialchars($ligne['species']), $ligne['age'], $ligne['image_path']);

                $animals[$ligne['id']] = $animal;
            }
            return $animals;
        } catch (PDOException $e) {
            echo "Erreur de syntaxe mySql: " . $e->getMessage();
            exit();
        }
    }

    public function create(Animal $a) {
        $requete = "INSERT INTO animals (name, species, age, image_path) VALUES (:name, :species, :age, :image_path)";
        $stmt = $this->pdo->prepare($requete);

        $stmt->bindValue(':name', $a->getNom());
        $stmt->bindValue(':species', $a->getEspece());
        $stmt->bindValue(':age', $a->getAge());
        $stmt->bindValue(':image_path', $a->getCheminVersImage());

        $stmt->execute();
        return $this->pdo->lastInsertId();
    }
    
    public function update($id, Animal $a) {
        throw new Exception("not yet implemented");
    }

    public function delete($id) {
        throw new Exception("not yet implemented");
    }
}