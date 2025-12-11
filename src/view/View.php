<?php
require_once('model/AnimalBuilder.php');
class View {
    private String $title;
    private String $content;
    private Router $router;
    private array $menu;
    private $feedback;

    public function __construct(String $title,String $content, Router $router, $feedback) {
        $this->title = $title;
        $this->content = $content;
        $this->router = $router;
        $this->menu = [
            ['url' => 'site.php', 'texte' => 'Accueil'],
            ['url' => 'site.php?action=liste', 'texte' => 'Liste des animaux']
        ];
        $this->feedback = $feedback;
    }

    public function getFeedback() {
        return $this->feedback;
    }

    public function setFeedback($feedback) {
        $this->feedback = $feedback;
    }

    public function render() {
        include('squelette.php');
    }

    public function prepareTestPage() {
        $this->title = "Le titre";
        $this->content = "Ceci est le contenu";
    }

    public function prepareAnimalPage(Animal $animal) {
        $this->title = "Page sur " . htmlspecialchars($animal->getNom());
        $imagePath = $animal->getCheminVersImage();
        $this->content = "<div class='animal-page'>
            <img src='$imagePath' alt='" . htmlspecialchars($animal->getNom()) . "_image' class='animal-image'>
            <p class='animal-text'>" .
            htmlspecialchars($animal->getNom()) 
            . " est un animal de l'espèce " 
            . htmlspecialchars($animal->getEspece()) 
            . ". Il est âgé de " 
            . $animal->getAge() . " ans.</p></div>";
    }

    public function prepareUnknownAnimalPage() {
        $this->title = "Page d'erreur";
        $this->content = "<div class='error-page'>
                <h2>Animal Inconnu</h2>
                <p>Désolé, l'animal que vous cherchez n'existe pas dans notre base de données. Veuillez vous référer à notre <a href='site.php?action=liste'>liste d'animaux</a>.</p>
            </div>";
    }

    public function prepareUnknownActionPage() {
        $this->title = "Page introuvable";
        $this->content = "<div class='error-page'>
                <h2>Action non reconnu</h2>
                <p>L'action que vous avez démandé n'est pas valide. Veuillez vérifier l'URL ou retourner à la <a href='site.php'>page d'accueil</a>.</p>
            </div>";
    }

    public function preparePageAccueil() {
        $this->title = "Page d'accueil";
        $this->content = "<div class='accueil-page'>
                <p class='accueil-text'>On se trouve dans la " . $this->title . ".</p>
            </div>";
    }

    public function prepareListPage(array $tabAnimals) {
        $this->title = "List Page";
        $listAnimals = "<ul class='animal-list'>";
        foreach ($tabAnimals as $id => $animal) {
            $animalURL = $this->router->getAnimalURL($id);
            $listAnimals .= "<li><a href=\"$animalURL\">" . htmlspecialchars($animal->getNom()) . "</a></li>";
        }
        $listAnimals .= "</ul>";
        $this->content = $listAnimals;
    }


    public function prepareDebugPage($variable) {
        $this->title = 'Debug';
        $this->content = '<pre>'.htmlspecialchars(var_export($variable, true)).'</pre>';
    }

    public function prepareAnimalCreationPage(AnimalBuilder $animalBuilder) {
        $this->title = "Ajouter un animal";
        $nom = key_exists(AnimalBuilder::NAME_REF, $animalBuilder->getData()) ? $animalBuilder->getData()[AnimalBuilder::NAME_REF] : "";
        $espece = key_exists(AnimalBuilder::SPECIES_REF, $animalBuilder->getData()) ? $animalBuilder->getData()[AnimalBuilder::SPECIES_REF] : "";
        $age = key_exists(AnimalBuilder::AGE_REF, $animalBuilder->getData()) ? $animalBuilder->getData()[AnimalBuilder::AGE_REF] : "";
        $image = key_exists(AnimalBuilder::IMAGE_REF, $animalBuilder->getData()) ? $animalBuilder->getData()[AnimalBuilder::IMAGE_REF] : "";
        $error = $animalBuilder->getError();

        $saveURL = $this->router->getAnimalSaveURL();
        $this->content .= <<<HTML
            <!DOCTYPE html>
            <html lang="fr">
            <head>
                <meta charset="UTF-8">
                <link rel="stylesheet" href="src/view/site.css" />
                <title>$this->title</title>
            </head>
            <body>
                <form enctype="multipart/form-data" action="$saveURL" method="post">
                    <label>Séléctionner une image: 
                        <input type="file" name="image_animal"/>
                    </label>
                    <label>Nom: 
                        <input type='text' name='nom' value="$nom"/>
                    </label>
                    <label>Espèce: 
                        <input type='text' name='espece' value="$espece"/>
                    </label>
                    <label>Âge: 
                        <input type='number' name='age' value="$age"/>
                    </label>
                    <button type="submit" name='submit'>Créer votre animal</button>
                </form>
        HTML;
        if($error !== null) {
            $this->content .= "<p class='error'>$error</p>";
        }
        $this->content .= <<<HTML
            </body>
            </html>
        HTML;
    }

    public function displayAnimalCreationSuccess($id) {
        $url = $this->router->getAnimalURL($id);
        $this->feedback = "Succès de la création de l'animal";
        $this->router->POSTredirect($url,$this->feedback);
    }

}