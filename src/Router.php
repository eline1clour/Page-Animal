<?php
require_once('view/View.php');
require_once('control/Controller.php');

class Router {
    public function main(AnimalStorage $animalStorage) {
        $view = new View("","",$this);
        $controller = new Controller($view,$animalStorage);

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $view->prepareDebugPage($id);
            $controller->showInformation($id);
        } else {
            $controller->showPageAccueil();
        }

        if(isset($_GET['action']) && $_GET['action'] === 'liste') {
            $controller->showList();
        }
        $view->render();
    }

    public function getAnimalURL($id) {
        return "site.php?id=$id";
    }
}