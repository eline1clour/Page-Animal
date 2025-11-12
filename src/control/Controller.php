<?php 
require_once('model/AnimalStorage.php');

class Controller {
    private View $view;
    private AnimalStorage $animalStorage;
    
    public function __construct(View $view, AnimalStorage $animalStorage) {
        $this->view = $view;
        $this->animalStorage = $animalStorage;
    }

    

    public function showInformation($id) {
        if ($this->animalStorage->read($id) !== null) {
            $this->view->prepareAnimalPage($this->animalStorage->read($id));
        } else {
            $this->view->prepareUnknownAnimalPage();
        }
    }

    public function showPageAccueil() {
        $this->view->preparePageAccueil();
    }

    public function showList() {
        $this->view->prepareListPage($this->animalStorage->readAll());
    }

    public function createNewAnimal() {
        $this->view->prepareAnimalCreationPage();
    }

    public function saveNewAnimal(array $data) {
        if (isset($data['nom']) && isset($data['espece']) && isset($data['age'])) {
            $nom = $data['nom'];
            $espece = $data['espece'];
            $age = $data['age'];

            $a = new Animal($nom, $espece, $age);
            $id = $this->animalStorage->create($a);
            $this->view->prepareAnimalPage($this->animalStorage->read($id));
        } else {
            $this->view->prepareUnknownAnimalPage();
        }
    }
}