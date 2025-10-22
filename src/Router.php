<?php
require_once('view/View.php');
require_once('control/Controller.php');

class Router {
    public function main() {
        $view = new View("","");
        $controller = new Controller($view);

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $controller->showInformation($id);
        } else {
            $controller->showPageAccueil();
        }
        //$controller->showInformation($id);
        //$view->prepareTestPage();
        //$view->prepareAnimalPage("Médor","chien");
        $view->render();
    }
}