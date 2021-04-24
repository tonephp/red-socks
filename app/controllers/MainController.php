<?php

namespace app\controllers;

class MainController extends AppController {
    
    public function indexAction() {
    
       $this->setMeta(
           'TonePHP Framework',
           'TonePHP Framework',
           'TonePHP, framework'
       );
    }
}