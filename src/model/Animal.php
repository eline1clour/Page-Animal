<?php

/**
 * Cette classe répresente un animal avec ses caractéristiques principales.
 * Elle permet de stocker les informations d'un animal comme son nom, son espèce, son âge ou encore le chemin vers son image
 */

class Animal {
    private String $nom;
    private String $espece;
    private int $age;
    private $cheminVersImage;

    public function __construct(String $nom, String $espece, int $age, $cheminVersImage) {
        $this->nom = $nom;
        $this->espece = $espece;
        $this->age = $age;
        $this->cheminVersImage = $cheminVersImage;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getEspece() {
        return $this->espece;
    }

    public function getAge() {
        return $this->age;
    }

    public function getCheminVersImage() {
        return $this->cheminVersImage;
    }

    public function setCheminVersImage($cheminVersImage) {
        $this->cheminVersImage = $cheminVersImage;
    }         
}