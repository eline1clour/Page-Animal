<?php 
require_once('model/AnimalStorage.php');

class Controller {
    private View $view;
    private AnimalStorage $animalStorage;
    
    public function __construct(View $view, AnimalStorage $animalStorage) {
        $this->view = $view;
        $this->animalStorage = $animalStorage;
    }

    public function showInformation($id):void {
        if ($this->animalStorage->read($id) != null) {
            $this->view->prepareAnimalPage($this->animalStorage->read($id));
        } else {
            $this->view->prepareUnknownAnimalPage();
        }
    }

    public function showPageAccueil(): void {
        $this->view->preparePageAccueil();
    }

    public function showList(): void {
        $this->view->prepareListPage($this->animalStorage->readAll());
    }
}