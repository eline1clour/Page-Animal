<?php 
require_once('model/AnimalStorage.php');
require_once('model/AnimalBuilder.php');

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

    public function makeUnknownActionPage() {
        $this->view->prepareUnknownActionPage();
    }

    public function showPageAccueil() {
        $this->view->preparePageAccueil();
    }

    public function showList() {
        $this->view->prepareListPage($this->animalStorage->readAll());
    }

    public function createNewAnimal() {
        $this->view->prepareAnimalCreationPage(new AnimalBuilder([]));
    }

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

        //Deplacer le fichier
        $uploadDir = 'uploads/';
        
        $nomImage = basename($_FILES['image_animal']['name']);
        $imageTmp = $_FILES['image_animal']['tmp_name'];
        $nomFichier = uniqid('animal_', true);
        $extensionFichier = pathinfo($nomImage, PATHINFO_EXTENSION);
        $cheminImage = $uploadDir . $nomFichier . '.' . $extensionFichier;

        if(!move_uploaded_file($imageTmp, $cheminImage)) {
            $builderError = new AnimalBuilder($data);
            $builderError->getData()[AnimalBuilder::IMAGE_REF] = "";
            $this->view->prepareAnimalCreationPage($builderError);
            return;
        }

        $data[AnimalBuilder::IMAGE_REF] = $cheminImage;

        $builder = new AnimalBuilder($data);

        if(!$builder->isValid()) {
            $this->view->prepareAnimalCreationPage($builder);
            return;
        }

        $a = $builder->createAnimal();
        $a->setCheminVersImage($cheminImage);
        $id = $this->animalStorage->create($a);

        $this->view->displayAnimalCreationSuccess($id);
    }
}