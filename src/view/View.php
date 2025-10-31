<?php

class View {
    private String $title;
    private String $content;
    private Router $router;

    public function __construct(String $title,String $content, Router $router) {
        $this->title = $title;
        $this->content = $content;
        $this->router = $router;
    }

    public function render():void {
        echo <<<HTML
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <title>$this->title</title>
        </head>
        <body>
            <h1>$this->title</h1>
            <p>$this->content</p>
        </body>
        </html>
        HTML;
    }

    public function prepareTestPage():void {
        $this->title = "Le titre";
        $this->content = "Ceci est le contenu";
    }

    public function prepareAnimalPage(Animal $animal):void {
        $this->title = "Page sur " . $animal->getNom();
        $this->content = $animal->getNom() . " est un animal de l'espèce " . $animal->getEspece() . ". Il est 
        agé de " . $animal->getAge() . " ans";
    }

    public function prepareUnknownAnimalPage(): void {
        $this->title = "Erreur";
        $this->content = "Animal inconnu";
    }

    public function preparePageAccueil(): void {
        $this->title = "Page d'accueil";
        $this->content = "On se trouve dans la " . $this->title;
    }

    public function prepareListPage(array $tabAnimals): void {
        $this->title = "List Page";
        $listAnimals = "<ul>";
        foreach ($tabAnimals as $id => $animal) {
            $animalURL = $this->router->getAnimalURL($id);
            $listAnimals .= "<li><a href=\"$animalURL\">" . $animal->getNom() . "</a></li>";
        }
        $listAnimals .= "</ul>";
        $this->content = $listAnimals;
    }

    public function prepareUnknownPage(): void {
        $this->title = "Erreur";
        $this->content = "Page inconnu";
    }
}