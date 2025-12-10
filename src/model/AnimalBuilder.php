<?php 

class AnimalBuilder {
    public const NAME_REF = 'nom';
    public const SPECIES_REF = 'espece';
    public const AGE_REF = 'age';
    public const IMAGE_REF = 'image_animal';

    private array $data;
    private $error;

    public function __construct($data) {
        $this->data = $data;
        $this->error = null;
    }

    public function getData() {
        return $this->data;
    }

    public function getError() {
        return $this->error;
    }

    public function createAnimal() {
        if($this->error !== null) {
            throw new Exception("Valeurs des champs invalide: " . $this->error);
        }
        return new Animal($this->data[self::NAME_REF], $this->data[self::SPECIES_REF], $this->data[self::AGE_REF], $this->data[self::IMAGE_REF]);
    }

    public function isValid() {
        if(!key_exists(self::NAME_REF, $this->data) || $this->data[self::NAME_REF] === "") {
            $this->error = "Le champ nom est obligatoire";
        } 
        if (!key_exists(self::SPECIES_REF, $this->data) || $this->data[self::SPECIES_REF] === "") {
            $this->error = "Le champ espèce est obligatoire";
        } 
        if (!key_exists(self::AGE_REF, $this->data) || $this->data[self::AGE_REF] <= 0) {
            $this->error = "L'âge doit être supérieur à 0";
        }

        return $this->error === null;
    }
}