<?php 
require_once('model/AnimalStorage.php');
require_once('model/AnimalBuilder.php');

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
        $this->view->prepareAnimalCreationPage(new AnimalBuilder([]));
    }

    public function saveNewAnimal(array $data) {
        $animalBuilder = new AnimalBuilder($data);

        if ($animalBuilder->isValid()) {
            $a = $animalBuilder->createAnimal();
            $id = $this->animalStorage->create($a);

            $this->view->displayAnimalCreationSuccess($id);

        } else {
            $this->view->prepareAnimalCreationPage($animalBuilder);
        }
    }
}