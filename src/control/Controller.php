<?php 
require_once('model/AnimalStorage.php');
require_once('model/AnimalBuilder.php');

/**
 * Classe contrôleur du site. Elle gère les différents actions que l'utilisateur peut effectuer, telles que la
 * consultation des informations d'un animal, la liste des animaux, la création d'un nouvel animal.
 */
class Controller {
    private View $view;
    private AnimalStorage $animalStorage;
    
    public function __construct(View $view, AnimalStorage $animalStorage) {
        $this->view = $view;
        $this->animalStorage = $animalStorage;
    }

    /**
     * Affiche la page d'informations sur un animal.
     * Si l'animal est trouvé dans la base de données, sa page s'affiche. Sinon, une page d'erreur est affiché.
     * 
     * @param int $id L'identifiant de l'animal à afficher.
     */
    public function showInformation($id) {
        if ($this->animalStorage->read($id) !== null) {
            $this->view->prepareAnimalPage($this->animalStorage->read($id));
        } else {
            $this->view->prepareUnknownAnimalPage();
        }
    }

    public function makeUnknownActionPage() {
        $this->view->prepareUnknownActionPage();
    }

    public function showPageAccueil() {
        $this->view->preparePageAccueil();
    }

    public function showList() {
        $this->view->prepareListPage($this->animalStorage->readAll());
    }

    /**
     * Affiche le formulaire de création d'un nouvel animal.
     */
    public function createNewAnimal() {
        $this->view->prepareAnimalCreationPage(new AnimalBuilder([]));
    }

    /**
     * Sauvegarde un nouvel animal.
     * Valide les données du formulaire, gère l'upload de l'image et enregistre l'animal dans la base de données.
     * 
     * @param array $data Les données envoyées par le formulaire.
     */
    public function saveNewAnimal(array $data) {

        if(!key_exists("submit", $_POST)) {
            $this->view->prepareAnimalCreationPage(new AnimalBuilder([]));
            return;
        }

        //On verifie l'envoie de l'image
        if(!key_exists("image_animal", $_FILES) || $_FILES["image_animal"]["error"] !== 0) {
            $builderError = new AnimalBuilder($data);
            $builderError->getData()[AnimalBuilder::IMAGE_REF] = "";
            $this->view->prepareAnimalCreationPage($builderError);
            $this->view->setFeedBack("Veuillez séléctionner une image");
            return;
        }

        $typeImage = $_FILES['image_animal']['type'];
        $typeAutorise = ['image/jpeg', 'image/jpg', 'image/gif', 'image/png'];

        //Vérifier le type de l'image
        if(!in_array($typeImage, $typeAutorise)) {
            $builderError = new AnimalBuilder($data);
            $builderError->getData()[AnimalBuilder::IMAGE_REF] = "";
            $this->view->prepareAnimalCreationPage($builderError);
            $this->view->setFeedBack("Séléctionner une image valide [.jpeg, .jpg, .gif, .png]");
            return;
        }

       // Déplace le fichier téléchargé vers le répertoire cible
        $uploadDir = 'uploads/';
        
        $nomImage = basename($_FILES['image_animal']['name']);
        $imageTmp = $_FILES['image_animal']['tmp_name'];
        $nomFichier = uniqid('animal_', true);
        $extensionFichier = pathinfo($nomImage, PATHINFO_EXTENSION);
        $cheminImage = $uploadDir . $nomFichier . '.' . $extensionFichier;

        // Vérifie si le fichier a bien été téléchargé
        if(!move_uploaded_file($imageTmp, $cheminImage)) {
            $builderError = new AnimalBuilder($data);
            $builderError->getData()[AnimalBuilder::IMAGE_REF] = "";
            $this->view->prepareAnimalCreationPage($builderError);
            return;
        }

        // On ajoute la valeur du chemin de l'image aux données de data.
        $data[AnimalBuilder::IMAGE_REF] = $cheminImage;

        $builder = new AnimalBuilder($data);

        // Si les données sont invalides, retourne le formulaire avec les erreurs
        if(!$builder->isValid()) {
            $this->view->prepareAnimalCreationPage($builder);
            return;
        }
        // Crée l'animal et l'enregistre dans la base de données
        $a = $builder->createAnimal();
        $a->setCheminVersImage($cheminImage);
        $id = $this->animalStorage->create($a);

        // Envoie vers la page de succès (page de l'animal crée)
        $this->view->displayAnimalCreationSuccess($id);
    }
}