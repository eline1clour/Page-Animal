<?php 
/**
 * Classe de construction d'un animal
 * Cette classe permet de valider les données d'un animal et de créer une instance de 'Animal'.
 * Elle vérifie que les champs du formulaire sont correctement remplis et retourne une erreur si nécessaire.
 * Elle stock les références vers les différents champs.
 */
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

    /**
     * Crée une instance de l'animal avec les données validées.
     * 
     * @return Animal L'instance de l'animal créée.
     */
    public function createAnimal() {
        return new Animal($this->data[self::NAME_REF], $this->data[self::SPECIES_REF], $this->data[self::AGE_REF], $this->data[self::IMAGE_REF]);
    }

    /**
     * Valide les données de l'animal
     * Vérifie que le nom, l'espèce et l'âge sont présents et valides.
     * Si une erreur est rencontrée, elle est stockée dans l'attribut $error.
     * 
     * @return bool Retourne true si les données sont valides et false sinon.
     */

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