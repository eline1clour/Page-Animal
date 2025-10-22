<?php 
require_once('model/Animal.php');

class Controller {
    private View $view;
    private array $animalsTab;
    
    public function __construct(View $view) {
        $this->view = $view;
        $this->animalsTab = array(
            'medor' => new Animal('Médor', 'chien','10'),
            'felix' => new Animal('Félix', 'chat',4),
            'denver' => new Animal('Denver', 'dinosaure',1),
        );
    }

    public function showInformation($id):void {
        if(key_exists($id, $this->animalsTab)) {
            $this->view->prepareAnimalPage($this->animalsTab[$id]);
        } else {
            $this->view->prepareUnknownAnimalPage();
        }
	     
    }

    public function showPageAccueil() {
        $this->view->preparePageAccueil();
    }
}