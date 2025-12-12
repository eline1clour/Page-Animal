<?php
require_once('view/View.php');
require_once('Router.php');
require_once('model/AnimalBuilder.php');
require_once('model/Animal.php');

/**
 * Vue spécialisée pour l'API.
 * Génère des réponses JSON plutôt que du HTML.
 */
class ApiView extends View {
    private $data = null;
    private int $statusCode = 200;

    public function __construct() {
        // Router requis par la classe mère, mais inutilisé ici.
        $dummyRouter = new Router();
        parent::__construct('', '', $dummyRouter, '');
    }

    /**
     * Envoie la réponse JSON au client.
     */
    public function render() {
        header('Content-Type: application/json; charset=utf-8');
        http_response_code($this->statusCode);
        echo json_encode($this->data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    /**
     * Prépare la réponse pour un animal trouvé.
     */
    public function prepareAnimalPage(Animal $animal) {
        $this->data = [
            'nom' => $animal->getNom(),
            'espece' => $animal->getEspece(),
            'age' => $animal->getAge(),
        ];
    }

    /**
     * Réponse quand l'animal demandé n'existe pas.
     */
    public function prepareUnknownAnimalPage() {
        $this->statusCode = 404;
        $this->data = [
            'error' => 'Animal inconnu',
        ];
    }

    /**
     * Réponse quand l'action/collection est inconnue.
     */
    public function prepareUnknownActionPage() {
        $this->statusCode = 400;
        $this->data = [
            'error' => 'Action ou collection non reconnue',
        ];
    }

    /**
     * Non utilisé par l’API, mais présent pour compatibilité.
     */
    public function preparePageAccueil() {
        $this->data = [
            'message' => 'Bienvenue sur l’API animaux',
        ];
    }

    /**
     * Prépare la liste des animaux (id + nom).
     */
    public function prepareListPage(array $tabAnimals) {
        $liste = [];
        foreach ($tabAnimals as $id => $animal) {
            $liste[] = [
                'id' => $id,
                'nom' => $animal->getNom(),
            ];
        }
        $this->data = $liste;
    }

    /**
     * Non utilisé par l’API; ici pour compatibilité.
     */
    public function prepareAnimalCreationPage(AnimalBuilder $animalBuilder) {
        $this->statusCode = 405;
        $this->data = [
            'error' => 'Création via API non supportée',
        ];
    }

    /**
     * Non utilisé par l’API; rediriger n’a pas de sens ici.
     */
    public function displayAnimalCreationSuccess($id) {
        $this->statusCode = 405;
        $this->data = [
            'error' => 'Création via API non supportée',
        ];
    }

    /**
     * Compatibilité avec Controller.
     */
    public function setFeedBack($feedback) {
        // ignoré pour l'API
    }
}