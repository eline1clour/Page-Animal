<?php
require_once('AnimalStorage.php');
require_once('Animal.php');

/**
 * Classe de stokage simulé d'animaux pour les tests.
 */
class AnimalStorageStub implements AnimalStorage {
    private array $animalsTab;

    public function __construct() {
        $this->animalsTab = array(
            'medor' => new Animal('Médor', 'chien',10),
            'felix' => new Animal('Félix', 'chat',4),
            'denver' => new Animal('Denver', 'dinosaure',1),
        );
    }

    public function read($id) {
        if (key_exists($id, $this->animalsTab)) {
            return $this->animalsTab[$id];
        } else {
            return null;
        }
    }

    public function readAll() {
        return $this->animalsTab;
    }

    public function create(Animal $a) {
        throw new Exception("Impossible de créer un animal dans cette pseudo-base");
    }

    public function delete(String $id) {
        throw new Exception("Impossible de supprimer un animal dans cette pseudo-base");
    }

    public function update(String $id, Animal $a) {
        throw new Exception("Impossible de mettre à jour un animal dans cette pseudo-base");
    }
}