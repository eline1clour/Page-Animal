<?php 


class Controller {
    private View $view;
    private array $animalsTab;
    
    public function __construct(View $view) {
        $this->view = $view;
        $this->animalsTab = array(
            'medor' => array('Médor', 'chien'),
            'felix' => array('Félix', 'chat'),
            'denver' => array('Denver', 'dinosaure'),
        );
    }

    public function showInformation($id):void {
        if(key_exists($id, $this->animalsTab)) {
            $this->view->prepareAnimalPage($this->animalsTab[$id][0], $this->animalsTab[$id][1]);
        } else {
            $this->view->prepareUnknownAnimalPage();
        }
	     
    }

    public function showPageAccueil() {
        $this->view->preparePageAccueil();
    }
}