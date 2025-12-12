<?php
require_once('view/ApiView.php');
require_once('control/Controller.php');

/**
 * Routeur dédié à l'API JSON.
 */
class ApiRouter {
    public function main(AnimalStorage $animalStorage) {
        $view = new ApiView();
        $controller = new Controller($view, $animalStorage);

        $collection = isset($_GET['collection']) ? $_GET['collection'] : null;
        $id = isset($_GET['id']) ? $_GET['id'] : null;

        if ($collection === 'animaux') {
            if ($id !== null) {
                $controller->showInformation($id);
            } else {
                $controller->showList();
            }
        } else {
            $controller->makeUnknownActionPage();
        }

        $view->render();
    }
}