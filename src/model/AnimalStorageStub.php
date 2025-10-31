<?php
require_once('AnimalStorage.php');
require_once('Animal.php');

class AnimalStorageStub implements AnimalStorage {
    private array $animalsTab;

    public function __construct() {
        $this->animalsTab = array(
            'medor' => new Animal('Médor', 'chien',10),
            'felix' => new Animal('Félix', 'chat',4),
            'denver' => new Animal('Denver', 'dinosaure',1),
        );
    }

    public function read($id): Animal {
        if (key_exists($id, $this->animalsTab)) {
            return $this->animalsTab[$id];
        } else {
            return null;
        }
    }

    public function readAll(): array {
        return $this->animalsTab;
    }
}