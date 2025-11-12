<?php 

class AnimalBuilder {
    public const NAME_REF = 'nom';
    public const SPECIES_REF = 'espece';
    public const AGE_REF = 'age';

    private array $data;
    private ?String $error = null;

    public function __construct($data) {
        $this->data = $data;
    }

    public function getData() {
        return $this->data;
    }

    public function getError() {
        return $this->error;
    }

    public function createAnimal() {
        return new Animal($this->data[self::NAME_REF], $this->data[self::SPECIES_REF], $this->data[self::AGE_REF]);
    }

    public function isValid() {
        $nom = isset($this->data[self::NAME_REF]) ? $this->data[self::NAME_REF] : '';
        $espece = isset($this->data[self::SPECIES_REF]) ? $this->data[self::SPECIES_REF] : '';
        $age = isset($this->data[self::AGE_REF]) ? $this->data[self::AGE_REF] : '';

        if(empty($nom)) {
            $this->error = "Le champ nom est obligatoire";
            return false;
        } elseif (empty($espece)) {
            $this->error = "Le champ espèce est obligatoire";
            return false;
        } elseif ($age <= 0) {
            $this->error = "L'âge doit être supérieur à 0";
            return false;
        }

        return true;
    }
}