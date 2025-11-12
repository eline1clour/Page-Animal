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
        $this->view->prepareAnimalCreationPage([],null);
    }

    public function saveNewAnimal(array $data) {
        $error = '';
        if (isset($data['nom']) && isset($data['espece']) && isset($data['age'])) {
            $nom = $data['nom'];
            $espece = $data['espece'];
            $age = $data['age'];

            if (!empty($nom) && !empty($espece) && $age > 0) {
                $a = new Animal($nom, $espece, $age);
                $id = $this->animalStorage->create($a);
                $this->view->prepareAnimalPage($this->animalStorage->read($id));

            } else {
                if (empty($nom)) {
                    $error = "Le champs nom est obligatoire";
                } else if (empty($espece)) {
                    $error = "Le champs espèce est obligatoire";
                } else if ($age <= 0) {
                    $error = "Le champs âge doit être positif et supérieur à 0";
                }

               $this->view->prepareAnimalCreationPage($data, $error);
            }
            
        } else {
            $this->view->prepareAnimalCreationPage($data, "Tous les champs sont obligatoire");
        }
    }
}