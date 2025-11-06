<?php

class View {
    private String $title;
    private String $content;
    private Router $router;
    private array $menu;

    public function __construct(String $title,String $content, Router $router) {
        $this->title = $title;
        $this->content = $content;
        $this->router = $router;
        $this->menu = [
            ['url' => 'site.php', 'texte' => 'Accueil'],
            ['url' => 'site.php?action=liste', 'texte' => 'Liste des animaux']
        ];
    }

    public function render() {
        include('squelette.php');
    }

    public function prepareTestPage() {
        $this->title = "Le titre";
        $this->content = "Ceci est le contenu";
    }

    public function prepareAnimalPage(Animal $animal) {
        $this->title = "Page sur " . $animal->getNom();
        $this->content = $animal->getNom() . " est un animal de l'espèce " . $animal->getEspece() . ". Il est 
        agé de " . $animal->getAge() . " ans";
    }

    public function prepareUnknownAnimalPage() {
        $this->title = "Erreur";
        $this->content = "Animal inconnu";
    }

    public function preparePageAccueil() {
        $this->title = "Page d'accueil";
        $this->content = "On se trouve dans la " . $this->title;
    }

    public function prepareListPage(array $tabAnimals) {
        $this->title = "List Page";
        $listAnimals = "<ul>";
        foreach ($tabAnimals as $id => $animal) {
            $animalURL = $this->router->getAnimalURL($id);
            $listAnimals .= "<li><a href=\"$animalURL\">" . $animal->getNom() . "</a></li>";
        }
        $listAnimals .= "</ul>";
        $this->content = $listAnimals;
    }

    public function prepareUnknownPage() {
        $this->title = "Erreur";
        $this->content = "Page inconnu";
    }

    public function prepareDebugPage($variable) {
        $this->title = 'Debug';
        $this->content = '<pre>'.htmlspecialchars(var_export($variable, true)).'</pre>';
    }
}