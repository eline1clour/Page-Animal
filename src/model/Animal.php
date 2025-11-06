<?php

class Animal {
    private String $nom;
    private String $espece;
    private int $age;

    public function __construct(String $nom, String $espece, int $age) {
        $this->nom = $nom;
        $this->espece = $espece;
        $this->age = $age;
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
}