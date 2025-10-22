<?php
require_once('view/View.php');
require_once('control/Controller.php');

class Router {
    public function main() {
        $view = new View("","");
        $controller = new Controller($view);
        $controller->showInformation("félix");
        //$view->prepareTestPage();
        //$view->prepareAnimalPage("Médor","chien");
        $view->render();
         
    }
}