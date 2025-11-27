<?php
require_once('view/View.php');
require_once('control/Controller.php');

class Router {
    public function main(AnimalStorage $animalStorage) {
        $feedback = $_SESSION['feedback'] ?? null;
        $view = new View("","",$this,$feedback);
        unset($feedback);
        $controller = new Controller($view,$animalStorage);
        
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        $action = isset($_GET['action']) ? $_GET['action'] : null;

        switch ($id) {
            case null:
                $controller->showPageAccueil();
                break;
            
            default:
                $controller->showInformation($id);
                break;
        }

        switch ($action) {
            case 'liste':
                $controller->showList();
                break;
            case 'nouveau':
                $controller->createNewAnimal();
                break;
            case 'sauverNouveau':
                $controller->saveNewAnimal($_POST);
                break;
        }
        
        
        $view->render();
    }

    public function getAnimalURL($id) {
        return "site.php?id=$id";
    }

    public function getAnimalCreationURL() {
        return "site.php?action=nouveau";
    }

    public function getAnimalSaveURL() {
        return "site.php?action=sauverNouveau";
    }

    public function POSTredirect($url, $feedback) {
        $_SESSION['feedback'] = $feedback;
        header("Location: $url", true, 303);
        exit;
    }
}