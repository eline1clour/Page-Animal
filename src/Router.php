<?php
require_once('view/View.php');
require_once('control/Controller.php');

/**
 * Cette classe est responsable de gérer les requête entrantes et de rédiriger l'utilisateur vers la page appropriée
 * en fonction des paramètres présents dans l'URL (id et action).
 * Elle décide quelle méthode du contôleur doit être appelée en fonction des paramètres et transmet les données nécessaires à la vue.
 */
class Router {
    public function main(AnimalStorage $animalStorage) {
        // Récupère le feedback de la session si disponible et la reinitialise après l'affichage.
        $feedback = key_exists('feedback', $_SESSION) ? $_SESSION['feedback'] : '';
		$_SESSION['feedback'] = '';

        $view = new View("","",$this,$feedback);
        $controller = new Controller($view,$animalStorage);
        
        // Récupère les paramètres d'URL pour les différentes requetes.
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        $action = isset($_GET['action']) ? $_GET['action'] : null;
        
        if($action !== null) {
            switch ($action) {    
                case 'liste':
                    // Affiche la liste des animaux
                    $controller->showList();
                    break;

                case 'nouveau':
                    // Affiche le formulaire pour ajouter un nouvel animal.
                    $controller->createNewAnimal();
                    break;

                case 'sauverNouveau':
                    // Sauvegarde le nouvel animal.
                    $controller->saveNewAnimal($_POST);
                    break;

                default:
                    // Affiche une page d'erreur si action non reconnue.
                    $controller->makeUnknownActionPage();
                    break;
            }
        }
        else if($id !== null) {
            $controller->showInformation($id);
        }
        // Si aucun paramètre d'id ou action, on affiche la page d'accueil.
        else {
            $controller->showPageAccueil();
        }

        // À la fin, on affiche la vue.
        $view->render();
    }

    /**
     * Retourne l'URL de l'animal correspondant à un identifiant donné.
     * 
     * @param int $id L'identifiant de l'animal
     * @return string L'url complète pour l'animal
     */
    public function getAnimalURL($id) {
        return "site.php?id=$id";
    }

    /**
     * Retourne l'URL pour accéder à la page de création d'un nouvel animal.
     * 
     * @return string L'URL pour la création d'un nouvel animal.
     */
    public function getAnimalCreationURL() {
        return "site.php?action=nouveau";
    }

    /**
     * Retourne l'URL pour sauvegarder un nouvel animal.
     * 
     * @return string l'url pour sauvegarder un nouvel animal.
     */
    public function getAnimalSaveURL() {
        return "site.php?action=sauverNouveau";
    }

    /**
     * Redirige l'utilisateur vers une url donnée avec un feedback socké dans la session.
     * Cette méthode est utilisée après qu'une action soit effectuée (comme  création d'un nouvel animal).
     * 
     * @param string $url L'url vers laquelle l'utilisateur sera redirigé.
     * @param string $feedback Le message de feedback à afficher.
     */
    public function POSTredirect($url, $feedback) {
        $_SESSION['feedback'] = $feedback;
        header("Location: $url", true, 303); 
        exit;
    }
}