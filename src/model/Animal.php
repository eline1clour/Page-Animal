<?php

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