<?php

class View {
    private String $title;
    private String $content;

    public function __construct(String $title,String $content) {
        $this->title = $title;
        $this->content = $content;
    }

    public function render():void {
        echo <<<HTML
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <title>$this->title</title>
        </head>
        <body>
            <h1>$this->title</h1>
            <p>$this->content</p>
        </body>
        </html>
        HTML;
    }

    public function prepareTestPage():void {
        $this->title = "Le titre";
        $this->content = "Ceci est le contenu";
    }

    public function prepareAnimalPage($name, $species):void {
        $this->title = "Page sur " . $name;
        $this->content = $name . " est un animal de l'espèce " . $species;
    }
}