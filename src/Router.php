<?php
require_once('view/View.php');
require_once('control/Controller.php');
require_once('model/AnimalStorageStub.php');

class Router {
    public function main(AnimalStorage $animalStorageStub) {
        $view = new View("","",$this);
        
        $controller = new Controller($view,$animalStorageStub);

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $controller->showInformation($id);
        } else {
            $controller->showPageAccueil();
        }

        if(isset($_GET['action']) && $_GET['action'] === 'liste') {
            $controller->showList();
        }
        //$controller->showInformation($id);
        //$view->prepareTestPage();
        //$view->prepareAnimalPage("Médor","chien");
        $view->render();
    }

    public function getAnimalURL($id): String {
        return "site.php?id=$id";
    }
}